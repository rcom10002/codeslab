<?php
/**
 * 使用示例：<br />
 * $qp = new QuestionParser('C:/2010年普通高等学校招生全国统一考试全国卷.txt');<br />
 * $qp->processQuestions();
 *
 * @author KNIGHTRCOM
 *
 */
class QuestionParser {

    private $_filename;

    public function __construct($rtfName) {
        $this->_filename = $rtfName;
        if (!file_exists($rtfName)) {
            throw new Exception('Specified RTF file is invalid.');
        }
        if (filesize($filename) > 1024 * 1024 * 1024 * 5) {
            throw new Exception('The RTF file\'s size must be no more than 5M.');
        }
    }

    /**
     * @return array
     */
    public function processQuestions() {
        // 读取文本内容
        $questionPaperText = file_get_contents($this->_filename) . "\n"; // 补充换行，样式匹配可能有用

        // 按题型规则提取问题
        $sections = $this->processPaperSections($questionPaperText);

        // 处理题型
        $resultArray = array();
        foreach ($sections as $classId => $sectionText) {
            // 创建题型处理器
            $classname = QuestionType::$PROCESSORS[$classId];
            $questionProcessor = new $classname();
            // 开始处理
            debug($sectionText);
            $resultArray[$classId] = $questionProcessor->embedText($sectionText)->parse();
            debug($resultArray[$classId]);
        }
        return $resultArray;
    }

    /**
     * @param $questionPaperText
     * @return array
     */
    private function processPaperSections($questionPaperText) {
        $results = array();
        foreach (QuestionType::$PATTERNS as $key => $questionStyle) {
            if (substr($key, 0, 1) == '_') {
                continue;
            }
            $sectionText = array();
            preg_match("/$questionStyle.*?$questionStyle/su", $questionPaperText, $sectionText);
            if (count($sectionText) > 0) {
                $sectionText = $sectionText[0];
            } else {
                continue;
            }
            $results[$key] = $sectionText;
        }
        return $results;
    }

}
?>