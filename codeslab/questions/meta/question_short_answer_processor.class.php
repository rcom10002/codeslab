<?php

/**
 * <pre>
 * 简答题，有大Question，大Question内部嵌套小Question，所有Question只有文本内容，均无Option
 * 
 * 题型模板：
 * <ul>
 * <li>小题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，前缀修饰符可选，必须位于行首</li>
 * <li>注意：每个问题必须独占一行，忽略大题号定义</li>
 * </ul>
 * 题型举例：
 * 
 * ===<<<简答题>>>===
 * 胡锦涛在十七大报告中指出，在新的发展阶段，继续全面建设小康社会，发展中国特色社会主义，必须坚持以邓小平理论、“三个代表”重要思想为知道，深入贯彻落实科学发展观。科学发展观是同马列主义、毛泽东思想、邓小平理论、“三个代表”重要思想既一脉相承又与时俱进的科学理论，是我国经济社会发展的重要指导方针，是发展中国特色社会主义必须坚持和贯彻的重大战略思想。
 * ===<<<问题描述结束>>>===
 * 1. 简述科学发展观的主要内容。（12分）
 * 2. 联系实际，你认为应如何来落实科学发展观？（10分）
 * ===<<<问题结束>>>=== 
 * 资源短缺和市场有限往往制约着一个国家的发展。历史上，许多国家为了获取资源、争夺市场采用了非和平的手段。我国政府明确指出，中国坚持走和平发展道路。完成下列问题。
 * ===<<<问题描述结束>>>===
 * （1）以一种陆地资源为例。说明其特点和分布规律。（10分）
 * （2）结合材料和所学知识。概括说明19世纪末欧洲列强激烈争夺殖民地的原因。这种强烈争压最终导致了什么结果？（8分）
 * （3）分析说明上表。（2分）
 * （4）中国走和平发展道路，应该选择不打贸易战，追求第四种结果。请说明这种选择的经济学理由。（8分）
 * ===<<<问题结束>>>===
 * ===<<<简答题>>>===
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class QuestionShortAnswerProcessor extends QuestionBaseProcessor {

    public function defineStyles() {
        $this->qnp = '[（]?\b\d{1,2}[）、.．]'; // question number pattern
        $this->qp = array('(.+?)', QuestionType::$PATTERNS[QuestionType::_SHORT_ANSWER_DESC_END], 
                          '(.+?)',  QuestionType::$PATTERNS[QuestionType::_SHORT_ANSWER_QUESTION_END]); // question pattern
    }

    public function parse() {
        // 定义题型样式
        $qp = $this->patterning($this->qp, 'us');

        // 提取题型
        $questionTextArray = array();
        preg_match_all($qp, preg_replace($this->patterning(QuestionType::$PATTERNS[QuestionType::SHORT_ANSWER], 'us'), '', $this->_sectionText), $questionTextArray);
        if (count($questionTextArray) == 0 || count($questionTextArray[0]) == 0) {
            return null;
        }

        // 处理题型
        $questionArray = array();
        $questionDescArray = $questionTextArray[1]; // 每个问题的描述部分
        $questionSetArray = $questionTextArray[2]; // 每个问题的提问部分
        for ($i = 0; $i < count($questionDescArray); $i++) {
            // 拆解每个题型并生成对应的Question
            $question = new Question(); // 大问题部分
            $question->Set_content(ext_trim($questionDescArray[$i]));
            $question->Set_type(QuestionType::SHORT_ANSWER);
            $question->Set_questions(array());
            $subQuestionArray = &$question->Get_questions();
            $questionArray[] = $question; // 追加大问题

            // 生成子问题以及选项
            $questionSet = array();
            preg_match_all($this->patterning(array($this->qnp, '.+?(?=(?:\n', $this->qnp, '|$))'), 'us'), $questionSetArray[$i], $questionSet);
            $questionSet = count($questionSet) > 0 ? $questionSet[0] : null;
            if (!$questionSet) {
                continue;
            }
            foreach ($questionSet as $optionText) {
                $subQuestion = new Question(); // 子问题
                $subQuestion->Set_content(ext_trim(preg_replace($this->patterning(array('.*?', $this->qnp), 'us'), '', $optionText)));
                $subQuestion->Set_type(QuestionType::SHORT_ANSWER);
//                $subQuestion->Set_options(array());
                $subQuestionArray[] = $subQuestion; // 追加子问题
                
//                $subOptionArray = &$subQuestion->Get_options();
//                // 整理每个选项组
//                $optionSetTextArray = array();
//                preg_match_all($this->patterning(array($this->onp, '.+?', '(?:(?=', $this->onp, ')|(?=$))'), 'us'), $optionText, $optionSetTextArray);
//                foreach ($optionSetTextArray as $eachOptionTextArray) {
//                    foreach ($eachOptionTextArray as $eachOptionText) {
//                        $option = new Option();
//                        $option->Set_option_content(ext_trim(preg_replace($this->patterning($this->onp), '', $eachOptionText)));
//                        $option->Set_item_tag(preg_replace($this->patterning(array('(', $this->onp, ').+')), '$1', $eachOptionText));
//                        $option->Set_type(QuestionType::SHORT_ANSWER);
//                        $subOptionArray[] = $option;
//                    }
//                }
            }
        }

        // 返回结果
        return $questionArray;
    }

}
