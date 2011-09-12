<?php
class ClassBuilder {
    var $ClassName;
    var $SuperClass;
    var $Variables;
    var $Methods;
    var $Output;
    var $FilePath;

    function ClassBuilder($ClassName) {
        $this->ClassName = $ClassName;
        $this->Variables = array();
        $this->Methods = array();
    }

    function SetSuperClass($SuperClass) {
        $this->SuperClass = $SuperClass;
    }

    function SetVariables($Variables) {
        while(list($VariableIndex, $VariableName) = each($Variables)) {
            array_push($this->Variables, $VariableName);
        }
    }

    function SetMethods($Methods) {
        while(list($MethodIndex, $MethodName) = each($Methods)) {
            array_push($this->Methods, $MethodName);
        }
    }

    function GetOutput() {
        return $this->Output;
    }

    function GetFilePath() {
        return $this->FilePath;
    }

    function GenerateClass() {
        $Output = '';
        $Output .= "\n";
        $Output .= $this->Tab(1) . "// Class template generated at http://www.card2u.com.my/ClassBuilder\n";

        if($this->SuperClass) {
            $Output .= $this->Tab(1) . "class $this->ClassName extends $this->SuperClass {\n";
        }
        else {
            $Output .= $this->Tab(1) . "class $this->ClassName {\n";
        }

        reset($this->Variables);
        while(list($VarIndex, $VarName) = each($this->Variables)) {
            $Output .= $this->Tab(2) . "var \$$VarName;\n";
        }

        $Output .= "\n";

        $Output .= $this->Tab(2) . "// Class constructor\n";
        $Output .= $this->Tab(2) . "function $this->ClassName() {\n";
        $Output .= "\n";
        $Output .= $this->Tab(2) . "}\n";
        $Output .= "\n";

        $Output .= $this->Tab(2) . "// Returns class name\n";
        $Output .= $this->Tab(2) . "function GetClassName() {\n";
        $Output .= $this->Tab(3) . "return '$this->ClassName';\n";
        $Output .= $this->Tab(2) . "}\n";
        $Output .= "\n";

        reset($this->Methods);
        while(list($MethodIndex, $MethodName) = each($this->Methods)) {
            $Output .= $this->Tab(2) . "function $MethodName() {\n";
            $Output .= "\n";
            $Output .= $this->Tab(2) . "}\n";
            $Output .= "\n";
        }

        reset($this->Variables);
        while(list($VarIndex, $VarName) = each($this->Variables)) {
            $Output .= $this->Tab(2) . "function Get$VarName() {\n";
            $Output .= $this->Tab(3) . "return \$this->$VarName;\n";
            $Output .= $this->Tab(2) . "}\n";
            $Output .= "\n";
        }

        $Output .= "\n";

        reset($this->Variables);
        while(list($VarIndex, $VarName) = each($this->Variables)) {
            $Output .= $this->Tab(2) . "function Set$VarName(\$$VarName) {\n";
            $Output .= $this->Tab(3) . "\$this->$VarName = \$$VarName;\n";
            $Output .= $this->Tab(2) . "}\n";
            $Output .= "\n";
        }

        $Output .= "\n";
        $Output .= $this->Tab(1) . "}\n";
        $Output .= "\n";

        /*
         $FileName = 'ClassBuilder/' . $this->ClassName . '.txt';
         $FilePath = 'http://www.card2u.com.my/' . $FileName;
         $File = fopen($FileName, 'w') or die("Error opening file!");
         fwrite($File, $Output);
         fclose($File) or die("Error closing file!");
         */

        $this->Output = $Output;
        $this->FilePath = $FilePath;
    }

    function Tab($Num) {
        $Output = '';

        for($i = 1; $i <= $Num; $i++) {
            $Output .= '   ';
        }

        return $Output;
    }

}

$x = new ClassBuilder("QuestionSet");
$x->SetVariables(array(
'_single_choice',
'_multiple_choice',
'_completion',
'_true_or_false',
'_cloze_test',
'_simple_answer',
'_short_answer',
'_integration'
));
// $x->SetMethods(array("Method1", "Method2"));
$x->GenerateClass();
echo $x->GetOutput();
flush();
?>