<?php
function __autoload($className){
	include_once("models/$className.php");	
}

// Ver archvio local

if( ! isset($_POST['action']) ) {
	print json_encode(0);
	return;
}

switch( $_POST['action'] ) {
	case 'get_adultos':
		print $adulto->getAdultos();		
	break;

	case 'get_skus':
		print $adulto->getSkuList();		
	break;
	
	case 'add_adulto':
		$adultobj = new stdClass;
		$adultobj = json_decode($_POST['adulto']);
		print $adulto->add($adultobj);		
	break;
	
	case 'delete_adulto':
		$adultobj = new stdClass;
		$adultobj = json_decode($_POST['adulto']);
		print $adulto->delete($adultobj);		
	break;
	
	case 'update_field_data':
		$adultobj = new stdClass;
		$adultobj = json_decode($_POST['adulto']);
		print $adulto->updateValue($adultobj);				
	break;

	case 'search_adulto':
		//print_r(PDO::getAvailableDrivers());
		$adultobj = new stdClass;
		$adultobj = json_decode($_POST['adulto']);
		print $adulto->search($adultobj);		
	break;

}

exit();