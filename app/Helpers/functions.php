<?php
/*
 * 系统共用函数
 * 734162396@qq.com
 *
 * Copyright 2019,Ruan Shaoxiang
 */


//返回全局唯一标识符
function guid() {
    return  md5(uniqid(mt_rand(), true));
}

//日志调试输出
//用法 my_debug(__FILE__,__LINE__,$var);
function my_debug($fileName,$srcLineNo,$src){
    $content=var_export2String($fileName,$srcLineNo,$src);
    my_log_debug($content);
}

//将var_export的内容输出到string
function var_export2String($fileName,$srcLineNo,$src) {
    ob_start();
    echo 'my_export:',$fileName,',Line :',$srcLineNo,"\n";
    if(is_string($src)){
        echo $src,"\n";
    }else{
        var_export($src);
    }
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function my_log_debug($content){
    \SeasLog::debug($content);
}

//返回当前时间串
function nowTime(){
    return date("Y-m-d H:i:s");
}

/*
 * 时间格式的整理
 * 日期显示
 * 根据时间戳显示不同的风格
 */
function get_last_time($targetTime)
{
    if ($targetTime == '' || $targetTime == 0) {
        return false;
    }
    //完整时间戳
    $strtotime = is_int($targetTime) ? $targetTime : strtotime($targetTime);
    $times_day = date('Y-m-d', $strtotime);
    $times_day_strtotime = strtotime($times_day);

    //今天
    $nowdate_str = strtotime(date('Y-m-d'));

    //精确的时间间隔(秒)
    $interval = time() - $strtotime;

    //今天的
    if ($times_day_strtotime == $nowdate_str) {

        //小于一分钟
        if ($interval < 60) {
            $pct = sprintf("%d秒前", $interval);
        }
        //小于1小时
        elseif ($interval < 3600) {
            $pct = sprintf("%d分钟前", ceil($interval / 60));
        } else {
            $pct = sprintf("%d小时前", floor($interval / 3600));
        }
    }
    //昨天的
    elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-1 days')))) {
        $pct = '昨天' . date('H:i', $strtotime);
    }
    //前天的
    elseif ($times_day_strtotime == strtotime(date('Y-m-d', strtotime('-2 days')))) {
        $pct = '前天' . date('H:i', $strtotime);
    }
    //一个月以内
    elseif ($interval < (3600 * 24 * 30)) {
        $pct = date('m月d日', $strtotime);
    }
    //一年以内
    elseif ($interval < (3600 * 24 * 365)) {
        $pct = date('Y年m月d日', $strtotime);
    }
    //一年以上
    else {
        $pct = date('Y年m月d日', $strtotime);
    }

    return $pct;
}

/*
 * 根据code获取open_id
 *
 */
function getOpenIdByCode($code)
{
    $js_code = $code;
    $appId = config('wxconfig.appId');
    $appSecret = config('wxconfig.appSecret');
    $grant_type = 'authorization_code';

    $curl = curl_init();
    $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appId.'&secret='.$appSecret.'&js_code='.$js_code.'&grant_type='.$grant_type;

    curl_setopt($curl, CURLOPT_URL, $url);

    //设置是否输出header
    curl_setopt($curl, CURLOPT_HEADER, false);

    //设置是否输出结果
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    //设置是否检查服务器端的证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    //使用curl_exec()将curl返回的结果转换成正常数据并保存到一个变量中
    $data = json_decode(curl_exec($curl),true);

    //关闭会话
    curl_close($curl);

    return $data;
}
