<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$coupons = mysqli_query($conn, "
    SELECT coupons.*, products.name AS product_name 
    FROM coupons 
    JOIN products ON coupons.product_id = products.id
    WHERE coupons.user_id = $user_id
    ORDER BY coupons.created_at DESC
");

if (!$coupons) {
    die("Error fetching coupons: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Coupons</title>
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
        <a href="user_dashboard.php">Products</a>
        <a href="my_coupons.php">My Coupons</a>
        <a href="logout.php">Logout</a>
    </div>

    <h2>My Coupons</h2>
    <table>
        <thead>
            <tr>
                <th>Coupon Code</th>
                <th>Product</th>
                <th>Redeemed</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($c = mysqli_fetch_assoc($coupons)): ?>
            <tr>
                <td><?= htmlspecialchars($c['code']) ?></td>
                <td><?= htmlspecialchars($c['product_name']) ?></td>
                <td><?= $c['redeemed'] ? 'Yes' : 'No' ?></td>
                <td><?= htmlspecialchars($c['created_at']) ?></td>
                <td>
                    <?php if (!$c['redeemed']): ?>
                        <form method="POST" action="redeem_coupon.php" style="margin:0;">
                            <input type="hidden" name="coupon_id" value="<?= $c['id'] ?>">
                            <button type="submit">Redeem</button>
                        </form>
                    <?php else: ?>
                        Redeemed
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
