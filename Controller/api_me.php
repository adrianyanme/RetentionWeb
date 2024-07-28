<?php
function getUserData($api_url, $token) {
    $curl = curl_init($api_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $token
    ));

    $response = curl_exec($curl);
    if (curl_errno($curl)) {
        return ['error' => 'Request Error:' . curl_error($curl)];
    } else {
        return json_decode($response, true);
    }
    curl_close($curl);
}
?>
