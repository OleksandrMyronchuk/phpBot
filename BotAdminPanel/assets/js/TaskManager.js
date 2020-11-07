var button_addTask = document.getElementById("button_addTask");
var button_showChats = document.getElementById("button_showChats");
var button_showTasks = document.getElementById("button_showTasks");
var button_Save = document.getElementById("button_Save");
var button_Cancel = document.getElementById("button_Cancel");
var NewTask = document.getElementById("New-Task");
var TaskTable = $('#TaskTable');
var ChatNamesTable = $('#ChatNamesTable');
var TaskTable_wrapper = null;
var ChatNamesTable_wrapper = null;

var input_chat_id = document.getElementById("input_chat-id");
var input_action = document.getElementById("input_action-name");
var input_execution_time = document.getElementById("input_execution-time");

function BlockSwitcher(isNewTask)
{
    if(null == TaskTable_wrapper) {
        TaskTable_wrapper = document.getElementById("TaskTable_wrapper");
    }
    if(null == ChatNamesTable_wrapper) {
        ChatNamesTable_wrapper = document.getElementById("ChatNamesTable_wrapper");
    }

    if(0 == isNewTask)
    {
        button_addTask.style.display = "block";
        button_showChats.style.display = "block";
        TaskTable_wrapper.style.display = "block";
    }
    else
    {
        button_addTask.style.display = "none";
        button_showChats.style.display = "none";
        TaskTable_wrapper.style.display = "none";
    }

    NewTask.style.display = (1 == isNewTask ? "block" : "none");

    ChatNamesTable_wrapper.style.display = (2 == isNewTask ? "block" : "none");
    button_showTasks.style.display = (2 == isNewTask ? "block" : "none");
}

button_showChats.onclick = function () {
    BlockSwitcher(2); /* SHOW TABLE WITH CHATS some(2);*/
}

button_Cancel.onclick = function () {
    BlockSwitcher(0);
}

button_Save.onclick = function () {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
        {
            console.log(this.responseText);
            PrintTask();
        }
    };
    xhttp.open("POST", "Cron/NewTask.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var dataToSend =
        "chat_id=" + input_chat_id.value +
        "&action=" + input_action.value +
        "&execution_time=" + input_execution_time.value;

    xhttp.send(dataToSend);
    BlockSwitcher(0);
}

button_showTasks.onclick = function () {
    BlockSwitcher(0);
}

button_addTask.onclick = function () {
    BlockSwitcher(1);
}

function LoadChatNamesTable(dataToShow) {
    if ($.fn.DataTable.isDataTable('#TaskTable')) {
        ChatNamesTable.DataTable().clear().destroy();
    }
    ChatNamesTable.DataTable({
        autoWidth: true,
        data: dataToShow,
        columns:
            [
                { title: "Id", data: "_id" },
                { title: "Chat Name", data: "_chat_name" },
                { title: "Chat Id", data: "_chat_id" }
            ]
    })
}

function LoadTaskTable(dataToShow) {
    if ($.fn.DataTable.isDataTable('#TaskTable')) {
        TaskTable.DataTable().clear().destroy();
    }
    TaskTable.DataTable({
        autoWidth: true,
        data: dataToShow,
        columns:
            [
                { title: "Task Id", data: "_id" }, /*hide*/
                { title: "Chat Name", data: "_chat_name" },
                { title: "Chat Id", data: "_chat_id" },
                { title: "Action Name", data: "_action_name" },
                { title: "Execution Time", data: "_execution_time" },
                { title: "Action", data: null },
                { title: "Action", data: null }
            ],
        columnDefs: [
            {
                targets: -1,
                data: null,
                defaultContent: "<a href=\"#\" class=\"editor\">Edit</a>"
            },
            {
                targets: -2,
                data: null,
                defaultContent: "<a href=\"#\" class=\"delete\">Delete</a>"
            },
        ]
    });
    TaskTable.on('click', 'a.delete', function (e) {
        var answer = confirm("Are you sure you want to delete this task?");
        if(answer)
        {
            var userId = $(this).closest('tr').find('td:eq(0)').text();
            DeleteTask(userId);
            $(this).parent().parent().remove();
        }
        e.preventDefault();
    } );

    TaskTable.on('click', 'a.editor', function (e) {

        alert('This feature is temporarily down');
        /*Потім добавити*/

        e.preventDefault();
    } );
}

function DeleteTask(taskId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)
        {console.log(this.responseText)}
    };
    xhttp.open("POST", "Cron/DeleteTask.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var dataToSend =
        "taskId=" + taskId;
    xhttp.send(dataToSend);
}

function PrintChatNames() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            LoadChatNamesTable(JSON.parse( this.responseText ));
        }
    };
    xhttp.open("POST", "Cron/PrintChatNames.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
PrintChatNames();

function PrintTask() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            LoadTaskTable(JSON.parse( this.responseText ));
        }
    };
    xhttp.open("POST", "Cron/PrintTask.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}
PrintTask();