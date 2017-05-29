<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial

 adapted by Alexandra de Groof*/

require_once("DB_Functions.php");

$db = new DB_Functions();
// json response array
$response = array("error" => FALSE);


if (isset($_POST['MitarbeiterID']) && isset($_POST['password'])) {

    // receiving the post params
    $MitarbeiterID = $_POST['MitarbeiterID'];
    $password = $_POST['password'];

    // get the user by MitarbeiterID and password
    $user = $db->getUserByEmailAndPassword($MitarbeiterID, $password);

    if ($user != false && user["inaktiv_flag"]!=1) {
        // user is found
        $response["error"] = FALSE;

        //$response["user"]["name"] = $user["name"];

        echo json_encode($response);
    }
    elseif ($user != false){
        $response["error"] = TRUE;
        $response["error_msg"] = "Sie sind kein aktiver Mitarbeiter. Bitte kontaktieren Sie einen Admin";
    }
    else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "Falsches Passwort oder ID. Bitte erneut versuchen";
        echo json_encode($response);
    }
} else {
    // required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters MitarbeiterID or password is missing!";
    echo json_encode($response);
}


