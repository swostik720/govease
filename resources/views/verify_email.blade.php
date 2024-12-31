<!-- Show messages if any -->
@if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Form to send OTP -->
<form method="POST" action="{{ route('sendOtp') }}">
    @csrf
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Send OTP</button>
</form>

<!-- Form to verify OTP -->
<form method="POST" action="{{ route('verifyOtp') }}">
    @csrf
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit">Verify OTP</button>
</form>

<p>Already verified? <a href="{{ route('login') }}">Sign in</a></p>