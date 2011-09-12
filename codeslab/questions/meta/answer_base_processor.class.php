<?php
/**
 * <pre>
 * 对于整张卷子，需要按照以下形式来对题型进行划分，这样程序才可以针对题型执行自动导入
 * 
 * XX年 YY考试官方试题
 * ===<<<单选题答案>>>===
 * 1—5 BBABC   6—10 ACAAB   11—15 CACCB   16--20 BCBCA
 * 21--25 CBDAB   26—30 CADCB   31—35 CADAD   36—40 CBDAC
 * 41—45 BACDB   46—50 BABAC   51--55 ACDAD   56—60 CABCB
 * 61—65 CDBAD   66—70 CBCDB   71—75 BAGCD
 * ===<<<单选题答案>>>===
 * ===<<<多选题答案>>>===
 * 1.ABC  2.BC   3.AD
 * 4.ABCD 5.AD   6.ACD
 * ===<<<多选题答案>>>===
 * ===<<<填空题答案>>>===
 * 1. 第一题第一空答案|-第一题第二空答案 ...[标记(|-)答案(第一题第N空答案)]
 * 2. 空|-空|-空
 * ===<<<填空题答案>>>===
 * ===<<<判断题答案>>>===
 * 1. yes
 * 2. no
 * ===<<<判断题答案>>>===
 * ===<<<简单题答案>>>===
 * 1. sdfsdfsdfsdfsdfsdf
 * 2. sdfsdfsdfsdfsdfsdfsdfsdf
 * ===<<<简单题答案>>>===
 * ===<<<简答题答案>>>===
 * 1. 第一题第一问答案|-第一题第二问答案 ...[标记(|-)答案(第一题第N问答案)]
 * 2. asdasd|-asdasd|-asdfasdf
 * ===<<<简答题答案>>>===
 * ===<<<完形填空题答案>>>===
 * 1. 第一题第一小题答案|-第一题第二小题答案 ...[标记(|-)答案(第一题第N小题答案)]
 * 2. A|-B|-C
 * ===<<<完形填空题答案>>>===
 * ===<<<判断改错题答案>>>===
 * 1. yes
 * 2. no ===<<<自定义标记>>>=== 判断题错误修改
 * ===<<<判断改错题答案>>>===
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
 * @see AnswerType
 * @author KNIGHTRCOM
 * @version 1.0
 */
abstract class AnswerBaseProcessor {

    private $data = array();
    protected $_sectionText;
    protected $_styles = array();

    public function __construct() {
        $this->defineStyles();
    }

    abstract protected function defineStyles();

    abstract protected function parse();

    /**
     * @param $sectionText string
     * @return AnswerBaseProcessor
     */
    public function embedText($sectionText) {
        $this->_sectionText = $sectionText;
        return $this;
    }

    /**
     * create pattern
     * 
     * @param $styles   mixed array or string
     * @param $modifers string
     * @return string
     */
    protected function patterning($styles, $modifers = 'um') {
        if (is_array($styles)) {
            $styles = implode('', $styles);
        }
        return '/'.$styles.'/'.($modifers === null ? 'um' : $modifers);
    }

    /**
     * @param $name
     * @param $value
     * @return void
     */
    public function __set($name, $value) {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name) {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }
}
