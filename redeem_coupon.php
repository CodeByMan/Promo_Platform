<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: my_coupons.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$coupon_id = $_POST['coupon_id'];

$sql = "SELECT * FROM coupons WHERE id = $coupon_id AND user_id = $user_id AND redeemed = 0";
$res = mysqli_query($conn, $sql);

if (mysqli_num_rows($res) !== 1) {

    echo "<script>alert('Invalid coupon or already redeemed'); window.location.href='my_coupons.php';</script>";
    exit();
}

$update = mysqli_query($conn, "UPDATE coupons SET redeemed = 1 WHERE id = $coupon_id");

if ($update) {
    echo "<script>alert('Coupon redeemed successfully'); window.location.href='my_coupons.php';</script>";
} else {
    echo "Error updating coupon: " . mysqli_error($conn);
}
?>
