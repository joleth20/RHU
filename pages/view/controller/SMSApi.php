<?php

    // require_once( 'vendor/autoload.php' );
    //
    // use Semaphore\SemaphoreClient;
    // $client = new SemaphoreClient( '{6918c1d9849f34811e900d656f6722f7}', '{rhu}' ); //Sender Name defaults to SEMAPHORE
    // echo $client->send( '09461654559', 'test notif' );
    //


    $message_type = $_POST["message_type"];
    $contact_no = $_POST["number"];
    if (isset($_POST["status"])) {
      $status = $_POST["status"];
    }

    if ($message_type == "appt") {
        if ($status == "Pending") {
          $req_date = $_POST["req_date"];
          $req_time = $_POST["req_time"];
          $message_content = "New Appointment Request Received!
          \nDate: ".$req_date."
          \nTime: ".$req_time."
          \nPlease login to RHU website for more details.";
        }

        if ($status == "Approved") {
          $patient_name = $_POST["patient_name"];
          $req_date = $_POST["req_date"];
          $req_time = $_POST["req_time"];
          $doctor = $_POST["doctor"];

          $message_content = "Hi ".$patient_name.",
          \nGreat news! Your appointment for consultation at Montalban Rural Health Unit has been APPROVED.
          \nRequest Date:".$req_date."
          \nRequest Time:".$req_time."
          \nDoctor:".$doctor."
          \nStay safe! Before your visit, remember to bring your face mask, maintain social distance, and sanitize hands regularly. If you're experiencing symptoms or have been in contact with a COVID-positive person, please reschedule your appointment. Your health is our priority.
          \nThis is a one-way notification, and replies to this message will not be monitored.
          \nThank you,
          \nMontalban Rural Health Unit";

        }

        if ($status == "Rejected") {
          $patient_name = $_POST["patient_name"];

          $message_content = "Hi ".$patient_name.",
          \nWe regret to inform you that your appointment request for consultation at Montalban Rural Health Unit has been REJECTED.
          \nWe apologize for any inconvenience.
          \nThank you for your understanding.
          \nBest Regards,
          \nMontalban Rural Health Unit";
        }
    }elseif ($message_type == "rx") {
        if ($status == "Pending") {
            echo 1;
          $req_date = $_POST["req_date"];
          $req_time = $_POST["req_time"];
          $message_content = "New Medication Refills Request Received!
          \nDate: ".$req_date."
          \nTime: ".$req_time."
          \nPlease login to RHU website for more details.";
        }

        if ($status == "Approved") {
          $patient_name = $_POST["patient_name"];
          $req_date = $_POST["req_date"];
          $req_time = $_POST["req_time"];
          $doctor = $_POST["doctor"];

          $message_content = "Hi ".$patient_name.",
          \nGreat news! Your medication request at Montalban Rural Health Unit has been APPROVED.
          \nRequest Date:".$req_date."
          \nRequest Time:".$req_time."
          \nDoctor:".$doctor."
          \nThis is a one-way notification, and replies to this message will not be monitored.
          \nThank you,
          \nMontalban Rural Health Unit";
        }

        if ($status == "Rejected") {
          $patient_name = $_POST["patient_name"];

          $message_content = "Hi ".$patient_name.",
          \nWe regret to inform you that your Medication Refills at Montalban Rural Health Unit has been REJECTED.
          \nWe apologize for any inconvenience.
          \nThank you for your understanding.
          \nBest Regards,
          \nMontalban Rural Health Unit";
        }
    }elseif ($message_type == "reminder") {
      $patient_name = $_POST["patient_name"];
      $rx_name = $_POST["rx_name"];
      $days_remaining = $_POST["days_remaining"];

      $message_content = "Hi ".$patient_name.",
      \nThis is to remind you that your medication schedule for ".$rx_name." will end in ".$days_remaining." days.
      \nPlease login to RHU website for medication refills if needed.

      \nBest Regards,
      \nMontalban Rural Health Unit";
      
      echo "<script>alert('SMS Sent!')</script>";
    }elseif ($message_type == "otp_register" || $message_type == "otp_register_admin") {
      $patient_name = $_POST["patient_name"];
      $otp_code = $_POST["otp_code"];

      $message_content = "Hi ".$patient_name.",
      \nYour OTP is
      \n".$otp_code.".
      \nBest Regards,
      \nMontalban Rural Health Unit";

    }elseif ($message_type == "sms_template") {
      $patient_name = $_POST["patient_name"];
      $sms_content = $_POST["sms_content"];
      $message_content = "Hi ".$patient_name.",
      \n".$sms_content."
      \nBest Regards,
      \nMontalban Rural Health Unit";

    }
    
    // print_r($_POST);
    // exit();
  
    $apikey = "6918c1d9849f34811e900d656f6722f7";
    $number = $contact_no;
    $message = $message_content;
    $sendername = "RHUAREA1";
    $ch = curl_init();
    $parameters = array(
        'apikey' => $apikey, //Your API KEY
        'number' => $number,
        'message' => $message,
        'sendername' => $sendername
    );
    // echo $message_type."<br>";
    // echo $doctor."<br>";
    // echo $patient_name."<br>";
    // echo $req_time."<br>";
    // echo $req_date."<br>";
    // echo "Receiver Number: ".$number."<br>";
    // echo "Message: ".$message."<br>";

    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
    curl_setopt( $ch, CURLOPT_POST, 1 );

    //Send the parameters set above with the request
    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

    // Receive response from server
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $output = curl_exec( $ch );
    curl_close ($ch);

    // //Show the server response
    // echo $output;
    // echo '<script>alert('.$message_type.')</script>';
    // echo '<script>alert('.$message.')</script>';
    // print_r($_POST);
    // exit();
    if ($message_type == "appt") {
      echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
    }elseif ($message_type=="reminder") {
        echo "<script>window.top.location.href='../RHU/?p=rx_reminder';</script>";
    }elseif ($message_type=="otp_register") {
      echo "<script>window.top.location.href='../RHU/?p=otp';</script>";
    }elseif ($message_type=="otp_register_admin") {
      echo "<script>window.top.location.href='../RHU/?p=account_mgmt';</script>";
    }elseif ($message_type=="sms_template") {
      echo "<script>window.top.location.href='../RHU/?p=patient_records';</script>";
    }else {
      echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
    }
 ?>
