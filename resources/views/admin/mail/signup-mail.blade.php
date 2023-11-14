Hello {{$email_data['first_name']}}
<br>
<br>
Welcome to our website
<br>
Please click to below link to verify your email and activated your account.
<br>
<br>
<a href="{{$email_data['base_url']}}/api/verify?code={{$email_data['verification_link']}}">Click Here</a>
<br>
<br>
Thank you
<br>
Aaqa tech co


