<?php
if($_POST) {

    $to_Email = 'support@sunandenergy.com'; // Write your email here to receive the form submissions
    $subject = 'New message from Sun & Energy'; // Write the subject you'll see in your inbox

    $name = $_POST["userName"];
    $email = $_POST["userEmail"];
    $phone = $_POST["userSubject"];
    $message = $_POST["userMessage"];
   
    // Use PHP To Detect An Ajax Request
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
   
        // Exit script for the JSON data
        $output = json_encode(
        array(
            'type'=> 'error',
            'text' => 'Request must come from Ajax'
        ));
       
        die($output);
    }
   
    // Checking if the $_POST vars well provided, Exit if there is one missing
    if(!isset($_POST["userChecking"]) || !isset($_POST["userName"]) || !isset($_POST["userEmail"]) || !isset($_POST["userSubject"]) || !isset($_POST["userMessage"])) {
        
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-close-round"></i> Input fields are empty!'));
        die($output);
    }

    // Anti-spam field, if the field is not empty, submission will be not proceeded. Let the spammers think that they got their message sent with a Thanks ;-)
    if(!empty($_POST["userChecking"])) {
        $output = json_encode(array('type'=>'error', 'text' => '<i class="icon ion-checkmark-round"></i> Thanks for your submission'));
        die($output);
    }
   
    // PHP validation for the fields required
    if(empty($_POST["userName"])) {
        $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Error on 1st field :<br>Name too short or not specified'));
        die($output);
    }
    
    if(!filter_var($_POST["userEmail"], FILTER_VALIDATE_EMAIL)) {
        $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Error on 2nd field :<br>Please enter a valid email address.'));
        die($output);
    }

    if(empty($_POST["userSubject"])) {
        $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Error on 3rd field :<br>Please select the reason of your message.'));
        die($output);
    }

    // Avoid too small message by changing the value of the minimum characters required. Here it's <20
    if(strlen($_POST["userMessage"])<20) {
        $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Error on 4th field :<br>Too short message! Take your time and write a few words.'));
        die($output);
    }
   
    // Proceed with PHP email
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type:text/html;charset=UTF-8' . "\r\n";
    $headers .= 'From: Sun & Energy <noreply@sunandenergy.com>' . "\r\n";
    $headers .= 'Reply-To: '.$_POST["userEmail"]."\r\n";
    
    'X-Mailer: PHP/' . phpversion();
    
    // Body of the Email received in your Inbox
    $emailcontent = "
    <head>
        <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1'>
    </head>
    <body style='font-family:Verdana;background:#f2f2f2;color:#606060;'>

        <style>
            h3 {
                font-weight: normal;
                color: #999999;
                margin-bottom: 0;
                font-size: 14px;
            }
            a , h2 {
                color: #6534ff;
            }
            p {
                margin-top: 5px;
                line-height:1.5;
                font-size: 14px;
            }
        </style>

        <table cellpadding='0' width='100%' cellspacing='0' border='0'>
            <tr>
                <td>
                    <table cellpadding='0' cellspacing='0' border='0' align='center' width='100%' style='border-collapse:collapse;'>
                        <tr>
                            <td>

                                <div>
                                    <table cellpadding='0' cellspacing='0' border='0' align='center'  style='width: 100%;max-width:600px;background:#FFFFFF;margin:0 auto;border-radius:5px;padding:50px 30px'>
                                        <tr>
                                            <td width='100%' colspan='3' align='left' style='padding-bottom:0;'>
                                                <div>
                                                    <h2>New message</h2>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width='100%' align='left' style='padding-bottom:30px;'>
                                                <div>
                                                    <p>Hello, you've just received a new message via the contact form on your website.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width='100%' align='left' style='padding-bottom:20px;'>
                                                <div>
                                                    <h3>From</h3>
                                                    <p>$name</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width='100%' align='left' style='padding-bottom:20px;'>
                                                <div>
                                                    <h3>Email Address</h3>
                                                    <p>$email</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width='100%' align='left' style='padding-bottom:20px;'>
                                                <div>
                                                    <h3>Phone Number</h3>
                                                    <p>$phone</p>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width='100%' align='left' style='padding-bottom:20px;'>
                                                <div>
                                                    <h3>Message</h3>
                                                    <p>$message</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";
    
    $Mailsending = @mail($to_Email, $subject, $emailcontent, $headers);
   
    if(!$Mailsending) {
        
        //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
        $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Oops! Looks like something went wrong<br>Please check your PHP mail configuration.'));
        die($output);
        
    } else {

        $STORE_MODE = "mailchimp";

        // MailChimp API Key findable in your Mailchimp's dashboard
        $API_KEY =  "79013bb6b24b2b032030786a08979cc3-us15";
                     
        // MailChimp List ID  findable in your Mailchimp's dashboard
        $LIST_ID =  "1ff8c93d9d";
         
        require('MailChimp.php');

        if($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["userEmail"])) {

            $emailFor = $_POST["userEmail"];
            
            header('HTTP/1.1 200 OK');
            header('Status: 200 OK');
            header('Content-type: application/json');

            // Checking if the email writing is good
            if(filter_var($emailFor, FILTER_VALIDATE_EMAIL)) {
                $MailChimp = new \Drewm\MailChimp($API_KEY);
                    
                $result = $MailChimp->call('lists/subscribe', array(
                            'id'                => $LIST_ID,
                            'email'             => array('email'=>$emailFor),
                            'double_optin'      => false,
                            'update_existing'   => true,
                            'replace_interests' => false,
                            'send_welcome'      => true,
                        ));     
        
                // SUCCESS SENDING
                if($result["email"] == $emailFor) {        
                    $output = json_encode(array('type'=>'message', 'text' => '<span><i class="icon ion-checkmark-round"></i></span><strong>Hello '.$_POST["userName"] .'!</strong><br>Your message has been sent, we will get back to you asap !'));
                    die($output);
                } else {
                    $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Oops! Looks like something went wrong<br>Please check your PHP mail configuration.'));
                    die($output);
                }
            // ERROR DURING THE VALIDATION 
            } else {
                $output = json_encode(array('type'=>'error', 'text' => '<span><i class="icon ion-close-round"></i></span>Oops! Looks like something went wrong<br>Please check your PHP mail configuration.'));
                die($output);
            }
        } else {
            header('HTTP/1.1 403 Forbidden');
            header('Status: 403 Forbidden');
        }
    }
}
?>