<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $experience = $_POST['experience'];
    $work_in_us = $_POST['work-in-us'];
    $protected_veteran = $_POST['protected-veteran'];
    $disabled = $_POST['disabled'];
    $resume = $_FILES['resume'];
    $cover_letter = $_POST['cover-letter'];
    
    $to = 'info@neamsoftware.com';

    $subject = 'Job Application Form Submission';

    $message = "Name: $name\n";
    $message .= "Email: $email\n";
    $message .= "Years of Experience: $experience\n";
    $message .= "Can work in the US: $work_in_us\n";
    $message .= "Protected Veteran: $protected_veteran\n";
    $message .= "Disabled: $disabled\n";
    $message .= "Cover Letter: $cover_letter\n";

    $headers = "From: $email" . "\r\n" .
        "Reply-To: $email" . "\r\n" .
        "X-Mailer: PHP/" . phpversion();

    if ($resume['error'] == UPLOAD_ERR_OK) {
        $upload_path = 'uploads/';
        $uploaded_file = $upload_path . basename($resume['name']);

        if (move_uploaded_file($resume['tmp_name'], $uploaded_file)) {
            $file_attached = true;
            $file_path = $uploaded_file;
        }
    }

    if (mail($to, $subject, $message, $headers)) {
        header("Location: career.html");
        exit();
    } else {
        header("Location: error_page.html");
        exit();
    }
}
?>
