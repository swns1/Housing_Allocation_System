<?php

include 'connect.php';

class Users{
    private $email;
    private $username;
    private $password;

    public function __construct($email, $username, $password){
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }
}

if(isset($_POST['signUp'])){
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password =$_POST['password'];

    $user = new Users($email, $username, $password);

    $checkEmail = "SELECT * from users where email = '" .$user->getEmail() ."'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "Email already exists!";
    } else {
        $insertQuery = "INSERT INTO users(email, username, password)
         Values ('" .$user->getEmail() ."','" .$user->getUsername() ."','" .$user->getPassword() ."')";
            if($conn->query($insertQuery)){
                echo "Data inserted successfully!";
                header("location: index.php");
            } else {
                echo "Error: " .$conn->error;
            }
    }
}

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    $query = mysqli_query($conn, "SELECT * from users WHERE email='$email' AND password='$password'");
    if(mysqli_num_rows($query) > 0) {
        $_SESSION['email'] = $email;
        header('Location: home.php');
        exit();
    } else {
        header('Location: index.php');
    }
}
?>