<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body style="left:0; top:0; padding:50px; border:20px solid #dadada; border-radius:20px; margin:50px; margin-top:0px; font-family:Verdana, Geneva, Tahoma, sans-serif; font-size: 20px; text-align: justify;">
    Hi {{ $name }},
    <br/><br/>
    This is to remind you of a scheduled data entry at {{ $quarter }}. Click on the link below to start:
    <br/>
    {{ $link }}
    <br/><br/>
    The Mailer,<br/>
    {{ env('APP_NAME') }}
</body>
</html>
