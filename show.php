<?php 
//Typecast the value as integer to prevent SQL injection
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
//1. Create et connect database
// Database information
/*
 hostname: "127.0.0.1" or "localhost"
 username: "php_learning_admin"
 password: "Geneva2024##"
 database: "php_learning"
 port:     3306 or 3307
*/
// Syntax mysqli_connect(host, username, password, dbname, port, socket)
$db = new mysqli("127.0.0.1","root", "", "php_learning", 3308);

// Test if connection succeed
if($db->connect_errno){
    $msg = "Database connection failed: ";
    $msg .= $db->connect_error;
    $msg .= " (" .$db->connect_errno . ")";
    exit($msg);

     

}
// 2. Perform database query
$sql = "SELECT * FROM tasks ";
$sql .= "WHERE id = {$id} ";
$sql .= "LIMIT 1";
$result = $db->query($sql);

// Test if query succeed
if(!$result){
    exit("Database query failed");
 }

      // 3. Use returned data (if any)
$task = $result->fetch_object();

if(is_null($task)){
    exit("No task found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager : Show task</title>
</head>
<body>
    <header>
        <h1>Task Manager</h1>
    </header>

    <section>
        <h1>Show task details</h1>
        <dl>
            <dt>ID</dt>
            <dd><?php echo $task->id; ?></dd>
        </dl>

        <dl>
            <dt>Priority</dt>
            <dd><?php echo $task->priority; ?></dd>
        </dl>

        <dl>
            <dt>Description</dt>
            <dd><?php echo $task->description; ?></dd>
        </dl>

        <dl>
            <dt>Complete</dt>
            <dd><?php echo $task->complete; ?></dd>
        </dl>

        <dl>
            <dt>Due date</dt>
            <dd><?php echo $task->due_date; ?></dd>
        </dl>

    </section>
    
</body>
</html>

<?php
    // 4. Release returned data
   $result->free();

    //5. Close database connection
    $db->close();
    ?>