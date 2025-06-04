<?php
session_start();
include('db.php');

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$products = mysqli_query($conn, "SELECT * FROM products");
if (!$products) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
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

    <h2>Available Products and Offers</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th><th>Price</th><th>Discount</th><th>Get Coupon</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = mysqli_fetch_assoc($products)): ?>
                <?php
                    $product_id = $p['id'];
                    $check = mysqli_query($conn, "SELECT id FROM coupons WHERE user_id = $user_id AND product_id = $product_id LIMIT 1");
                    $alreadyGenerated = mysqli_num_rows($check) > 0;
                ?>
                <tr>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>$<?= htmlspecialchars($p['price']) ?></td>
                    <td><?= htmlspecialchars($p['discount']) ?>%</td>
                    <td>
                        <?php if ($alreadyGenerated): ?>
                            <button class="disabled" disabled>Already Generated</button>
                        <?php else: ?>
                            <form method="POST" action="generate_coupon.php">
                                <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                                <button type="submit">Generate Coupon</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
