<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>CodeCanopy Installer</title>
	<link href="assets/css/bootstrap.css" rel="stylesheet">
	<style>
	.box { width:450px; margin: 20px auto; padding: 20px 0;}
	.alert { width: 700px; margin: 20px auto;}
	</style>
</head>
<body>



<?php

$Hostname = $_POST['Hostname'];
$Username = $_POST['Username'];
$Password = $_POST['Password'];
$DB = $_POST['DB'];
$sitename = $_POST['sitename'];
$u4rl = $_POST['URL'];

$adminu = $_POST['adminusername'];
$adminp = $_POST['adminpassword'];


if(substr($u4rl, 0, 7) == "http://") {
	if(substr($u4rl, 0, 11) == "http://www.") {
		$URL = str_replace("http://www.","",$u4rl);
	} else {
		$URL = str_replace("http://","",$u4rl);
	}
} elseif(substr($u4rl, 0, 8) == "https://") {
	
	if(substr($u4rl, 0, 12) == "https://www.") {
		$URL = str_replace("https://www.","",$u4rl);
	} else {
		$URL = str_replace("https://","",$u4rl);
	}

} else {
	$URL = $u4rl;
} 


if (isset($_POST['Hostname']) && isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['DB']) ) {
	$con = mysql_connect("$Hostname", "$Username", "$Password") or die(mysql_error());
	$con2 = mysql_select_db("$DB") or die(mysql_error());
}

if(isset($_POST['submit'])) {



if (!$con)
  {
  $alert = 'Could not connect to DB, Check db credentials and try again :)';
  } else {



  	if (!$con2)
	{
		$alert = 'Could not connect to DB, Check table name and try again :)';
	} else {


		mysql_query("
			DROP TABLE settings ;
		");

		// Create a MySQL table in the selected database
		mysql_query("
		CREATE TABLE IF NOT EXISTS `settings` (
		  `location` text NOT NULL,
		  `bar` int(11) NOT NULL,
		  `analytics` text NOT NULL,
		  `ads` int(11) NOT NULL,
		  `socialmedia` int(11) NOT NULL,
		  `bookmarklet` int(11) NOT NULL,
		  `api` int(11) NOT NULL,
		  `name` text NOT NULL,
		  `length` int(11) NOT NULL,
		  `ad_html` text,
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `safe` text,
		  `chars` text NOT NULL,
		  `splash` int(11) NOT NULL,
		  `validurl` int(11) NOT NULL,
		  `parabox` text,
		  `boxcreate` int(11) NOT NULL,
		  `boxvisit` int(11) NOT NULL,
		  `pods` int(11) NOT NULL,
		  `qr` text NOT NULL,
		  `login` text NOT NULL,
		  `top3` int(11) NOT NULL,
		  `description` int(11) NOT NULL,
		  `recentview` int(11) NOT NULL,
		  `recentcreate` int(11) NOT NULL,
		  KEY `Id` (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
		");


		mysql_query("
		CREATE TABLE  IF NOT EXISTS `stats` (
		  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
		  `urlid` int(11) DEFAULT NULL,
		  `ip` varchar(200) DEFAULT NULL,
		  `locfrom` varchar(200) DEFAULT NULL,
		  `country` varchar(200) DEFAULT NULL,
		  `language` varchar(200) DEFAULT NULL,
		  `time` time DEFAULT NULL,
		  `cdate` varchar(200) DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=206995 DEFAULT CHARSET=utf8;
		");




		$query = "SELECT * FROM settings WHERE id='1' ";
		$result = mysql_query($query) or die(mysql_error());

		if (mysql_num_rows($result) )
		{
		   // print 'record is already in table';

		}
		else
		{
		    mysql_query("

		INSERT INTO `settings` (`location`, `bar`, `analytics`, `ads`, `socialmedia`, `bookmarklet`, `api`, `name`, `length`, `ad_html`, `id`, `safe`, `chars`, `splash`, `validurl`, `parabox`, `boxcreate`, `boxvisit`, `pods`, `qr`, `login`, `top3`, `description`, `recentview`, `recentcreate`)
		VALUES
			('$URL', 1, '', 0, 1, 1, 1, '$sitename', 6, '', 0, '', '', 1, 1, '', 0, 0, 0, '1', '', 1, 1, 0, 1);
			
		")
		 or die(mysql_error());   
		     
		    // print 'record added';
		}

		$ourFileName = "lib/config.php";
		$fh = fopen($ourFileName, 'w') or die("Please chmod /lib to 777");
		fwrite($fh, '<?php
		$cchost = "'.$Hostname.'";
		$ccuser = "'.$Username.'"; 
		$ccpass = "'.$Password.'"; 
		$ccname = "'.$DB.'";
		$adminuser = "'.$adminu.'";
		$adminpassword = "'.$adminp.'";
		?>');
		fclose($fh);

		$installed = "Thank you for purchasing from CodeCanopy any further problems please email support@codecanopy.com you can login your admin panel here: <a href='http://".$URL."/admin'>Admin Panel</a>";

	}

  }

}



		if (file_exists("lib/config.php")) {
		$remove = "Please delete install.php and upgrade.php <br/> UPGRADE MAY HAVE RESET SETTINGS. PLEASE LOGIN TO ADMIN PANEL AND CONTINUE SETUP.";
		}



if(isset($remove)) {
echo '<div class="alert alert-error">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Script Upgraded!</strong> '.$remove.'
</div>';
}


if(isset($installed)) {
echo '<div class="alert alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Script Upgraded!</strong> '.$installed.'
</div>';
}

if(isset($alert)) {
echo '<div class="alert">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Warning!</strong> '.$alert.'
</div>';
}
?>	




<div class="box well">
<form class="form-horizontal" method="post" action="upgrade.php">
  <div class="control-group">
    <label class="control-label" for="Hostname">Hostname: </label>
    <div class="controls">
      <input type="text" name="Hostname" value="localhost">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="Username">Username: </label>
    <div class="controls">
      <input type="text" name="Username" placeholder="Username">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="Password">Password: </label>
    <div class="controls">
      <input type="password" name="Password" placeholder="Password">
    </div>
  </div>

  <div class="control-group">
    <label class="control-label" for="DB">DB Name: </label>
    <div class="controls">
      <input type="text" name="DB" placeholder="DB Name">
    </div>
  </div>

  <hr/>

  <div class="control-group">
    <label class="control-label" for="sitename">Site Name: </label>
    <div class="controls">
      <input type="text" name="sitename" placeholder="Meela">
    </div>
  </div>

   <div class="control-group">
    <label class="control-label" for="URL">Site URL: </label>
    <div class="controls">
      <input type="text" name="URL" placeholder="mee.la" value="<?php echo $_SERVER['SERVER_NAME']; ?>">
    </div>
  </div>
  


  <hr/>

  <div class="control-group">
    <label class="control-label" for="adminusername">Admin Username: </label>
    <div class="controls">
      <input type="text" name="adminusername">
    </div>
  </div>

   <div class="control-group">
    <label class="control-label" for="adminpassword">Admin Password: </label>
    <div class="controls">
      <input type="password" name="adminpassword">
    </div>
  </div>
  



  <div class="control-group">
    <div class="controls">
      <button type="submit" name="submit" class="btn btn-success">upgrade</button>
    </div>
  </div>
</form>
</div>


</body>
</html>