<?php
/**
 * <pre>
 * 完形填空，有大Question和子Question，每个子Question都有Option，每个Option都是大写字母且后面至少有个标识表示
 * 
 * 题型模板：
 * <ul>
 * <li>题号定义：半角两位以内的数字形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选，至少要有一个后缀修饰符，必须位于行首</li>
 * <li>选项编号定义：半角大写英文字母形式，支持的修饰符有<u>()（）、.．</u>符号有全半角之分，所有前缀修饰符均可选</li>
 * <li>样式定义：参考以下例子，首尾用“完形填空”注明，每题需要有“正文结束”和“选项结束”注明</li>
 * <li>注意：选项内不允许出现与题号或选项编号样式相同的字样，如果有，请改写成全角数字来解决冲突</li>
 * </ul>
 * 
 * 题型举例：
 * ===<<<完形填空>>>===
 *   Mr. Green was ill and went to the hospital. A doctor __1__ and said, “Well, Mr. Green, you are going to __2__ some injections, and you’ll feel much better. A nurse will come __3__ give you the first one this evening, and then you’ll __4__ get another one tomorrow evening.” __5__ a young nurse came to Mr. Green’s bed and said to him, “I am going to give you your __6__ injection now, Mr. Green. Where do you want it?”
 *   The old man was __7__. He looked at the nurse for a __8__, then he said, “__9__ has ever let me choose that before. Are you really going to let me choose now?”
 *   “Yes, Mr. Green,” the nurse answered. She was in a hurry. “Where do you want it?”
 *   “Well, then,” the old man answered __10__ “I want it in your left arm, please.”
 * ===<<<正文结束>>>===
 * 1. A. looked for him    B. looked him over
 * C. looked after him    D. looked him up
 * 2. A. get    B. give    C. make    D. hold
 * 3. A. so    B. but    C. or    D. and
 * 4. A. must      B. can   C. had better   D. have to
 * 5. A. In the morning    B. In the afternoon
 * C. In the end     D. In the evening
 * 6. A. first      B. one      C. two     D. second
 * 7. A. confident   B. surprised   C. full     D. hungry
 * 8. A. hour    B. minutes    C. year   D. moment
 * 9. A. Somebody  B. Anybody   C. Nobody   D. people
 * 10. A. with a smile     B. in time
 * C. in surprise     D. with tears in his eyes 
 * ===<<<选项结束>>>===
 * One winter Nasreddin had very 1 money.His crops 2 very bad that year,and he 3 live very cheaply.He gave his donkey less food,and when after two days the donkey 4 just the same,he 5 to himself,"The donkey was used to 6 a lot.Now he is quickly getting used to eating less; and soon he will get used to living 7 almost nothing."
 * Each day Nasreddin gave the donkey a little 8 food, until it was hardly eating anything. 
 * Then one day,when the donkey was going to market with a load of wood on its back, it suddenly 9 . "How unlucky I am,"said Nasreddin,"Just when my donkey had got used to eating hardly anything,it came 1 0 the end of its days in this world.
 * ===<<<正文结束>>>===
 * 1.A.few B. little C. lot D. much
 * 2.A.had been B. has been C. was being D. is being
 * 3.A.has to B. have to C. had to D. must have to
 * 4.A.1ooks B. is seen C. looked D. was seen
 * 5.A.says B. say C. saying D. said
 * 6.A.eat B. eating C. have eaten D. being eaten
 * 7.A.on B. by C. up D. to
 * 8.A.more B. less C. few D. small
 * 9.A.dead B. dying C. died D. was dying
 * 10.A.on B. up C. in D.to
 * ===<<<选项结束>>>===
 * (2)A:Hi ,Nancy .   B:Hi,Yang Ling. A: Glad_(1)_see you. 
 *   B:Glad to see you,_(2)_. A:What’s that _(3)_the chair. 
 *   B:Oh, it’s _(4)_family photo.A:Can_(5)_have a look. 
 *   B:Sure. A:_(6)_ he your brother David？. B:No,_(7)_Mike. 
 *   A:Oh , I see.He is Helen’s_(8)_. B:Yes’he is.It’s time _(9)_go home. 
 *   A:OK.Let’s go home. 
 * ===<<<正文结束>>>===
 * 1、A. two  B. to  C. too 
 * 2、A. two  B. to  C. too 
 * 3、A. on  B. to   C. in 
 * 4、A. I   B. he’s  C. my 
 * 5、A. she  B. I   C. he’s 
 * 6、A.Is   B. Are   C. Am 
 * 7、A. I’m  B. you’re  C. he’s 
 * 8、A. brother  B. friend  C. uncle 
 * 9、A. two  B. to  C. too 
 * ===<<<选项结束>>>===
 * (3)A：_(1)_the time ,please,mum?   B:_(2)_nine_(3)_.Nancy,you can go to_(4)_now.             A:OK,mum. _(5)_the TV,please.       B: OK.                      
 *  A: Good night ,mum.              B: _(6)_. 
 * ===<<<正文结束>>>===
 * 1、A.What    B. What’s   C. Who   D.Who’s 
 * 2、A.It’s a    B.It        C.It’s     D.It a 
 * 3、A.clock    B. \        C. o’clock  D.B&C 
 * 4、A.home   B.bed      C.school    D.up 
 * 5、A.Turn off  B. Close  C. Turn on   D.Open 
 * 6、A Goodbye  B.See you   C.Good night D.Bye 
 * ===<<<选项结束>>>===
 * ===<<<完形填空>>>===
 * </pre>
 * 
 * @author KNIGHTRCOM
 * @version 0.9
 */
