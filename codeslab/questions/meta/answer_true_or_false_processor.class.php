<?php
/**
 * <pre>
 * 判断题，yes、no、对、错均可作为标准样式
 *
 * 题型模板：
 * <ul>
 * <li>忽略题号定义，只对答案定义敏感</li>
 * <li>答案定义：yes、no、对、错、true、false均可作为标准样式，数字编号(item_tag)，1为对，0为错</li>
 * </ul>
 * 题型举例：
 * 
 * 1. yes
 * 2. no
 * 3. 对
 * 4. 错
 * 5. true
 * 6. false
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerTrueOrFalseProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->ap = 'yes|no|对|错|true|false'; // answer pattern
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
            $answer->Set_content(ext_trim($answerText));
            $answer->Set_type(AnswerType::TRUE_OR_FALSE);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
