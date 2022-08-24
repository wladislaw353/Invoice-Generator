<?php

require_once 'file_upload.php';

use Shuchkin\SimpleXLSX;

require_once 'SimpleXLSX.php';
require_once 'db.php';

$xlsx = new SimpleXLSX('data.xlsx');

if ($xlsx->success()) {

    // Get ICO codes
    $ico_data = [];
    foreach ($xlsx->rows() as $key => $row) {
        if ($key === 0) continue;
        $ico_data[] = $row[0];
        $ico_data[] = $row[1];
    }
    $ico_data = array_unique($ico_data);
    $ico_data = array_values($ico_data);

    // Get user data from API
    $ch = curl_init();
    $options = [
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_URL            => "https://api.mockaroo.com/api/131d4840?count=". count($ico_data) ."&key=68adc680"
    ];
    curl_setopt_array($ch, $options);
    $user_data = json_decode(curl_exec($ch), true);
    curl_close($ch);

    // Build SQL query
    $sql_query = "INSERT IGNORE INTO users (ico, name, address, phone, email, iban, bankCode, bankName, swift) VALUES";
    foreach ($ico_data as $key => $ico) {
        $sql_query .= "(";
        $sql_query .= $ico . ', ';
        $sql_query .= '"' . $user_data[$key]['name'] . '", ';
        $sql_query .= '"' . $user_data[$key]['address'] . '", ';
        $sql_query .= '"' . $user_data[$key]['phone'] . '", ';
        $sql_query .= '"' . $user_data[$key]['email'] . '", ';
        $sql_query .= '"' . $user_data[$key]['iban'] . '", ';
        $sql_query .= '"' . $user_data[$key]['bankCode'] . '", ';
        $sql_query .= '"' . $user_data[$key]['bankName'] . '", ';
        $sql_query .= '"' . strtoupper(substr($user_data[$key]['bankName'], 0, 4)) . 'CZPP' . rand(100, 999) . '"'; // Generate SWIFT
        $sql_query .= "),";
    }
    // Replace last , by ;
    $sql_query = substr_replace($sql_query, ';', -1);

    $db->query($sql_query);

    unlink('data.xlsx');

    $response = [
        'isError' => false,
        'data' => 'Users successfully added'
    ];
} else {
    $response = [
        'isError' => true,
        'data' => 'xlsx error: ' . $xlsx->error()
    ];
}
exit (json_encode($response));
