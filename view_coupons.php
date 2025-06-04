<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
    header('Location: login.php');
    exit();
}

$coupons = mysqli_query($conn, "
    SELECT c.code, c.redeemed, c.created_at, u.user_name, p.name AS product_name 
    FROM coupons c 
    JOIN users u ON c.user_id = u.user_id 
    JOIN products p ON c.product_id = p.id 
    ORDER BY c.created_at DESC
");

if (!$coupons) {
    die("Error fetching coupons: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Coupons</title>
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

    <h2>All Coupons</h2>

    <table>
        <thead>
            <tr>
                <th>Coupon Code</th>
                <th>User</th>
                <th>Product</th>
                <th>Redeemed</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($c = mysqli_fetch_assoc($coupons)): ?>
            <tr>
                <td><?= htmlspecialchars($c['code']) ?></td>
                <td><?= htmlspecialchars($c['user_name']) ?></td>
                <td><?= htmlspecialchars($c['product_name']) ?></td>
                <td><?= $c['redeemed'] ? 'Yes' : 'No' ?></td>
                <td><?= htmlspecialchars($c['created_at']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
