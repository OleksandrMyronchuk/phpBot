<?php
require_once '../Auth.php';
isLogged('login.html');

require_once ABSPATH . 'Defines.php';

$timeOffsetBD = date(DATEFORMAT, strtotime('-' . abs(TIMEOFFSET - 24) . ' hours'));
$timeOffsetED = date(DATEFORMAT, strtotime('+' . TIMEOFFSET . ' hours'));
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
<button onclick="ExportToExcel()">Export To Excel</button>
<br/><br/>
<p>URL to the Google Sheets Doc:</p>
<input id="spreadsheetId" type="text">
<button onclick="ExportToGoogleSheets()">Export To Google Sheels</button>
<br/><br/>
<button onclick="View()">View</button>
<br/><br/>
<button onclick="DeleteToken()">Delete The Google Sheets Token</button>
<br/><br/>
<div id="GoogleSheetsOutPut"></div>
<br/><br/>
<table id="CurrentTable"></table>
<script>
    function LoadTable(dataToExport) {
        var currentTable = $('#CurrentTable');
        if ($.fn.DataTable.isDataTable('#CurrentTable')) {
            currentTable.DataTable().clear().destroy();
        }
        currentTable.DataTable({
            autoWidth: true,
            data: dataToExport,
            columns:
                [{ title: "User Id", data: "_userId" },
                { title: "Username", data: "_username" },
                { title: "First Name", data: "_firstName" },
                { title: "Last Name", data: "_lastName" },
                { title: "Telegram Time", data: "_telegramTime" },
                { title: "Server Time", data: "_serverTime" },
                { title: "Day", data: "_day" },
                { title: "Context", data: "_context" }]
        });
    }

    function View() {
        var beginDate = document.getElementById("beginDate").value;
        var endDate = document.getElementById("endDate").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                LoadTable(JSON.parse( this.responseText ));
            }
        };
        xhttp.open("POST", "Magic5AM/Export/View.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var dataToSend =
            "beginDate=" + beginDate +
            "&endDate=" + endDate;
        xhttp.send(dataToSend);
    }

    function DeleteToken() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {}
        };
        var linkToWebSite =
            window.location.href;
        linkToWebSite = linkToWebSite.replace("BotAdminPanel/Magic5AM/Export.php", "Sheets/DeleteToken.php");
        xhttp.open("POST", linkToWebSite, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
    }

    function ExportToExcel() {
        var beginDate = document.getElementById("beginDate").value;
        var endDate = document.getElementById("endDate").value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var fileData = ['\ufeff'+this.responseText];
                var blobObject = new Blob(fileData,{
                    type: "text/csv;charset=utf-8;"
                });
                var downloadLink = document.createElement("a");
                var url = URL.createObjectURL(blobObject);
                downloadLink.href = url;
                downloadLink.download = "report " + new Date().toLocaleString() +  ".csv";
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
            }
        };
        xhttp.open("POST", "Magic5AM/Export/ExcelReport.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var dataToSend =
            "beginDate=" + beginDate +
            "&endDate=" + endDate;
        xhttp.send(dataToSend);
    }

    function ExportToGoogleSheets() {
        var GoogleSheetsOutPut = document.getElementById("GoogleSheetsOutPut");
        GoogleSheetsOutPut.innerHTML = "Export has been started. Do not press anything!";
        var beginDate = document.getElementById("beginDate").value;
        var endDate = document.getElementById("endDate").value;
        var urlToGoogleSheetsDoc = document.getElementById("spreadsheetId").value;
        var spreadsheetId = new RegExp("/spreadsheets/d/([a-zA-Z0-9-_]+)").exec(urlToGoogleSheetsDoc)[1];
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            GoogleSheetsOutPut.innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", "Magic5AM/Export/GoogleSheetsReport.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var dataToSend =
            "beginDate=" + beginDate +
            "&endDate=" + endDate +
            "&spreadsheetId=" + spreadsheetId;
        xhttp.send(dataToSend);
    }
</script>



<?php
