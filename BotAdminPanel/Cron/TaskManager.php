<?php
/*
Таблиця
Список ід чатів
Створити таблицю ід чатів
*/

require_once '../Define.php';
require_once '../Auth.php';
global $homepage;
isLogged($homepage . 'BotAdminPanel/login.html');

?>
<link rel="stylesheet" type="text/css" href="<?=($homepage . 'assets/css/bootstrap.min.css')?>"/>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="<?=($homepage . 'BotAdminPanel/assets/css/style.css')?>"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>
<br/><br/>

<div class="container">

    <table id="ChatNamesTable"></table>
    <table id="TaskTable"></table>
    <div>
        <button type="button" id="button_addTask">Add Task</button>
        <button type="button" id="button_showChats">Show Chats</button>
        <button type="button" id="button_showTasks">Show Tasks</button>
    </div>

    <div id="New-Task" class="row">
        <div class="col">
            <label for="input_chat-id">Chat Id:</label>
        </div>

        <div class="col">
            <input type="text" id="input_chat-id" name="input_chat-id">
        </div>

        <div class="col">
            <label for="input_action-name">Action Name:</label>
        </div>

        <div class="col">
            <input type="text" id="input_action-name" name="input_action-name">
        </div>

        <div class="col">
            <label for="input_execution-time">Execution Time:</label>
        </div>

        <div class="col">
            <input type="text" id="input_execution-time" name="input_execution-time">
        </div>

        <br>

        <div class="col">
            <button type="button" id="button_Save">Save</button>
            <button type="button" id="button_Cancel">Cancel</button>
        </div>
    </div>

    <div id="Chats-List" class="row">
        <div class="col">
        </div>
    </div>

</div>
<script type="text/javascript" src="<?=($homepage . 'BotAdminPanel/assets/js/TaskManager.js')?>"></script>