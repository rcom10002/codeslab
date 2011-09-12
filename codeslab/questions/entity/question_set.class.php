<?php

// Class template generated at http://www.card2u.com.my/ClassBuilder
class QuestionSet {
    var $_single_choice = array();
    var $_multiple_choice = array();
    var $_completion = array();
    var $_true_or_false = array();
    var $_cloze_test = array();
    var $_simple_answer = array();
    var $_short_answer = array();
    var $_integration = array();

    // Class constructor
    function QuestionSet() {

    }

    // Returns class name
    function GetClassName() {
        return 'QuestionSet';
    }

    function Get_single_choice() {
        return $this->_single_choice;
    }

    function Get_multiple_choice() {
        return $this->_multiple_choice;
    }

    function Get_completion() {
        return $this->_completion;
    }

    function Get_true_or_false() {
        return $this->_true_or_false;
    }

    function Get_cloze_test() {
        return $this->_cloze_test;
    }

    function Get_simple_answer() {
        return $this->_simple_answer;
    }

    function Get_short_answer() {
        return $this->_short_answer;
    }

    function Get_integration() {
        return $this->_integration;
    }

}
?>