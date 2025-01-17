<html>
<body>
<form action="{{ route('home.verify', ['type' => 'birthcertificate']) }}" method="POST">
    @csrf
    <label for="number">Enter Birth Certificate Number:</label>
    <input type="text" id="number" name="number" required>
    <label for="name">Enter Full Name:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Verify</button>
</form>
</body>
</html>
