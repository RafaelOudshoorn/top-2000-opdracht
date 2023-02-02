<?php
    declare(strict_types=1);

    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;

    class TicketManager {
        public static function getAmountByDate($pDate, $pTime): int {
            global $con;

            $stmt = $con->prepare("SELECT SUM(`amount`) FROM `ticket` WHERE `datetime` = ?;");
            $stmt->bindValue(1, $pDate . ' ' . $pTime);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        }

        public static function checkBoughtTickets($pEmail): array
        {
            global $con;

            $stmt = $con->prepare("SELECT `email` FROM `ticket` WHERE `email` = ?;");
            $stmt->bindValue(1, $pEmail);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public static function createOrderNumber(): string {
            return "NPO2-" . date("dmy") . "-" . rand(10000,99999);
        }

        public static function addTicket($pOrder, $pName, $pEmail, $pDate, $pTime, $pAmount): void {
                global $con;

                $stmt = $con->prepare("INSERT INTO `ticket` (`orderNumber`, `name`, email, `datetime`, `amount`) VALUES (?, ?, ?, ?, ?);");
                $stmt->bindValue(1, $pOrder);
                $stmt->bindValue(2, $pName);
                $stmt->bindValue(3, $pEmail);
                $stmt->bindValue(4, $pDate . " " . $pTime);
                $stmt->bindValue(5, $pAmount);
                $stmt->execute();
        }

        public static function createQr($orderNumber, $pDate, $pTime): void {
            require_once('../vendor/autoload.php');

            $options = new QROptions(
                [
                    'eccLevel' => QRCode::ECC_L,
                    'outputType' => QRCode::OUTPUT_IMAGE_JPG,
                    'version' => QRCode::VERSION_AUTO,
                ]
            );
            $data = "{'OrderNumber': '{$orderNumber}', 'Timestamp': '{$pDate} {$pTime}'}";
            $url = (new QRCode($options))->render($data);

            $pattern = '/data:image\/(.+);base64,(.*)/';
            preg_match($pattern, $url, $matches);

            $imageExtension = $matches[1];
            $encodedImageData = $matches[2];
            $decodedImageData = base64_decode($encodedImageData);

            file_put_contents("../private/data/qrcode.{$imageExtension}", $decodedImageData);
        }

        public static function sendEmail($orderNumber, $pName, $pEmail, $pDate, $pTime, $pAmount): void {
            self::createQr($orderNumber, $pDate, $pTime);
            $pAttachment = "../private/data/qrcode.jpg";

            $message = "
                <!DOCTYPE html>
                <html lang='nl'>
                    <body style='
                        background-color: #e0e0e0;
                    '>
                        <div style='
                            width: 450px;
                            height: auto;
                            margin-left: auto;
                            margin-right: auto;
                            background-color: #ffffff;
                            border: 4px solid #D9151B;                      
                            border-radius: 12px;
                        '>
                            <div style='
                                width: 80%;
                                height: auto;
                                margin-left: auto;
                                margin-right: auto;
                                padding: 5%; 
                            '>
                                <h1>Top2000 Cafe Ticket</h1>
                                <p>Deze ticket is nodig om binnen te komen binnen het Top2000 cafe</p>
                                <p><span style='color:#D9151B;'>Ordernummer:</span> {$orderNumber}</p>
                                <p><span style='color:#D9151B;'>Naam:</span> {$pName}</p>
                                <p><span style='color:#D9151B;'>Email:</span> {$pEmail}</p>
                                <p><span style='color:#D9151B;'>Tijdslot:</span> {$pDate} {$pTime}</p>
                                <p><span style='color:#D9151B;'>Aantal:</span> {$pAmount}</p>
                                <img src='cid:qrcode' alt='qrcode'/>
                            </div>
                        </div>
                    </body>
                </html>
            ";

            EmailManager::sendEmail($pEmail, $pName, $message, $pAttachment);
        }

        public static function executeAll($pName, $pEmail, $pDate, $pTime, $pAmount): void
        {
            if(!self::getAmountByDate($pDate, $pTime) >= 75) {
                for($i = 1; $i <= $pAmount; $i++) {
                    $orderNumber = self::createOrderNumber();
                    
                    self::addTicket($orderNumber, $pName, $pEmail, $pDate, $pTime, $pAmount);
                    self::sendEmail($orderNumber, $pName, $pEmail, $pDate, $pTime, $pAmount);

                    header("location:ticket.php");
                }
            } else {
                self::displayWarning("Selecteer een ander tijdslot");
            }
        }

        public static function displayWarning($pMessage): void {
            echo "
                <div class='warning-container'>
                    <p class='warning-text'>{$pMessage}</p>
                    <hr>
                    <a class='warning-button' href='ticket.php'>Oke</a>
                </div>
            ";
        }

        public static function resendTicket($pEmail): void {
            global $con;

            $stmt = $con->prepare("SELECT * FROM `ticket` WHERE `email` = ?;");
            $stmt->bindValue(1, $pEmail);
            $stmt->execute();
            $tickets = $stmt->fetchAll(PDO::FETCH_OBJ);

            foreach ($tickets as $ticket) {
                $datetime = $ticket->datetime;
                $date = date("Y-m-d", strtotime($datetime));
                $time = date("H:i:s", strtotime($datetime));

                self::sendEmail($ticket->orderNumber, $ticket->name, $ticket->email, $date, $time, $ticket->amount);
            }

            header("location:ticket.php");
        }
    }