<?php

class Adulto {
	
	private $dbh;
	
	public function __construct($host,$user,$pass,$db)	{		
		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);		
	}

	public function getAdultos(){				
		$sth = $this->dbh->prepare("SELECT * FROM adulto");
		$sth->execute();
		return json_encode($sth->fetchAll());
	}

	public function add($adultobj){		
		$sth = $this->dbh->prepare("INSERT INTO adulto(sku, producto, presentacion, peso, porcion) VALUES (?, ?, ?, ?, ?)");
		$sth->execute(array($adultobj->sku, $adultobj->producto, $adultobj->presentacion, $adultobj->peso, $adultobj->porcion));		
		return json_encode($this->dbh->lastInsertId());
	}
	
	public function delete($adultobj){				
		$sth = $this->dbh->prepare("DELETE FROM adulto WHERE id=?");
		$sth->execute(array($adultobj->id));
		return json_encode(1);
	}
	
	public function updateValue($adultobj){		
		$sth = $this->dbh->prepare("UPDATE adulto SET ". $adultobj->field ."=? WHERE id=?");
		$sth->execute(array($adultobj->newvalue, $adultobj->id));				
		return json_encode(1);	
	}

	public function search($adultobj){		
		$sth = $this->dbh->prepare("SELECT * FROM adulto WHERE sku=?");
		$sth->execute(array($adultobj->sku));
		return json_encode($sth->fetchAll());
	}

}
?>