<?php

// Regulate input with allow list 0 and 1 to prevent SQL injection
$allowed = array("0", "1");
if(isset($_GET['complete']) && in_array($_GET['complete'], $allowed)){
    $complete = $_GET['complete'];
}
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
// 2. Perform database query to display 1 entry
     // Data base table name : tasks

     $sql = "SELECT * FROM  tasks ";
     if(isset($complete)){
        $sql .= "WHERE complete = {$complete} ";
     }
     $sql .= "ORDER BY priority";

     $result = $db->query($sql);

     // Test if query succeed
     if(!$result){
        exit("Database query failed");
     }
     // 3. Use returned data (if any)
//$task = $result->fetch_object();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager Index page</title>
</head>
<body>
    <header>
        <h1> Task Managaer</h1>
    </header>
<nav>
    <a href="new.php">+ New Task</a>
</nav>

    <section>
        <h2>Tasks list</h2>

        <p>
            <a href="index.php">All</a>
            <a href="index.php?complete=1">Complete</a>
            <a href="index.php?complete=0">Incomplete</a>
            
        </p>

        <table>
            <tr>
                <th>ID</th>
                <th>Priority</th>
                <th>Completed</th>
                <th>Description</th>
                <th>Due Date</th>
                <th></th>
            </tr>
            <?php
            // Loop result query all result
            ?>
            <?php // foreach ($result as $task) { ?>

            <?php while($task = $result->fetch_object()){?>
                <tr>
                    <td><?php echo $task ->id; ?> </td>
                    <td><?php echo $task->priority ;?> </td>
            <!-- Changing boolean 0 and 1 by true or false when task is completed-->
                    <td><?php echo $task->complete == 1  ?  'true' : 'false';?> </td>
                    <td><?php echo $task->description ;?> </td>
                    <td><?php echo $task->due_date ;?> </td>
                    <td><a href="show.php?id=<?php echo $task->id; ?>">View</a></td>
                </tr>
            <?php } ?>
        </table>
    </section>

    <?php
    // 4. Release returned data
   $result->free();

    //5. Close database connection
    $db->close();
    ?>
</body>
</html>