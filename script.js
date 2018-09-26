window.onload=function() {
    let newTaskForm = document.getElementById("new_task");
    newTaskForm.style.display = "none";
}

function showNewTask() {
    let newTaskForm = document.getElementById("new_task");
    if(newTaskForm.style.display === "none") {
        newTaskForm.style.display = "block";
    } else {
        newTaskForm.style.display = "none";
    }
}

function showUpdateForm() {
    let updateForm = document.getElementById("new_task");
    if(updateForm.style.display === "none") {
        updateForm.style.display = "block";
    } else {
        updateForm.style.display = "none";
    }
}

function closeDialog() {
    let newTaskForm = document.getElementById("new_task");
    newTaskForm.style.display = "none";
    $optionThree = document.getElementById("three");
}