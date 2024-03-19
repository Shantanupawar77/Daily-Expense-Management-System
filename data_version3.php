<?php
require 'config.php';

// Fetch all expenses from the database
$rows = mysqli_query($con, "SELECT * FROM expenses");

// Initialize an array to store expenses grouped by user ID
$userExpenses = array();

// Loop through each row and group expenses by user ID
foreach ($rows as $row) {
    $user_id = $row["user_id"];
    // If user ID doesn't exist in the array, create a new entry
    if (!isset($userExpenses[$user_id])) {
        $userExpenses[$user_id] = array();
    }
    // Add the expense details to the user's array
    $userExpenses[$user_id][] = array(
        'expense_id' => $row["expense_id"],
        'expense' => $row["expense"],
        'expensedate' => $row["expensedate"],
        'expensecategory' => $row["expensecategory"]
    );
}

// Create CSV content
$csvContent = "";
$csvContent.="User_id,Expense_id,Expense,Expense_Date,Expense_Category\n";
foreach ($userExpenses as $user_id => $expenses) {
    foreach ($expenses as $expense) {
        $csvContent .= "$user_id,{$expense['expense_id']},{$expense['expense']},{$expense['expensedate']},{$expense['expensecategory']}\n";
    }
}

// Return CSV content
return $csvContent;
?>