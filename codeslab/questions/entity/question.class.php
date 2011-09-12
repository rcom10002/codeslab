<?php
// Class template generated at http://www.card2u.com.my/ClassBuilder
class Question {
//    var $_id;
//    var $_sub_id;
//    var $_level;
//    var $_limit_tm;
//    var $_point;
//    var $_source;
//    var $_status;
    var $_type;
    var $_content;
//    var $_content_edit;
//    var $_option_count;
//    var $_guide;
//    var $_category;
//    var $_expire;
//    var $_sub_flg;
    var $_options;
    var $_questions;
    var $_explanation;

    // Class constructor
    function Question() {

    }

    // Returns class name
    function GetClassName() {
        return 'Question';
    }

    function Get_id() {
        return $this->_id;
    }

    function Get_sub_id() {
        return $this->_sub_id;
    }

    function Get_level() {
        return $this->_level;
    }

    function Get_limit_tm() {
        return $this->_limit_tm;
    }

    function Get_point() {
        return $this->_point;
    }

    function Get_source() {
        return $this->_source;
    }

    function Get_status() {
        return $this->_status;
    }

    function Get_type() {
        return $this->_type;
    }

    function Get_content() {
        return $this->_content;
    }

    function Get_content_edit() {
        return $this->_content_edit;
    }

    function Get_option_count() {
        return count($this->_options);
    }

    function Get_guide() {
        return $this->_guide;
    }

    function Get_category() {
        return $this->_category;
    }

    function Get_expire() {
        return $this->_expire;
    }

    function Get_sub_flg() {
        return $this->_sub_flg;
    }

    function &Get_options() {
        return $this->_options;
    }

    function &Get_questions() {
        return $this->_questions;
    }

    function Get_explanation() {
    	return $this->_explanation;
    }

    function Set_id($_id) {
        $this->_id = $_id;
    }

    function Set_sub_id($_sub_id) {
        $this->_sub_id = $_sub_id;
    }

    function Set_level($_level) {
        $this->_level = $_level;
    }

    function Set_limit_tm($_limit_tm) {
        $this->_limit_tm = $_limit_tm;
    }

    function Set_point($_point) {
        $this->_point = $_point;
    }

    function Set_source($_source) {
        $this->_source = $_source;
    }

    function Set_status($_status) {
        $this->_status = $_status;
    }

    function Set_type($_type) {
        $this->_type = $_type;
    }

    function Set_content($_content) {
        $this->_content = $_content;
    }

    function Set_content_edit($_content_edit) {
        $this->_content_edit = $_content_edit;
    }

    function Set_option_count($_option_count) {
        $this->_option_count = $_option_count;
    }

    function Set_guide($_guide) {
        $this->_guide = $_guide;
    }

    function Set_category($_category) {
        $this->_category = $_category;
    }

    function Set_expire($_expire) {
        $this->_expire = $_expire;
    }

    function Set_sub_flg($_sub_flg) {
        $this->_sub_flg = $_sub_flg;
    }

    function Set_options($_options) {
        return $this->_options = $_options;
    }

    function Set_questions($_questions) {
        return $this->_questions = $_questions;
    }

    function Set_explanation($_explanation) {
    	$this->_explanation = $_explanation;
    }
}
?>