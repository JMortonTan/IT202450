<?php
session_start();

class Common {
    private $db;

    public static function is_logged_in($redirect = true){
        if(Common::get($_SESSION, "user", false)){
            return true;
        }
        else{
            return false;
        }
    }

    /*** System user ID used mostly as FK for various transactions.
     *    Cached in Session to reduce DB calls to fetch it. Populates on login.
     * @return mixed|string
     */
    public static function get_system_id(){
        return Common::get($_SESSION, "system_id", -1);
    }
    public static function get_user_id(){
        $id = -1;
        $user = Common::get($_SESSION, "user", false);
        if($user){
            $id = Common::get($user,"id", -1);
        }
        return $id;
    }
    public static function get_username(){
        $user = Common::get($_SESSION, "user", false);
        $name = "";
        if($user){
            $name = Common::get($user, "first_name", false);
            if(!$name){
                $name = Common::get($user, "email", false);//if this is false we have a bigger problem
                //or we didn't check if the user is logged in first
            }
        }
        return $name;
    }

    /*** Quick URL tool to get relative urls by passing desired php file name.
     * @param $lookup
     * @return mixed|string
     */
    public static function url_for($lookup){
        $path = __DIR__. "/../$lookup.php";
        //Heroku is deployed under an app folder and __DIR pulls full path
        //so we want to split the path on our doc root, then just grab
        //the contents after it
        $r = explode("public_html", $path, 2);
        if(count($r) > 1){
            return $r[1];
        }
        echo "Error finding path", "danger";
        return "/project/index.php";
    }
    /*** Attempts to safely retrieve a key from an array, otherwise returns the default
     * @param $arr
     * @param $key
     * @param string $default
     * @return mixed|string
     */
    public static function get($arr, $key, $default = "") {
        if (is_array($arr) && isset($arr[$key])) {
            return $arr[$key];
        }
        return $default;
    }

    /*** Returns a shared instance of our PDO connection
     * @return PDO
     */
    public function getDB() {
        if (!isset($this->db)) {
            //Initialize all of these at once just to make the IDE happy
            $dbdatabase = $dbuser = $dbpass = $dbhost = NULL;
            require_once("config.php");
            if (isset($dbhost) && isset($dbdatabase) && isset($dbpass) && isset($dbuser)) {
                $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
                $this->db = new PDO($connection_string, $dbuser, $dbpass);
            } else {
                //https://www.w3schools.com/php/func_error_log.asp
                error_log("Missing db config details");
            }
        }
        return $this->db;
    }

    /*** Update Accounts balance value when given a transaction
     * @param $account_number
     * @param $new_balance
     * @return null
     */
    public function update_balance($account_number, $new_balance) {
        $query = file_get_contents("queries/MAKEITRAIN.sql");
        $dbdatabase = $dbuser = $dbpass = $dbhost = NULL;
        require_once("config.php");
        $connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
        try {
            $db = new PDO($connection_string, $dbuser, $dbpass);
            $stmt = $db->prepare($query);
            $stmt->execute([":account_number" => $account_number]);
            header("Location: accounts.php");
        }catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

$common = new Common();