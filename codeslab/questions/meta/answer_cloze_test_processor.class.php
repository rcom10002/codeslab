<?php
/**
 * <pre>
 * 完形填空题，对所有字母字符敏感，连续的字母组合代表一个答案(忽略大小写格式)
 *
 * 题型模板：
 * <ul>
 * <li>答案定义：一题有多个答案时需要用组合符号“|-”进行分割</li>
 * <li>注意：每题独占一行</li>
 * </ul>
 * 题型举例：
 * 
 * 1. B|-B|-S
 * 2. A|-B|-C
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerClozeTestProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->anp = '(?:\n|^)\s*[(（]?\b\d+\b[）).．、]'; // answer number pattern
        $this->ap = '.+'; // answer pattern
        $this->sas = '\|-'; // sub answer split char
    }

    public function parse() {
        // 定义题型样式
        $ap = $this->patterning(array($this->anp, $this->ap), 'umi');

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
            $answer = new Answer(true);
            $answerText = preg_replace($this->patterning($this->anp), '', $answerText);
            $subAnswerTextArray = array();
            $subAnswerTextArray = preg_split($this->patterning($this->sas), $answerText);
            foreach ($subAnswerTextArray as $subAnswerText) {
                $subAnswer = new Answer();
                $subAnswer->Set_content(ext_trim($subAnswerText));
                $subAnswer->Set_type(AnswerType::CLOZE_TEST);
                $subAnswers = &$answer->Get_answers();
                $subAnswers[] = $subAnswer;
            }
            $answer->Set_type(AnswerType::CLOZE_TEST);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }
    
}
