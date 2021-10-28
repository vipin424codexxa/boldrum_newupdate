Hello {{$email_data['name']}}
<br><br>
<h4>Welcome to Boldrum.dk</h4>
Please click the below link to verify your email and activate your account!
<br><br>
<a href="{{ url('https://app.boldrum-it.com/verify') }}{{ '/' }}{{$email_data['verification_code']}}">click here</a>
<br><br>
Thank You!
<br>