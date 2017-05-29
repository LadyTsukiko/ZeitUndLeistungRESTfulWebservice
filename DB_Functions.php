<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
 * adapted by Alexandra de Groof
 */

class DB_Functions {

    private $conn;

    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }

    // destructor
    function __destruct() {
        
    }

    /**
     * save the 'Erfassung' to the db, returns false in case the sql trows an error
     * @param $mitarbeiterid
     * @param $leistung
     * @param $zeit
     * @param $projekt
     * @param $dauer
     * @return bool
     */
    public function saveErfassung($mitarbeiterid, $leistung, $zeit, $projekt, $dauer){
                                    //INSERT INTO `zeiterfassung`( `mitarbeiter_id`, `leistungs_id`, `projekt_id`, `datum`, `dauer`) SELECT 12,                  leistung.leistungs_id, projekt.projekt_id, 1234-12-12, 1234       FROM projekt INNER JOIN leistung WHERE leistung.name = "test" AND projekt.name = "test"
        $stmt = $this->conn->prepare("INSERT INTO `zeiterfassung`( `mitarbeiter_id`, `leistungs_id`, `projekt_id`, `datum`, `dauer`)  SELECT ".$mitarbeiterid.", leistung.leistungs_id, projekt.projekt_id , '".$zeit."', ".$dauer." FROM projekt INNER JOIN leistung WHERE leistung.name like '".$leistung."' AND projekt.name like '".$projekt."'");
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        else return false;

    }

    /**
     * Get user by MitarbeiterID and password + verifies pw and if user is active
     * @param $mitarbeiterid
     * @param $password
     * @return array|null
     */
    public function getUserByEmailAndPassword($mitarbeiterid, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM mitarbeiter WHERE inaktiv_flag = 0 AND mitarbeiter_id = ?");

        $stmt->bind_param("s", $mitarbeiterid);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            $encrypted_password = $user['passwort'];
            // check for password equality
            if (password_verify($password, $encrypted_password))//php function that uses bcrypt
            {
                           // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }



    /*
     * Encrypting password
     * @param password
     * returns salt and encrypted password

    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }*/


    /**
     * reads all active projects and services from the db
     * @return array[2] containing an array of projects and one of services
     */
    public function getProjekteAndLeistung(){
        $stmt = $this->conn->prepare("SELECT name FROM projekt WHERE inaktiv_flag = 0");

        if ($stmt->execute()) {
            $resArrayP = array();
            $result = $stmt->get_result();
            while ($row=$result->fetch_assoc()){
                $resArrayP[] = $row;
            }
            $stmt->close();
        }
        $stmt = $this->conn->prepare("SELECT name FROM leistung WHERE inaktiv_flag = 0");

        if ($stmt->execute()) {
            $resArrayL = array();
            $result = $stmt->get_result();
            while ($row=$result->fetch_assoc()){
                $resArrayL[] = $row;
            }
            $stmt->close();
        }

        return array($resArrayP, $resArrayL);
    }

}

?>
