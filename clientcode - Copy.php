<?php 
session_start();
require 'config.php';
// error_reporting(0);

if (isset($_POST["sendnow"])) {
  // echo '<script type="text/javascript">alert("You cannot proceed")</script>';
  // Declaring variables
  $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
  $enquiry1 = mysqli_real_escape_string($con, $_POST["enquiry1"]);

  //Import PHPMailer classes into the global namespace
  //These must be at the top of your script, not inside a function
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication

    $mail->Username   = 'optimumumtraininginstitute@gmail.com';                     //SMTP username
    $mail->Password   = 'sdlhmscolcllzihm';                               //SMTP password

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, $fullname);
    $mail->addAddress('optimumumtraininginstitute@gmail.com', 'Optimum TI');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Enquiry Message';
    $mail->Body    = $enquiry1;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}
?>