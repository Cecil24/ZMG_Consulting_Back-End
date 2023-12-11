<?php

namespace App\services;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NoteService
{

    /**
     * @param $note
     * @param $object_id
     * @param $type
     * @return Note
     */
    public function captureNote($note,$object_id,$type): Note
    {
        return Note::create([
            'note' => $note,
            'created_by' => Auth::user()->getAuthIdentifier(),
            'type' => $type,
            'object_id' => $object_id,
        ]);
    }
}
