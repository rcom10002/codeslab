<?php
class QuestionType {

    public static $PATTERNS = array(
    SINGLE_CHOICE => '===<<<单选题>>>===',
    MULTIPLE_CHOICE => '===<<<多选题>>>===',
    COMPLETION => '===<<<填空题>>>===',
    TRUE_OR_FALSE => '===<<<判断题>>>===',
    SIMPLE_ANSWER => '===<<<简单题>>>===',
    SHORT_ANSWER => '===<<<简答题>>>===',
    _SHORT_ANSWER_DESC_END => '===<<<问题描述结束>>>===',
    _SHORT_ANSWER_QUESTION_END => '===<<<问题结束>>>===',
    CLOZE_TEST => '===<<<完形填空>>>===',
    _CLOZE_TEST_TEXT_END => '===<<<正文结束>>>===',
    _CLOZE_TEST_OPTION_END => '===<<<选项结束>>>===',
    INTEGERATION => '===<<<综合题>>>==='
    );

    public static $PROCESSORS = array(
    SINGLE_CHOICE => 'QuestionSingleChoiceProcessor',
    MULTIPLE_CHOICE => 'QuestionMultipleChoiceProcessor',
    COMPLETION => 'QuestionCompletionProcessor',
    TRUE_OR_FALSE => 'QuestionTrueOrFalseProcessor',
    SIMPLE_ANSWER => 'QuestionSimpleAnswerProcessor',
    SHORT_ANSWER => 'QuestionShortAnswerProcessor',
    CLOZE_TEST => 'QuestionClozeTestProcessor',
    INTEGERATION => 'QuestionIntegerationProcessor'
    );

    const SINGLE_CHOICE = 'SINGLE_CHOICE';
    const MULTIPLE_CHOICE = 'MULTIPLE_CHOICE';
    const COMPLETION = 'COMPLETION';
    const TRUE_OR_FALSE = 'TRUE_OR_FALSE';
    const SIMPLE_ANSWER = 'SIMPLE_ANSWER';
    const SHORT_ANSWER = 'SHORT_ANSWER';
    const _SHORT_ANSWER_DESC_END = '_SHORT_ANSWER_DESC_END';
    const _SHORT_ANSWER_QUESTION_END = '_SHORT_ANSWER_QUESTION_END';
    const CLOZE_TEST = 'CLOZE_TEST';
    const _CLOZE_TEST_TEXT_END = '_CLOZE_TEST_TEXT_END';
    const _CLOZE_TEST_OPTION_END = '_CLOZE_TEST_OPTION_END';
    const INTEGERATION = 'INTEGERATION';
}
?>