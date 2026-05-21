# Accepto WHMCS Plugin

Accepto WHMCS Plugin lets WHMCS merchants accept cryptocurrency payments through Accepto. Customers are redirected from a WHMCS invoice to the hosted Accepto checkout page, and successful payment notifications are recorded back into WHMCS automatically.

## Download

Download the latest plugin package from:

https://github.com/acceptohq/whmcs-plugin/archive/refs/heads/main.zip

## Requirements

- WHMCS 8.x or later
- PHP cURL extension enabled
- An active Accepto merchant account
- An Accepto secret API key

## Installation

1. Download and unzip the plugin package.
2. Upload `accepto.php` to:

```text
modules/gateways/accepto.php
```

3. Upload `callback/accepto_callback.php` to:

```text
modules/gateways/callback/accepto_callback.php
```

4. In WHMCS, go to `System Settings` > `Payment Gateways`.
5. Activate `Accepto`.
6. Paste your Accepto API Key into the `API Key` field.
7. Save the gateway settings.

The Accepto API endpoint is built into the plugin as `https://api.accepto.io`, so merchants do not need to configure an API Base URL.

## Webhook URL

Configure the following webhook URL in your Accepto dashboard:

```text
https://your-whmcs-domain.com/modules/gateways/callback/accepto_callback.php
```

Replace `your-whmcs-domain.com` with your actual WHMCS domain.

## How It Works

1. A customer opens a WHMCS invoice and chooses Accepto as the payment method.
2. The plugin creates an Accepto order with the invoice amount and currency.
3. WHMCS redirects the customer to the Accepto checkout URL.
4. The customer pays with a supported cryptocurrency.
5. Accepto sends a webhook to WHMCS after payment is completed.
6. The plugin marks the invoice as paid when the webhook status is `SUCCESS`.

## Configuration Fields

| Field | Required | Description |
| --- | --- | --- |
| API Key | Yes | Your secret Accepto API key from the Accepto dashboard. |

## Troubleshooting

- If WHMCS shows `Error initializing Accepto payment`, confirm that the API Key is correct and active.
- If invoices are not marked paid, confirm that the webhook URL is configured in Accepto and reachable from the public internet.
- If the payment button does not appear, make sure the Accepto gateway is activated and enabled for the invoice currency.

## Security Notes

- Do not share your secret API Key publicly.
- Use HTTPS for your WHMCS site and webhook URL.
- Keep WHMCS and PHP dependencies up to date.
