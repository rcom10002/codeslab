<?php
/**
 * <pre>
 * 多选题，对所有字母字符敏感，连续的字母组合代表一个答案
 *
 * 题型模板：
 * <ul>
 * <li>答案定义：大小写字母均可，连续的字母组合被当作一道题的答案</li>
 * </ul>
 * 题型举例：
 * 
 * 1.ABC  2.BC   3.AD
 * 4.ABCD 5.AD   6.ACD
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerMultipleChoiceProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->ap = '[a-z]+'; // answer pattern
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
            $answer->Set_type(AnswerType::MULTIPLE_CHOICE);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
