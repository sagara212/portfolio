<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Accept");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses pengiriman email di sini
    $name = $_POST['name'] ?? 'Unknown';
    $email = $_POST['email'] ?? 'Unknown';
    $message = $_POST['message'] ?? 'No message';

    // Pengaturan email
    $to = "mbagusprayogi2@gmail.com";
    $subject = "New message from $name";
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

    // Mengirim email
    if (mail($to, $subject, $body)) {
        echo json_encode(["message" => "Email sent successfully!"]);
    } else {
        error_log("Failed to send email.", 0);
        echo json_encode(["message" => "Failed to send email."]);
    }
} else {
    error_log("Invalid request method.", 0);
    echo json_encode(["message" => "Invalid request method."]);
}
?>
