<?php
if (!$_GET['p']) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Wrong backsteps/approvals</title>
<style type="text/css">
*{
    font-family:"Arial";
    font-weight:bold;
    font-size:11px;
}
body {
    padding: 0px;
    margin: 0px;
    background-color:#eee;
}
input, textarea{
    border:1px solid #aaa;
}
fieldset{
    border:1px solid #aaa;
    margin-left:10px;
    margin-right:10px;
    margin-top:5px;
    margin-bottom:5px;
}
.readyonly{
    background-color:#F7F7F7;
    font-size:12px;
    color:#666666;
    font-family: Arial
    text-decoration: none;
}
</style>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">
var LOCK = false;
var submitClickHandler = function () {
    if ($("#taskNumber").val() == "") {
        alert("Task number is mandatory.");
        return;
    }
    if ($("#prodComments").val() == "" || $("#prodComments").val().length > 600) {
        alert("Issue description is mandatory and its maxium length is 600.");
        return;
    }
    if (LOCK) {
    	alert("Previous operation is not finished yet!");
        return;
    }
    LOCK = true;
    $("#btnSubmit").attr("disabled", "");
    $.post(
        "wrong.php?p=submit", 
        {
            TaskNumber: $("#taskNumber").val(),
            WrongWhat: $("#WrongWhat").find(":checked").val(),
            CommentsEval: $("#CommentsEval").find(":checked").val(),
            ProdComments: $("#prodComments").val()
        },
        function (data) {
            $("#btnSubmit").attr("disabled", "");
            LOCK = false;
            if (data == "OK") {
                alert("Data was submitted successfully!");
                $("#WrongWhat").find("input")[1].checked = true;
                $("#CommentsEval").find("input")[1].checked = true;
                $("#prodComments").val("");
            } else if (data.indexOf("Warning") > -1) {
                alert(data.split("~")[1]);
            } else {
                alert("Data wasn't submitted, please try it again!");
            }
        }
    );
};
$(function() {
    $("#btnSubmit").bind("click", submitClickHandler);
});
</script>
</head>
<body>
    <div>
        <fieldset>
            <legend>Wrong backsteps/approvals</legend>
            <p>
                <label for="taskNumber">Task Number:</label>
                <input type="text" id="taskNumber" name="taskNumber" size="13" readonly="readonly" class="readyonly" value="<?php echo $_GET['taskNumber'] ?>" />
            </p>
            <p id="WrongWhat">
                <label>Please select the issue to be reported:</label><br/>
                <input type="radio" value="0" id="wrongWhatApproval" name="wrongWhat" />
                <label for="wrongWhatApproval">Wrong approval</label><br/>
                <input type="radio" value="1" id="wrongWhatPartialy" name="wrongWhat" checked="checked" />
                <label for="wrongWhatPartialy">Partialy wrong backstep</label><br/>
                <input type="radio" value="2" id="wrongWhatBackstep" name="wrongWhat" />
                <label for="wrongWhatBackstep">Wrong backstep</label>
            </p>
            <p id="CommentsEval">
                <label>Please select the issue to be reported:</label><br/>
                <input type="radio" value="0" id="commentsEvalGood" name="commentsEval" />
                <label for="commentsEvalGood">Good comments (QAS provided everything I needed to fastly fix the issues)</label><br/>
                <input type="radio" value="1" id="commentsEvalNeutral" name="commentsEval" checked="checked" />
                <label for="commentsEvalNeutral">Neutral (something took sometime for me to understand)</label><br/>
                <input type="radio" value="2" id="commentsEvalBackstep" name="commentsEval" />
                <label for="commentsEvalBackstep">Poor comments (Couldn't perform one of the fixes, or it took a really long time)</label>
            </p>
            <p>
                <label for="prodComments">Issue description (max 600 characters):</label><br/>
                <textarea id="prodComments" style="width: 100%; height: 150px;"></textarea>
            </p>
            <input type="button" value="Submit" id="btnSubmit" name="btnSubmit" />
        </fieldset>
    </div>
</body>
</html>
<?php
} else {
    echo Main::run();
}
?>
<?php
class Main {
    public static function run() {
        // DataBase Connection
        $connection = mysql_connect("localhost","stgq6","bluehost");
        if(!$connection){
            die("DataBase connection failed: ".mysql_error());
        }
        // Selects data base
        $db_select = mysql_select_db("stgq6",$connection);
        if(!$db_select){
            die("DataBase selection failed: " . mysql_error());
        }
        $p = $_GET['p'];
        $m = new WrongProcessor();
        return $m->$p();
    }
}

class WrongProcessor {

    public function submit() {
        // check data
        $queryString = "SELECT Date
                          FROM Report 
                         WHERE Task = '" . $_POST['TaskNumber'] . "'";
        $result = mysql_query($queryString);
        if ($result) {
            if(mysql_num_rows($result) == 0) {
                return "Warning~No QA Report for the current task!";
            }
        } else {
            return "Error";
        }
        // check data
        $queryString = "SELECT Task
                          FROM WrongQA 
                         WHERE Task = '" . $_POST['TaskNumber'] . "'";
        $result = mysql_query($queryString);
        if ($result) {
            if(mysql_num_rows($result) == 1) {
                return "Warning~A wrong entry for the current task already exists!";
            }
        } else {
            return "Error";
        }
        // submit data
        $taskNumber   = $_POST['TaskNumber'];
        $wrongWhat    = $_POST['WrongWhat'];
        $commentsEval = $_POST['CommentsEval'];
        $prodComments = $_POST['ProdComments'];
        $queryString = "INSERT INTO WrongQA
                        SELECT Date, '$taskNumber', $wrongWhat, $commentsEval, '$prodComments', null, null
                          FROM Report 
                         WHERE Task = '$taskNumber'
                         ORDER BY Date DESC LIMIT 1";
        if (mysql_query($queryString)) {
            return "OK";
        }
        return "Error";
    }

}
?>