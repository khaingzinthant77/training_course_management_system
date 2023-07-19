<!DOCTYPE html>
<html>

<head>
    <title>VPS Control Panel</title>
</head>

<body>
    <h4>Dear Sir,</h4>
    <p>For <b> {{ $details['name'] ?? '' }} <b>, VPS Control Panel access OTP code is <b> {{ $details['otp'] }}.</b></p>
    <p>Please do not share it except this account.</p>
    <p>Respectully yours,</p>
    <p>VPS Control Panel</p>
</body>

</html>
