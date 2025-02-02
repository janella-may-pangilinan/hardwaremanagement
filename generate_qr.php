<?php
// generate_qr.php
require_once 'phpqrcode/qrlib.php';  // Include the QR code library

// Get the data from the URL parameter
$data = isset($_GET['data']) ? $_GET['data'] : 'No Data';

// Set the QR code output path
QRcode::png($data);
?>
