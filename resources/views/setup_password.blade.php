<!DOCTYPE html>
<html>
<head>
    <title>Setup Password</title>
</head>
<body>
    <h1>Setup Your Password</h1>

    <form action="{{ route('setupPassword.store') }}" method="POST">
        @csrf
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <label for="password_confirmation">Confirm Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>

        <button type="submit">Set Password</button>
    </form>
</body>
</html>
