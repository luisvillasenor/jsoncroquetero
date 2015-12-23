<?php

class Cachorro {
	
	private $dbh;
	
	public function __construct($host,$user,$pass,$db)	{		
	try{
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
		$this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	}
		
	}

	public function search($sku,$peso,$edad){		
		$sth = $this->dbh->prepare('SELECT sku, producto, presentacion, peso, porcion FROM cachorro WHERE sku='.$sku.' AND peso='.$peso.' AND edad='.$edad.'');
		$sth->execute();
		return json_encode($sth->fetchAll(PDO::FETCH_ASSOC));
	}

}
?>