<?php
require_once 'Auth.php';
isLogged('login.html');

require_once ABSPATH . 'Defines.php';

$timeOffsetBD = date(DATEFORMAT, strtotime('-' . abs(TIMEOFFSET - 24) . ' hours'));
$timeOffsetED = date(DATEFORMAT, strtotime('+' . TIMEOFFSET . ' hours'));
/*
Show all users
Show all users who accept members
Show all users who forgot to accept members
*/
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>

<input
    type="date"
    id="beginDate"
    name="beginDate"
    value="<?=$timeOffsetBD?>"
>
<input
    type="date"
    id="endDate"
    name="endDate"
    value="<?=$timeOffsetED?>"
>
<br/><br/>
<button onclick="GetMembers(0)">Show everyone who has been participated</button>
<button onclick="GetMembers(1)">Show everyone who has not been participated</button>
<button onclick="GetMembers(2)">Show all members</button>


<table id="CurrentTable"></table>
<script>
    function LoadTable(dataToExport) {
        var currentTable = $('#CurrentTable');
        if ($.fn.DataTable.isDataTable('#CurrentTable')) {
            currentTable.DataTable().clear().destroy();
        }
        var currentTable = $('#CurrentTable');
        currentTable.DataTable({
            autoWidth: true,
            data: dataToExport,
            columns:
                [{ title: "User Id", data: "_UserId" },
                { title: "Username", data: "_Username" },
                { title: "First Name", data: "_FirstName" },
                { title: "Last Name", data: "_LastName" },
                { title: "Action", data: null }],
            columnDefs: [ {
                targets: -1,
                data: null,
                defaultContent: "<a href=\"\" class=\"editor_remove\">Delete</a>"
            } ]
        });
        currentTable.on('click', 'a.editor_remove', function (e) {
            var answer = confirm("Are you sure you want to delete this user?");
            if(answer)
            {
                var userId = $(this).closest('tr').find('td:eq(0)').text();
                DeleteUser(userId);
                $(this).parent().parent().remove();
            }
            e.preventDefault();
        } );
    }

    function DeleteUser(userId) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {}
        };
        xhttp.open("POST", "User/User.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var dataToSend =
            "userId=" + userId;
        xhttp.send(dataToSend);
    }

    function GetMembers(action) {
        var beginDate = document.getElementById("beginDate").value;
        var endDate = document.getElementById("endDate").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                LoadTable(JSON.parse( this.responseText ));
            }
        };
        xhttp.open("POST", "User/UserInfo.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var dataToSend =
            "beginDate=" + beginDate +
            "&endDate=" + endDate +
            "&action=" + action;
        xhttp.send(dataToSend);
    }
</script>