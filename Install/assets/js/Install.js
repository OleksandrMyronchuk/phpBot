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
    },
    superuser: {
        login: null,
        password: null
    }
};

(function () {
    var method = "POST";
    var url = "ContentManager.php";
    var params = "functionName=GetContent";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    }
    xhttp.open(method, url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(params);
})();

function SaveContent() {

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

function Block1() { return true; }

function Block2() {

}

function Block3() {

}

function Block4() {

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