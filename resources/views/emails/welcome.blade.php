<!DOCTYPE html>
<html>
<head>
    <title>WELCOME TO {{ config('globals.app_full_name') }}</title>
</head>
<body>
    <h1>Hi, {{ $user->first_name }}!</h1>
    <p>Your account was created successfully</p>
    <p>User your email to login</p>
    <p>Your password is: <strong>{{ $password }}</strong></p>
    <p>This can be updated once you verify your email when logging in.</p>
</body>
</html>
