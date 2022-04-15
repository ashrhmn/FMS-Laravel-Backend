<h1>Welcome {{ $name }}</h1>

<p> Click the link below to verify your email : </p>

<a href="http://127.0.0.1:8000/api/auth/verify-email/{{ $token }}">Verify Email</a>
