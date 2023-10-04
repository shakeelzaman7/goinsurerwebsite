<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

     
        // Get the form fields and remove whitespace.
        $email = strip_tags(trim($_POST["emailsub"]));
		$email = str_replace(array("\r","\n"),array(" "," "),$email);

        // Check that data was sent to the mailer.
        if ( empty($email)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Update this to your desired email address.
        $recipient = "leads@goinsurer.com";
		$subject = "Email subscription from $email";

        // Email content.
        $email_content = "Email : $email\n\n";

        // Email headers.
        $email_headers = "From: <$email>";

        // Send the email.
        
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
          header("Location: ./index.html");
    exit;
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
