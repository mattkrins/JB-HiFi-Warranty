<?php
	$database = "database.txt";
	$config = array(
		"contact" => array(
			"name" => "Person",
			"email" => "your@email.com",
			"phone" => "12345678",
		),
		"organisation" => array(
			"name" => "Your Organisation Name",
			"id" => 0000, // internal id for jb-hifi (find by view source: portal.nn.net.au/warranty/warrantyreq.php)
		),
		"location" => array(
			"address" => "123 Fake Street",
			"suburb" => "Fakevill",
			"state" => "ABC",
			"post" => "1234",
		),
		"jobid" => "46338", // A random job used for authentication with the server
		"teacher" => "0", // no need to edit this
	);
	$domain = array(
		"sdn" => "domain", // simple domain name
		"fqdn" => "domain.etc.com", //fully qualified domain name
		"users" => array(
			"ou" => "Users", // organisational unit containing user groups
			"staff" => "Staff", // organisational unit for regular users
			"admin" => "Tech", // organisational unit for administrators
		),
	);
	$user_agent = "Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)"; // what browser do we appear as
	$api = array(
		"submit" => "https://portal.nn.net.au/ajax/warranty/ajaxWarrantyCreate.php",
		"retrieve" => "http://gateway.nn.net.au/ajax/service/serviceLoadJob.php",
		"list" => "http://gateway.nn.net.au/ajax/service/serviceLoadJobList.php",
	);
	$db = fopen($database, "a+");
	if($db){$config["models"] = json_decode(fread($db,filesize($database)), true);fclose($db);}
?>