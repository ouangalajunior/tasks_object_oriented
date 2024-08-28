<?php

// Helper function
function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}
//typecast the value to prevent SQL injection

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

//2. Perform database query

//Post method for submission

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    

//1. Create database
$db = mysqli_connect("127.0.0.1", "root", "", "php_learning", 3308);


// Test if connection succeed
if($db->connect_errno){
    $msg = "Database connection failed: ";
    $msg .= $db->connect_error;
    $msg .= " (" .$db->connect_errno . ")";
    exit($msg);
}

    //2. Perform database query

    $sql = "DELETE FROM tasks ";
    $sql .= "WHERE id={$id} ";
    $sql .= "LIMIT 1 ";


    $result = $db->query($sql);
    //Test if quey succeeded
    if (!$result) {
        echo "Delete   failed";
        exit;
    }

    $db->close();


    //3. Use returned data if any
    
} 
redirect_to('index.php');

?>