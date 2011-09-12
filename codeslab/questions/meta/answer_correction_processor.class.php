<?php
/**
 * <pre>
 * 判断改错题
 *
 * 题型模板：
 * <ul>
 * <li>题号定义：半角数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选，至少要有一个后缀修饰符，必须位于行首</li>
 * <li>答案定义：yes、no、对、错、true、false均可作为标准样式，数字编号(item_tag)，1为对，0为错</li>
 * <li>解释定义：答案后全部内容均作为解释内容</li>
 * <li>注意：每题独占一行</li>
 * </ul>
 * 题型举例：
 * 
 * 1．no 本句“西医医学与现代麻醉医学相结合的产物”是错误的提法。因为在针刺镇痛基础上，发展起来的针刺麻醉方法，用于外科手术获得成功，这是我国针灸医学与现代医学相结合的产物，是我国中西医结合的一项重要研究成果。
 * 2. yes
 * 3. 错	   该句中“它将与临床医学结合，进入精典实验医学这两句”是错误的。因为这两句的概念较含糊，正确的句子应该是实验针灸学是针灸学术理论现代化发展过程中，分化出的一个新学科领域。它将与传统针灸学结合进入现代整体医学发展的新阶段，这是针灸学术发展的必然趋势。
 * 4. 对
 * 5. true
 * 6. false Refer to www.google.com
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerCorrectionProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->anp = '(?:\n|^)\s*[(（]?\b\d+\b[）).．、]'; // answer number pattern
        $this->ap = '\s*(yes|no|对|错|true|false)'; // answer pattern
        $this->ep = '.*'; // explanation pattern
    }

    public function parse() {
        // 定义题型样式
        $ap = $this->patterning(array($this->anp, $this->ap, $this->ep), 'umi');

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
            $answer->Set_content(ext_trim(preg_replace($ap, '$1', $answerText)));
            $answer->Set_type(AnswerType::CORRECTION);
            $answer->Set_desc(ext_trim(preg_replace($this->patterning(array($this->anp, $this->ap), 'umi'), '', $answerText)));
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }
    
}
