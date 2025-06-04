<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    $sql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result); 

    if ($user && password_verify($user_password, $user['user_password'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['user_name'];
        $_SESSION['role_id'] = $user['role_id'];

        if ($user['role_id'] == 1) {
            echo "<script> window.location.href='admin_dashboard.php';</script>";
        } elseif ($user['role_id'] == 2) {
            echo "<script> window.location.href='user_dashboard.php';</script>";
        }
        exit(); 
    } else {
        
        echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <style>
        body {
            font-family: sans-serif;
            background: #fafafa;
            margin: 20px auto;
            max-width: 500px;
            padding: 20px;
            
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 15px;
            font-weight: 600;
            color: #555;
        }
        input{
            margin-top: 6px;
            padding: 10px;
            font-size: 1rem;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }
        input:focus {
            border-color: #333;
            outline: none;
        }
        button {
            margin-top: 25px;
            padding: 12px 20px;
            background-color: #333;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #555;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #555;
        }
    </style>
</head>
<body>

<h2>Login Form</h2>

<form method="POST">
    <label for="email">Email</label>
    <input name="email" type="email" required>

    <label for="password">Password</label>
    <input name="password" type="password" required>

    <button type="submit">Login</button>
</form>

<a href="register.php">Don't have an account? Register</a>

</body>
</html>
