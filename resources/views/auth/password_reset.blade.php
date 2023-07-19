<!DOCTYPE html>
<html>

<head>
    <title>Linn Training System</title>
</head>

<body>
    <h4>Dear {{ $details['name'] ?? '' }},</h4>
    <h2 style="color:cornflowerblue">Password Reset Link</h2>
    <p><a href="{{ $details['link'] }}">{{ $details['link'] }}</a></p>
    <p>Please do not share it except this account.</p>
    <p>Respectully yours,</p>
    <p>Linn Training System</p>
</body>

</html>
