<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require "../static/phpmailer/Exception.php";
    require '../static/phpmailer/PHPMailer.php';
    require '../static/phpmailer/SMTP.php';

    class EmailManager {
        public static function sendEmail($pReceivingEmail, $pSubject, $pBody, $pAttachment) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.strato.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@futurecombinations.nl';
                $mail->Password = '$Yr8RZkU4HQ!2SZKS';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('info@futurecombinations.nl', 'Top 2000');
                $mail->addAddress($pReceivingEmail);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $pSubject;
                $mail->Body    = $pBody;
                $mail->addEmbeddedImage($pAttachment, "qrcode");

                $mail->send();

                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
        public static function sendList($pReceivingEmail, $pSubject, $pBody) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.strato.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'info@futurecombinations.nl';
                $mail->Password = '$Yr8RZkU4HQ!2SZKS';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('info@futurecombinations.nl', 'Top 2000');
                $mail->addAddress($pReceivingEmail);

                //Content
                $mail->isHTML(true);
                $mail->Subject = $pSubject;
                $mail->Body    = $pBody;

                $mail->send();

                return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }