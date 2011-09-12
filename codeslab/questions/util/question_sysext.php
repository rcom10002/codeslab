<?php
$debug_mode = true;

/**
 * @param $classname
 * @return void
 */
function __autoload($classname) {
    $filename = strtolower(preg_replace('/(?<=\B)([A-Z])/s', '_$1', $classname)) . ".class.php";
    foreach (preg_split('/@/',CLASSPATH) as $cp) {
        if (file_exists("$cp/$filename")) {
            require_once ("$cp/$filename");
            break;
        }
    }
}

/**
 * Any parameter is OK, but the last parameter will determine whether halt the current program
 * if last parameter == true
 *     exit the current program
 * else
 *     return the execution right to invoker
 * 
 * @return void
 */
function debug() {
//	if (!$debug_mode) {
//		return;
//	}
	echo '<pre>';
	foreach (func_get_args() as $var) {
		$psfix = str_repeat('-', 40);
	    echo "<span style='font-size: 18px; color:blue;'>".
	         "debug: $psfix I were newbility line separator $psfix".
	         "</span>\n";
	    echo(var_dump($var));
	}
    echo '</pre>';
}

function debugx($var) {
//	if (!$debug_mode) {
//		return;
//	}
	$param = func_get_args();
	if (count($param) > 0) {
		call_user_func_array ('debug', $param);
	}
    exit();
}
/*
function debug() {
    global $debug_mode;
    if ($debug_mode == 'off') {
        return;
    }
    // 没有指定参数时仅仅输出DEBUG POINT字样用于标记程序运行到什么地方
    if (func_num_args() == 0) {
        echo '[[[DEBUG POINT]]]';
        return;
    }
    // 取得参数
    $argList = func_get_args();
    // 默认情况下不会终止程序执行，仅做输出调试
    $noExit = true;
    // 如果有一个以上参数且最末参数为布尔型，则需要重新决定变量 $noExit 值
    if (func_num_args() > 1 && ($argList[func_num_args() - 1] === true || $argList[func_num_args() - 1] === false)) {
        $noExit = ($argList[func_num_args() - 1]);
        unset($argList[func_num_args() - 1]);
        $argList = array_values($argList);
    }
    // 输出调试信息
    foreach ($argList as $arg) {
        echo var_dump($arg);
    }
    // 根据 $noExit 值来判断是否终止程序
    if (!$noExit) {
        exit();
    }
}
*/
/**
 * @param $message
 * @return void
 */
function ext_log($message) {
    echo $message;
}

/**
 * @param $str
 * @return string
 */
function ext_trim($str) {
    if (empty($str)) {
        return $str;
    }
    return preg_replace('/^[　\t \r\n]+|[　\t \r\n]+$/us', '', $str);
}

//class ClassLoader {
//    public static $_all_files = array();
//
//    /**
//     * @param $classname
//     * @return void
//     */
//    public static function generateClassPath($classname) {
//        foreach (preg_split('/:/',CLASSPATH) as $cp) {
//            echo "<<<<$cp>>>>";
//            if (count($_all_files) == 0 && $handle = opendir($cp)) {
//                while (false !== ($file = readdir($handle))) {
//                    if (preg_match('/[.]class[.]php$/', $file) > 0) {
//                        continue;
//                    }
//                    ClassLoader::$_all_files[$file] = "$file";
//                }
//                closedir($handle);
//            }
//        }
//    }
//}
