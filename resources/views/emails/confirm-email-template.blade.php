<html>
	<head>
	</head>
	<body>
		<div style="width:50%; margin:10px auto; text-align:center">

			<img src="http://phpstack-93963-566910.cloudwaysapps.com/images/logo-mobile-v1.jpg">		

		</div>

		<div style="width:50%; margin: 10px auto;">

			<p>Hi {{ $name }},</p>

			<p style="margin-top:20px;">You just added this email address ({{ $email }}) to your Platstack account. Please follow this link to confirm that this email address is yours.</p>

			<p style="text-align:center; margin: 30px 0;"><a href="{{ $url }}" target="_blank" style="display:inline-block; padding:5px 10px; color:#fff; background:blue; font-weight:bold">Verify your email address</a></p>

			<p>Thanks,<br />The Platstack Team</p>

		</div>

	</body>
</html>