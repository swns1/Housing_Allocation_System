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
        echo  "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>SweetAlert</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>

        Swal.fire({
            title: 'Error!',
            text: 'Email already exists!',
            icon: 'info'
        }).then((result) => {
            if(result.isConfirmed) {
                window.history.back();
            }
        });
        </script>
            
        </body>
        </html> ";
    } else {
        $insertQuery = "INSERT INTO users(email, username, password)
         Values ('" .$user->getEmail() ."','" .$user->getUsername() ."','" .$user->getPassword() ."')";
            if($conn->query($insertQuery)){
                echo  "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>SweetAlert</title>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                <script>
        
                Swal.fire({
                    title: 'Success',
                    text: 'Account Created!',
                    icon: 'success'
                 }).then((result) => {
                    if(result.isConfirmed) {
                        window.history.back();
                    }
                });
                </script>
                    
                </body>
                </html> ";
            } else {
                echo  "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>SweetAlert</title>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                <script>
        
                Swal.fire({
                    title: 'Error!',
                    text: 'Account did not Registered!',
                    icon: 'info'
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.history.back();
                    }
                });
                </script>
                    
                </body>
                </html> ";
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
                echo  "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>SweetAlert</title>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                <script>
        
                Swal.fire({
                    title: 'Error!',
                    text: 'Incorrect password or email',
                    icon: 'error'
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.history.back();
                    }
                });
                </script>
                    
                </body>
                </html> ";
    }
}

if(isset($_POST['Confirm'])){
    $email = $_POST['email'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['newPassword'];

    if ($newPassword !== $confirmPassword) {
        echo  "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>SweetAlert</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>

        Swal.fire({
            title: 'Error!',
            text: 'Password did not match',
            icon: 'error'
        }).then((result) => {
            if(result.isConfirmed) {
                window.history.back();
            }
        });
        </script>
            
        </body>
        </html> ";
        exit();
    }

    $user = new Users($email, null, $confirmPassword);

    $checkEmail = "SELECT * FROM users where email ='" .$user->getEmail() ."'";
    $result = $conn->query($checkEmail);

    if($result->num_rows > 0){

        $updatePassword = "UPDATE users SET password = '" .$user->getPassword() ."' where email ='" .$user->getEmail() ."'";
        if($conn->query($updatePassword)){
            echo  "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>SweetAlert</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
            <script>
    
            Swal.fire({
                title: 'Success',
                text: 'Password is updated!',
                icon: 'success'
            });
            </script>
                
            </body>
            </html> ";
        header("Location: index.php");
        exit();
        }else {
            echo  "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>SweetAlert</title>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
            <script>
    
            Swal.fire({
                title: 'Error!',
                text: 'Error updating password!',
                icon: 'error'
            }).then((result) => {
                if(result.isConfirmed) {
                    window.history.back();
                }
            });
            </script>
                
            </body>
            </html> ";
        }
    } else {
        echo  "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>SweetAlert</title>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>

        Swal.fire({
            title: 'Error!',
            text: 'Email not found',
            icon: 'error'
        }).then((result) => {
            if(result.isConfirmed) {
                window.history.back();
            }
        });
        </script>
            
        </body>
        </html> ";
    }
}

?>

