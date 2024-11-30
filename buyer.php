<?php
session_start();
include('connect.php');

class BuyerData {
    private $propertyId;
    private $fullname;
    private $email;
    private $phone;
    private $message;
    private $userId;

    public function __construct($propertyId, $fullname, $email, $phone, $message, $userId) {
        $this->propertyId = $propertyId;
        $this->fullname = $fullname;
        $this->email = $email;
        $this->phone = $phone;
        $this->message = $message;
        $this->userId = $userId;
    }

    public function getPropertyId() {
        return $this->propertyId;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getMessage() {
        return $this->message;
    }

    public function getUserId() {
        return $this->userId;
    }
}

abstract class Base {
    protected $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    protected function showAlert($title, $message, $type) {
        echo "
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
                title: '{$title}',
                text: '{$message}',
                icon: '{$type}'
            }).then(() => {
                window.location.href = 'home.php';
            });
        </script>
        </body>
        </html>";
    }

    abstract public function execute($data);
}

class SubmitBuyer extends Base {
    public function execute($data) {
        $insertQuery = "INSERT INTO buyers (property_id, fullname, email, phone, message, user_id) 
                        VALUES ('" . $data->getPropertyId() . "', '" . $data->getFullname() . "', '" . $data->getEmail() . "', 
                                '" . $data->getPhone() . "', '" . $data->getMessage() . "', '" . $data->getUserId() . "')";

        if ($this->conn->query($insertQuery)) {
            $this->showAlert('Success!', 'Your purchase request has been submitted.', 'success');
        } else {
            $this->showAlert('Error!', 'There was an error submitting your request.', 'error');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitBuyer'])) {
        $buyerData = new BuyerData(
            $_POST['property_id'],
            $_POST['fullname'],
            $_POST['email'],
            $_POST['phone'],
            $_POST['message'],
            $_SESSION['user_id']
        );

        $submitBuyer = new SubmitBuyer($conn);
        $submitBuyer->execute($buyerData);
    }
}
?>
