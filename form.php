<?php session_start();if(!isset($_SESSION["permisions"])){header("Location: login.php");die();}?>
<?php if(!isset($_GET["model"])){exit;} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="1999/xhtml/index.html">
	<head>
		<title>Log Warranty</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<?php require"config.php";?>
		<?php if(!isset($config["models"][$_GET["model"]])){exit;}?>
		<div class="content">
			<div class="content-holder">
				<div id="close"><a href="../"><img src="css/images/close.png" name="close" alt="Close" /></a></div>
				<h1>Log Warranty</h1>
				<div class="form">
					<form action="log.php" method="post">
						<?php $var = glob('css/images/models/'.$_GET["model"].'.*');
						if(!isset($var[0])){$var[0]="css/images/models/default.png";}?>
						<img src="<?php echo$var[0];?>" width="200px" />						
						<div class="group">
							<input name="serial" type="text" value="" placeholder="Serial Number" required>
						</div>
						<div class="group">
							<select name="issue" required><option value = "1">Hard Drive</option><option value = "2">CPU</option><option value = "3">Charger</option><option value = "4">RAM</option><option value = "5">Motherboard</option><option value = "6">Keyboard</option><option value = "7">Palmrest</option><option value = "8">DVD Drive</option><option value = "9">Screen</option><option value = "10">Physical Screen Damage</option><option value = "11">Physical Base</option><option value = "12">Physical Top Cover</option><option value = "13">Physical Keyboard</option><option value = "14">Physical Charger</option><option value = "15">6-Cell Battery</option><option value = "16">Physical Battery</option><option value = "17">Basecover</option><option value = "18">Screen Hinges</option><option value = "19">Fan</option><option value = "20">Internal Power</option><option value = "22">LCD Cable</option><option value = "23">Keyboard Bezel</option><option value = "24">Power Socket</option><option value = "25">HDD Cover</option><option value = "26">9-cell battery</option></select>
						</div>
						<div class="group">
							<textarea name = "desc" placeholder="Problem Description" required></textarea>
						</div>
						<input type='hidden' name='teacher' value="<?php if(isset($config["models"][$_GET["model"]]["teacher"]) and $config["models"][$_GET["model"]]["teacher"]){echo"1";}else{echo"0";}?>" />
						<input type='hidden' name='model' value="<?php print$config["models"][$_GET["model"]]["id"];?>" />
						<input type='hidden' name='submit' value='true' />
						<input type="submit" class="btn" name="submit" value="Submit Job<?php if(isset($config["models"][$_GET["model"]]["teacher"]) and $config["models"][$_GET["model"]]["teacher"]){echo" For Teacher";}?>" />
					</form>
				</div>
			</div>
		</div>
	</body>
</html>