<?php session_start();if(!isset($_SESSION["permisions"])){header("Location: login.php");die();}?>
<?php
require"config.php";
if(isset($_GET["del"])){
	$deleting = true;
	if(isset($config["models"][$_GET["del"]])){
		$check = glob("css/images/models/".$_GET["del"].".*");
		if(isset($check[0]) and file_exists($check[0])) {
			$delete = unlink($check[0]);
			if(!$delete){$error = "Failed to delete image.";}
		}
		unset($config["models"][$_GET["del"]]);
		$db = fopen($database, "w");
		if($db){fwrite($db, json_encode($config["models"]));fclose($db);}else{$error = "Database write error.";}
		$deleted = true;
		header("Refresh: 3; URL=index.php");
	}else{$error = "Model does not exist.";}
}
if(isset($_POST["submit"])) {
	$error = false;
	if(!isset($database)){$error = "Database error.";}
	if (!file_exists($database)) {$error = "Database error.";}
	if (!is_readable($database)) {$error = "Database read error.";}
	if (filesize($database)<5) {$error = "Database read error.";}
	if(!isset($_POST["name"])){$error = "Model name required.";}
	if(!isset($_POST["id"])){$error = "Model id required.";}
	if(!$error and isset($_FILES["image"]) and $_FILES["image"]["tmp_name"]) {
		$target_dir = "css/images/models/";
		$FileSizeLimit = 500000;
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$new_file = $target_dir.$_POST["name"].".".$imageFileType;
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if(!$check) {$error = "File is not an image.";}
		if (file_exists($new_file)) {$error ="Sorry, image file already exists.";}
		if ($_FILES["image"]["size"] > $FileSizeLimit) {$error = "Sorry, your file is too large.";}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {$error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";}
		if (!$error) {
			if (!move_uploaded_file($_FILES["image"]["tmp_name"], $new_file)) {
				$error = "Image failed to upload.";
			}
		}
	}
	if(!$error) {
		$teacher = false;
		if(isset($_POST["teacher"]) and $_POST["teacher"]=="on" ){$teacher=true;}
		$config["models"][$_POST["name"]] = array(
			"id" => $_POST["id"],
			"teacher" => $teacher,
		);
		$db = fopen($database, "w");
		if($db){fwrite($db, json_encode($config["models"]));fclose($db);$success = true;}else{$error = "Database write error.";}
		header("Refresh: 3; URL=index.php");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="1999/xhtml/index.html">
	<head>
		<title>Models</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="content">
			<div class="content-holder">
				<div id="close"><a href="../"><img src="css/images/close.png" name="close" alt="Close" /></a></div>
				<h1>Models</h1>
				<div class="form">
					<?php if(isset($deleting) and $deleting){?>
						<?php if(isset($deleted) and $deleted){?>
						<h4 class='success' >Model "<?php echo$_GET["del"];?>" deleted.</h4>
						<p>Please wait, redirecting...</p>
						<?php }?>
						<?php if(isset($error) and $error){echo"<h4 class='error' >".$error."</h4>";}?>
					<?php }elseif(isset($success) and $success){?>
						<?php if(isset($new_file)){?><img src="<?php echo$new_file;?>" width="200px" /><?php }?>
						<h4 class='success' >Model "<?php echo$_POST["name"];?>" Added.</h4>
						<p>Please wait, redirecting...</p>
					<?php }else{?>
						<form method="post" enctype="multipart/form-data">
							<img src="css/images/models/default.png" width="200px" />
							<?php if(isset($error) and $error){echo"<h4 class='error' >".$error."</h4>";}?>
							
							<div class="group">
								<input name="image" type="file">
							</div>				
							
							<div class="group">
								<input name="name" type="text" value="" placeholder="Model Name" required>
							</div>
							
							<div class="group">
								<input name="id" type="text" value="" placeholder="Model ID" required>
							</div>
							
							<div class="group">
								<input type="checkbox" name="teacher" id="teacher" class="checkbox" /><label for="teacher" class="css-label">NTP Device?</label>
							</div>
							<input type='hidden' name='submit' value='true' />
							<input type="submit" class="btn" name="submit" value="Add Model" />
						</form>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>