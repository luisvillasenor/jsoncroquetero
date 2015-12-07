<?php

class Adulto {
	
	private $dbh;
	private $conn;
	
	public function __construct($host,$user,$pass,$db)	{		
//		$this->dbh = new PDO("mysql:host=".$host.";dbname=".$db,$user,$pass);
		//$this->conn = new mysqli("localhost", "root", "sECTUREd15", "test");
		
	}

	public function getAdultos(){				
	
		$conn = new mysqli("localhost", "root", "sECTUREd15", "test");
		$result = $conn->query("SELECT sku, producto, presentacion, peso, porcion FROM adulto");
		if (!$result) { die ('No se puede usar la base de datos : ' . mysql_error()); }
		// Creamos un array de objetos

		$outp = "[";
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		    if ($outp != "[") {$outp .= ",";}
		    $outp .= '{"sku":"'  . $rs["sku"] . '",';
		    $outp .= '"producto":"'   . $rs["producto"]        . '",';
		    $outp .= '"presentacion":"'   . $rs["presentacion"]        . '",';
		    $outp .= '"peso":"'   . $rs["peso"]        . '",';
		    $outp .= '"porcion":"'. $rs["porcion"]     . '"}';
		}
		$outp .="]";

		$conn->close();
		return $outp;
		//return json_encode($rows);
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

		$conn = new mysqli("localhost", "root", "sECTUREd15", "test");
		$result = $conn->query("SELECT * FROM adulto WHERE sku = '$adultobj->sku' AND peso = '$adultobj->peso' ");

		if (!$result) {
		    die ('No se puede usar la base de datos : ' . mysql_error());
		}

		// Creamos un array de objetos
/*
		$outp = "[";
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		    if ($outp != "[") {$outp .= ",";}
		    $outp .= '{"sku":"'  . $rs["sku"] . '",';
		    $outp .= '"producto":"'   . $rs["producto"]        . '",';
		    $outp .= '"presentacion":"'   . $rs["presentacion"]        . '",';
		    $outp .= '"peso":"'   . $rs["peso"]        . '",';
		    $outp .= '"porcion":"'. $rs["porcion"]     . '"}';
		}
		$outp .="]";
*/
		$rows = array();
		while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
		    $rows[] = $rs;
		}

		$conn->close();

/*
		return $outp;
		//return json_encode($fila);
		mysql_free_result($sth);
*/

		//$sth = $this->dbh->prepare("SELECT * FROM adulto WHERE sku=? AND peso=?");
		//$sth->execute(array($adultobj->sku,$adultobj->peso));
		return json_encode($rows);
		//return $sth;
	}

}
?>