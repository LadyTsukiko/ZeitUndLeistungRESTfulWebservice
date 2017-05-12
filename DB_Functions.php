<?php

/**
 * @author Ravi Tamada
 * @link http://www.androidhive.info/2012/01/android-login-and-registration-with-php-mysql-and-sqlite/ Complete tutorial
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
     * Get user by MitarbeiterID and password
     * @param $mitarbeiterid
     * @param $password
     * @return array|null
     */
    public function getUserByEmailAndPassword($mitarbeiterid, $password) {

        $stmt = $this->conn->prepare("SELECT * FROM mitarbeiter WHERE mitarbeiter_id = ?");

        $stmt->bind_param("s", $mitarbeiterid);

        if ($stmt->execute()) {
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            // verifying user password
            //$salt = $user['salt'];
            $encrypted_password = $user['passwort'];
            //$hash = $this->checkhashSSHA($salt, $password);
            // check for password equality
            //if ($encrypted_password == $hash) {
            if ($encrypted_password == $password) {
                // user authentication details are correct
                return $user;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Check user is existed or not
     */
    public function isUserExisted($id) {
        $stmt = $this->conn->prepare("SELECT MitarbeiterID from users WHERE MitarbeiterID = ?");

        $stmt->bind_param("s", $id);

        $stmt->execute();

        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // user existed 
            $stmt->close();
            return true;
        } else {
            // user not existed
            $stmt->close();
            return false;
        }
    }

    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    public function hashSSHA($password) {

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }

    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    public function checkhashSSHA($salt, $password) {

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
    }

    public function getProjekteAndLeistung(){
        $stmt = $this->conn->prepare("SELECT name FROM projekt");

        if ($stmt->execute()) {
            $resArrayP = array();
            $result = $stmt->get_result();
            while ($row=$result->fetch_assoc()){
                $resArrayP[] = $row;
            }
            $stmt->close();
        }
        $stmt = $this->conn->prepare("SELECT name FROM leistung");

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
