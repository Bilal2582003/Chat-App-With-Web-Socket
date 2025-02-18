<?php
class Users{
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_profile;
    private $user_status;
    private $user_created_on;
    private $user_verification_code;
    private $user_login_status;
    public $connect;
    public function __construct(){
        require_once "Connection.php";
        $db_obj = new Database_connection();
        $this->connect = $db_obj->connect(); 
    }

    function setUserId($userID){
        $this->user_id = $userID;
    }
    function getUserId(){
        return $this->user_id;
    }
    function setUserName($userName){
        $this->user_name = $userName;
    }
    function getUserName(){
        return $this->user_name;
    }
    function setUserEmail($userEmail){
        $this->user_email = $userEmail;
    }
    function getUserEmail(){
        return $this->user_email;
    }
    function setUserPassword($userPassword){
        $this->user_password = $userPassword;
    }
    function getUserPassword(){
        return $this->user_password;
    }
    function setUserProfile($userProfile){
        $this->user_profile = $userProfile;
    }
    function getUserProfile(){
        return $this->user_profile;
    }
    function setUserStatus($userStatus){
        $this->user_status = $userStatus;
    }
    function getUserStatus(){
        return $this->user_status;
    }
    function setUserCreatedOn($userCreated_on){
        $this->user_created_on = $userCreated_on;
    }
    function getUserCreatedOn(){
        return $this->user_created_on;
    }
    function setUserVerificationCode($userVerification_code){
        $this->user_verification_code = $userVerification_code;
    }
    function getUserVerificationCode(){
        return $this->user_verification_code;
    }
    function setUserLoginStatus($userLoginStatus){
        $this->user_login_status = $userLoginStatus;
    }
    function getUserLoginStatus(){
        return $this->user_login_status;
    }

    function make_avatar($character){
        $path = "images/".time().".png";
        $image = imagecreate(200,200);
        $red=rand(0,255);
        $green=rand(0,255);
        $blue=rand(0,255);
        imagecolorallocate($image, $red, $green, $blue);
        $text_color = imagecolorallocate($image, 255,255,255);
        $font = dirname(__FILE__)."/font/arial.ttf";
        imagettftext($image,100, 0, 55, 150, $text_color,$font,$character);
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }

    function get_user_data_by_email(){
        $query = "SELECT * from users where email = :email";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':email', $this->user_email);
        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }
        return $user;
    }
    function get_user_data_by_id(){
        $query = "SELECT * from users where id = :id";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':id', $this->user_id);
        if($statement->execute()){
            $user = $statement->fetch(PDO::FETCH_ASSOC);
        }
        return $user;
    }

    function save_data(){
        $query = "insert into users (`name`, `email`, `password`, `profile`, `status`, `created_on`, `verification_code`) Values(:user_name, :user_email, :user_password, :user_profile, :user_status, :user_created_on, :user_verification_code)";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_name', $this->user_name);
        $statement->bindParam(':user_email', $this->user_email);
        $statement->bindParam(':user_password', $this->user_password);
        $statement->bindParam(':user_profile', $this->user_profile);
        $statement->bindParam(':user_status', $this->user_status);
        $statement->bindParam(':user_created_on', $this->user_created_on);
        $statement->bindParam(':user_verification_code', $this->user_verification_code);
        if($statement->execute()){
            return true;
        }else{
            false;
        }
    }

    function is_valid_email_verification_code(){
        $query = "SELECT * from users where verification_code = :user_verification_code";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_verification_code', $this->user_verification_code);
        $statement->execute();
        if($statement->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    function enable_user_account(){
        $query="Update users set status=:user_status where verification_code =:user_verification_code";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(":user_status", $this->user_status);
        $statement->bindParam(":user_verification_code", $this->user_verification_code);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    function update_user_login_data(){
        $query="UPDATE users set login_status = :login_status where id = :user_id";
        $statment = $this->connect->prepare($query);
        $statment->bindParam(':login_status', $this->user_login_status);
        $statment->bindParam(':user_id', $this->user_id);
        if($statment->execute()){
            return true;
        }else{
            return false;
        }
    }

    function upload_image($image){
        $extension = pathinfo( $image['name'] );
        $extension = $extension['extension']; // it will get image extension
        $new_name = rand() . '.' . $extension;
        $destination = 'images/'.$new_name;
        move_uploaded_file($image['tmp_name'], $destination);
        return $destination;
    }
    function update_data(){
        $query = "UPDATE users set name = :name, email = :email, password=:password, profile = :profile where id = :id";
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':name', $this->user_name);
        $statement->bindParam(':email', $this->user_email);
        $statement->bindParam(':password', $this->user_password);
        $statement->bindParam(':profile', $this->user_profile);
        $statement->bindParam(':id', $this->user_id);
        if($statement->execute()){
            return true;
        }else{
            return false;
        }
    }

    function get_all_user_data(){
        $query = "SELECT * from users ";
        $statement = $this->connect->prepare($query);
        if($statement->execute()){
            $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        return $user;
    }

}
?>