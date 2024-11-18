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

if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password =$_POST['password'];

    $user = new Users($email, null, $password);

    $query = "SELECT * from users where email = '" .$user->getEmail() ."' and password = '" .$user->getPassword() ."'";
    $result = $conn->query($query);
    if($result->num_rows > 0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: home.php");
        exit();
    } else {
        echo "Incorrect email or password";
    }
}

// Handles admin login
if(isset($_POST['admin_login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $password = mysqli_real_escape_string($conn, $_POST['admin_password']);
    
    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . "<br>";
    
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    echo "Number of rows: " . mysqli_num_rows($query);
    
    if(mysqli_num_rows($query) == 1) {
        $_SESSION['admin'] = true;
        header('Location: adminhome.php');
        exit();
    }
}

// Add property
if(isset($_POST['add_property'])) {
    $name = mysqli_real_escape_string($conn, $_POST['property_name']);
    $type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    mysqli_query($conn, "INSERT INTO properties (property_name, property_type, location, price, status) 
                        VALUES ('$name', '$type', '$location', '$price', '$status')");
    $_SESSION['admin'] = true;
    header('Location: adminhome.php');
    exit();
}

// Edit property
if(isset($_POST['edit_property'])) {
    $id = $_POST['property_id'];
    $name = mysqli_real_escape_string($conn, $_POST['property_name']);
    $type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    mysqli_query($conn, "UPDATE properties 
                        SET property_name='$name', property_type='$type', 
                            location='$location', price='$price', status='$status' 
                        WHERE id=$id");
    $_SESSION['admin'] = true;
    header('Location: adminhome.php');
    exit();
}

// Delete property
if(isset($_POST['delete_property'])) {
    $id = $_POST['property_id'];
    mysqli_query($conn, "DELETE FROM properties WHERE id=$id");
    $_SESSION['admin'] = true;
    header('Location: adminhome.php');
    exit();
}

//To show error 
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_POST);
?>