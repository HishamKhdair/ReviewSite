<?php

//This header means the server is sending a JSON representation of the object
header("Content-Type: application/json");

// use the review_DB model
require 'reviews.php';

// create an object of Product Dalabase class
$DB = new ReviewDataBase();

$DB->Connect();

// api functions 
// //--> rewrite use PHP functions

if (isset($_REQUEST['id'])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'DELETE':
            $DB->Delete();
            break;

        case 'GET':
            $raccoonArr = $DB->Select($_REQUEST['id']);
            $ReviewArr = array("review" => $raccoonArr);
			echo json_encode($ReviewArr);
            break;

        default:
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: GET, DELETE');
            break;
    }
} 






else {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'PUT':
            // read the entire php://input stream
            $submission = file_get_contents('php://input');
            // decode it as json
            $object = json_decode($submission);
            $DB->Update($object->reviewId,$object->review,$object->rating);
            break;

        case 'POST':
            // read the entire php://input stream
            $submission = file_get_contents('php://input');
            // decode it as json
            $object = json_decode($submission);
            $DB->Insert($object->raccoonid,$object->reviewname,$object->review,$object->rating);
            break;

        case 'GET':
            $raccoon = $DB->Select();
            $raccoonArr = array("raccoon" => $raccoon);
            echo json_encode($raccoonArr);
            break;

        default:
            header('HTTP/1.1 405 Method Not Allowed');
            header('Allow: PUT, GET, POST');
            break;
    }
}

$DB->Disconnect();
?>