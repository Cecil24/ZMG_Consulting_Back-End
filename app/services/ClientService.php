<?php

namespace App\services;

use App\Common\AuditType;
use App\Exceptions\ClientDocumentException;
use App\Models\Client;
use App\Models\ClientDocumentRequests;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ClientService
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function captureClient($data): Client
    {

        //Create Client
        $client = Client::create([
            'name' => $data['name'],
            'client_id' => $data['client_id'],
            'email' => $data['email'],
            'employee' => $data['employee'],
            'contact_phone_number' => $data['contact_phone_number'],
            'services_rendered' => $data['services_rendered'],
            'agent_name' => $data['agent_name'],
            'contact_person' => $data['contact_person'],
            'year_end_date' => $data['year_end_date'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'frequency' => $data['frequency'],
            'status' => $data['status'],
            'type' => $data['type'],
            'nature' => $data['nature'],
        ]);

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$client->id,'CLIENT');

        AttachmentService::processAttachedFiles($data, $client);

        $service = new AuditTrailService();
        $service->logAuditTrail($client->id, AuditType::CAPTURED_CLIENT);

        return $client;
    }

    /**
     * @return Collection
     */
    public function getClients(): Collection
    {
        return Client::get();
    }

    /**
     * @param $id
     * @return Client
     */
    public function getClient($id): Client
    {
        $client = Client::where('id',$id)->first();
        $client->notes = Note::with('By')->where('type','CLIENT')->where('object_id', $id)->get();
        $media = $client->getMedia('media');
        $client->media = $media ?: null;

        return $client;
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getClientDocuments($id): Collection
    {
        $clientD = ClientDocumentRequests::where('client_id',$id)->get();
        $documents[] = null;
        foreach ($clientD as $clientDocument) {
            $media = $clientDocument->getMedia('media');
            $media = $media ?array_push($documents,$media): null;
        }
        $clientD->media = $documents?: null;

        return $clientD;
    }

    /**
     * @param $data
     * @return Client
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updateClient($data):Client
    {
        $client = Client::where('id', $data['id'])->first();

        if($client !== null){
            //Update Client
            $client->name = $data['name'];
            $client->client_id = $data['client_id'];
            $client->email = $data['email'];
            $client->employee = $data['employee'];
            $client->contact_phone_number = $data['contact_phone_number'];
            $client->services_rendered = $data['services_rendered'];
            $client->agent_name = $data['agent_name'];
            $client->contact_person = $data['contact_person'];
            $client->year_end_date = $data['year_end_date'];
            $client->start_date = $data['start_date'];
            $client->end_date = $data['end_date'];
            $client->frequency = $data['frequency'];
            $client->status = $data['status'];
            $client->type = $data['type'];
            $client->nature = $data['nature'];

            $client->save();
        }else{
            throw new \Exception('Client not found');
        }

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$client->id,'CLIENT');

        AttachmentService::processAttachedFiles($data, $client);

        $service = new AuditTrailService();
        $service->logAuditTrail($client->id, AuditType::UPDATED_CLIENT);

        return $client;
    }

    public function requestDocuments($data):Client
    {
        $client = Client::where('client_id', $data['client_id'])->first();

        $clientRequest = new ClientDocumentRequests();

        $clientRequest->client_id = $client->id;
        $clientRequest->instructions = $data['note'];
        $clientRequest->created_by = Auth::user()->getAuthIdentifier();
        $clientRequest->save();

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$client->id,'CLIENT');

        NotificationService::sendServiceProviderEmailForAllocation(
            'CLIENT_DOCUMENTS',
            $client,
            array($data['note']),
            $this->createLinkForClientDocument($clientRequest->id)
        );

        $service = new AuditTrailService();
        $service->logAuditTrail($client->id, AuditType::REQUESTED_DOCUMENTS);

        return $client;
    }

    public function createLinkForClientDocument(int $id) : string
    {
        return env("FRONT_END_URL") . "/client-documents/upload-document?Token=" . encrypt($id);
    }

    public function submitDocuments($data): void
    {
        try {
            $client = Client::where('id', $data['client_id'])->first();

            $noteService = new NoteService();
            $clientDocument = ClientDocumentRequests::where('id',$data['client_id'])->latest()->first();

            $admin = User::where('id',$clientDocument->created_by)->firstOrFail();

            AttachmentService::processAttachedFiles($data, $clientDocument);
            $this->uploadClaimDocuments($data, $clientDocument);

            if($clientDocument){
                $clientDocument['is_submitted'] = 1;
                $clientDocument->save();
            }

            NotificationService::sendEmail(
                'CLIENT_DOCUMENTS',
                $admin,
                ["Documents have been submitted"]);


            $noteService->captureNote($data['note'],$client->id,'CLIENT');


        }catch(\Exception $e){

        }
    }

    /**
     * @throws ClientDocumentException
     */
    public function getClientByToken($data)
    {
        $clientDocument = ClientDocumentRequests::where('id', decrypt($data['token']))->get()->first();

        if($clientDocument){
            if($clientDocument->is_submitted){
                throw new ClientDocumentException("Documents already submitted");
            }
            return $clientDocument;
        }else{
            throw new ClientDocumentException("Client Documents Request not found");
        }
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadClaimDocuments($data, $client): void
    {
        $clientD = ClientDocumentRequests::where('client_id',$data['client_id'])->get();
        foreach ($clientD as $client){
            if($client){
                $client['is_submitted'] = 1;
                $client->save();
            }
        }
    }
}
