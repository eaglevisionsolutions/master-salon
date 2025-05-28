<?php
// Email/SMS Notification Helper
// NOTE: For production use, consider using PHPMailer or a transactional email service.

function send_email($to, $subject, $body, $from = 'noreply@salonspa.com') {
    $headers = "From: $from\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    return mail($to, $subject, $body, $headers);
}

// Example placeholder for SMS (implement as needed)
function send_sms($phone, $message) {
    // Integrate with an SMS API such as Twilio, Nexmo, etc.
    return true;
}
?>