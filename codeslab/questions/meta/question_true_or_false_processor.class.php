<?php

/**
 * <pre>
 * 判断题，有Question，没有Option
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有均修饰符可选，必须位于行首</li>
 * <li>注意：每题独占一行</li>
 * </ul>
 * 题型举例：
 *
 * 2. 岩石的润湿性对油气在油层中的流动有着很大的影响，若岩石亲油则有利于水驱油，若岩石亲水则不利于水驱油。
 *
 * (17) 由于地壳运动所引起的岩层变形和变位均称为非构造变动。
 * 
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 *
 */
class QuestionTrueOrFalseProcessor extends QuestionBaseProcessor {

    public function defineStyles() {
        $this->qnp = '^.*?[(（]?\b\d+\b[）).．、]?'; // question number pattern
        $this->qtp = '.+'; // question text pattern
        $this->qp = array($this->qnp, $this->qtp); // question pattern
    }

    public function parse() {
        // 定义题型样式
        $qp = $this->patterning($this->qp);

        // 提取题型
        $questionTextArray = array();
        preg_match_all($qp, $this->_sectionText, $questionTextArray);
        if (count($questionTextArray) > 0 && count($questionTextArray[0]) > 0) {
            $questionTextArray = $questionTextArray[0];
        } else {
            return null;
        }

        // 处理题型
        $questionArray = array();
        foreach ($questionTextArray as $eachQuestionText) {
            // 拆解每个题型并生成对应的Question
            $question = new Question();
            $question->Set_content(ext_trim(preg_replace($this->patterning($this->qnp), '', $eachQuestionText)));
            $question->Set_type(QuestionType::TRUE_OR_FALSE);

            $questionArray[] = $question;
        }

        // 返回结果
        return $questionArray;
    }

}
