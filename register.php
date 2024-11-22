<?php

include 'connect.php';

class Users {
    private $email;
    private $username;
    private $password;
    private $conn;

    public function __construct($conn, $email, $username, $password){
        $this->conn = $conn;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function getEmail() { return $this->email; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }

    public function signUp() {
        $checkEmail = "SELECT * from users where email = '$this->email'";
        $result = $this->conn->query($checkEmail);
        if($result->num_rows > 0){
            return "Email already exists!";
        } 
        $insertQuery = "INSERT INTO users(email, username, password) VALUES ('$this->email','$this->username','$this->password')";
        if($this->conn->query($insertQuery)){
            return "success";
        }
        return "Error: " . $this->conn->error;
    }

    public function login() {
        $query = mysqli_query($this->conn, "SELECT * from users WHERE email='$this->email' AND password='$this->password'");
        return mysqli_num_rows($query) > 0;
    }
}
if(isset($_POST['signUp'])){
    $user = new Users($conn, $_POST['email'], $_POST['username'], $_POST['password']);
    $result = $user->signUp();
    if($result === "success") {
        header("location: index.php");
    } else {
        echo $result;
    }
}

if(isset($_POST['login'])) {
    $user = new Users($conn, $_POST['email'], '', $_POST['password']);
    if($user->login()) {
        $_SESSION['email'] = $user->getEmail();
        header('Location: home.php');
        exit();
    } else {
        header('Location: index.php');
    }
}
?>