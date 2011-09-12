<?php
// 定义CLASSPATH以便question_sys.php可以自动装载需要使用的类
define(ABSPATH, dirname(__FILE__));
define(CLASSPATH, implode('@', array(ABSPATH, ABSPATH.'/entity', ABSPATH.'/meta')));
require_once(ABSPATH.'/util/question_sysext.php');
set_time_limit(0);

/**
 * 
 * 使用示例：<br />
 * Parser::parseQuestionPaper('C:/2010年普通高等学校招生全国统一考试全国卷.txt');<br />
 * Parser::parseAnswerPaper('C:/2010年普通高等学校招生全国统一考试全国卷（答案）.txt');
 * 
 * @author KNIGHTRCOM
 * @version 0.9
 */
class Parser {

    /**
     * 分析试题文件
     * 
     * @param $questionFilePath 试题文件路径
     * @return array
     */
    public static function parseQuestionPaper($questionFilePath) {
        $parser = new QuestionParser($questionFilePath);
        return $parser->processQuestions();
    }

    /**
     * 分析答案文件
     * 
     * @param $answerFilePath 答案文件路径
     * @return array
     */
    public static function parseAnswerPaper($answerFilePath) {
        $parser = new AnswerParser($answerFilePath);
        return $parser->processAnswers();
    }
}

$debug_mode = true;

// 调用入口
//debug(Parser::parseAnswerPaper('C:/sample.txt'));
//debug(Parser::parseQuestionPaper('C:/sample.txt'));
Parser::parseQuestionPaper('C:/sample.txt')
?>