<h1>User email Verification</h1>

<p>Hello {{$name}},</p>
<p>Please click the below button to verify your email address</p>

<a href="http://127.0.0.1:8000/api/auth/emailverification/{{$token}}" ><button type="button">Click to verify</button></a>