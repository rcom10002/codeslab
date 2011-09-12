<?php
/**
 * 使用示例：<br />
 * $qp = new AnswerParser('C:/2010年普通高等学校招生全国统一考试全国卷（答案）.txt');<br />
 * $qp->processAnswers();
 *
 * @author KNIGHTRCOM
 *
 */
class AnswerParser {

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
    public function processAnswers() {
        // 读取文本内容
        $answerPaperText = file_get_contents($this->_filename) . "\n"; // 补充换行，样式匹配可能有用

        // 按题型规则提取问题
        $sections = $this->processPaperSections($answerPaperText);

        // 处理题型
        $resultArray = array();
        foreach ($sections as $classId => $sectionText) {
            // 创建题型处理器
            $classname = AnswerType::$PROCESSORS[$classId];
            $AnswerProcessor = new $classname();
            // 开始处理
            debug($sectionText);
            $resultArray[$classId] = $AnswerProcessor->embedText($sectionText)->parse();
            debug($resultArray[$classId]);
        }
        return $resultArray;
    }

    /**
     * @param $AnswerPaperText
     * @return array
     */
    private function processPaperSections($answerPaperText) {
        $results = array();
        foreach (AnswerType::$PATTERNS as $key => $AnswerStyle) {
            if (substr($key, 0, 1) == '_') {
                continue;
            }
            $sectionText = array();
            preg_match("/$AnswerStyle.*?$AnswerStyle/su", $answerPaperText, $sectionText);
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