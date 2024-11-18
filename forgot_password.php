<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Forgot Password</h1>
        <form action="register.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter email">
            <label for="password">New Password:</label>
            <input type="password" name="password" placeholder="Enter new password" required>
            <label for="newPassword">Confirm Password:</label>
            <input type="password" name="newPassword" placeholder="Enter Confirm password" required>
            <button type="submit" name= "Confirm">Reset Password</button>
        </form>

</body>
</html>