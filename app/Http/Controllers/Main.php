<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
class Main extends Controller
{
    public function updateProfile(){
        DB::beginTransaction();
        try {
            $data = \request()->data;
            $id = \request()->id;
            User::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated your profile.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }

    public function changePassword(){
        DB::beginTransaction();
        try {
            $data = ["password" => Hash::make(request()->new_password)];
            $id = request()->id;
            User::find($id)->update($data);
            DB::commit();
            return response()->json(['message' => 'Successfully updated your password.'], 200);
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e], 500);
        }
    }
    
    public function about(){
        return view('about');
    }

    public function dashboard(){
        DB::statement("SET SQL_MODE=''");
        $data = DB::select("SELECT SUM(p.amount) as amount FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) = MONTH(CURRENT_DATE())");
        $custom = DB::select("SELECT (SUM(p.downpayment) + SUM(p.fullpayment)) as amount FROM customization p WHERE p.status NOT IN('Pending', 'Disapproved') AND MONTH(p.created_at) = MONTH(CURRENT_DATE())");
        return view('home', compact('data', 'custom'));
    }

    public function fetchDashboard(){
        //sales per month this year
        $this_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = YEAR(CURRENT_DATE()) GROUP BY MONTH(o.created_at)");
        //last year
        $last_year = DB::select("SELECT SUM(p.amount) as amount, MONTH(o.created_at) as month_date FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Pending', 'Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = (YEAR(CURRENT_DATE()) -1) GROUP BY MONTH(o.created_at)");
        
        $type = DB::SELECT("SELECT COUNT(o.order_id) as order_count, p.type FROM product_sales p LEFT JOIN orders o ON p.product_id = o.product_id AND o.status NOT IN('Disapproved') WHERE MONTH(o.created_at) IS NOT NULL and YEAR(o.created_at) = (YEAR(CURRENT_DATE())) GROUP BY p.type");
        $custom = DB::SELECT("SELECT COUNT(custom_id) as custom_count FROM customization WHERE status <> 'Pending'");
        return response()->json(['this_year' => $this_year, 'last_year' => $last_year, 'type' => $type, 'custom' => $custom]);
    }

    public function sendSMS(){
        $details = [
            'title' => 'Mail from ItSolutionStuff.com',
            'body' => 'This is for testing email using smtp'
        ];
        // ini_set("SMTP","smtp.gmail.com");
        // ini_set("smtp_port","587");
        // ini_set("SMTP","ssl://smtp.gmail.com");
        // ini_set("smtp_port","465");
        // Please specify the return address to use
        // ini_set('sendmail_from', 'panganibanjohnmichael7@gmail.com');
        // mail('09071181516@vtext.com', '', 'sadasd');
        Mail::to('09071181516@vtext.com')->send(new \App\Mail\Mailing($details));
        return "sadas";
        // use PHPMailer\PHPMailer\PHPMailer;
        // use PHPMailer\PHPMailer\SMTP;
        // use PHPMailer\PHPMailer\Exception;

        //Create an instance; passing `true` enables exceptions
        // $mail = new PHPMailer(true);

        // try {
        //     //Server settings
        //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        //     $mail->isSMTP();                                            //Send using SMTP
        //     $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        //     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        //     $mail->Username   = 'user@example.com';                     //SMTP username
        //     $mail->Password   = 'secret';                               //SMTP password
        //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        //     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //     //Recipients
        //     $mail->setFrom('from@example.com', 'Mailer');
        //     $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        //     $mail->addAddress('ellen@example.com');               //Name is optional
        //     $mail->addReplyTo('info@example.com', 'Information');
        //     $mail->addCC('cc@example.com');
        //     $mail->addBCC('bcc@example.com');

        //     //Attachments
        //     $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //     $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //     //Content
        //     $mail->isHTML(true);                                  //Set email format to HTML
        //     $mail->Subject = 'Here is the subject';
        //     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        //     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        //     $mail->send();
        //     echo 'Message has been sent';
        // } catch (Exception $e) {
        //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        // }
    }
}
