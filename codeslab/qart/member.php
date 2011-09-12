<?php
if (!$_GET['m'] || !$_GET['p']) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Member Maintenance</title>
<style type="text/css">
* {
    font-family:"Arial";
    font-weight:bold;
    font-size:11px;
}
input {
    border: 1px solid #aaa;
}
body {
    padding: 0px;
    margin: 0px;
    background-color:#eee;
}
fieldset{
    border:1px solid #aaa;
    margin-left:10px;
    margin-right:10px;
    margin-top:5px;
    margin-bottom:5px;
}
.highlight-row tr:hover {
    background-color: SkyBlue;
}
h2 {
    margin: 0px;
    background-color:#59c;
    color:#fff;
    font-size:12px;
    padding:3px;
}
</style>
<script type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script type="text/javascript">
function PAGE_DATA_STATUS() {
    // action status
    this.NEW = false;
    this.EDIT = false;
    this.DELETE = false;
    // current action role
    this.ROLE = null;
    // current aciton lock
    this.ACTION_LOCK = false;
    this.ORDERBY = null;
}
PAGE_DATA_STATUS.prototype.resetAllStatus = function () {
    this.NEW = false;
    this.EDIT = false;
    this.DELETE = false;
    this.ROLE = null;
    this.ACTION_LOCK = false;
};
PAGE_DATA_STATUS.prototype.isProcessing = function () {
    return (this.NEW || this.EDIT || this.DELETE);
};
PAGE_DATA_STATUS.prototype.log = function (text) {
    $("status-display").text(
        "[debug info " + new Date() +  "]\n" +
        "NEW :" + this.NEW + "\n" +
        "EDIT :" + this.EDIT + "\n" +
        "DELETE :" + this.DELETE + "\n" +
        "ROLE :" + this.ROLE + "\n" +
        "ACTION_LOCK :" + this.ACTION_LOCK + "\n" +
        "ORDER :" + this.ORDERBY
    );
    if (text) {
        $("status-display").text("[debug info " + new Date() +  "]" + text);
    }
};
var page_data_status = new PAGE_DATA_STATUS();
$(document).ready(function () {
    // find all geos
    $.get("member.php?m=member&p=getAllGeos", 
          null,
          function(data){
              $("#action-geography").html($("#action-geography").html() + data);
          });
    var executeCancel = function () {
        if (page_data_status.isProcessing() && !confirm("Do you want to drop the modified data?")) {
            return false;
        }
        if (page_data_status.NEW) {
            $("#btn-action-cancel,#btn-action-apply").attr("disabled", "disabled");
        } else if (page_data_status.EDIT) {
            $("#btn-action-cancel,#btn-action-apply").attr("disabled", "disabled");
        }
        $("#action-fields :input").attr("disabled", "disabled").val("");
        var key = "#" + $("#action-role").val().toLowerCase();
        key += "-member-editor";
        $(key).find("tbody tr").attr("bgcolor", "");
        page_data_status.resetAllStatus();
        return true;
    }
    // highlight when editor is clicked
    $("#builder-member-editor tbody,#qa-member-editor tbody,#wpl-member-editor tbody").bind("click", function (event) {
        if (page_data_status.isProcessing()) {
            return;
        }
        $(this).find("tr").attr("bgcolor", "");
        var tr = $(event.target).closest("tr");
        tr.attr("bgcolor", "#abcdef");
        tr.find("td").each(function(index) {
            if ($(this).find("input").length > 0) {
                // skip the checkbox
                return;
            }
            $("#action-fields td:nth-child(" + index + ")").find("input, select").val($(this).text());
        });
    });
    // view the Builder/QA/WPL
    $("#btn-view-builder").bind("click", function() {
        if (page_data_status.ACTION_LOCK) {
            alert("Previous operation is not finished yet!"); 
            return;
        }
        if (!executeCancel()) {
            return;
        }
        $("#builder-member-editor,#qa-member-editor,#wpl-member-editor").css("display", "none");
        $("#builder-member-editor").css("display", "");
        $.get("member.php?m=member&p=listMember&Role=Builder", 
              { test: "test" },
              function(data){
                  $("#builder-member-editor").find("tbody").html(data);
                  $("#action-role")[0].selectedIndex = 0;
                  $("#btn-action-new,#btn-action-edit,#btn-action-delete").attr("disabled", "");
              });
    });
    $("#btn-view-qa").bind("click", function() {
        if (page_data_status.ACTION_LOCK) {
            alert("Previous operation is not finished yet!"); 
            return;
        }
        if (!executeCancel()) {
            return;
        }
        $("#builder-member-editor,#qa-member-editor,#wpl-member-editor").css("display", "none");
        $("#qa-member-editor").css("display", "");
        $.get("member.php?m=member&p=listMember&Role=QA", 
              { test: "test" },
              function(data){
                  $("#qa-member-editor").find("tbody").html(data);
                  $("#action-role")[0].selectedIndex = 1;
                  $("#btn-action-new,#btn-action-edit,#btn-action-delete").attr("disabled", "");
              });
    });
    $("#btn-view-wpl").bind("click", function() {
        if (page_data_status.ACTION_LOCK) {
            alert("Previous operation is not finished yet!"); 
            return;
        }
        if (!executeCancel()) {
            return;
        }
        $("#builder-member-editor,#qa-member-editor,#wpl-member-editor").css("display", "none");
        $("#wpl-member-editor").css("display", "");
        $.get("member.php?m=member&p=listMember&Role=WPL", 
              { test: "test" },
              function(data){
                  $("#wpl-member-editor").find("tbody").html(data);
                  $("#action-role")[0].selectedIndex = 2;
                  $("#btn-action-new,#btn-action-edit,#btn-action-delete").attr("disabled", "");
              });
    });
    // action buttons
    $("#btn-action-new").bind("click", function() {
        // check status
        if (page_data_status.isProcessing()) {
            if (page_data_status.ACTION_LOCK) {
                alert("Previous operation is not finished yet!");
                return;
            } else {
                if (!confirm("Do you want to drop the modified data and start a new operation?")) {
                    return;
                }
            }
        }
        page_data_status.resetAllStatus();
        page_data_status.NEW = true;
        if ($("#action-role").val() == "WPL") {
            $("#action-fields").find(":input:lt(3)").attr("disabled", "").val("");
        } else {
            $("#action-fields").find(":input").attr("disabled", "").val("");
        }
        $("#action-fields").find("input:nth-child(1)")[0].focus();
        $("#btn-action-apply,#btn-action-cancel").attr("disabled", "");
    });
    $("#btn-action-edit").bind("click", function() {
        // validate data
        var key = "#" + $("#action-role").val().toLowerCase();
        key += "-member-editor";
        if ($(key).find("tr[bgcolor='#abcdef']").length == 0) {
            alert("Click one record to edit, please.");
            return;
        }
        // check status
        if (page_data_status.isProcessing()) {
            if (page_data_status.ACTION_LOCK) {
                alert("Previous operation is not finished yet!");
                return;
            } else {
                if (!confirm("Do you want to drop the modified data and start a new operation?")) {
                    return;
                }
            }
        }
        page_data_status.resetAllStatus();
        page_data_status.EDIT = true;
        if ($("#action-role").val() == "WPL") {
            $("#action-fields").find(":input:lt(3)").attr("disabled", "");
        } else {
            $("#action-fields").find(":input").attr("disabled", "");
        }
        $("#action-fields").find("input:nth-child(1)")[0].focus();
        $("#btn-action-apply,#btn-action-cancel").attr("disabled", "");
    });
    $("#btn-action-apply").bind("click", function() {
        // validate data
        var errorMessage = "";
        if (!/^\S+?@\S+$/.test($("#action-email").val())) {
            errorMessage += "Email format is invalid\n";
        }
        if ($("#action-name").val().trim() == "") {
            errorMessage += "Name format is invalid\n";
        }
        if ($("#action-geography").val().trim() == "") {
            errorMessage += "Geography format is invalid\n";
        }
        if (!$("#action-queue").attr("disabled") && $("#action-queue").val().trim() == "") {
            errorMessage += "Queue format is invalid\n";
        }
        if (!$("#action-clearance").attr("disabled") && $("#action-clearance").val().trim() == "") {
            errorMessage += "Clearance format is invalid\n";
        }
        if (errorMessage.length > 0) {
            alert(errorMessage);
            return;
        }
        var tempRole = $("#action-role").val().toLowerCase();
        if (page_data_status.NEW) {
            // lock the current operation
            page_data_status.ACTION_LOCK = true;
            // execute action
            $.get("member.php?m=member&p=saveMember&action-key-email=" + $("action-email").val(),
                    {
                        Role: $("#action-role").val(),
                        Email: $("#action-email").val(),
                        Name: $("#action-name").val(),
                        Geography: $("#action-geography").val(),
                        Queue: $("#action-queue").val(),
                        Clearance: $("#action-clearance").val()
                    },
                    function (data) {
                        // process data
                        $("#" + tempRole + "-member-editor").find("tbody").html(data);
                        $("#btn-action-cancel,#btn-action-apply").attr("disabled", "disabled");
                        // unlock the current operation
                        page_data_status.ACTION_LOCK = false;
                        page_data_status.NEW = false;
                        executeCancel();
                    });
        } else if (page_data_status.EDIT) {
            // lock the current operation
            page_data_status.ACTION_LOCK = true;
            // execute action
            $.get("member.php?m=member&p=saveMember&action-key-email=" + $("action-key-email").val(),
                    {
                        Role: $("#action-role").val(),
                        Email: $("#action-email").val(),
                        Name: $("#action-name").val(),
                        Geography: $("#action-geography").val(),
                        Queue: $("#action-queue").val(),
                        Clearance: $("#action-clearance").val()
                    },
                    function (data) {
                        // process data
                        $("#" + tempRole + "-member-editor").find("tbody").html(data);
                        $("#btn-action-cancel,#btn-action-apply").attr("disabled", "disabled");
                        // unlock the current operation
                        page_data_status.ACTION_LOCK = false;
                        page_data_status.EDIT = false;
                        executeCancel();
                    });
        }
    });
    $("#btn-action-cancel").bind("click", executeCancel);
    $("#btn-action-delete").bind("click", function() {
        // validate data
        var key = "#" + $("#action-role").val().toLowerCase();
        key += "-member-editor";
        if ($(key).find(":checked").length == 0) {
            alert("Please choose records to delete.");
            return;
        }
        // check status
        if (page_data_status.isProcessing()) {
            if (page_data_status.ACTION_LOCK) {
                alert("Previous operation is not finished yet!");
                return;
            } else {
                if (!executeCancel()) {
                    return;
                }
            }
        }
        // execute action
        var emails = "";
        $(key).find(":checked").each(function () {
            emails += $(this).val() + ",";
        });
        emails = emails.replace(/,$/, "");
        if (!confirm("Do you really want to delete the following data?\n" + emails.split(/,/g).join("\n"))) {
            return;
        }
        page_data_status.DELETE = true;
        // lock the current operation
        page_data_status.ACTION_LOCK = true;
        var tempRole = $("#action-role").val().toLowerCase();
        $.get("member.php?m=member&p=deleteMembers&Emails=" + emails, 
                { Role: $("#action-role").val() },
                function (data) {
                    // process data
                    $("#" + tempRole + "-member-editor").find("tbody").html(data);
                    // unlock the current operation
                  page_data_status.ACTION_LOCK = false;
                  page_data_status.DELETE = false;
                  executeCancel();
                });
    });
    $("#btn-action-new,#btn-action-edit,#btn-action-cancel,#btn-action-apply,#btn-action-delete").bind("click", function () {
        page_data_status.log();
    });

});
</script>
</head>
    <body>
    <fieldset>
    <legend>Member Maintenance</legend>
    <!-- Member Editor -->
    <div>
        <!-- Navigator -->
        <table>
            <tr>
                <td><input type="button" id="btn-view-builder" value="View Builder" /></td>
                <td><input type="button" id="btn-view-qa" value="View QA" /></td>
                <td><input type="button" id="btn-view-wpl" value="View WPL" /></td>
            </tr>
        </table>
        <!-- Row Editor -->
        <table>
            <tr>
                <td colspan="5">
                    <select id="action-role" disabled="disabled">
                        <option>Builder</option>
                        <option>QA</option>
                        <option>WPL</option>
                    </select>
                    <input type="text" id="action-key-email" style="display: none;" />
                    <input type="button" id="btn-action-new" value="New" disabled="disabled" />
                    <input type="button" id="btn-action-edit" value="Edit" disabled="disabled" />
                    <input type="button" id="btn-action-cancel" value="Cancel" disabled="disabled" />
                    <input type="button" id="btn-action-apply" value="Apply" disabled="disabled" />
                    <input type="button" id="btn-action-delete" value="Delete checked items" disabled="disabled" />
                </td>
            </tr>
            <tr>
                <td><label for="action-email">Email</label></td>
                <td><label for="action-name">Name</label></td>
                <td><label for="action-geography">Geography</label></td>
                <td><label for="action-queue">Queue</label></td>
                <td><label for="action-clearance">Clearance</label></td>
            </tr>
            <tr id="action-fields">
                <td><input type="text" style="width: 200px;" id="action-email" disabled="disabled" /></td>
                <td><input type="text" style="width: 200px;" id="action-name" disabled="disabled" /></td>
                <!-- <td><input type="text" style="width: 200px;" id="action-geography" disabled="disabled" /></td> --> 
                <td>
                    <select style="width: 200px;" id="action-geography" disabled="disabled" />
                    </select>
                </td>
                <td><input type="text" style="width: 200px;" id="action-queue" disabled="disabled" /></td>
                <td><input type="text" style="width: 200px;" id="action-clearance" disabled="disabled" /></td>
            </tr>
            <tr>
                <td id="status-display" colspan="5"></td>
            </tr>
        </table>
        <!-- Builder -->
        <table id="builder-member-editor" cellspacing="4" cellpadding="4" border="1" style="border-collapse: collapse; border-width: 1px; border-color: rgb(204, 204, 204); display: none;">
            <!-- titles -->
            <thead><tr bgcolor="#5599cc"><th colspan="6"><h2>Builder</h2></th></tr>
            <tr><th>&nbsp;</th><th>Email</th><th>Name</th><th>Geography</th><th>Queue</th><th>Clearance</th></tr></thead>
            <!-- data -->
            <tbody class="highlight-row" style="cursor: pointer;"></tbody>
        </table>
        <!-- QA -->
        <table id="qa-member-editor" cellspacing="4" cellpadding="4" border="1" style="border-collapse: collapse; border-width: 1px; border-color: rgb(204, 204, 204); display: none;">
            <!-- titles -->
            <thead><tr bgcolor="#5599cc"><th colspan="6"><h2>QA</h2></th></tr>
            <tr><th>&nbsp;</th><th>Email</th><th>Name</th><th>Geography</th><th>Queue</th><th>Clearance</th></tr></thead>
            <!-- data -->
            <tbody class="highlight-row" style="cursor: pointer;"></tbody>
        </table>
        <!-- WPL -->
        <table id="wpl-member-editor" cellspacing="4" cellpadding="4" border="1" style="border-collapse: collapse; border-width: 1px; border-color: rgb(204, 204, 204); display: none;">
            <!-- titles -->
            <thead><tr bgcolor="#5599cc"><th colspan="6"><h2>WPL</h2></th></tr>
            <tr><th>&nbsp;</th><th>Email</th><th>Name</th><th>Geography</th></tr></thead>
            <!-- data -->
            <tbody class="highlight-row" style="cursor: pointer;"></tbody>
        </table>
    </div>
    </fieldset>
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
        $m = $_GET['m'];
        $p = $_GET['p'];
