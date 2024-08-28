<?php


error_reporting(E_ALL);

// Helper function
function redirect_to($location) {
    header("Location: " . $location);
    exit;
  }
  

//Post method for submission

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $task = [];
    $task['description'] = $_POST['description'] ?? '';
    $task['priority'] = $_POST['priority'] ?? '10';
    $task['complete'] = $_POST['complete'] ?? '0';
    $task['due_date'] = $_POST['due_date'] ?? '';

 // Syntax mysqli_connect(host, username, password, dbname, port, socket)
$db = new mysqli("127.0.0.1","root", "", "php_learning", 3308);

// Test if connection succeed
if($db->connect_errno){
    $msg = "Database connection failed: ";
    $msg .= $db->connect_error;
    $msg .= " (" .$db->connect_errno . ")";
    exit($msg);
}
//2. Perform database query


$sql = "INSERT INTO tasks(priority, description, complete, due_date) VALUES ";
$sql .= "(";
$sql .= "'" . $db->real_escape_string( $task['priority']) . "',";
$sql .= "'" . $db->real_escape_string($task['description']) . "',";
$sql .= "'" . $db->real_escape_string($task['complete']) . "',"; 
$sql .= "'" . $db->real_escape_string($task['due_date']) . "'";  
$sql .= ")";

$result = $db->query($sql);
//Test if quey succeeded
if(!$result){
    echo "Insert failed";
    exit;
}


//3. Use returned data if any
$new_id = $db->insert_id;
//4. Close db
$db->close();
redirect_to('show.php?id=' . $new_id);

}
?>