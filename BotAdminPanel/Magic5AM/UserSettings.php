<?php
require_once 'Auth.php';
isLogged('login.html');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.21/datatables.min.js"></script>

<script>

    function LoadTable(dataToExport) {
        var currentTable = $('#CurrentTable');
        currentTable.DataTable({
            autoWidth: true,
            data: dataToExport,
            columns:
                [{ title: "User Id", data: "_UserId" },
                { title: "Username", data: "_Username" },
                { title: "First Name", data: "_FirstName" },
                { title: "Last Name", data: "_LastName" },
                { title: "Current Day", data: "_CurrentDay" }]
        });

        currentTable.on('dblclick', 'tr', function () {
            var data = currentTable.DataTable().row(this).data();
            currentDay = window.prompt("Enter the number of days", data._CurrentDay);
            if(currentDay===null){return;}
            data._CurrentDay = currentDay;
            UpdateDay(data._CurrentDay, data._UserId);
            currentTable.DataTable().row(this).data(data).draw();
            e.preventDefault();
        } );
    }

    function UpdateDay(setDay, userID) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("Day for the user with id " + userID + " has been updated to " + setDay );
            }
        };
        xhttp.open("POST", "User/UserSettings.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var data = "setDay=" + setDay + "&userID=" + userID;
        xhttp.send(data);
    }

    (function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                LoadTable(JSON.parse( this.responseText ));
            }
        };
        xhttp.open("POST", "User/UserSettings.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    })();

</script>


    <table id="CurrentTable"></table>