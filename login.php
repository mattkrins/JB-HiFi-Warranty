<?php
session_start();
require"config.php";
if(isset($_GET["logout"])){
		session_unset();
		session_destroy();
		header('Location: ?');
}
if(isset($_POST['submit'])){
	if(isset($_SESSION["username"])){
		session_unset();
		session_destroy();
	}else{
		if(!isset($_POST['password']) or (strlen($_POST['password']) < 2) ){$error = "User/Password Incorrect";}else{
			$ldap = ldap_connect($domain["fqdn"]) or false;
			if(isset($ldap) and $ldap){$bind = @ldap_bind($ldap, $domain["sdn"].'\\'.$_POST['username'], $_POST['password']) or false;}
			if(isset($bind) and $bind){
				$filter = "(sAMAccountName=".$_POST['username'].")";
				$attributes = explode(".", $domain["fqdn"]);
				foreach ($attributes as &$v) {$v = ",dc=".$v;}
				$attributes = join("", $attributes);
				$result = ldap_search($ldap, "ou=".$domain["users"]["ou"].$attributes, $filter, array("memberof")) or exit("Unable to search LDAP server");
				$entries = ldap_get_entries($ldap, $result);
				ldap_unbind($ldap);$access = 0;
				foreach($entries[0]['memberof'] as $grps) {
					if(strpos($grps, $domain["users"]["admin"])) {$access = 2;break;}
					if(strpos($grps, $domain["users"]["staff"])){$access = 1;break;}
				}
				$_SESSION["username"] = $_POST['username'];
				$_SESSION["permisions"] = $access;
				header("Refresh: 3; URL=../");
			} else {
				$error = "Failed to login";
			}
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="1999/xhtml/index.html">
	<head>
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
		<div class="content">
			<div class="content-holder">
				<div class="form">
					<?php if(isset($_SESSION["username"])){?>
						<img width="150px" src="css/images/user.jpg"/>
						<h1>Hello <?php echo$_SESSION["username"]; ?></h1>
						<?php if(isset($_POST['username'])){?><p>Please wait, redirecting...</p><?php }?>
						<p>Click <a href="../">here</a> to log a job.</p>
						<form action="" method="post">
							<input type="submit" class="btn alt" name="submit" value="Logout" />
						</form>
					<?php }else{?>
						<h1>Login</h1>
							<form action="" method="post">
								<div class="group">
									<input name="username" type="text" value="" placeholder="username">
								</div>

								<div class="group">
									<input name="password" type="password" value="" placeholder="password">
								</div>
								<?php if(isset($error) and $error){echo"<h4 class='error' >".$error."</h4>";}?>
								<input type="submit" class="btn" name="submit" value="Login" />
							</form>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>