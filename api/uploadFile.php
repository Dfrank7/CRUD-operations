<?php
//header('Access-Control-Allow-Origin: *');

// var_dump($_POST);
// var_dump($_FILES);
// die;

$location = '../assets/images/inspection-photos';

switch ($_POST['type']) {
	case 'inspection':
		$location = '../assets/images/inspection-photos';
		break;

	case 'facility':
		$location = '../assets/images/facility-photos';
		break;

	case 'allottee-photos':
		$location = '../uploads/allottee-photos';
		break;

	case 'allottee-ids':
		$location = '../uploads/allottee-ids';
		break;

	case 'allottee-signatures':
		$location = '../uploads/allottee-signatures';
		break;

	case 'property-documents':
		$location = '../uploads/property-documents';
		break;
}

$uploadfilename = (isset($_POST['filename']) && !empty($_POST['filename'])) ? $_POST['filename'] : $_FILES['file']['name'];
// die($uploadfilename);

if(move_uploaded_file($_FILES['file']['tmp_name'], $location.'/'. $uploadfilename)){
	echo 'OK';
} else {
	echo 'ERROR:'.$_FILES['file']['error'];
}
