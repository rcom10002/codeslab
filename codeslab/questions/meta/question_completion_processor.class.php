<?php

/**
 * <pre>
 * 填空题，只有Question，没Option
 * 
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有均修饰符可选，必须位于行首</li>
 * <li>注意：本题必须独占一行</li>
 * </ul>
 * 题型举例：
 * 
 * 76. My friend gave me a nice       . (手表) for my birthday.
 * 
 * 80. Many students think that teenagers should be    (允许) to choose their own clothes.
 * 
 * 85. The h       you work, the more progress you'll make.
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class QuestionCompletionProcessor extends QuestionBaseProcessor {

    public function defineStyles() {
        $this->qnp = '(\n|^)\s*[(（]?\b\d+\b[）).．、]?'; // question number pattern
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
            $question->Set_type(QuestionType::COMPLETION);

            $questionArray[] = $question;
        }

        // 返回结果
        return $questionArray;
    }

}
