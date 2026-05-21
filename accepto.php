<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

const ACCEPTO_WHMCS_API_BASE_URL = 'https://api.accepto.io';

function accepto_MetaData()
{
    return array(
        'DisplayName' => 'Accepto Crypto Payments',
        'APIVersion' => '1.1',
        'DisableLocalCreditCardInput' => true,
        'TokenisedStorage' => false,
    );
}

function accepto_config()
{
    return array(
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Accepto',
        ),
        'apiKey' => array(
            'FriendlyName' => 'API Key',
            'Type' => 'text',
            'Size' => '50',
            'Default' => '',
            'Description' => 'Enter your Accepto API Key',
        ),
    );
}

function accepto_link($params)
{
    $apiKey = $params['apiKey'];
    $apiBaseUrl = ACCEPTO_WHMCS_API_BASE_URL;

    // Invoice Parameters
    $invoiceId = $params['invoiceid'];
    $amount = $params['amount'];
    $currencyCode = $params['currency'];

    $postData = array(
        'merchant_order_id' => (string)$invoiceId,
        'amount' => (string)$amount,
        'currency' => $currencyCode,
        'attach' => json_encode(array('whmcs_invoice_id' => $invoiceId))
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiBaseUrl . '/api/v1/orders');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200 || $httpCode == 201) {
        $responseData = json_decode($response, true);
        if (isset($responseData['checkout_url'])) {
            $checkoutUrl = $responseData['checkout_url'];
            return '<form action="' . $checkoutUrl . '" method="GET">
                        <input type="submit" value="' . $params['langpaynow'] . '" class="btn btn-primary" />
                    </form>';
        }
    }

    return '<div class="alert alert-danger">Error initializing Accepto payment. Please check your API configuration.</div>';
}
