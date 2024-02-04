<?php

namespace App\services;

use App\Models\Client;
use App\Models\Note;
use Illuminate\Support\Collection;
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

        return $client;
    }
}
