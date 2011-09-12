<?php
// Class template generated at http://www.card2u.com.my/ClassBuilder
class Answer {
    var $_type;
    var $_content;
    var $_item_tag;
    var $_answers;
    var $_desc;

    // Class constructor
    function AnswerPaper($hasChildren = false) {
        if ($hasChildren) {
            $_answers = array();
        }
    }

    // Returns class name
    function GetClassName() {
        return 'Answer';
    }

    function Get_type() {
        return $this->_type;
    }

    function Get_content() {
        return $this->_content;
    }

    function Get_item_tag() {
        return $this->_item_tag;
    }
    
    function &Get_answers() {
        return $this->_answers;
    }
    
    function Get_desc() {
        return $this->_desc;
    }

    function Set_type($_type) {
        $this->_type = $_type;
        if ($this->_type == AnswerType::TRUE_OR_FALSE ||
                $this->_type == AnswerType::SINGLE_CHOICE || 
                $this->_type == AnswerType::MULTIPLE_CHOICE ||
                $this->_type == AnswerType::CLOZE_TEST ||
                $this->_type == AnswerType::CORRECTION) {
            $this->Set_content($this->Get_content());
        }
    }

    function Set_content($_content) {
        $this->_content = $_content;

        // 处理判断题，改错题
        if ($this->_type && ($this->_type == AnswerType::TRUE_OR_FALSE ||
                 $this->_type == AnswerType::CORRECTION)) {
            if (preg_match('/^(yes|true|对)$/u', $_content) > 0) {
                $this->Set_item_tag(1);
            } else if (preg_match('/^(no|false|错)$/u', $_content) > 0) {
                $this->Set_item_tag(0);
            }
        }

        // 处理单选题、多选题和完形填空题
        if ($this->_type &&
                ($this->_type == AnswerType::SINGLE_CHOICE || 
                 $this->_type == AnswerType::MULTIPLE_CHOICE || 
                 $this->_type == AnswerType::CLOZE_TEST)) {
            if (preg_match('/^[a-z]+$/i', $_content) > 0) {
                if (strlen($_content) == 1 && (($this->_type == AnswerType::SINGLE_CHOICE || $this->_type == AnswerType::CLOZE_TEST))) {
                    // 处理单选
                    $this->Set_item_tag($this->process_item_tag($_content));
                } else if ($this->_type == AnswerType::MULTIPLE_CHOICE) {
                    // 处理多选
                    $items = array();
                    foreach (preg_split('/(?<=[a-z])(?=[a-z])/is', $_content) as $item) {
                        $items[] = $this->process_item_tag($item);
                    }
                    $this->Set_item_tag($items);
                }
            }
        }
    }

    private function Set_item_tag($_item_tag) {
        $this->_item_tag = $_item_tag;
    }

    function Set_desc($_desc) {
        $this->_desc = $_desc;
    }
    
    private function process_item_tag($_item_tag) {
        $_item_tag = strtoupper($_item_tag);
        return is_numeric($_item_tag) ? $_item_tag : ord($_item_tag) - 64;
    }
}
?>