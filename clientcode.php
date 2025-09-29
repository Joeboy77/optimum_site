<?php 

  use PHPMailer\PHPMailer\PHPMailer;
  // use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  //include required phpmailer files
  require 'vendor/autoload.php';

session_start();
require 'config.php';
// error_reporting(0);

if (isset($_POST["sendnow"])) {
//   // echo '<script type="text/javascript">alert("You cannot proceed")</script>';
//   // Declaring variables
  $fullname = mysqli_real_escape_string($con, $_POST["fullname"]);
  $email = mysqli_real_escape_string($con, $_POST["email"]);
  $enquiry1 = mysqli_real_escape_string($con, $_POST["enquiry1"]);

      //Create instance of phpmailer
        $mail = new PHPMailer(true);

      try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = "true";
        $mail->Username = "optimumumtraininginstitute@gmail.com";
        $mail->Password = "sdlh msco lcll zihm";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $fullname);
        $mail->addAddress('optimumumtraininginstitute@gmail.com', 'Optimum TI');     //Add a recipient

        $mail->Subject = 'New Enquiry Message';
        $mail->Body    = "Name: $fullname\n".
                          "Email: $email\n".
                          "Message: $enquiry1";
        if ($mail->send()) {
          // code...
          //echo "Error...!";
          ?>
          <script>

            swal({
              title: "Success",
              text: "Success! Message sent successfully",
              icon: "success",
            });

          </script>

          <?php
          // header("Location: registration.php?error= Error!! Check internet connection");
          exit();
        }else{
          //echo "Error...!";
          ?>
          <script>

            swal({
              title: "Error",
              text: "Error!! Message could not be sent",
              icon: "error",
            });

          </script>

          <?php
          // header("Location: registration.php?error= Error!! Check internet connection");
          exit();
        }
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
}
?>