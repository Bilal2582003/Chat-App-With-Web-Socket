<?php
class ChatRoom{
private $id;
private $user_id;
private $msg;
private $created_on;
protected $con;

function setId($id){
    $this->id = $id; 
}
function setUserId($user_id){
    $this->user_id = $user_id; 
}
function setMsg($msg){
    $this->msg = $msg; 
}
function setCreatedOn($date){
    $this->created_on = $date; 
}
function getId(){
    return $this->id ; 
}
function getUserId(){
    return $this->user_id ; 
}
function getMsg(){
    return $this->msg; 
}
function getCreatedOn(){
    return $this->created_on; 
}

public function __construct(){
    require_once "Connection.php";
    $db_obj = new Database_connection();
    $this->con = $db_obj ->connect();
}
public function save_chat(){
    $query = "INSERT into chatrooms (user_id, msg, created_on) Value (:user_id, :msg, :created_on)";
    $statement = $this->con->prepare($query);
    $statement->bindParam(":user_id", $this->user_id);
    $statement->bindParam(":msg", $this->msg);
    $statement->bindParam(":created_on", $this->created_on);
    $statement->execute();
}
public function get_all_chat_data(){
    $query="SELECT * from chatrooms join users on users.id = chatrooms.user_id order by chatrooms.id ";
    $statement = $this->con->prepare($query);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

}
?>