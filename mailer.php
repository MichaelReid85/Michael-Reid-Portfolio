<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "mike1109r@yahoo.com";
        
        # Sender Data
        $name    = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["full-name"])));
        $email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone   = $_POST["phone-number"];
        $subject = $_POST["subject"];
        $budget  = $_POST["budget"];
        $file    = $_POST["file"];
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }
        
        # Mail Content
        $content = "Name: $name\n";
        $content .= "Subject: $subject\n\n";
        $content .= "Email: $email\n\n";
        $content .= "Phone: $phone\n\n";
        $content .= "Budget: $budget\n\n";
        $content .= "Message:\n$message\n";
        $content .= "File: <a href='$file' target='_blank'>$file</a>";

        # email headers.
        $headers = "From: $name <$email>";

        # Send the email.
        $success = mail($mail_to, $name, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong, we couldn't send your message.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
