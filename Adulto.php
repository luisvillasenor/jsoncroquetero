<?php
function __autoload($className){
	include_once("models/$className.php");	
}

//$adulto = new Adulto("internal-db.s202570.gridserver.com","db202570","3bbcQt2WtV?","db202570_devcroquetero");
$adulto = new Adulto("localhost","root","sECTUREd1","db202570_devcroquetero");

if( ! isset($_REQUEST['action']) ) {
	print json_encode(0);
	return;
}

switch( $_REQUEST['action'] ) {
	case 'get_adultos':
		print $adulto->getAdultos();		
	break;
	
	case 'add_adulto':
		$adultobj = new stdClass;
		$adultobj = json_decode($_REQUEST['adulto']);
		print $adulto->add($adultobj);		
	break;
	
	case 'delete_adulto':
		$adultobj = new stdClass;
		$adultobj = json_decode($_REQUEST['adulto']);
		print $adulto->delete($adultobj);		
	break;
	
	case 'update_field_data':
		$adultobj = new stdClass;
		$adultobj = json_decode($_REQUEST['adulto']);
		print $adulto->updateValue($adultobj);				
	break;

	case 'search_adulto':
		$adultobj = new stdClass;
		$adultobj = json_decode($_GET['adulto']);
		print $adulto->search($adultobj);		
	break;

}

exit();