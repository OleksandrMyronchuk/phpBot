var functionName = "Block";

var content =
{
    botToken: null,
    databaseConnection: {
        host: null,
        username: null,
        password: null,
        dbname: null,
        charset: null
    }
};

function SetContentValues() {
    var botToken = document.getElementById('botToken');
    botToken.value = content.botToken === undefined ? '' : content.botToken;

    if(content.databaseConnection != null) {
        var host = document.getElementById('host');
        host.value = content.databaseConnection.host === undefined ? '' : content.databaseConnection.host;
        var username = document.getElementById('username');
        username.value = content.databaseConnection.username === undefined ? '' : content.databaseConnection.username;
        var password = document.getElementById('password');
        password.value = content.databaseConnection.password === undefined ? '' : content.databaseConnection.password;
        var dbname = document.getElementById('dbname');
        dbname.value = content.databaseConnection.dbname === undefined ? '' : content.databaseConnection.dbname;
        var charset = document.getElementById('charset');
        charset.value = content.databaseConnection.charset === undefined ? '' : content.databaseConnection.charset;
    }
}

var callbackForMPR;
function MakePOSTRequest(url, params) {
    var method = "POST";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callbackForMPR(this.responseText);
        }
    }
    xhttp.open(method, url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
}

(function () {
    var url = "ContentManager.php";
    var params = "functionName=GetContent";
    MakePOSTRequest(url, params);
    callbackForMPR = function(val)
    {
        content = JSON.parse(val);
        SetContentValues();
    }
})();

function SaveContent() {
    content =
    {
        botToken: document.getElementById('botToken').value,
        databaseConnection: {
            host: document.getElementById('host').value,
            username: document.getElementById('username').value,
            password: document.getElementById('password').value,
            dbname: document.getElementById('dbname').value,
            charset: document.getElementById('charset').value
        }
    };

    var url = "ContentManager.php";
    var params = "functionName=SaveContent&data=" + JSON.stringify(content);
    MakePOSTRequest(url, params);
    callbackForMPR = function(val) {}
}

function OpenNewBlock(num) {
    document.getElementById("block" + (num - 1)).style.display = 'none';
    document.getElementById("block" + num).style.display = 'block';
}

function NextBlock(num) {
    if(-1 == num)
    {
        Finish();
        return;
    }
    var result = eval(functionName + (num - 1) + "();");
    if(result)
    {
        OpenNewBlock(num);
    }
}

function WebHookInstallation(botTokenValue)
{
    var url = "SetWebhook.php";
    var params = "botToken=" + botTokenValue;
    MakePOSTRequest(url, params);
    callbackForMPR = function(val)
    {
        document.getElementById("webhook-status").innerText =
            val;
    }
}

function Checking()
{
    var url = "Checking.php";
    MakePOSTRequest(url, '');
    callbackForMPR = function(val)
    {
        console.log(val);
        /*document.getElementById("webhook-status").innerText =
            val;*/
    }
}

function Block1() {
    return true;
}

function Block2() {
    var botTokenValue = document.getElementById('botToken').value;
    if(botTokenValue != '')
    {
        WebHookInstallation(botTokenValue);
        return true;
    }
    else
    {
        alert("Error!");
    }
}

function Block3() {
    return true;
}

function Block4() {
    var hostValue = document.getElementById('host').value;
    var usernameValue = document.getElementById('username').value;
    var passwordValue = document.getElementById('password').value;
    var dbnameValue = document.getElementById('dbname').value;
    var charsetValue = document.getElementById('charset').value;

    var result =
        hostValue != '' &&
        usernameValue != '' &&
        passwordValue != '' &&
        dbnameValue != '' &&
        charsetValue != '';

    if(result)
    {
        SaveContent();
        Checking();
        return true;
    }
    else
    {
        alert("Error");
    }
}

function Block5() {

}

function Block6() {

}

function Block7() {

}

function Block8() {

}

function Block9() {

}

function Finish() {

}