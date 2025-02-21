<?php
include("dataconnection.php");
session_start();

if(isset($_POST['rating']) && isset($_POST['review']) && isset($_POST['product_id']) && isset($_POST['user_id'])) {
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    $product_id = $_POST['product_id'];
    $user_id = $_POST['user_id'];

    $query = "INSERT INTO reviews (product_id, user_id, rating, review) VALUES ('$product_id', '$user_id', '$rating', '$review')";
    if(mysqli_query($userconnection, $query)) {
        $_SESSION['Msg'] = "Review submitted successfully!";
    } else {
        $_SESSION['Msg'] = "Failed to submit review. Please try again.";
    }
} else {
    $_SESSION['Msg'] = "All fields are required.";
}

header("Location: products.php?title=$product_id");
exit();
?>