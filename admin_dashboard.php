<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: login.php'); 
    exit();
}

$product = mysqli_query($conn, "SELECT * FROM products");
if (!$product) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body { 
            font-family: sans-serif; 
        }
        h2 { 
            margin-bottom: 10px; 
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-bottom: 30px; 
        }
        th, td { 
            border: 1px solid #ccc; 
            padding: 8px; 
            text-align: left;
        }
        th { 
            background-color: #f0f0f0; 
        }
        a.button {
            background-color: #333;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 5px;
        }
        .topnav {
            background-color: #eee;
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .topnav a {
            margin-right: 15px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            padding: 8px 12px;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }
        .topnav a:hover {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="view_coupons.php">View Coupons</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>All Products</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Price ($)</th>
                <th>Discount (%)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($result = mysqli_fetch_assoc($product)): ?>
            <tr>
                <td><?= htmlspecialchars($result['id']) ?></td>
                <td><?= htmlspecialchars($result['name']) ?></td>
                <td><?= htmlspecialchars($result['price']) ?></td>
                <td><?= htmlspecialchars($result['discount']) ?></td>
                <td>
                    <a href="edit_product.php?id=<?= $result['id'] ?>" class="button">Edit</a>
                    <a href="delete_product.php?id=<?= $result['id'] ?>" class="button"
                       onclick="return confirm('Are you sure you want to delete this product?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="add_product.php" class="button">Add New Product</a>

</body>
</html>
