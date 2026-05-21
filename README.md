# Accepto WHMCS Plugin

[English](#english) | [中文](#中文)

## English

Accepto WHMCS Plugin lets WHMCS merchants accept cryptocurrency payments through Accepto. Customers are redirected from a WHMCS invoice to the hosted Accepto checkout page, and successful payment notifications are recorded back into WHMCS automatically.

### Download

Download the latest plugin package from:

https://github.com/acceptohq/whmcs-plugin/archive/refs/heads/main.zip

### Requirements

- WHMCS 8.x or later
- PHP cURL extension enabled
- An active Accepto merchant account
- An Accepto secret API key

### Installation

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

### Webhook URL

Configure the following webhook URL in your Accepto dashboard:

```text
https://your-whmcs-domain.com/modules/gateways/callback/accepto_callback.php
```

Replace `your-whmcs-domain.com` with your actual WHMCS domain.

### How It Works

1. A customer opens a WHMCS invoice and chooses Accepto as the payment method.
2. The plugin creates an Accepto order with the invoice amount and currency.
3. WHMCS redirects the customer to the Accepto checkout URL.
4. The customer pays with a supported cryptocurrency.
5. Accepto sends a webhook to WHMCS after payment is completed.
6. The plugin marks the invoice as paid when the webhook status is `SUCCESS`.

### Configuration Fields

| Field | Required | Description |
| --- | --- | --- |
| API Key | Yes | Your secret Accepto API key from the Accepto dashboard. |

### Troubleshooting

- If WHMCS shows `Error initializing Accepto payment`, confirm that the API Key is correct and active.
- If invoices are not marked paid, confirm that the webhook URL is configured in Accepto and reachable from the public internet.
- If the payment button does not appear, make sure the Accepto gateway is activated and enabled for the invoice currency.

### Security Notes

- Do not share your secret API Key publicly.
- Use HTTPS for your WHMCS site and webhook URL.
- Keep WHMCS and PHP dependencies up to date.

## 中文

Accepto WHMCS 插件用于帮助 WHMCS 商户接入 Accepto 加密货币收款。客户在 WHMCS 账单页面选择 Accepto 后，会跳转到 Accepto 托管收银台完成支付；支付成功后，Accepto 会通过回调通知 WHMCS，并自动将账单标记为已支付。

### 下载

下载最新插件包：

https://github.com/acceptohq/whmcs-plugin/archive/refs/heads/main.zip

### 环境要求

- WHMCS 8.x 或更高版本
- PHP 已启用 cURL 扩展
- 已开通 Accepto 商户账户
- Accepto Secret API Key

### 安装步骤

1. 下载并解压插件包。
2. 将 `accepto.php` 上传到：

```text
modules/gateways/accepto.php
```

3. 将 `callback/accepto_callback.php` 上传到：

```text
modules/gateways/callback/accepto_callback.php
```

4. 登录 WHMCS 后台，进入 `System Settings` > `Payment Gateways`。
5. 启用 `Accepto` 支付网关。
6. 在 `API Key` 字段中填写您的 Accepto API Key。
7. 保存支付网关设置。

Accepto API 地址已内置在插件中：`https://api.accepto.io`，商户不需要填写或配置 API Base URL。

### 回调地址

请在 Accepto 后台配置以下 Webhook URL：

```text
https://your-whmcs-domain.com/modules/gateways/callback/accepto_callback.php
```

请将 `your-whmcs-domain.com` 替换为您的真实 WHMCS 域名。

### 工作流程

1. 客户打开 WHMCS 账单并选择 Accepto 作为支付方式。
2. 插件根据账单金额和币种创建 Accepto 订单。
3. WHMCS 将客户跳转到 Accepto 收银台。
4. 客户使用支持的加密货币完成支付。
5. 支付完成后，Accepto 向 WHMCS 发送 Webhook 回调。
6. 当回调状态为 `SUCCESS` 时，插件自动将 WHMCS 账单标记为已支付。

### 配置字段

| 字段 | 是否必填 | 说明 |
| --- | --- | --- |
| API Key | 是 | 您在 Accepto 后台获取的 Secret API Key。 |

### 常见问题

- 如果 WHMCS 显示 `Error initializing Accepto payment`，请确认 API Key 正确且处于可用状态。
- 如果账单没有自动标记为已支付，请确认 Webhook URL 已在 Accepto 后台配置，并且公网可访问。
- 如果账单页没有显示支付按钮，请确认 Accepto 支付网关已启用，并且当前账单币种允许使用该网关。

### 安全建议

- 请勿公开分享您的 Secret API Key。
- WHMCS 站点和 Webhook URL 请使用 HTTPS。
- 请保持 WHMCS 和 PHP 运行环境及时更新。
