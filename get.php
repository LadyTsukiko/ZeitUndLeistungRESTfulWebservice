<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 06/05/2017
 * Time: 19:57
 */

require_once("DB_Functions.php");

$db = new DB_Functions();
echo json_encode($db->getProjekteAndLeistung());