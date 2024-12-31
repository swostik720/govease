<!DOCTYPE html>
<html>
<head>
    <title>Select Option</title>
</head>
<body>
    <h1>Select your option</h1>
    <form action="{{ route('selectOption') }}" method="POST">
        @csrf <!-- CSRF Token -->
        <!-- Add fields here for selecting citizenship, driving license, etc. -->
        <label for="citizenship">Citizenship</label>
        <input type="radio" id="citizenship" name="option" value="citizenship">
        
        <label for="license">Driving License</label>
        <input type="radio" id="license" name="option" value="license">
        
        <button type="submit">Next</button>
    </form>
</body>
</html>
