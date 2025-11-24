<?php

namespace App\Http\Controllers;

use App\Helper\MyHelper;
use App\Models\Common;
use App\Models\IR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class EmailController extends Controller
{
    public static function sendEmailNotif($id)
    {
        $ecount = 0;
        $userID = MyHelper::decrypt(Session::get('Employee_ID'));

        $param = [
            $userID,
            $id
        ];

        // dd($param);

        $clk = IR::getIR($param);
        // dd($clk);
        $email = IR::getEmailNotif([$clk[0]->Location_ID]);
        $data['clk'] = $clk;

        // AC
        $data['email']     = $email[0]->ACEmail;
        $data['name']      = $email[0]->AC;;
        $ecount = +self::sendEmail($data);

        // AM
        $data['email']     = $email[0]->AMEmail;
        $data['name']      = $email[0]->AM;;
        $ecount = +self::sendEmail($data);

        return $ecount;
    }



    public static function sendEmail($data)
    {
        if (empty($data['email']) || env('ALLOW_EMAIL')  == 0) {
            return -99;
        }


        try {
            ini_set('max_execution_time', 360);

            $content = 'Hi, <b>' . $data['name'] . '!</b> <br><br> Kindly see below details of the Cash Sales Deposit Audit of the Treasury Department';

            if ($content === 0):
                return 0;
            else:
                $data['content'] = $content;
                Mail::send(['html' => 'emails.mail'], $data, function ($message) use ($data) {
                    $subject = '[MyHub] Cash Sales Deposit Audit : Treasury Findings';
                    $message->to($data['email'], env('MAIL_FROM_NAME'))
                        ->cc(['jb.santiago@alfamart.com.ph', 'mp.gonzales@alfamart.com.ph'])
                        ->subject($subject);
                });
                return 1;
            endif;
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return -1;
        }
    }

    public static function sendEmailNotifTest()
    {
        $locID = 37;
        return   self::sendEmailNotif($locID);
    }
}
