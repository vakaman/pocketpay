<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funds Transfer Notification | {{ config('app.name') }}</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px;">

    <img src="{{ env('APP_URL') . '/img/logo.png' }}" alt="{{ env('APP_NAME') }}" width="150">

    <h1 style="color: #333;">Funds Transfer Notification</h1>

    <p>Hello {{ $header->receiver }},</p>

    <p>We wanted to inform you that a funds transfer has been initiated from your account. Here are the details of the
        transfer:</p>

    <ul>
        <li><strong>From Account:</strong> {{ $header->sender }}</li>
        <li><strong>To Account:</strong> {{ $header->receiver }}</li>
    </ul>

    <p>If you have any questions or concerns regarding this transfer, please don't hesitate to contact our support team.
    </p>

    <p>Thank you for using our services!</p>

    <p>Regards,<br>
        The {{ config('app.name') }} Team</p>

</body>

</html>
