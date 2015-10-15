<?php
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 10/8/2015
 * Time: 11:28 PM
 */
header("Content-Type: text/html;charset=utf-8");//防乱码
include 'simple_html_dom.php';
//使用url和file都可以创建DOM

class runtime//代码计时
{
    var $StartTime = 0;
    var $StopTime = 0;

    function get_microtime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return ((float)$usec + (float)$sec);
    }

    function start()
    {
        $this->StartTime = $this->get_microtime();
    }

    function stop()
    {
        $this->StopTime = $this->get_microtime();
    }

    function spent()
    {
        return round(($this->StopTime - $this->StartTime) * 1000, 1);
    }

}
$runtime= new runtime;
$runtime->start();

for($range=1;$range<=1;$range++)
{


    $html = file_get_html('http://www.taschinese.com/home.php?mod=space&uid='.$range.'&do=profile');
    $tmp =$html->find('div div div h2 ',0)->plaintext;//获取用户名和UID的string
    //echo $tmp; 全部字符串
    if (strpos($html->innertext, '提示信息') == false) {//防止用户被删掉的情况
        if( $tmp !== false) {
            $tmp = rtrim($tmp, ' ');//去除空格
            $tmp = rtrim($tmp, ')');
            //处理UID 字符串
            $pos2 = stripos($tmp, ":");
            echo "UID" . substr($tmp, $pos2) . '<br>';
            //处理用户名 字符串
            $pos1 = stripos($tmp, "(");
            echo "用户名" . strstr($tmp, '(', TRUE) . '<br>';
            $tmp2 = $html->find('ul[class=pf_l], ul[class=cl]', 2);//获取用户信息字符串
            $eles = $tmp2->find('*');
                foreach ($eles as $e) {
                    $pos2 = strpos($e->innertext, '性别');
                    if ($pos2 !== false) {
                        echo '性别: ' . substr($e->plaintext, 6) . '<br>';
                    }
                    $pos3 = strpos($e->innertext, '生日');
                    if ($pos3 !== false) {
                        echo '生日: ' . substr($e->plaintext, 6) . '<br>';
                    }
                    $pos4 = strpos($e->innertext, '出生地');
                    if ($pos4 !== false) {
                        echo '出生地: ' . substr($e->plaintext, 9) . '<br>';
                    }
                    $pos4 = strpos($e->innertext, '学历');
                    if ($pos4 !== false) {
                        echo '学历: ' . substr($e->plaintext, 6) . '<br>';
                    }
                }
            }
            echo '<img src="http://www.taschinese.com/uc/avatar.php?uid=' . $range . '&size=middle"/>' . '<br>';
            echo "-----------------------------------------" . '<br>';
    }
    else{
        echo 'UID:'.$range.'用户不存在' . '<br>';
    }
}
$runtime->stop();
echo "页面执行时间: ".$runtime->spent()." 毫秒";
?>