<?php
class AnswerType {

    public static $PATTERNS = array(
    SINGLE_CHOICE => '===<<<单选题答案>>>===',
    MULTIPLE_CHOICE => '===<<<多选题答案>>>===',
    COMPLETION => '===<<<填空题答案>>>===',
    TRUE_OR_FALSE => '===<<<判断题答案>>>===',
    CORRECTION => '===<<<判断改错题答案>>>===',
    SIMPLE_ANSWER => '===<<<简单题答案>>>===',
    SHORT_ANSWER => '===<<<简答题答案>>>===',
//    _SHORT_ANSWER_DESC_END => '===<<<问题描述结束答案>>>===',
//    _SHORT_ANSWER_QUESTION_END => '===<<<问题结束答案>>>===',
    CLOZE_TEST => '===<<<完形填空答案>>>===',
//    _CLOZE_TEST_TEXT_END => '===<<<正文结束答案>>>===',
//    _CLOZE_TEST_OPTION_END => '===<<<选项结束答案>>>===',
//    INTEGERATION => '===<<<综合题答案>>>==='
    OTHERS => '===<<<其它题答案>>>===',
    _SPLIT_LINE => '===<<<答案分割线>>>==='
    );

    public static $PROCESSORS = array(
    SINGLE_CHOICE => 'AnswerSingleChoiceProcessor',
    MULTIPLE_CHOICE => 'AnswerMultipleChoiceProcessor',
    COMPLETION => 'AnswerCompletionProcessor',
    TRUE_OR_FALSE => 'AnswerTrueOrFalseProcessor',
    CORRECTION => 'AnswerCorrectionProcessor',
    SIMPLE_ANSWER => 'AnswerSimpleAnswerProcessor',
    SHORT_ANSWER => 'AnswerShortAnswerProcessor',
    CLOZE_TEST => 'AnswerClozeTestProcessor',
//    INTEGERATION => 'AnswerIntegerationProcessor'
    OTHERS => 'AnswerOthersProcessor'
    );

    const SINGLE_CHOICE = 'SINGLE_CHOICE';
    const MULTIPLE_CHOICE = 'MULTIPLE_CHOICE';
    const COMPLETION = 'COMPLETION';
    const TRUE_OR_FALSE = 'TRUE_OR_FALSE';
    const CORRECTION = 'CORRECTION';
    const SIMPLE_ANSWER = 'SIMPLE_ANSWER';
    const SHORT_ANSWER = 'SHORT_ANSWER';
//    const _SHORT_ANSWER_DESC_END = '_SHORT_ANSWER_DESC_END';
//    const _SHORT_ANSWER_QUESTION_END = '_SHORT_ANSWER_QUESTION_END';
    const CLOZE_TEST = 'CLOZE_TEST';
//    const _CLOZE_TEST_TEXT_END = '_CLOZE_TEST_TEXT_END';
//    const _CLOZE_TEST_OPTION_END = '_CLOZE_TEST_OPTION_END';
//    const INTEGERATION = 'INTEGERATION';
    const OTHERS = 'OTHERS';
    const _SPLIT_LINE = '_OTHERS_SPLIT_LINE';
}
?>