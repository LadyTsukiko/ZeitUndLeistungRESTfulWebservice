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
        $stmt = $this->conn->prepare("INSERT INTO `zeiterfassung`( `mitarbeiter_id`, `leistungs_id`, `projekt_id`, `datum`, `dauer`) VALUES (".$mitarbeiterid.", ".$leistung.", ".$projekt.", '".$zeit."', ".$dauer.")");
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
    public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT MitarbeiterID from users WHERE MitarbeiterID = ?");

        $stmt->bind_param("s", $email);

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

}

?>
