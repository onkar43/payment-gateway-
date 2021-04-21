
<?php

  
    session_start();

    $cname = $_POST['name'];
    $cemail = $_POST['emailid'];
    $cmobile = $_POST['mobile'];
    $camount = $_POST['amount'];
    $cmessage = $_POST['message'];


    include 'instamojo/Instamojo.php';

    $apikey = 'test_e972142dbff14043005f03ea5b1';
    $apiauth = 'test_c37a0c2ca0a0f3a370f5ae0b895';

    $api = new Instamojo\Instamojo($apikey, $apiauth, 'https://test.instamojo.com/api/1.1/');



    try 
    {

        $response = $api->paymentRequestCreate(array(

            "purpose" => $cmessage,

            "amount" => $camount,

            "send_email" => TRUE,

            "buyer_name" => $cname,

            "email" => $cemail,

            "phone" => $cmobile,

            "send_sms" => TRUE,

            "allow repeated payment"=>FALSE,

            "redirect_url" => "http://localhost/payment/lastpage.php"

            ));

            $pay_url = $response['longurl'];

            header("location: $pay_url");

    }

  catch (Exception $e) 
  {

    print('Error: ' .$e->getMessage());

  }

    $_SESSION['csname'] = $cname;
    $_SESSION['csemail'] = $cemail;
    $_SESSION['csamount'] = $camount;
    $_SESSION['cstransactionid'] = $response['id'];

?>