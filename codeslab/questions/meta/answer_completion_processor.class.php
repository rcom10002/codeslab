<?php
/**
 * <pre>
 * 填空题，每题可能有多个答案，需要用组合符号“|-”分割
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选，至少要有一个后缀修饰符，必须位于行首</li>
 * <li>答案定义：一题有多个答案时需要用组合符号“|-”进行分割</li>
 * <li>注意：每题独占一行</li>
 * </ul>
 * 题型举例：
 * 
 * 1.   中西医学 科学技术和实验方法|-基础理论、刺灸效应和机理|-生命活动影响规律
 * 2)   竞争与挑战|-综合国力|-科技与人才|-精神文明
 * 3、针刺镇痛、 促机体防卫免疫|-脏腑、器官功能的调整
 * (4)   神经体液|-最大极限及其机理
 * 5．   针灸学范畴的内容|-现代科学实验
 * 6）   科学实验|-调节机体生命|-相互关系  
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerCompletionProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->anp = '(?:\n|^)\s*[(（]?\b\d+\b[）).．、]'; // answer number pattern
        $this->ap = '.+'; // answer pattern
        $this->sas = '\|-'; // sub answer split char
    }

    public function parse() {
        // 定义题型样式
        $ap = $this->patterning(array($this->anp, $this->ap));

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
                $subAnswer->Set_type(AnswerType::COMPLETION);
                $subAnswers = &$answer->Get_answers();
                $subAnswers[] = $subAnswer;
            }
            $answer->Set_type(AnswerType::COMPLETION);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
