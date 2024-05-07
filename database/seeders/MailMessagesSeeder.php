<?php

namespace Database\Seeders;

use App\Models\MailMessage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MailMessagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailMessage::create([
            'type' => 'SUCCESS',
            'body' => 'param0.',
            'subject' => 'CLIENT_DOCUMENTS'
        ]);
    }
}
