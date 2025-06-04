<?php
session_start();
include('db.php'); 


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: user_dashboard.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

$check = mysqli_query($conn, "SELECT id FROM coupons WHERE user_id = $user_id AND product_id = $product_id");
if (mysqli_num_rows($check) > 0) {
    echo "<script>alert('You have already generated a coupon for this product.'); window.location.href='my_coupons.php';</script>";
    exit();
}

function generateUniqueCode($length = 8) {
    $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charsArray = str_split($chars); 
    $code = '';

    for ($i = 0; $i < $length; $i++) {
        $code .= $charsArray[array_rand($charsArray)];
    }
    return $code;
}

do {
    $code = generateUniqueCode(); 
    $res = mysqli_query($conn, "SELECT id FROM coupons WHERE code = '$code'");
   } while (mysqli_num_rows($res) > 0); 


$insert = mysqli_query($conn, "INSERT INTO coupons (user_id, product_id, code, redeemed, created_at) VALUES ($user_id, $product_id, '$code', 0, NOW())");


if ($insert) {
    echo "<script>alert('Coupon generated: $code'); window.location.href='my_coupons.php';</script>";
    exit();
} else {
    echo "Error: " . mysqli_error($conn);
}
