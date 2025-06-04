<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $delete_sql = "DELETE FROM products WHERE id = '$id'";


    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Product Deleted Successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "Error Deleting Product: " . mysqli_error($conn);
    }
}
?>
