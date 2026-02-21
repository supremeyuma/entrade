<!-- resources/views/emails/charge_url.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Charge URL</title>
</head>
<body>
    <p>Dear Customer,</p>
    <p>Your charge URL is: <a href="{{ $charge_url }}">{{ $charge_url }}</a></p>
    <p>Thank you for your transaction.</p>
</body>
</html>
