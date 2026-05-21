<?php
require_once __DIR__ . '/../../../init.php';
require_once __DIR__ . '/../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../includes/invoicefunctions.php';

$gatewayModuleName = 'accepto';
$gatewayParams = getGatewayVariables($gatewayModuleName);

if (!$gatewayParams['type']) {
    die("Module Not Activated");
}

$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

if (!$data || !isset($data['order'])) {
    die("Invalid payload");
}

$order = $data['order'];
$invoiceId = $order['merchant_order_id'];
$transactionId = $order['id'];
$paymentAmount = $order['amount'];
$paymentFee = 0;
$status = $order['status'];

$invoiceId = checkCbInvoiceID($invoiceId, $gatewayParams['name']);
checkCbTransID($transactionId);

if ($status === 'SUCCESS') {
    addInvoicePayment(
        $invoiceId,
        $transactionId,
        $paymentAmount,
        $paymentFee,
        $gatewayModuleName
    );
    logTransaction($gatewayParams['name'], $payload, "Successful");
    echo "OK";
} else {
    logTransaction($gatewayParams['name'], $payload, "Status: $status");
    echo "OK";
}
