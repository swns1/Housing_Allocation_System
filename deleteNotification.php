<?php
session_start();
include('connect.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM notifications WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    $response = ['success' => $stmt->execute()];
    echo json_encode($response);
}
