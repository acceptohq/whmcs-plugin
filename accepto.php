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
    $endpoint = ACCEPTO_WHMCS_API_BASE_URL . '/v1/orders';

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
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
        'Accept: application/json'
    ));

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($response === false || $curlError) {
        if (function_exists('logTransaction')) {
            logTransaction('Accepto', array(
                'endpoint' => $endpoint,
                'curl_error' => $curlError,
            ), 'Connection Error');
        }

        return '<div class="alert alert-danger">Error initializing Accepto payment. Please check your API configuration.</div>';
    }

    if ($httpCode == 200 || $httpCode == 201) {
        $responseData = json_decode($response, true);
        if (isset($responseData['checkout_url'])) {
            $checkoutUrl = htmlspecialchars($responseData['checkout_url'], ENT_QUOTES, 'UTF-8');
            $payNowLabel = htmlspecialchars($params['langpaynow'], ENT_QUOTES, 'UTF-8');

            return '<a href="' . $checkoutUrl . '" class="btn btn-primary">' . $payNowLabel . '</a>';
        }
    }

    if (function_exists('logTransaction')) {
        logTransaction('Accepto', array(
            'endpoint' => $endpoint,
            'http_code' => $httpCode,
            'response' => $response,
        ), 'API Error');
    }

    return '<div class="alert alert-danger">Error initializing Accepto payment. Please check your API configuration.</div>';
}