//        if ($m == 'report') {
//            // report
//            $m = new ReporterViewer();
//        } else if ($m == 'member') {
//            // member
//            $m = new MemberEditor();
//        }
        $m = new MemberEditor();
        return $m->$p();
    }
    
    public static function generateRows($data, $withFirstDummyCheckbox = "Email", $skipColumns = null, $colorFunc = null) {
        $row = "<tr>";
        if ($colorFunc) {
            $row = "<tr bgcolor='" . $colorFunc($data) . "'>";
        }
        if ($withFirstDummyCheckbox) {
            $row .= "<td><input type='checkbox' value='" . htmlspecialchars($data[$withFirstDummyCheckbox]) . "' /></td>";
        }
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                continue;
            }
            if ($skipColumns && in_array($key, $skipColumns)) {
                continue;
            }
            $val = htmlspecialchars($val);
            $row .= "<td>$val</td>";
        }
        $row .= "</tr>";
        return $row;
    }
}

class MemberEditor {

    public function getAllGeos() {
            $orderBy = $_GET['orderBy'];
        if (!$orderBy) {
            $orderBy = "Date DESC";
        }
        $whereQueue = mysql_real_escape_string($_GET['Queue']);
        $whereWPLGeo = mysql_real_escape_string($_GET['WPLGeo']);
        $whereWBGeo = mysql_real_escape_string($_GET['WBGeo']);
        $whereQAGeo = mysql_real_escape_string($_GET['QAGeo']);
        $rs = mysql_query("SELECT DISTINCT WPL.Geography FROM WPL");
        $rows = "";
        while ($data = mysql_fetch_array($rs)) {
            $kv = htmlspecialchars($data["Geography"]);
            $rows .= "<option value='$kv'>$kv</option>";
        }
        return $rows;
    }

    public function saveMember() {
        $role = $_GET['Role'];
        if ($role == 'WPL') {
            $queryString = "REPLACE INTO {$_GET['Role']} VALUES ('{$_GET['Email']}', '{$_GET['Name']}', '{$_GET['Geography']}')";
        } else {
            $queryString = "REPLACE INTO {$_GET['Role']} VALUES ('{$_GET['Email']}', '{$_GET['Name']}', '{$_GET['Geography']}', '{$_GET['Queue']}', '{$_GET['Clearance']}')";
        }
        if (mysql_query($queryString)) {
            return $this->listMember();
        }
        return false;
    }

    public function deleteMembers() {
        $emails = mysql_real_escape_string($_GET['Emails']);
        if (mysql_query("DELETE FROM {$_GET['Role']} WHERE find_in_set(Email, '$emails') > 0")) {
            return $this->listMember();
        }
        return false;
    }

    public function listMember() {
        $role = $_GET['Role'];
        $rs = mysql_query("SELECT * FROM {$_GET['Role']}");
        $rows = "";
        while ($data = mysql_fetch_array($rs)) {
            $rows .= Main::generateRows($data);
        }
        return $rows;
    }
}

// Server-side UI processor
?>