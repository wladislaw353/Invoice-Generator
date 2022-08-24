<?php

require_once 'file_upload.php';

use Shuchkin\SimpleXLSX;

require_once 'SimpleXLSX.php';
require_once 'tcpdf/tcpdf.php';
require_once 'db.php';

$xlsx = new SimpleXLSX('data.xlsx');

if ($xlsx->success()) {

    // Get ICO codes and amount
    $header_values = $xlsx_data = [];
    foreach ($xlsx->rows() as $key => $row) {
        // Get columns names
        if ($key === 0) {
            foreach ($row as $text) {
                if ($text) $header_values[] = strtolower( explode(' / ', $text)[1] );
            }
            continue;
        }
        // Delete empty elements
        $row = array_filter($row, function($element) {
            return !empty($element);
        });
        // Add columns names as a key of array
        $xlsx_data[] = array_combine( $header_values, $row );
    }
    
    // Get user data from DB
    $sql = $db->prepare("SELECT ico, name, address, phone, email, iban, bankCode, bankName, swift FROM users");
    $sql->execute();
    $users = $sql->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);

    $invoices = [];
    foreach ($xlsx_data as $invoice) {
        $supplier_data = $users[$invoice['supplier']][0];
        $receiver_data = $users[$invoice['receiver']][0];
        if (!$supplier_data || !$receiver_data) {
            continue;
        }
        $file = generatePDF(
            $invoice['supplier'],
            $invoice['receiver'],
            $users,
            $invoice['amount'],
            rand(1000000000, 9999999999), // faktura
            date('d.m.Y'), // date_vystaveni
            date('d.m.Y', strtotime("+30 day")), // date_splatnosti
            rand(1000000000, 9999999999) // cislo_uctu
        );
        $invoices[] = [
            'name' => $supplier_data['name'] . ' - ' . $receiver_data['name'],
            'link' => $file
        ];
    }

    unlink('data.xlsx');

    $response = [
        'isError' => false,
        'data' => $invoices
    ];    
} else {
    $response = [
        'isError' => true,
        'data' => 'xlsx error: ' . $xlsx->error()
    ];
}
exit (json_encode($response));


function getToken($data) {
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

function generatePDF($supplier, $receiver, $users, $amount, $faktura, $date_vystaveni, $date_splatnosti, $cislo_uctu) {

    // Uses for invoice_template.php
    $s_name     = $users[$supplier][0]['name'];
    $s_address  = $users[$supplier][0]['address'];
    $s_phone    = $users[$supplier][0]['phone'];
    $s_email    = $users[$supplier][0]['email'];
    $s_bankName = $users[$supplier][0]['bankName'];
    $s_swift    = $users[$supplier][0]['swift'];
    $s_iban     = $users[$supplier][0]['iban'];
    $s_bankCode = $users[$supplier][0]['bankCode'];
    $r_name     = $users[$receiver][0]['name'];
    $r_address  = $users[$receiver][0]['address'];

    $invoice_number = getToken(openssl_random_pseudo_bytes(16));

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    
    $pdf->SetCreator($s_name);
    $pdf->SetAuthor($s_name);
    $pdf->SetTitle('Invoice '.$invoice_number);
    $pdf->SetSubject('');
    $pdf->SetKeywords('');
    
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetMargins(7, 7, 7);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    $pdf->SetFont('dejavusans', '', 9);
    $pdf->AddPage();
    
    // $html
    require 'invoice_template.php';

    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    
    $style = [
        'border' => 0,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => [0,0,0],
        'bgcolor' => false,
        'module_width' => 1,
        'module_height' => 1
    ];
    
    $pdf->write2DBarcode('https://www.naseandulka.cz/uklid-domu-praha/', 'QRCODE,H', 7, 203, 50, 50, $style, 'N');
    
    $path = "/../invoices/invoice-$invoice_number.pdf";

    $pdf->Output(__DIR__ . $path, 'F');

    return $path;
}