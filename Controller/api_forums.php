<?php
function getForumsData($api_url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    if ($result === FALSE) {
        return ['error' => 'Gagal mengambil data dari API'];
    }

    $data = json_decode($result, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => 'Gagal menguraikan data JSON'];
    }

    return $data;
}
?>
