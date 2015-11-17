<?php session_start();if(!isset($_SESSION["permisions"])){header("Location: login.php");die();}?>
<?php
	require"config.php";
	//if(!isset($_POST["id"])){exit;}
	if(isset($config) and isset($user_agent) and isset($api)){
		$params = "txtServiceEmail=".$config["contact"]["email"]."&&txtServiceId=".$config["jobid"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
		curl_setopt($ch, CURLOPT_URL,$api["list"]);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response=curl_exec ($ch);
		curl_close ($ch);
		if(isset($response)){$result = json_decode($response, true);}else{$result = false;}
	}else{exit;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="1999/xhtml/index.html">
	<head>
		<title>Check Job</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="content" style="width: 350px;">
			<div class="content-holder">
				<div id="close"><a href="index.php"><img src="css/images/close.png" name="close" alt="Close" /></a></div>
				<div class="form">
					<?php if(isset($result) and isset($result["data"])){ ?>
					<h5><?php print$result["data"];?></h5>
					<?php }else{?>
						<h1 style="color:red;" >Error</h1>
						<h5><?php if(isset($result)){print_r($result);} ?></h5>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>