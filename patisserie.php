<!doctype html>
<html>
<head>
	<title> Accès à Mysql sur BlueMix</title>
	<meta http-equiv="content-type" content="texthtml; charset=utf-8">
	<link rel="stylesheet" href="style.css"/>
</head>
<body>
	<table>
	<tr><td><span class="blue"> Liste des gâteaux</span></td></tr>


	<?php
			
		$vcap_services = json_decode($_ENV['VCAP_SERVICES'], true);
		$uri = $vcap_services['compose-for-mysql'][0]['credentials']['uri'];
		$db_creds = parse_url($uri);
		$dbname = "patisserie";

		$dsn = "mysql:host=" . $db_creds['host'] . ";port=" . $db_creds['port'] . ";dbname=" . $dbname;
		$dbh = new PDO($dsn, $db_creds['user'], $db_creds['pass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		
	/*$dsn='mysql:dbname=patisserie;host=sl-us-dal-9-portal.6.dblayer.com:';
	$user='';
	$password='';*/
	try{
		//$dbh=new PDO($dsn, $user, $password);
		$resultat=$dbh->query("select * from gateau");
		foreach($resultat->fetchAll(PDO::FETCH_OBJ) as $ligne){
			echo '<tr><td>id: '.$ligne->id.'</td><td> nom: '.$ligne->nom.'</td></tr>';
		}
		$resultat->closeCursor();
	}catch(PDOException $e){
		echo 'erreur'.$e->getMessage();
	}
	?>
	</table>
</body>
</html>


