<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil data dari formulir
    $name = htmlspecialchars($_POST['name'] ?? 'Unknown');
    $email = htmlspecialchars($_POST['email'] ?? 'Unknown');
    $message = htmlspecialchars($_POST['message'] ?? 'No message');

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Konfigurasi PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Pengaturan SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';         // Ganti dengan SMTP server Anda
        $mail->SMTPAuth = true;
        $mail->Username = 'your_email@example.com'; // Email Anda
        $mail->Password = 'your_password';         // Password email Anda
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enkripsi
        $mail->Port = 587;                         // Port SMTP (587 untuk TLS)

        // Pengaturan pengirim dan penerima
        $mail->setFrom('your_email@example.com', 'Your Name'); // Ganti dengan email pengirim
        $mail->addAddress('mbagusprayogi2@gmail.com');         // Ganti dengan email penerima

        // Konten email
        $mail->isHTML(true);
        $mail->Subject = "New message from $name";
        $mail->Body = "
            <h3>New Contact Message</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>$message</p>
        ";

        // Kirim email
        $mail->send();
        echo "Email has been sent successfully.";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request method.";
}
?>
