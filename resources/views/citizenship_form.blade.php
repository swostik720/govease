<!DOCTYPE html>
<html>
<head>
    <title>Citizenship Verification</title>
</head>
<body>
    <h1>Verify Citizenship</h1>
    <form action="{{ route('citizenshipVerify') }}" method="POST">
        @csrf
        <div>
            <label for="number">Citizenship Number:</label>
            <input type="text" id="number" name="number" required>
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
