<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $role_id = 2; 

    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO `users`(`user_name`, `user_email`, `user_password`, `role_id`)
            VALUES ('$user_name', '$user_email', '$hashed_password', '$role_id')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Successfully Registered'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Register Form</title>
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

<h2>Register Form</h2>

<form method="POST">
    <label for="name">Name</label>
    <input name="name" type="text" required>

    <label for="email">Email</label>
    <input name="email" type="email" required>

    <label for="password">Password</label>
    <input name="password" type="password" required>

    <button type="submit">Register</button>
</form>

<a href="login.php">Already have an account? Login</a></span>

</body>
</html>
