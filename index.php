<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
</head>
<body>
    
    <form action="register.php" method="post">
        <h1>Register</h1>
        <input type="email" name="email" placeholder="Enter email" required>
        <label for="email">Email:</label>
        <input type="text" name="username" placeholder="Enter username" required>
        <label for="username">Username:</label> 
        <input type="password" name="password" placeholder="Enter password" required>
        <label for="password">Password:</label>
        <button type="submit" name="signUp">Sign Up</button>
    </form>

    <form action="register.php" method="post">
        <h1>Login</h1>
        <input type="email" name="email" placeholder="Enter email" required>
        <label for="email">Email:</label> 
        <input type="password" name="password" placeholder="Enter password" required>
        <label for="password">Password:</label>
        <button type="submit" name="login">Login</button>
    </form>

</body>
</html>    </html>