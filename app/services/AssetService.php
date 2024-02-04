<?php

namespace App\services;

use App\Models\Asset;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class AssetService
{
    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function captureAsset($data): Asset
    {

        $num = strval(rand(1,99999999));
        $assetID = 'ZMG-C-'.$num;
        //Create asset
        $asset = asset::create([
            'type' => $data['type'],
            'asset_id' => $assetID,
            'location' => $data['location'],
            'employee' => $data['employee'],
            'brand_name' => $data['brand_name'],
            'serial_number' => $data['serial_number'],
            'status' => $data['status'],
            'imei_number' => $data['imei_number'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'model' => $data['model'],
            'ram_size' => $data['ram_size'],
            'furniture_type' => $data['furniture_type'],
            'description' => $data['description'],
        ]);

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$asset->id,'ASSET');

        AttachmentService::processAttachedFiles($data, $asset);

        $user = User::where('id',Auth::user()->getAuthIdentifier())->first();
        $otp = '638393';

        NotificationService::sendEmail('OTP',$user,array($otp));

        return $asset;
    }

    /**
     * @return Collection
     */
    public function getAssets(): Collection
    {
        return Asset::get();
    }

    /**
     * @param $id
     * @return Asset
     */
    public function getAsset($id): Asset
    {
        $asset = Asset::where('id',$id)->first();
        $asset->notes = Note::with('By')->where('type','ASSET')->where('object_id', $id)->get();
        $media = $asset->getMedia('media');
        $asset->media = $media ?: null;

        return $asset;
    }

    /**
     * @param $data
     * @return Asset
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws \Exception
     */
    public function updateAsset($data):Asset
    {
        $asset = Asset::where('id', $data['id'])->first();

        if($asset !== null){
            //Update asset
            $asset->type = $data['type'];
            $asset->asset_id = $data['asset_id'];
            $asset->location = $data['location'];
            $asset->employee = $data['employee'];
            $asset->brand_name = $data['brand_name'];
            $asset->serial_number = $data['serial_number'];
            $asset->status = $data['status'];
            $asset->imei_number = $data['imei_number'];
            $asset->start_date = $data['start_date'];
            $asset->end_date = $data['end_date'];
            $asset->model = $data['model'];
            $asset->ram_size = $data['ram_size'];
            $asset->furniture_type = $data['furniture_type'];
            $asset->description = $data['description'];

            $asset->save();
        }else{
            throw new \Exception('asset not found');
        }

        $noteService = new NoteService();
        $noteService->captureNote($data['note'],$asset->id,'ASSET');

        AttachmentService::processAttachedFiles($data, $asset);

        return $asset;
    }
}
