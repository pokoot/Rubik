<?php  if ( !defined("BASE_PATH")) exit( "No direct script access allowed" );

/**
 * Send an email
 *
 * @access public
 * @param mixed $recipient email address
 * @param string $subject email header
 * @param string $message email body
 * @return void
 */
if( !function_exists('send_email')){

    function send_email( $to , $subject = 'Test email', $message = 'Hello World' , $cc = '' , $bcc = '' ){

        ini_set('SMTP','localhost');
        ini_set('sendmail_from', 'noreply@thecellcity.com');

        $from = "noreply <noreply@thecellcity.com>";
        $from = explode( '<' , $from );

        $headers = "From: =?UTF-8?B?" . base64_encode($from[0]). "?= <" . $from[1] . "\n";


        $to = "=?UTF-8?B?" . base64_encode(''). "?= <" .  $to . ">";


        $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=\n";

        if( $cc != '' ){
            $headers .= "Cc: =?UTF-8?B?" . base64_encode(''). "?= <" . $cc  . ">\n";
        }

        if( $bcc != ''){
            $headers .= "Bcc: =?UTF-8?B?" . base64_encode('') . "?= <" . $bcc . ">\n";
        }

        $headers .=
            "Content-Type: text/plain; " .
            "charset=UTF-8; format=flowed\n" .
            "MIME-Version: 1.0\n" .
            "Content-Transfer-Encoding: 8bit\n" .
            "X-Mailer: PHP\n";

        $status =  @mail($to, $subject, $message, $headers);

        return $status;




        /*

        if( !$headers ){

            $headers =  'From: ' . EMAIL_FROM . "\r\n" .
                        'Reply-To: ' . EMAIL_REPLY_TO . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
        }


        $status = @mail( $recipient , $subject , $message , $headers );

        return $status;
        */
    }
}


?>
