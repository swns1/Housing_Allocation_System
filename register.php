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
        echo "
        <script>
            alert('Email already exists!');
            window.history.back();
        </script>
        ";
    } else {
        $insertQuery = "INSERT INTO users(email, username, password)
         Values ('" .$user->getEmail() ."','" .$user->getUsername() ."','" .$user->getPassword() ."')";
            if($conn->query($insertQuery)){
                echo "
                    <script>
                        alert('Data inserted successfully!');
                    </script>
                ";
                header("location: index.php");
            } else {
                echo "
                    <script>
                        alert('Error: " . $conn->error . "');
                        window.history.back();
                    </script>
                ";
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
        echo "
            <script>
                alert('Incorrect email or password');
                window.history.back();
            </script>
        ";
    }
}

if(isset($_POST['Confirm'])){
    $email = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['newPassword'];

    if ($newPassword !== $confirmPassword) {
        echo "
        <script>
            alert('Passwords do not match!');   
            window.history.back();
        </script>
        ";
        exit();
    }

    $user = new Users($email, null, $confirmPassword);

    $checkEmail = "SELECT * FROM users where email ='" .$user->getEmail() ."'";
    $result = $conn->query($checkEmail);

    if($result->num_rows > 0){

        $updatePassword = "UPDATE users SET password = '" .$user->getPassword() ."' where email ='" .$user->getEmail() ."'";
        if($conn->query($updatePassword)){
            echo "
            <script>
                alert('Password updated!');
            </script>
        ";
        header("Location: index.php");
        exit();
        }else {
            echo "
            <script>
                alert('Error Updating password');
                window.history.back();
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Email not Found');
            window.history.back();
        </script>
        ";
    }
}

?>

