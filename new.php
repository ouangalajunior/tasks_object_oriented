<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager: New task</title>
</head>

<body>

    <header>
        <h1> New Task</h1>
    </header>
    <nav>
        <a href="index.php">Task List</a>
    </nav>


    <form action="new_process.php" method="post">
      
<!--
        <dl>
            <dt>Priority</dt>
            <dd>
                <select name="priority">
                    <?php 
                   // for($i=1; $i<=10; $i++){
                  //      echo "<option value=\"{$i}\"> {$i}</option>";
                  //  }
                    ?>

                </select>
            </dd>
        </dl>
                -->
                <dl>
          <dt>Priority</dt>
          <dd>
            <select name="priority">
            <?php
              for($i=1; $i <= 10; $i++) {
                echo "<option value=\"{$i}\">{$i}</option>";
              }
            ?>
            </select>
          </dd>
        </dl>

        <dl>
            <dt>Description</dt>
            <dd><input type="text" name="description" value=""></dd>
        </dl>
     

        <dl>
            <dt>Due date</dt>
            <dd><input type="date" name="due_date" value=""></dd>
        </dl>

        <dl>
          <dt>Completed</dt>
          <dd>
          <input type="checkbox" name="complete" value="1">
          </dd>
        </dl>

        <div>
            <input type="submit" value="Create Task">
        </div>

    </form>
</body>

</html>