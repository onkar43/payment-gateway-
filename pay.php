<?php

    session_start();

    $cname = $_POST['name'];
    $cemail = $_POST['emailid'];
    $cmobile = $_POST['mobile'];
    $camount = $_POST['amount'];
    $cmessage = $_POST['message'];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/payment-requests/');
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:test_e972142dbff14043005f03ea5b1",
                  "X-Auth-Token:test_c37a0c2ca0a0f3a370f5ae0b895"));
    $payload = Array(
        'purpose' => $cmessage,
        'amount' => $camount,
        'phone' => $cmobile,
        'buyer_name' => $cname,
        'redirect_url' => 'http://localhost/payment/lastpage.php',
        'send_email' => TRUE,
        //'webhook' => 'http://www.example.com/webhook/',
        'send_sms' => TRUE,
        'email' => $cemail,
        'allow_repeated_payments' => FALSE
    );
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
    $response = curl_exec($ch);
    curl_close($ch); 

    

    echo $response;


    $response = json_decode($response, TRUE);

    $_SESSION['csname'] = $cname;
    $_SESSION['csemail'] = $cemail;
    $_SESSION['csamount'] = $camount;
    $_SESSION['cstransactionid'] = $response['payment_request']['id'];

    header("location:".$response['payment_request']['longurl']);

?>




