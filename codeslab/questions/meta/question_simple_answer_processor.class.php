<?php

/**
 * <pre>
 * 简单题，只有Question，没有Option
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有均修饰符可选，必须位于行首</li>
 * <li>注意：本题必须独占一行</li>
 * </ul>
 * 题型举例：
 *
 * 6、油田开发对注入水水质的基本要求是什么？
 *
 * （4）中国走和平发展道路，应该选择不打贸易战，追求第四种结果。请说明这种选择的经济学理由。
 * 
 * 1 简述财产所有权的发生与消灭 简述财产所有权的发生与消灭 财产所有权的发生
 * 
 * 44) 简述消费者协会的职能。
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class QuestionSimpleAnswerProcessor extends QuestionBaseProcessor {

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
            $question->Set_type(QuestionType::SIMPLE_ANSWER);

            $questionArray[] = $question;
        }

        // 返回结果
        return $questionArray;
    }

}
