<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui, viewport-fit=cover" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/framework7/4.5.0/css/framework7.bundle.css"></link>
</head>
<body>
<div class="page-content">
	<h1>Coaching Hub on Blockchain</h1>
	<h2>Hi <?=$compact['data']['coach']['FirstName']?> <?=$compact['data']['coach']['LastName']?>,</h2>
	<p>You registered on Coaching Hub on Blockchain App using the details:</p>
<div class="list">
<ul>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Date Time</div>
						| <?=date('Y-m-d h:i:s',$compact['data']['coach']['DateTime']->sec)?>
				</div>
		</div>
	</li>

	<li>
		<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Name</div>
						| <?=$compact['data']['coach']['FirstName']?> <?=$compact['data']['coach']['LastName']?> 
				</div>
		</div>
	</li>
	<li>
		<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Email</div>
						| <?=$compact['data']['coach']['Email']?>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Mobile</div>
						| +<?=$compact['data']['coach']['CountryCode']?> <?=$compact['data']['coach']['Mobile']?>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Date of Birth</div>
						| <?=$compact['data']['coach']['DateofBirth']?>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Gender</div>
						| <?=$compact['data']['coach']['Gender']?>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Coach ID</div>
						| <strong><?=$compact['data']['coach']['CoachID']?></strong>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Email OTP</div>
						| <strong><?=$compact['data']['coach']['otp']['email']?></strong>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">IP</div>
						| <strong><?=$compact['data']['coach']['geoData']['geobytesipaddress']?></strong>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Location</div>
						| <strong><?=$compact['data']['coach']['geoData']['geobytesfqcn']?></strong>
				</div>
		</div>
	</li>
	<li>
			<div class="item-inner">
				<div class="item-title">
						<div class="item-header">Lat / Lon</div>
						| <strong><?=$compact['data']['coach']['geoData']['geobyteslatitude']?> / <?=$compact['data']['coach']['geoData']['geobyteslongitude']?></strong>
				</div>
		</div>
	</li>	
	
	</ul>
	<p>SignIn on the app Coaching Hub on Blockchain and verify your OTP. Start coaching or learn from excellent coaches.</p>
</div>	
</div>
</body>
</html>