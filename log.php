<?php session_start();if(!isset($_SESSION["permisions"])){header("Location: login.php");die();}?>
<?php
	require"config.php";
	if(!isset($_POST["model"]) or !isset($_POST["serial"]) or !isset($_POST["issue"]) or !isset($_POST["desc"]) or !isset($_POST["teacher"])){exit;}
	if(isset($config) and isset($user_agent) and isset($api)){
		$params = "txtContact=".$config["contact"]["name"]."&txtemail=".$config["contact"]["email"]."&txtphone=".$config["contact"]["phone"]."&txtorg=".$config["organisation"]["name"]."&txtorgid=".$config["organisation"]["id"]."&txtorgaddress=".$config["location"]["address"]."&txtorgsub=".$config["location"]["suburb"]."&txtorgstate=".$config["location"]["state"]."&txtorgpost=".$config["location"]["post"]."&txtModel=".$_POST["model"]."&txtSerial=".$_POST["serial"]."&sltSuspectedIssue=".$_POST["issue"]."&txtProblemDesc=".$_POST["desc"]."&nttpUnit=".$_POST["teacher"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST,true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
		curl_setopt($ch, CURLOPT_URL,$api["submit"]);
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
		<title>Log Warranty</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="content">
			<div class="content-holder">
				<div id="close"><a href="../"><img src="css/images/close.png" name="close" alt="Close" /></a></div>
				<div class="form">
					<?php if(isset($result) and isset($result["id"]) and isset($result["data"])){ ?>
						<div class="group">
							<br/>
							<h1 style="color:green;" >Job Logged (<?php print$result["id"];?>)</h1>
							<h5><?php print$result["data"];?></h5>
							<p>Click <a href="check.php?id=<?php print$result["id"];?>">here</a> to check the job.</p>
						</div>
					<?php }else{?>
						<div class="group">
							<br/>
							<h1 style="color:red;" >Failed to log job.</h1>
							<?php if(isset($result) and isset($result["data"])){ ?>
								<h5><?php print$result["data"];?></h5>
							<?php }else{?>
								<h5>Unknown error, please <a href="#" onclick="window.history.back();">try again</a>.</h5>
								<div class="group">
									<textarea name = "desc" value="" disabled rows="15"><?php echo$api["submit"].'?'.$params;?></textarea>
								</div>
							<?php }?>
						</div>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>