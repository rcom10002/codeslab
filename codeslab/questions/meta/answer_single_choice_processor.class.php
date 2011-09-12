<?php
/**
 * <pre>
 * 单选题，对所有字母字符敏感，每个字母代表一个答案
 *
 * 题型模板：
 * <ul>
 * <li>答案定义：大小写字母均可，每个字母对应一道题</li>
 * </ul>
 * 题型举例：
 *
 * 1—5 BBABC   6—10 ACAAB   11—15 CACCB   16--20 BCBCA
 * 21--25 CBDAB   26—30 CADCB   31—35 CADAD   36—40 CBDAC
 * 41—45 BACDB   46—50 BABAC   51--55 ACDAD   56—60 CABCB
 * 61—65 CDBAD   66—70 CBCDB   71—75 BAGCD
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerSingleChoiceProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->ap = '[a-z]'; // answer pattern
    }

    public function parse() {
        // 定义题型样式
        $ap = $this->patterning($this->ap, 'usi');

        // 处理答案
        $answerTextArray = array();
        preg_match_all($ap, $this->_sectionText, $answerTextArray);
        if (count($answerTextArray) > 0 && count($answerTextArray[0]) > 0) {
            $answerTextArray = $answerTextArray[0];
        } else {
            return null;
        }

        // 处理答案
        $answerArray = array();
        foreach ($answerTextArray as $answerText) {
            // 拆解每个答案并生成对应的Answer
            $answer = new Answer();
            $answer->Set_content($answerText);
            $answer->Set_type(AnswerType::SINGLE_CHOICE);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
