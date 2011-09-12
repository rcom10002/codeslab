<?php
/**
 *
 *
 *
 *
 *
 */
class TabControl {
    
    static $_tab_control = null;
    
    private $_config_tabs = array();
    
    private $_identifier = null;
    
    public static $_role_WB = 'WB';
    
    public static $_role_QA = 'QA';
    
    public static $_role_WDL = 'WDL';
    
    public static $_role_QALead = 'QALead';
    
    public static $_role_Manager = 'Manager';
    
    /**
     * @return TabControl
     */
    public static function getInstance() {
        if (isset(TabControl::$_tab_control)) {
            return TabControl::$_tab_control;
        }
        TabControl::$_tab_control = new TabControl();
        return TabControl::$_tab_control;
    }
    
    /**
     * @return void
     */
    private function __construct() {
        TabControl::$_tab_control = $this;
        // config the tabs's content
        $this->_config_tabs = array(
            TabControl::$_role_WB => array(
            	'Common errors' => 'common.php',
                'Wrong backsteps/approvals' => 'wrong.php'),
            TabControl::$_role_QA => array(
            	'QAR Tool' => 'index.php', 
            	'Backstep review' => 'review.php', 
            	'personal QA Evaluation' => 'personeval.php',
                'Wrong backsteps/approvals' => 'wrong.php'),
            TabControl::$_role_WDL => array(
            	'Report Wrong Backstep' => 'badreturn.php', 
            	'Full Report extraction' => 'full.php',  
            	'Member Maintenance' => 'member.php', 
            	'Summary' => 'console.php', 
            	'QA Evaluation' => 'qaevaluation.php',
                'Wrong backsteps/approvals' => 'wrong.php'),
            TabControl::$_role_QALead => array(
            	'QAR Tool' => 'index.php', 
            	'QA Evaluation' => 'qaevaluation.php', 
            	'Backstep review' => 'badreturnreview.php', 
            	'Full Report extraction' => 'full.php',  
            	'Member Maintenance' => 'member.php', 
            	'Summary' => 'console.php', 
            	'Queue\'s errors' => 'queueerror.php',
                'Wrong backsteps/approvals' => 'wrong.php'),
            TabControl::$_role_Manager => array(
            	'Full Report extraction' => 'full.php',  
            	'Member Maintenance' => 'member.php', 
            	'Summary' => 'console.php', 
            	'QA Evaluation' => 'qaevaluation.php',
                'Wrong backsteps/approvals' => 'wrong.php')
        );
    }
    
    /**
     * This method will accept a string then convert it to an inner identifer<br />
     * so that Tab Control can output tab content associated with proper role
     * 
     * @param $value
     * @return TabControl
     */
    public function setEmail($value) {
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
        // Tabs for WB (for everyone in Builder table but not in any other table)
        // Tabs for QAS (for everyone in QA table and NOT in OtherClearances table)
        // Tabs for WDL (for everyone with Clearance=1 on OtherClearances table)
        // Tabs for QA Lead (for everyone with Clearance=3 on OtherClearances table)
        // Manager & Senior WDLs (for everyone with Clearance=2 on OtherClearances table)
        $roleQuery = mysql_query(str_replace("#", "'" . str_replace("'", "''", $value) . "'", "
            SELECT 'WB' role, 0 priority FROM Builder WHERE Email = #
            UNION
            SELECT 'QA', 1 FROM QA WHERE Email = # AND NOT EXISTS (SELECT * FROM OtherClearances WHERE Email = #)
            UNION
            SELECT 'WDL', 2 FROM OtherClearances WHERE Email = # AND Clearance = 1
            UNION
            SELECT 'QALead', 3 FROM OtherClearances WHERE Email = # AND Clearance = 3
            UNION
            SELECT 'Manager', 4 FROM OtherClearances WHERE Email = # AND Clearance = 2
             ORDER BY priority DESC"));
        if ($data = mysql_fetch_array($roleQuery)) {
            $this->_identifier = $data['role'];
        } else {
            die("<font size='7' face='verdana,arial,helvetica,sans-serif' color='red'>No information for you.</font>");
        }
        return $this;
    }
    
    /**
     * per the given identifier print the corresponding tabs
     * 
     * @return void
     */
    public function printTabs() {
        $params = preg_replace('/^.*?(\?.*)?$/', '$1', $_SERVER['REQUEST_URI']);
        $tabs = $this->_config_tabs[$this->_identifier];
        if (!is_array($tabs)) {
            return;
        }
        $tab_line = array();
        foreach ($tabs as $tab_title => $tab_url) {
            $tab_line[] = "<a href='$tab_url$params' onclick='document.getElementsByTagName(\"iframe\")[0].src=this.href; return false;'>$tab_title</a>";
        }
        echo '<html><head><style>h2 a {color: #BBDDFE; text-decoration: underline;} h2 a:hover {color: #FFFFFF;}</style></head><body style="margin: 0px; padding: 0px;">';
        echo '<h2 style="color: #FFFFFF; font-size: 12px; font-family: \'Arial\'; font-weight: bold; padding: 3px;">' . implode(" | ", $tab_line) . '</h2>';
        echo '<iframe src="' . $tabs[0][0] . '" style="margin: 0px; padding: 0px; border: none; width: 100%; height: 100%; max-height: 402px;" scroll="no"></iframe>';
        echo '<script>document.getElementsByTagName("iframe")[0].src=document.getElementsByTagName("a")[0].href;</script>';
        echo '</body></html>';
    }
}
// print the tabs per the given role
TabControl::getInstance()->setEmail($_GET['currentUser'])->printTabs();
//igor.kolejak@sk.ibm.com   WB
//gyissc@cn.ibm.com         QA
//loyato@ar.ibm.com         QALead
//huberc@us.ibm.com         Manager
?>