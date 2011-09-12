<?php
header('Content-type: text/html; charset=utf-8');
echo "<pre>";
system('java -jar "just.jar" config-file-path');
//$results = shell_exec('java -jar "just.jar" config-file-path');
//echo $results;
echo "</pre>";
?>
