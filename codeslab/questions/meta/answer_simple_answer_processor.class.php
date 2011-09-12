<?php
/**
 * <pre>
 * 简单题，每个答案独占一行
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选，至少要有一个后缀修饰符，必须位于行首</li>
 * <li>答案定义：匹配当前行除题号之外的所有内容</li>
 * </ul>
 * 题型举例：
 * 
 * 1．实验针灸学科学方法论，即是关于实验针灸学科学研究方法的理论。探索实验针灸学方法的一般结构、阐述它们的发展趋势和方向，以及实验针灸学科学研究中各种方法的相互关系等问题。狭义的仅指自然科学方法论，即研究自然科学中的一般方法，如观察法、实验法等。广义的则是指哲学方法论，即研究科学认识过程、方法和形式的一般理论问题，如科学理论的发现、构建、检验、评价、预测、决策等。
 * 2．科学实验是指自然科学实验，即根据一定目的，运用相应的仪器、设备等物质手段，在人为控制的条件下，模拟自然现象，以进行研究的方法。以认识自然界事物的本质和规律为目的和任务。它包括实验者、实验手段和实验对象三要素。
 * 3．软科学是研究中医针灸学发展，并对科学技术体系及其各个环节进行预测、规划、管理、指挥和监督，使之有机地配合，极大限度地发挥整体优势，综合多学科和科学研究方法进行跨学科研究的科学。
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerSimpleAnswerProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->anp = '(?:\n|^)\s*[(（]?\b\d+\b[）).．、]'; // answer number pattern
        $this->ap = '.+'; // answer pattern
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
            $answer = new Answer();
            $answer->Set_content(ext_trim(preg_replace($this->patterning($this->anp, 'u'), '', $answerText)));
            $answer->Set_type(AnswerType::SIMPLE_ANSWER);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
