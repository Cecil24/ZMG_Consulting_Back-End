<?php

namespace App\services;

use App\Mail\BrokerManagerMail;
use App\Mail\SupplerMail;
use App\Mail\UpdateMail;
use App\Models\MailMessage;
use App\Mail\BrokerCompanyMail;
use App\Mail\BrokerMail;
use App\Mail\ClaimServiceProvider;
use App\Mail\ServiceProviderEmail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * @param $selector
     * @param $user
     * @param array $params
     * @return void
     */
    public static function sendEmail($selector , $user, array $params): void
    {
        $user = User::where('id', $user->id)->first();

        $mail = MailMessage::where('subject', $selector)->first();
        $message = $mail->body;
        for( $i=0 ; $i<count($params) ; $i++){
            $temp = 'param' . $i;
            $message = str_replace($temp, $params[$i], $message);
        }
        Mail::to($user)->later(now()->addSecond(), new UpdateMail($user, $message, $mail->subject ));

    }


    /**
     * @param $selector
     * @param array $users
     * @param array $params
     * @return void
     */
    public static function sendEmailArray($selector , array $users, array $params) {

        $mail = MailMessage::where('subject', $selector)->first();
        $message = $mail->body;
        for( $i=0 ; $i<count($params) ; $i++){
            $temp = 'param' . $i;
            $message = str_replace($temp, $params[$i], $message);
        }

        foreach ($users as $user) {
            $userRole = User::with('roles')->where('id', $user->id)->first();
            Mail::to($user)->later(now()->addSecond(), new UpdateMail($userRole, $message, $mail->subject ));
        }
    }

}
