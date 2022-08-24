<?php

if (isset($_FILES['file']) and $_FILES['file']['error'] === UPLOAD_ERR_OK and substr($_FILES['file']['name'], -5) === '.xlsx') {
    if (!move_uploaded_file($_FILES['file']['tmp_name'], 'data.xlsx')) {
        $response = [
            'isError' => true,
            'data' => 'Error! Something go wrong. Please try again'
        ];
        exit(json_encode($response));
    }
} else {
    $response = [
        'isError' => true,
        'data' => 'Error! Select .xlsx file and try again'
    ];
    exit(json_encode($response));
}

