<?php
require 'config.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user_id associated with the logged-in email
$query = "SELECT user_id FROM users WHERE email = '$email'";
$result = mysqli_query($con, $query);
if (!$result || mysqli_num_rows($result) == 0) {
    // Redirect to login page if user not found
    header("Location: login.php");
    exit();
}

$row = mysqli_fetch_assoc($result);
$user_id = $row['user_id'];

// Fetch expenses for the logged-in user from the database
$rows = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = $user_id");

// Create CSV content
$csvContent = "User_id,Expense_id,Expense,Expense_Date,Expense_Category\n";
foreach ($rows as $row) {
    $csvContent .= "$user_id,{$row['expense_id']},{$row['expense']},{$row['expensedate']},{$row['expensecategory']}\n";
}

// Return CSV content
return $csvContent;
?>