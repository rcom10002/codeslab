<?php

// Class template generated at http://www.card2u.com.my/ClassBuilder
class Option {
//    var $_item_id;
//    var $_item_sub_id;
    var $_type;
    var $_option_content;
//    var $_option_content_edit;
    var $_item_tag;

    // Class constructor
    function Option() {

    }

    // Returns class name
    function GetClassName() {
        return 'Option';
    }

    function Get_item_id() {
        return $this->_item_id;
    }

    function Get_item_sub_id() {
        return $this->_item_sub_id;
    }

    function Get_type() {
        return $this->_type;
    }

    function Get_option_content() {
        return $this->_option_content;
    }

    function Get_option_content_edit() {
        return $this->_option_content_edit;
    }

    function Get_item_tag() {
        return $this->_item_tag;
    }


    function Set_item_id($_item_id) {
        $this->_item_id = $_item_id;
    }

    function Set_item_sub_id($_item_sub_id) {
        $this->_item_sub_id = $_item_sub_id;
    }

    function Set_type($_type) {
        $this->_type = $_type;
    }

    function Set_option_content($_option_content) {
        $this->_option_content = $_option_content;
    }

    function Set_option_content_edit($_option_content_edit) {
        $this->_option_content_edit = $_option_content_edit;
    }

    function Set_item_tag($_item_tag) {
        $_item_tag = strtoupper(ext_trim(preg_replace('/[^A-Z\d]/', '', $_item_tag)));
        $this->_item_tag = is_numeric($_item_tag) ? $_item_tag : ord($_item_tag) - 64;
    }


}

?>