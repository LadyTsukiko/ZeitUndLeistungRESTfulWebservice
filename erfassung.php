<?php
/**
 * Created by PhpStorm.
 * User: Alexandra de Groof
 * Date: 05/05/2017
 * saves the 'erfassung'
 */

require_once("DB_Functions.php");

$db = new DB\Helper\DB_Functions();

$response = array("error" => FALSE);

if (isset($_POST['Dauer']) && isset($_POST['Leistung'])&& isset($_POST['Projekt'])&& isset($_POST['MitarbeiterID']))
{
    $datum = $_POST['Datum'];
    $dauer = $_POST['Dauer'];
    $leistung = $_POST['Leistung'];
    $projekt = $_POST['Projekt'];
    $mitarbeiterid = $_POST['MitarbeiterID'];
   if($db->saveErfassung(new \DB\Objects\ErfassungsEntity($mitarbeiterid, $leistung, $datum, $projekt, $dauer))){
       $response["error"] = FALSE;
       $response["sucsess"] = "erfassung has been saved";
       echo json_encode($response);
   }
   else{
       $response["error"] = TRUE;
       $response["error_msg"] = "SQL Error";
       echo json_encode($response);
   }
}

else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "One or more of the required parameters are missing!";
    echo json_encode($response);
}