class QuestionClozeTestProcessor extends QuestionBaseProcessor {

    public function defineStyles() {
        $this->qnp = '(\n|^)\s*[(（]?\b\d+\b[）).．、]?'; // question number pattern
        $this->onp = '[(（]?\b[A-Z][）).．、]'; // option number pattern
        $this->otp = '.+'; // option text pattern
        $this->qop = array('(.+?)', QuestionType::$PATTERNS[QuestionType::_CLOZE_TEST_TEXT_END], 
                          '(.+?)',  QuestionType::$PATTERNS[QuestionType::_CLOZE_TEST_OPTION_END]); // question pattern
    }

    public function parse() {
        // 定义题型样式
        $qp = $this->patterning($this->qop, 'us');

        // 提取题型
        $questionOptionTextArray = array();
        preg_match_all($qp, preg_replace($this->patterning(QuestionType::$PATTERNS[QuestionType::CLOZE_TEST], 'us'), '', $this->_sectionText), $questionOptionTextArray);
        if (count($questionOptionTextArray) == 0 || count($questionOptionTextArray[0]) == 0) {
            return null;
        }

        // 处理题型
        $questionArray = array();
        $questionTextArray = $questionOptionTextArray[1]; // 每个问题的文章部分
        $questionOptionSetTextArray = $questionOptionTextArray[2]; // 每个问题文章后面的选项部分
        for ($i = 0; $i < count($questionTextArray); $i++) {
            // 拆解每个题型并生成对应的Question
            $question = new Question(); // 大问题部分
            $question->Set_content(ext_trim($questionTextArray[$i]));
            $question->Set_type(QuestionType::CLOZE_TEST);
            $question->Set_questions(array());
            $subQuestionArray = &$question->Get_questions();
            $questionArray[] = $question; // 追加大问题

            // 生成子问题以及选项
            $questionOptionSetText = array();
            preg_match_all($this->patterning(array($this->qnp, '.+?(?=(?:', $this->qnp, '|$))'), 'us'), $questionOptionSetTextArray[$i], $questionOptionSetText);
            $questionOptionSetText = count($questionOptionSetText) > 0 ? $questionOptionSetText[0] : null;
            if (!$questionOptionSetText) {
                continue;
            }
            foreach ($questionOptionSetText as $optionTextArray) {
                $subQuestion = new Question(); // 子问题
                $subQuestion->Set_type(QuestionType::CLOZE_TEST);
                $subQuestion->Set_options(array());
                $subQuestionArray[] = $subQuestion; // 追加子问题
                $subOptionArray = &$subQuestion->Get_options();
                // 整理每个选项组
                $optionSetTextArray = array();
                preg_match_all($this->patterning(array($this->onp, '.*?', '(?:(?=', $this->onp, ')|(?=$)|(?=', $this->qnp, '))'), 'us'), $optionTextArray, $optionSetTextArray);
                if (count($optionSetTextArray) > 0) {
                    $optionSetTextArray = $optionSetTextArray[0];
                }
                foreach ($optionSetTextArray as $eachOptionText) {
                    $option = new Option();
                    $option->Set_option_content(ext_trim(preg_replace($this->patterning($this->onp, 'us'), '', $eachOptionText)));
                    $option->Set_item_tag(preg_replace($this->patterning(array('(', $this->onp, ').+')), '$1', $eachOptionText));
                    $option->Set_type(QuestionType::CLOZE_TEST);
                    $subOptionArray[] = $option;
                }
            }
        }

        // 返回结果
        return $questionArray;
    }

}
