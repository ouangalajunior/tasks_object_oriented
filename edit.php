<?php



// Helper function
function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}
//typecast the value to prevent SQL injection

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

//1. Create database
$db = mysqli_connect("127.0.0.1", "root", "", "php_learning", 3308);

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

//Post method for submission

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task = [];
    $task['description'] = $_POST['description'] ?? '';
    $task['priority'] = $_POST['priority'] ?? '10';
    $task['complete'] = $_POST['complete'] ?? '0';
    $task['due_date'] = $_POST['due_date'] ?? '';


    //2. Perform database query

    $sql = "UPDATE tasks SET ";
    $sql .= "description= ' " . $db->real_escape_string($task['description']) . "', ";
    $sql .= "priority= ' " . $db->real_escape_string($task['priority']) . "', ";
    $sql .= "complete= ' " . $db->real_escape_string($task['complete']) . "', ";
    $sql .= "due_date= ' " . $db->real_escape_string($task['due_date']) . "' ";
    $sql .= "WHERE id={$id} ";
    $sql .= "LIMIT 1 ";


    $result = $db->query($sql);
    //Test if quey succeeded
    if (!$result) {
        echo "Update  failed";
        exit;
    }



    //3. Use returned data if any
    redirect_to('edit.php?success=1&id=' . $id);
} else {
    if (isset($_GET['success']) && $_GET['success'] == "1") {
        $message = "Task updated";
    }
    $sql = "SELECT * FROM tasks ";
    $sql .= "WHERE id = {$id} ";
    $sql .= "LIMIT 1";

    $result = $db->query($sql);
    //Test if quey succeeded
    if (!$result) {
        exit("Database query failed");
    }

      //3. Use returned data if any
      $task = $result->fetch_object();
      if(is_null($task)){
        exit("No task found");
      }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager: Edit task</title>
</head>

<body>

    <header>
        <h1> Edit task</h1>
    </header>
    <nav>
        <a href="index.php">Task List</a>
    </nav>

<?php if(isset($message)){echo "<div>" .$message ."</div> ";} ?>

    <form action="edit.php?id=<?php echo $id; ?>" method="post">
      

        
                
                <dl>
          <dt>Priority</dt>
          <dd>
            <select name="priority">
            <?php
              for($i=1; $i <= 10; $i++) {
                echo "<option value=\"{$i}\"";
                if($task->priority == $i) {
                    echo " selected";
                }
                
                echo ">{$i}</option>";
              }
            ?>
            </select>
          </dd>
        </dl>

        <dl>
            <dt>Description</dt>
            <dd><input type="text" name="description" value="<?php echo $task->description?>"></dd>
        </dl>
     

        <dl>
            <dt>Due date</dt>
            <dd><input type="date" name="due_date" value="<?php echo $task->due_date?>"></dd>
        </dl>

        <dl>
          <dt>Completed</dt>
          <dd>
            <input type="hidden" name="complete" value="0"/>
          <input type="checkbox" name="complete" value="1" <?php if($task->complete == "1") {echo "checked";} ?>/>
          </dd>
        </dl>

        <div>
            <input type="submit" value="Edit Task">
        </div>

    </form>
</body>

</html>

<?php
    // 4. Release returned data
    $result ->free();
    

    //5. Close database connection
    $db->close();
    ?>