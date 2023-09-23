<?php
if(isset($_POST['email'])) {

    $to = "neamtechnologies@gmail.com";
    $subject = "New contact form submission";

    function died($error) {

        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }

    // validates that expected data exists
    if(!isset($_POST['name']) ||
        !isset($_POST['company']) ||
        !isset($_POST['email']) ||
        !isset($_POST['service'])) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');
    }

    $name = $_POST['name']; // required
    $company = $_POST['company']; // required
    $email_from = $_POST['email']; // required
    $service = $_POST['service']; // not required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/';

    if(!preg_match($email_exp,$email_from)) {
        $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if(!preg_match($string_exp,$name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br />';
    }

    if(strlen($error_message) > 0) {
        died($error_message);
    }

    $email_message = "Form details below.\n\n";

    function clean_string($string) {
        $bad = array("content-type","bcc:","to:","cc:","href");
        return str_replace($bad,"",$string);
    }

    $email_message .= "Name: ".clean_string($name)."\n";
    $email_message .= "Phone Number: ".clean_string($company)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Service: ".clean_string($service)."\n";

    $headers = 'From: '.$email_from."\r\n".
    'Reply-To: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();

    // sends email
    mail($to, $subject, $email_message, $headers);

    header("Location: index.html"); // Replace "thank_you.html" with your actual thank you page URL

    // Sends an automated response to the client
    $email_subject = "Thank you for contacting us!";
    $email_body = "Thank you for reaching out to NEAM Technologies! We greatly appreciate your interest in our company and we are thrilled to hear from you. Rest assured that your message has been received and our dedicated team is diligently reviewing and preparing a response to your inquiry. We understand the value of your time and we are committed to providing you with the best possible service. In the meantime, we invite you to explore our website to learn more about our comprehensive services and innovative solutions. Should you have any further questions or comments, please do not hesitate to let us know. We are here to assist you in every way we can. Once again, thank you for choosing NEAM Technologies. We eagerly anticipate connecting with you soon!
        Best regards,
The NEAM Technologies Team";
    $headers = "From: neamtechnologies@gmail.com\n";
    mail($email_from, $email_subject, $email_body, $headers);

    exit;
}
?>
