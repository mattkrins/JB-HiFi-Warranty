<?php session_start();if(!isset($_SESSION["permisions"])){header("Location: login.php");die();}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="1999/xhtml/index.html">
	<head>
		<title>Log JB-HiFi Warranty</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<link rel="SHORTCUT ICON" href="favicon.ico"/>
	</head>
	<body>
		<?php require"config.php";?>
		<?php $x = count($config["models"]);?>
		<div class="content" style="width: <?php echo$x*250;?>px;">
			<div class="content-holder">
				<div id="close"><a href="login.php?logout" onclick="if (!confirm('Do you want to logout?')) return false;"><img src="css/images/close.png" name="close" alt="Close" /></a></div>
				<h1>JB-HiFi Warranty</h1>
				<div class="group">
					<div class="form">
						<table class="tg">
							<tr>
								<?php foreach ($config["models"] as $name => $model) {?>
								<?php $var = glob('css/images/models/'.$name.'.*');
								if(!isset($var[0])){$var[0]="css/images/models/default.png";}?>
								<th class="tg-baqh">
									<a href="form.php?model=<?php echo$name;?>"><img src="<?php echo$var[0];?>" width="200px" /></a>
									<h2><?php echo$name;?><?php if($_SESSION["permisions"]>1){?> <a href="models.php?del=<?php echo$name;?>" onclick="if (!confirm('Are you sure you want to delete model <?php echo$name;?>?')) return false;"><img src="css/images/del.png" width="16px" /></a><?php }?></h2>
								</th>
								<?php }?>
							</tr>
						</table>
					</div>
				</div>
				<div class="group">
					<h3>Check Warranty</h3>
					<div class="form">
						<form action="check.php" method="post">
							<input name="id" class="findjob" type="text" value="" placeholder="Job Number" required>
							<input type="submit" class="btn btnl" name="submit" value="Find Job" />
						</form>
					</div>
				</div>
				<div class="group">
					<div class="form">
						<form action="check.php" method="post">
							<a href="list.php" class="btn alt">List all jobs</a>
						</form>
					</div>
				</div>
				<?php if($_SESSION["permisions"]>1){?>
				<div class="group">
					<div class="form">
						<form action="check.php" method="post">
							<a href="models.php" class="btn alt2">Add new model</a>
						</form>
					</div>
				</div>
				<?php }?>
			</div>
		</div>
	</body>
</html>