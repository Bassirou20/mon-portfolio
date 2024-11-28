<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/../../vendor/autoload.php';


$dotenv = Dotenv::createImmutable(__DIR__ . '/../');


$dotenv->load();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone_number = strip_tags(trim($_POST["phone_number"]));
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($phone_number) || empty($subject) || empty($message)) {
        echo "Please fill in all fields.";
        exit;
    }

    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $recipient = "bassirouseye53@gmail.com";

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;

        // Chargement depuis .env
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($email, $name);
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = "
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; background-color: #f9f9f9; color: #333; }
                    .container { max-width: 600px; margin: 20px auto; padding: 20px; background: #fff; border: 1px solid #ddd; border-radius: 8px; }
                    h2 { color: #4CAF50; }
                    .info { margin-bottom: 20px; }
                    .info strong { display: inline-block; min-width: 120px; }
                    .message { margin-top: 20px; padding: 15px; background: #f7f7f7; border-left: 4px solid #4CAF50; }
                    .footer { margin-top: 20px; font-size: 12px; color: #777; }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Nouvelle demande de contact</h2>
                    <div class='info'>
                        <p><strong>Nom complet:</strong> $name</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Numéro de Téléphone:</strong> $phone_number</p>
                    </div>
                    <div class='message'>
                        <p><strong>Message:</strong></p>
                        <p>$message</p>
                    </div>
                    <div class='footer'>
                        <p>Ce message a été envoyé via le formulaire de contact.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        if ($mail->send()) {
            echo "success"; 
        } else {
            echo "Something went wrong.";
        }
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
