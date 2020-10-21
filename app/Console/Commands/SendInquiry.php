<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMaileur\PHPMailer\Exception;
use App\Models\Email;
use App\Models\Inquiry;
use Carbon\Carbon;

class SendInquiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inquiry:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        $email = new Email;
        $mailCredentials = $email->getMailCredentials();
        $inquiry = new Inquiry;
        $pending = $inquiry->getPendingEmail();
   
        foreach($pending as $row){
            // Instantiation and passing `true` enables exceptions
            $mail = new PHPMailer();

            try {
                // Server settings
                $mail->SMTPDebug = 0;                                	// Enable verbose debug output
                $mail->isSMTP();       
                $mail->CharSet    = "iso-8859-1";                      // Set mailer to use SMTP
                $mail->Host       = 'smtp.office365.com';              // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                              // Enable SMTP authentication
                $mail->Username   = $mailCredentials->email;           // SMTP username
                $mail->Password   = $mailCredentials->email_password;  // SMTP password
                $mail->SMTPSecure = 'tls';                             // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587; 

                //Recipients
                $mail->setFrom($mailCredentials->email, 'IPC Customer Relations');
                $mail->addAddress('paulalcabasa@gmail.com');
               // $mail->addAddress($row->dealer_crt_email);     // Add a recipient
               // $mail->addCC('customer-relations@isuzuphil.com');
                $mail->addBCC('paul-alcabasa@isuzuphil.com');

                $data = [
                    'details' => $row
                ];
                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Service Campaign: Isuzu Traviz';
                $mail->Body    = view('email/inquiry', $data);

                if($mail->send()){
                    //$inquiry = Inquiry::findOrFail($row->id);
                   // $inquiry->date_sent = Carbon::now();
                   // $inquiry->save();
                }
                
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        
    }
}
