<?php
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

     
        // Get the form fields and remove whitespace.
        $firstname = strip_tags(trim($_POST["fname"]));
		$firstname = str_replace(array("\r","\n"),array(" "," "),$firstname);
        $lastname = strip_tags(trim($_POST["lname"]));
		$lastname = str_replace(array("\r","\n"),array(" "," "),$lastname);
        $phoneno = filter_var(trim($_POST["pno"]), FILTER_SANITIZE_EMAIL);
        $zipcode = trim($_POST["zcode"]);
        $checkval = isset($_POST["leadid_tcpa_disclosure"]) ? 'Checked' : 'Not Checked';
         $leadId = trim($_POST["universal_leadid"]);

        // Check that data was sent to the mailer.
        if ( empty($firstname) OR empty( $lastname ) OR empty($phoneno) OR empty($zipcode)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Update this to your desired email address.
        $recipient = "leads@goinsurer.com";
		$subject = "Message from $firstname";

        // Email content.
        $email_content = "Name: $firstname . ' ' . $lastname \n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Phone: $phoneno\n";
        $email_content .= "ZipCode: $zipcode\n";
        $email_content .= "Agreed: $checkval\n";
        $email_content .= "Lead Id: $leadId\n";

        // Email headers.
        $email_headers = "From: $firstname <$phoneno>";

        // Send the email.
        
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
          header("Location: ../index.html");
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
