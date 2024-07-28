<?php
session_start();
include 'Controller/api_me.php';
include 'Controller/api_schedules.php';

// URL API yang membutuhkan otentikasi
$api_url = 'http://143.198.218.9:8000/api/me'; // Sesuaikan dengan URL API Anda
$schedules_api_url = 'http://143.198.218.9:8000/api/schedules'; // URL API untuk jadwal

if (isset($_SESSION['token'])) {
    $response_data = getUserData($api_url, $_SESSION['token']);
    if (isset($response_data['error'])) {
        $error_message = $response_data['error'];
        $response_data = null;
    } else {
        $created_at = date('Y-m-d', strtotime($response_data['created_at']));
        // Logging respons API untuk debug
        file_put_contents('log.txt', "Dashboard Response: " . json_encode($response_data) . PHP_EOL, FILE_APPEND);
    }
} else {
    $response_data = null;
    $error_message = 'Anda belum login. Beberapa fitur mungkin tidak tersedia.';
}

$schedules_data = getSchedulesData($schedules_api_url);
if (isset($schedules_data['error'])) {
    $schedules_error_message = $schedules_data['error'];
    $schedules_data = [];
} else {
    $filtered_schedules = filterSchedulesForToday($schedules_data);
}

// Pastikan $filtered_schedules diinisialisasi
$filtered_schedules = [];

// Pagination logic
$items_per_page = 5; // Jumlah item per halaman
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman saat ini

$filtered_data = filterSchedulesForToday($schedules_data);
$pagination_result = paginateData($filtered_data, $items_per_page, $current_page);

$paginated_data = $pagination_result['data'];
$total_pages = $pagination_result['total_pages'];
$current_page = $pagination_result['current_page'];
?>