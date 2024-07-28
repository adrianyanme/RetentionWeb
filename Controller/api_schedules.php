<?php


function getSchedulesData($schedules_api_url) {
    $curl_schedules = curl_init($schedules_api_url);
    curl_setopt($curl_schedules, CURLOPT_RETURNTRANSFER, true);

    $schedules_response = curl_exec($curl_schedules);
    if (curl_errno($curl_schedules)) {
        return ['error' => 'Request Error:' . curl_error($curl_schedules)];
    } else {
        return json_decode($schedules_response, true);
    }
    curl_close($curl_schedules);
}

function filterSchedulesForToday($schedules_data) {
    $today = date('Y-m-d');
    $filtered_data = array_filter($schedules_data, function($schedule) use ($today) {
        return strpos($schedule['hearing_time'], $today) === 0;
    });
    
    return $filtered_data;
}

function paginateData($data, $items_per_page, $current_page) {
    // Pastikan $data adalah array atau Countable
    if (!is_array($data) && !$data instanceof Countable) {
        $data = [];
    }

    $total_items = count($data);
    $total_pages = ceil($total_items / $items_per_page);
    $start_index = ($current_page - 1) * $items_per_page;

    // Pastikan start_index tidak melebihi jumlah total item
    if ($start_index >= $total_items) {
        $start_index = 0;
        $current_page = 1;
    }

    $paginated_data = array_slice($data, $start_index, $items_per_page);

    

    return [
        'data' => $paginated_data,
        'total_pages' => $total_pages,
        'current_page' => $current_page
    ];
}
?>