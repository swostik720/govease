<!DOCTYPE html>
<html>
<head>
    <title>License Verification</title>
</head>
<body>
    <h1>Verify License</h1>
    <form action="{{ route('licenseVerify') }}" method="POST">
        @csrf
        <div>
            <label for="license_number">License Number:</label>
            <input type="text" id="license_number" name="license_number" required>
        </div>
        <div>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit">Verify</button>
    </form>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
