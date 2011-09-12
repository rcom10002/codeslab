<?php

/**
 * <pre>
 * 单选题，有Question，有Option
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选，至少要有一个后缀修饰符，必须位于行首</li>
 * <li>选项编号定义：半角大写英文字母形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有均修饰符可选</li>
 * <li>注意：选项内不允许出现与题号或选项编号样式相同的字样，如果有，请改写成全角数字来解决冲突</li>
 * </ul>
 * 题型举例：
 *
 * 1. 倾向是指岩层倾斜的方向。即倾斜线在(B)面上的投影所指的方向。
 *　　（A） 斜　　　（B） 水平　　　（C） 铅垂　　　（D） 岩层
 * `这里是放置答题解析的地方，比如选择第几个选项，为什么选择等等`
 * (16) Where did the story happen?
 *      A. In a fruit shop.                 B. In a book shop.         C. In a clothes shop.
 * `If you don't have such an explanation just ignore it`
 * 53 Frank wants to go to Sydney Tower with his two children, he will pay
 *     A.  $60                           B.  $90
 *     C.  $120                          D.  $150
 * 61． The beautiful girl wanted to ask her parents for advice because
 *     A. she didn't like the job
 *     B. she didn’t expect the examiner would ask such a question
 *     C. she didn't want to answer the question
 *     D. her parents would be angry if she didn't ask them
 *
 * 14) 儒学思想在后世不断发展，下列主张哪个具有民主启蒙色彩
 * A．民为贵，社稷次之，君为轻
 * B．制天命而用之
 * C．天人感应，君权神授
 * D．为天下之大灾者，君而已矣
 * `答题解析的格式应该是两个反单引号夹起来`
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class QuestionSingleChoiceProcessor extends QuestionBaseProcessor {

    public function defineStyles() {
        $this->qnp = '(\n|^)\s*[(（]?\b\d+\b[）).．、]?'; // question number pattern
        $this->qtp = '.+'; // question text pattern
        $this->qp = array($this->qnp, $this->qtp); // question pattern
        $this->onp = '[(（]?\b[A-Z][）).．、 ]'; // option number pattern
        $this->otp = '.+'; // option text pattern
        $this->op = array($this->onp, $this->otp, 'usi'); // option pattern
        $this->qop = array($this->qnp, $this->qtp, '?', '((?=', $this->qnp, ')|(?=', QuestionType::$PATTERNS[QuestionType::SINGLE_CHOICE], '))'); // question & option pattern
    }

    public function parse() {
        // 定义题型样式
        $qop = $this->patterning($this->qop, 'usi');

        // 提取题型
        $questionOptionTextArray = array();
        preg_match_all($qop, $this->_sectionText, $questionOptionTextArray);
        if (count($questionOptionTextArray) > 0 && count($questionOptionTextArray[0]) > 0) {
            $questionOptionTextArray = $questionOptionTextArray[0];
        } else {
            return null;
        }

        // 处理题型
        $questionArray = array();
        foreach ($questionOptionTextArray as $eachQuestionOptionText) {
        	// 执行插件预处理功能
        	$optionalExplanation = $this->plugin4PreprocessEachQuestionOptionText($eachQuestionOptionText);

        	// 拆解每个题型并生成对应的Question
            $question = new Question();
            $question->Set_content(ext_trim(preg_replace($this->patterning(array($this->qnp, '(.+?)\n.*'), 'usi'), '$2', $eachQuestionOptionText)));
            $question->Set_type(QuestionType::SINGLE_CHOICE);
            $question->Set_explanation($optionalExplanation);

            // 处理选项Option
            $eachQuestionOptionText = preg_replace($this->patterning(array($this->qnp, '.+?\n'), 'us'), '', $eachQuestionOptionText, 1); // 去除问题部分，仅仅保留Option
            $eachQuestionOptionText = preg_replace('/^\n+|\n+$/', "", $eachQuestionOptionText); // 去除首尾换行符
            $optionTextArray = array();
            preg_match_all($this->patterning(array($this->onp, '.+?', '(?:(?=', $this->onp, ')|(?=$))'), 'us'), $eachQuestionOptionText, $optionTextArray);
            if (count($optionTextArray) > 0) {
                $optionTextArray = $optionTextArray[0];
            }
            $options = array();
            foreach ($optionTextArray as $eachOptionText) {
                $option = new Option();
                $option->Set_option_content(ext_trim(preg_replace($this->patterning($this->onp), '', $eachOptionText)));
                $option->Set_item_tag(preg_replace($this->patterning(array('(', $this->onp, ').+')), '$1', $eachOptionText));
                $option->Set_type(QuestionType::SINGLE_CHOICE);
                $options[] = $option;
            }
            $question->Set_options($options);
            $questionArray[] = $question;
        }

        // 返回结果
        return $questionArray;
    }

    /**
     * @param $eachQuestionOptionText
     * @return string
     */
    private function plugin4PreprocessEachQuestionOptionText(&$eachQuestionOptionText) {
    	$explanation = preg_replace($this->patterning(".+(`.+`).+", 'us'), "$1", $eachQuestionOptionText);
    	if ($eachQuestionOptionText == $explanation) {
    		return null;
    	}
    	$eachQuestionOptionText = str_replace($explanation, "", $eachQuestionOptionText);
    	return $explanation == $eachQuestionOptionText ? null : str_replace("`", "", $explanation);
    }
}
