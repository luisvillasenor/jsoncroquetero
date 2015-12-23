<?php

if ($_SERVER["REQUEST_METHOD"] == "GET") {

	$host = "internal-db.s202570.gridserver.com";
	$user = "db202570";
	$pass = "3bbcQt2WtV?";
	$db = "db202570_devcroquetero";

	$sku = $_GET['sku'];
	$peso = $_GET['peso'];
	$edad = $_GET['edad'];

	try{
		$dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sth = $dbh->prepare('SELECT * FROM cachorro WHERE sku=? AND peso=? AND edad=?');
		$sth->execute(array($sku, $peso, $edad));
		return print json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
	}
	catch(PDOException $e) {
		echo "Error: " . $e->getMessage();
	}
	$dbh = null;
}

print json_encode(22);
exit();