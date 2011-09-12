<?php
/**
 * <pre>
 * 对于整张卷子，需要按照以下形式来对题型进行划分，这样程序才可以针对题型执行自动导入
 * 
 * XX年 YY考试官方试题
 * ===<<<单选题>>>===
 * 1. ……
 * 2. ……
 * 3. ……
 * ===<<<单选题>>>===
 * ===<<<填空题>>>===
 * 4. ……
 * 5. ……
 * ===<<<填空题>>>===
 * ===<<<简答题>>>===
 * 6. ……
 * 7. ……
 * 8. ……
 * 9. ……
 * ===<<<简答题>>>===
 * </pre>
 * 
 * @see QuestionType
 * @author KNIGHTRCOM
 * @version 1.0
 */
abstract class QuestionBaseProcessor {

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
     * @return QuestionBaseProcessor
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
