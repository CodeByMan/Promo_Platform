<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "<script>alert('No product ID specified'); window.location.href='admin_dashboard.php';</script>";
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "<script>alert('Product not found'); window.location.href='admin_dashboard.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];

    if ($discount < 1 || $discount > 100) {
        echo "<script>alert('Discount must be between 1% and 100%');</script>";
    } else {
        $update_sql = "UPDATE products SET 
                        name = '$name',
                        price = $price,
                        discount = $discount
                        WHERE id = '$id'";

        if (mysqli_query($conn, $update_sql)) {
            echo "<script>alert('Product Updated Successfully!'); window.location.href='admin_dashboard.php';</script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
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

<h2>Edit Product</h2>

<form method="POST">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required value="<?= htmlspecialchars($product['name']) ?>">

    <label for="price">Price (in $):</label>
    <input type="number" name="price" min="1" required value="<?= htmlspecialchars($product['price']) ?>">

    <label for="discount">Discount (1-100%):</label>
    <input type="number" name="discount" min="1" max="100" required value="<?= htmlspecialchars($product['discount']) ?>">

    <button type="submit">Update Product</button>
</form>

<a href="admin_dashboard.php">Back to Dashboard</a>

</body>
</html>
