<?php

namespace App\Helper;

use Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class MailHelper
{
    public static function orderReminder($data){
        try{
            if ($data == "") {
                return "false";
            }

            $sendMail = Mail::send('emails.reminder', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject("Hurry Up! Only 1 hours left to Deliver your Order ".$data['id']);
                $message->from(
                    env('MAIL_FROM_ADDRESS', config('mail.mailers.smtp.mailfrom')),
                );
            });
            $sendMail = 'true';
            if ($sendMail) {
                return "true";
            }

            return "false";
        } catch (Exception $ex) {
            return "false";
            Exceptions::exception($e);
        }

    }

    public static function orderRejectMail($data){
        try{
            if ($data == "") {
                return "false";
            }

            $sendMail = Mail::send('emails.reminder', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email'])
                    ->subject("Your Order Has been rejected".$data['id']);
                $message->from(
                    env('MAIL_FROM_ADDRESS', config('mail.mailers.smtp.mailfrom')),
                );
            });
            $sendMail = 'true';
            Order::where('status', 'new')->update([
                'status' => 'reject',
                'updated_at' => now(),
            ]);
            if ($sendMail) {
                return "true";
            }

            return "false";
        } catch (Exception $ex) {
            return "false";
            Exceptions::exception($e);
        }
    }
}