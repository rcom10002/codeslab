<?php
/**
 * <pre>
 * 其它题
 *
 * 题型模板：
 * <ul>
 * <li>内容无特殊现在，答案与答案直接需用分割线隔离，每个答案对应一道题</li>
 * </ul>
 * 题型举例：
 *
 * ===<<<其它题答案>>>===
 * 14．【答案】①寄托作者对童年时光、童年生活的深切留恋和怀念；②使童年的生活图景更真实、具体、生动，给人以身临其境的感受；③激发读者的阅读兴趣。
 * 【分析】文章三处细节写了煤油灯的外形或使用，结合作者生活的时代背景及抒发的思想感情作答。考察细节描写的作用。
 * ===<<<答案分割线>>>===
 * 15．【答案】
 * （1）①即使普通的煤油灯，在贫困的年代里也是很宝贵的；②灯下的温馨和苦读，是更值得珍惜的人生的宝贵财富。
 * （2）①曾经拥有的灯下的温馨已经逝去，“我”有一种不知身在何处的怅惘；②社会进步的同时，也不可避免地失去了一些美好的东西。
 * 【分析】此题考查理解文中重要句子的含义。第一句从比喻的本体和比喻义及作者在文章表达的情感，可以得到答案。第二句抓住“迷失”来分析作答。
 * ===<<<答案分割线>>>===
 * 16．【答案】
 * 第一问：文章以第一人称作为全文的基本视角；②偶尔插入第二人称，构成两种不同人称的互相交叉。
 * 第二问：①不同人称的出现丰富了文章的叙事手段，有助于作者思想情感的表达；②营造了一种亲切的气氛，拉近作者和读者之间的距离。
 * 【分析】考查人称变换在文中的作用。注意人称变换与作者情感的变化。
 * ===<<<答案分割线>>>===
 * 17．【答案】①灯火让作者不时想起与它共处的那段时光，它是作者人生中的“永恒之火”；②灯火下的祖孙相牵，使作者贫穷的童年生活变得温馨而富有诗意；③作者的成长离不开灯火下的夜读，这是作者人生的重要一步。
 * 【分析】考查概括中心主题。结合全文分析灯火在文中的含义。
 * 18．【答案】①赫然②悄悄③扩散④缀满⑤汇聚⑥显现⑦陶醉⑧映衬
 * ===<<<其它题答案>>>===
 * </pre>
 *
 * @author KNIGHTRCOM
 * @version 0.9
 */
class AnswerOthersProcessor extends AnswerBaseProcessor {

    public function defineStyles() {
        $this->ap = array(
        	'.+?', 
        	'(?:',
            AnswerType::$PATTERNS['_SPLIT_LINE'],
        	'|',
            AnswerType::$PATTERNS['OTHERS'],
        	')'); // answer pattern
            
        $this->mp = array(
        	'(',
            AnswerType::$PATTERNS['_SPLIT_LINE'],
        	'|',
            AnswerType::$PATTERNS['OTHERS'],
        	')'); // answer marked position
    }

    public function parse() {
        // 定义题型样式
        $ap = $this->patterning($this->ap, 'usi');

        // 处理答案
        $answerTextArray = array();
        preg_match_all($ap, $this->_sectionText, $answerTextArray);
        if (count($answerTextArray) > 0 && count($answerTextArray[0]) > 0) {
            $answerTextArray = $answerTextArray[0];
            $cp = $this->patterning($this->mp, 'usi');
            for ($i = 0; $i < count($answerTextArray); $i++) {
                $answerTextArray[$i] = preg_replace(array($cp, '/^\s*|\s*$/s'), '', $answerTextArray[$i]);
            }
        } else {
            return null;
        }

        // 处理答案
        $answerArray = array();
        foreach ($answerTextArray as $answerText) {
            // 拆解每个答案并生成对应的Answer
            $answer = new Answer();
            $answer->Set_content($answerText);
            $answer->Set_type(AnswerType::OTHERS);
            $answerArray[] = $answer;
        }

        // 返回结果
        return $answerArray;
    }

}
