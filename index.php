<?php

    $database = mysqli_connect('localhost', 'root', '', 'todo');
    $summary = '';
    $dueDate = '';
    $status = '';
    $id = 0;
    $editRow = false;
    
    //submit task

    if (isset($_POST['submit'])) {
        $summary = $_POST['summary'];
        $dueDate = $_POST['due_date'];
        $status = 'pending';
        $description = $_POST['description'];
        if (!empty($summary) && !empty($dueDate)) {
            mysqli_query($database, "INSERT INTO tasks(summary, due_date, statuss, description) VALUES('$summary', '$dueDate', '$status', '$description')");
            header('location: index.php');
        }
    }

    //update task
    
    if (isset($_POST['update'])) {
        $summary = $_POST['summary'];
        $dueDate = $_POST['due_date'];
        $id = $_POST['id'];
        if (!empty($summary) && !empty($dueDate)) {
            mysqli_query($database, "UPDATE tasks SET summary='$summary', due_date='$dueDate' WHERE id=$id");
            header('location: index.php');
        }
    }

    //delete task
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        mysqli_query($database, "DELETE FROM tasks WHERE id='$id'");
        header('location: index.php');
    }

    //edit task
    if (isset($_GET['edit'])) {
        $id = $_GET['edit'];
        $editRow = true;
        $rec = mysqli_query($database, "SELECT * FROM tasks WHERE id='$id'");
        $record = mysqli_fetch_array($rec);
        $summary = $record['summary'];
        $dueDate = $record['due_date'];
        $id = $record['id'];
    }
    
    $tasks = mysqli_query($database, "SELECT * FROM tasks");
    
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>To-do list</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="script.js"></script>
</head>
<body>
    <div>
        <button id="new" onclick="showNewTask()">New task</button>
        <input type="checkbox" id="completed" name="completed" value=1 checked />
        <label id="label_compl" for="completed">Show completed tasks</label>
    </div>
    <div>
        <table>
            <thead>
                <th>Summary<button name="sort_summary"><i class="arrow down"></i></button></th>
                <th>Status<button><i class="arrow down"></i></button></th>
                <th>Due Date<button><i class="arrow down"></i></button></th>
                <th>Actions</th>
            </thead>
            <tbody>

            <?php foreach ($tasks as $task) { ?>
                <tr>
                    <td id="summ">
                        <?php echo($task['summary']); ?>
                    </td>
                    <td id="status">
                        <select id="select">
                            <option value="pending" id="one">Pending</option>
                            <option value="in_progress" id="two">In progress</option>
                            <option value="completed" id="three">Completed</option>
                        </select>
                    </td>
                    <td id="date">
                        <?php $date = strtotime($task['due_date']); $date = date('d M Y', $date); echo($date); ?>
                    </td>
                    <td id="buttons">
                        <a href="index.php?edit=<?php echo($task['id']); ?>" onclick="showNewTask()" id="edit"><i class="fa fa-pencil"></i></a>
                        <a name="compl" id="compl" type="button"><i class="fa fa-check"></i></a>
                        <a class="delete_btn" href="index.php?id=<?php echo($task['id']); ?>"><font color=red>x</font></a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>
    <div id="new_task">
        <form method="POST" action="index.php">
            <button id="x" type="button" onclick="closeDialog()">X</button><br>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="summary">Summary: </label><font color=red>*</font>    
            <input type="text" name="summary" value="<?php echo $summary; ?>"><br>
            <label for="due_date">Due Date: </label><font color=red>*</font>  
            <input type="date" name="due_date" value="<?php echo $dueDate; ?>"><br>
            <label for="description">Description: </label>
            <textarea rows="4" cols="30" name="description"></textarea><br> 
            <?php if ($editRow == false): ?>
            <button id="save" type="submit" name="submit">Save</button>
            <?php else: ?>
            <button id="update" type="submit" name="update">Update</button>
            <?php endif ?>
            <button id="cancel" type="button" name="cancel" onclick="closeDialog()">Cancel</button>
        </form>
    </div>

</body>
</html>