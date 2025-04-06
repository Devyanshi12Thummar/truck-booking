<?php

function sendSMS($mobileNo,$message) {
    $curl = curl_init();
    $api_key = "3RrvIReIyN9BkG93wkL2KRHhnzHioCYlVuCWWQE1yNXMUQofQh4rJIubRxt2";
    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2?authorization=" . $api_key . "&sender_id=TXTIND&message=" . urlencode($message) . "&route=v3&numbers=" . urlencode($mobileNo),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);


}
sendSMS("9033018682","hiiamisha") ;