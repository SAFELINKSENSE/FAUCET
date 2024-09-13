<?php
/**
 DEMO FAUCET : https://faucet.bot.nu
 **/
error_reporting(0);
header("X-Frame-Options: DENY");
session_name('FAUCETSENSE');
session_start();
################################################################################
$web_logo = "FAUCET";
$web_title = "DOGE FAUCET";
$web_subtitle = "Unlimited Claim No Timer";
$web_home_subtitle = "Unlimited claim no timer and Instant payouts to your faucetpay account";
$web_keyword = "Crypto, Cryptocurrency, FaucetPay, Unlimited, No Timer, Instant Payout, DOGE Faucet, Dogecoin Faucet,";
$web_description = "Claim free DOGE Faucet unlimited no timer by completing easy captcha tasks and visiting shortlinks.";
################################################################################
/** 
 * TIMEZONE INTEGRATION
 * List of Supported Timezones : https://www.php.net/manual/en/timezones.php
**/
date_default_timezone_set('Asia/Jakarta');
$date = date('Y-m-d H:i:s');
################################################################################
/** 
 * LOG FILES INTEGRATION
**/

$file_prefix = "MYLOGSECRET"; //=> WARNING ! please change this default prefix to maintain the privacy of your log files

/** LOG PAYMENTS **/
$file_payments = sha1($file_prefix."_PAYMENTS").".txt";
if(!file_exists($file_payments)){file_put_contents($file_payments,"");}

/** LOG FAUCET BALANCE **/
$file_faucetbalance = sha1($file_prefix."_FAUCETBALANCE").".txt";
if(!file_exists($file_faucetbalance)){file_put_contents($file_faucetbalance,"0.00000000");}

################################################################################
/** 
 * FAUCETPAY.IO INTEGRATION 
 * https://faucetpay.io/page/faucet-admin
**/
$fp_api_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$fp_ticker = "DOGE";
$fp_reward = "100"; // example 100 = 0.00000100 DOGE
$fp_send_url = "https://faucetpay.io/api/v1/send";
################################################################################
/** 
 * EARN MONEY FOR FAUCET OWNER (SAFELINK & ADS BANNER)
**/

/** SAFELINK INTEGRATION **/
# https://safelink.my.id (Instant Payout to FaucetPay)
$faucetpay_email_address = "YourFaucetpayEmailAddress@gmail.com"; //=> WARNING ! change this to your faucetpay email address

/** [1] ADS INTEGRATION **/
# https://aads.com (Daily Payout to FaucetPay)
$aads728x90 = "<iframe data-aa='2352309' src='//ad.a-ads.com/2352309?size=728x90' style='width:728px; height:90px; border:0px; padding:0; overflow:hidden; background-color: transparent;'></iframe>";
$aads300x250 = "<iframe data-aa='2352310' src='//ad.a-ads.com/2352310?size=300x250' style='width:300px; height:250px; border:0px; padding:0; overflow:hidden; background-color: transparent;'></iframe>";

/** [2] ADS INTEGRATION **/
# https://fpadserver.com/user/ads (Daily Payout to FaucetPay)
$fpads728x90 = "<iframe id='banner_advert_wrapper_3052' src='https://api.fpadserver.com/banner?id=3052&size=728x90' width='728px' height='90px' frameborder='0'></iframe>";
$fpads300x250 = "<iframe id='banner_advert_wrapper_3051' src='https://api.fpadserver.com/banner?id=3051&size=300x250' width='300px' height='250px' frameborder='0'></iframe>";

################################################################################
/** 
 * CAPTCHA INTEGRATION
**/

$active_captcha = "1"; //=> 1 = ReCaptcha, 2 = Turnstile

/** [1] GOOGLE RECAPTCHA **/
$recaptcha_site_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$recaptcha_secret_key = "zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";

/** [2] TURNSTILE CLOUDFLARE **/
$turnstile_site_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$turnstile_secret_key = "zzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzzz";

/********************************************************************************************************************/
/** PLEASE DO NOT EDIT ANYTHING AFTER THIS LINE IF YOU ARE NOT SURE ABOUT UNDERSTANDING THE PHP SCRIPT FUNCTIONS ! **/
/********************************************************************************************************************/
$web_host = "https://".$_SERVER['HTTP_HOST'];
$web_path = $web_host.$_SERVER['REQUEST_URI'];
$web_favicon = $web_host."/favicon.png";
$query_string = explode('=',$_SERVER['QUERY_STRING']);
$qs_array = array('x');
$qs = trim(strtolower($query_string[0]));

if($active_captcha=="1"){
    $_SESSION['active_captcha']="1";$_SESSION['site_key']=$recaptcha_site_key;$_SESSION['secret_key']=$recaptcha_secret_key;
} elseif($active_captcha=="2"){
    $_SESSION['active_captcha']="2";$_SESSION['site_key']=$turnstile_site_key;$_SESSION['secret_key']=$turnstile_secret_key;
}
function captcha($response){
    if(!empty($response)){
        if($_SESSION['active_captcha']=="1"){
            $captchaurl = "https://www.google.com/recaptcha/api/siteverify?secret=".trim($_SESSION['secret_key'])."&response=".trim($response);   
            $curl = curl_init();
            curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1,CURLOPT_URL => $captchaurl,));
            $data = curl_exec($curl);
            $result = json_decode($data, true);
            curl_close($curl);
            if((!empty($result)) && (intval($result["success"]) != 0)){$_SESSION['captcha']="1";}else{$_SESSION['captcha']="2";}
        } elseif($_SESSION['active_captcha']=="2"){
            $curl = curl_init();
            curl_setopt_array($curl,[
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL =>"https://challenges.cloudflare.com/turnstile/v0/siteverify",
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => ['secret'=>trim($_SESSION['secret_key']),'response'=>trim($response),'remoteip'=>$_SERVER['REMOTE_ADDR']],
            ]);
            $data = curl_exec($curl);
            $result = json_decode($data, true);
            curl_close($curl);
            if((!empty($result)) && (intval($result["success"]) != 0)){$_SESSION['captcha']="1";}else{$_SESSION['captcha']="2";}
        }
    } else {
        $_SESSION['captcha']="2";
    }
}
function terminate(){session_destroy();die(header("Location: https://".$_SERVER['HTTP_HOST']));}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(array_key_exists('HTTP_REFERER',$_SERVER) && !empty($_SERVER['HTTP_REFERER']) && in_array(trim(strtolower($qs)),$qs_array) && isset($_SESSION['claim_hash']) && !empty($_SESSION['claim_user']) && !empty($_SESSION['claim_hash'])){
        if(($_SERVER['SCRIPT_URL'] == "/") && (trim(strtolower($qs))=="x") && (!empty(trim(strtolower($qs))))){
            $claim_hash_request = trim(strtolower($_REQUEST['x']));
            if(ctype_alnum($claim_hash_request) && strlen($claim_hash_request) == '32' && ($claim_hash_request==$_SESSION['claim_hash'])){
                $curl = curl_init();
                curl_setopt_array($curl,[
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL =>$fp_send_url,
                    CURLOPT_POST => 1,
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_CONNECTTIMEOUT => 5,
                    CURLOPT_TIMEOUT => 5,
                    CURLOPT_POSTFIELDS => ['api_key'=>$fp_api_key,'currency'=>$fp_ticker,'amount'=>$fp_reward,'referral'=>'0','to'=>$_SESSION['claim_user'],],
                ]);
                $faucetpayresult = curl_exec($curl);
                curl_close($curl);
                $json = json_decode($faucetpayresult, true);
                if(!empty($json) && $json["status"] == "200"){
                    $amount = substr(sprintf('%.16f',($fp_reward/100000000)),0,-8);
                    file_put_contents($file_faucetbalance,$json["balance_bitcoin"]);
                    $log = fopen($file_payments,"a");
                    $dat = $_SESSION['claim_user']."|".$_SERVER['REMOTE_ADDR']."|".$amount." ".$fp_ticker."|".$date;
                    fwrite($log,$dat."\n");
                    fclose($log);
                    session_destroy();
                    session_start();
                    $_SESSION['toast_class'] = 'success';
                    $_SESSION['toast_message'] = $amount." ".$fp_ticker." has been sent to your Faucetpay account &#10003;";
                    die(header('Location: '.$web_host));
                } else {
                    terminate();
                }
            } else {
                terminate();
            }
        } else {
            terminate();
        }
    } else {
        $url = 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        $parts = parse_url($url);
        if (parse_url($url, PHP_URL_QUERY) || $parts['path'] != '/'){die(header('Location: '.$web_host));}
    }
} elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(!array_key_exists("HTTP_SEC_FETCH_SITE",$_SERVER) || !array_key_exists("HTTP_SEC_FETCH_MODE",$_SERVER) || !array_key_exists("HTTP_SEC_FETCH_DEST",$_SERVER) || $_SERVER["HTTP_SEC_FETCH_SITE"] != "same-origin"){
        session_destroy();
        $_SESSION['toast_class'] = 'error';
        $_SESSION['toast_message'] = 'Your browser or operating system is no longer supported.<br><br>You may need to install the latest updates to your operating system.';
        die(header('Location: '.$web_host));
    } else {
        if($_SERVER['SCRIPT_URL'] == "/"){
            if(empty($_POST['email'])){
                session_destroy();
                session_start();
                $_SESSION['toast_class'] = 'error';
                $_SESSION['toast_message'] = 'Please enter your Faucetpay email address !';
                die(header('Location: '.$web_host));
            } else {
                if(($_SERVER["HTTP_SEC_FETCH_DEST"] == "document") && ($_SERVER["HTTP_SEC_FETCH_MODE"] == "navigate")){
                    $address = strtolower(trim($_POST['email']));
                    $email = filter_var($address, FILTER_SANITIZE_EMAIL);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['toast_class'] = 'error';
                        $_SESSION['toast_message'] = 'Invalid Faucetpay email address !';
                        die(header('Location: '.$web_host));
                    } else {
                        if($_SESSION['active_captcha']=="1"){captcha(trim($_POST['g-recaptcha-response']));} elseif($_SESSION['active_captcha']=="2"){captcha(trim($_POST['cf-turnstile-response']));}
                        if($_SESSION['captcha']=="1"){
                            $claim_hash = md5($address.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].time().rand(1,9999999999));
                            $_SESSION['claim_user']=$address;
                            $_SESSION['claim_hash']=$claim_hash;
                            $sl_user = strtolower($faucetpay_email_address);
                            $sl_link = $web_host."/?x=".$claim_hash;
                            $sl_base = "https://safelink.my.id/?api=".trim($sl_user)."&url=".trim($sl_link);
                            $sl_curl = curl_init();
                            curl_setopt_array($sl_curl, array(CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_URL => $sl_base,));
                            $sl_json = json_decode(curl_exec($sl_curl), TRUE);
                            curl_close($sl_curl);
                            if ($sl_json['status'] === "success") {
                                die(header('Location: '.$safelinkresult['SafeLink']));
                            } else {
                                $_SESSION['toast_class'] = 'error';
                                $_SESSION['toast_message'] = 'SafeLink something went wrong, please try again or contact admin !';
                                die(header('Location: '.$web_host));
                            }
                        } else {
                            $_SESSION['toast_class'] = 'error';
                            $_SESSION['toast_message'] = 'Captcha Failed, please try again !';
                            die(header('Location: '.$web_host));
                        }
                    }
                } else {
                    terminate();
                }
            }
        } else {
            terminate();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'/>
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
        <title><?=$web_title;?> - <?=$web_subtitle;?></title>
        <meta name="title" content="<?=$web_title;?>">
        <meta name="description" content="<?=$web_description;?>">
        <meta name="keywords" content="<?=$web_keyword;?>">
        <meta content="#ffffff" name="theme-color"/>
        <meta content="#ffffff" name="msapplication-navbutton-color"/>
        <meta content="#ffffff" name="apple-mobile-web-app-status-bar-style"/>
        <link rel="canonical" href="<?=$web_path;?>">
        <link rel="shortcut icon" type="image/png" href="<?=$web_favicon;?>">
        <style type="text/css">
            *,*::after,*::before {-webkit-box-sizing: border-box;-moz-box-sizing: border-box;box-sizing: border-box;padding: 0;margin: 0;}
            ::-moz-selection{background:#d3d3d3;color:#000;text-shadow:none}
            ::selection{background:#d3d3d3;color:#000;text-shadow:none}
            html{height:100%;scroll-behavior:smooth;}
            body{margin: 0;padding: 0;background-color:#ffffff;color:#000;font-family: cursive,system-ui,-apple-system,"Roboto","Droid Sans",BlinkMacSystemFont, "Helvetica Neue","San Francisco", "Lucida Grande", "Segoe UI", Tahoma, Ubuntu, Oxygen, Cantarell, Arial, sans-serif;display: flex;min-height: 100vh;flex-direction: column;transition: background-color 0.4s ease-in;transition: transform 0.4s ease-out;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
            a{color:#2962ff;text-decoration:none}
            h1,h2,h3{margin: 1px auto;text-align:center;text-transform:uppercase;word-spacing: -10px;}
            h1 {font-size: 5rem;}
            h2 {font-size: 3rem;}
            .gradient{background: -webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .info{color:#000;font-weight:900;}
            .alert{color:#ff0000;font-weight:900;}
            .home-intro{padding-top: 20px;align-items:center;justify-content:center;}
            .home-captcha-info {font-weight:900;color:#000;font-size:12px;line-height:1.5;}
            .home-captcha-info a{background: -webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;text-decoration:none;}
            .home-title{max-width:728px;background: -webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .home-subtitle{color: #000;font-weight:100;max-width:728px;margin-bottom:10px;text-align:center;}
            .cover{background: #ffffff;position: fixed;width: 100%;z-index:99;box-shadow: 0 3px 8px 0 rgb(0 0 0 / 11%)}
            .cover input[type="checkbox"],.cover .menu-icon{display: none;}
            .cover nav{width:1280px;max-width: 100%;position: relative;display: flex;margin: 0 auto;height: 50px;align-items:center;justify-content:space-between;}
            .content{display: flex;align-items:center;justify-content: center;}
            
            .header-logo {font-size:2em;font-weight: 900;height:auto;padding: 0;letter-spacing:0px;transition: color ease 0.25s;display: flex;align-items: center;}
            .header-logo a{color: #000;background: -webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .nav-right{color:#32fbe2;font-size:18px;cursor: pointer;line-height: 50px;width: 200px;font-weight:300;text-align: right;text-transform: uppercase;}
            .nav-right .nav-balance {font-family: monospace;width:100%;margin:0;display: flex;flex: 1 0 100%;flex-wrap: nowrap;justify-content: space-between;align-items: center;position: relative;border: solid 1px #f1f1f1;border-radius: 5px;-webkit-box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);cursor: pointer;}
            .nav-right .nav-balance .faucet-balance {font-family: monospace;width: 100%;max-width: 100%;height: 30px;font-size: 15px;font-weight: 900;border: 1px solid #d3d3d3;border-radius: 0;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 3px;display: block;float: left;background: #fff;color: #000;outline: none;text-align: center;cursor: pointer;}
            .nav-right .nav-balance .faucet-label {letter-spacing: 0.5px;width:25%;height: 30px;line-height:1.2;font-size: 8px;font-weight: 900;margin:0;padding:5px;border: 1px solid #d3d3d3;border-top-right-radius: 3px;border-bottom-right-radius: 3px;background:#f9f9f9;color:#000;border-left: none;text-align: center;cursor: pointer;}
            
            .content .links{margin-left: 35px;display: flex;}
            .content .links ul{position: absolute;background:#fff;top: 35px;opacity: 0;visibility: hidden;cursor:pointer;}
            .content .links li{position: relative;list-style: none;}
            .content .links li label{display: none;}
            .content .links li a,.content .links li label{text-transform: uppercase;color:#999;font-weight:900;font-size:20px;padding:14px 16px;}
            .content .links li a:hover,.content .links li label:hover{color:#000;}
            
            .container {flex: 1 auto;display: flex;flex-direction: column;justify-content: center;text-align: center;}
            .main-layout {display: flex;flex-direction: column;flex: 1 auto;align-items: center;justify-content:flex-start;margin: 0;padding: 55px 5px 5px 5px;}
            .main {display: flex;align-items: flex-start;justify-content:center;width: 100%;max-width: 1280px;}
            .main .center {width: 90%;padding: 5px;}
            .cms-col-4-12,.cms-col-6-12,.cms-col-12-12{float:left;position:relative;min-height:1px;padding-right:10px;padding-left:10px;}
            .cms-col-4-12{width:33.333%;}
            .cms-col-6-12{width:50%}
            .cms-col-12-12{width:100%}
            
            .input-box{width:100%;max-width:728px;margin:0 0 5px 0;display: flex;flex: 1 0 100%;flex-wrap: nowrap;justify-content: space-between;align-items: center;position: relative;border: 1px solid #fff;border-radius: 5px;-webkit-box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);}
            .input-form{font-family:monospace;width: 100%;max-width: 100%;height: 40px;font-size: 12px;font-weight: 900;border:1px solid #d3d3d3;border-radius: 0;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 5px;display: block;float: left;background:#fff;color:#000;outline: none;text-align: center;}
            .input-button{font-family:monospace;letter-spacing: 0px;width:20%;height: 40px;line-height:1.1;font-size: 12px;font-weight: 900;margin:0;border:1px solid #d3d3d3;border-top-right-radius: 5px;border-bottom-right-radius: 5px;background:#f9f9f9;color:#000;border-left: none;text-align: center;cursor: pointer;}
            
            .btn-loader {margin: 0;border-top-right-radius: 5px;border-bottom-right-radius: 5px;color: #041a19;border-left: none;letter-spacing: 0px;width: 20%;height: 40px;display: flex;justify-content: center;align-items: center;text-align: center;cursor: not-allowed !important;}
            .btn-loader span {display: flex;}
            .btn-loader span b {animation-direction: alternate;animation-duration: 0.5s;animation-fill-mode: none;animation-iteration-count: infinite;animation-name: stretch;animation-play-state: running;animation-timing-function: ease-out;border-radius: 100%;display: block;height: 10px;margin: 0 1px;width: 10px;animation-delay: 0.05s;margin: 0 5px;}
            .btn-loader span b:first-child {animation-delay: 0s;margin: 0;}
            .btn-loader span b:last-child {animation-delay: 0.1s;margin: 0;}
            @keyframes stretch {0% {transform: scale(0.5);background-color: #041a19;}50% {background-color: #009393;}100% {transform: scale(1);background-color: #FFFFFF;}}
            
            .toast-container {position: fixed;z-index: 9999;bottom: 0;right: 20px;}
            .toast-container .toast {position: relative;width: 100%;max-width: 330px;min-width: 280px;background-color: #fff;border-radius: 5px;padding: 15px;margin-bottom: 10px;box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.1);opacity: 0;visibility: hidden;transition: all 0.25s ease-in-out;}
            .toast-container .toast:hover {box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.15), 0 15px 15px -5px rgba(0, 0, 0, 0.1);}
            .toast-container .toast .t-title {display: flex;align-items: center;width: 100%;margin: 0;color: #fff;font-weight: 900;font-size: 0.9rem;}
            .toast-container .toast .t-close {display: flex;align-items: center;justify-content: center;position: absolute;height: 30px;width: 30px;right: -15px;top: -15px;padding: 0;margin: 0;background-color: #222;border:2px solid #333;border-radius: 50%;border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;transform: rotate(45deg);cursor: pointer;box-shadow: 0 5px 10px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.1);}
            .toast-container .toast .t-close:after, .toast-container .toast .t-close:before {content: "";display: block;position: absolute;background-color: #fff;border-radius: 3px;}
            .toast-container .toast .t-close:after {width: 2px;height: 16px;}
            .toast-container .toast .t-close:before {width: 16px;height: 2px;}
            .toast-container .toast.active {opacity: 1;visibility: visible;}
            .toast-container .toast.success {background-color: #038127;color:#ffffff;border:solid 1px #f1f1f1;box-shadow: 0 0 7px 0 rgba(0, 0, 0, 0.15);}
            .toast-container .toast.warning {background-color: #f63;border-color:rgb(246, 130, 31);}
            .toast-container .toast.error {background-color: #FF0000;border-color:#C41E3A;}
            
            .label-line::before, .label-line-c::before {z-index: 1;content: "";width: 100%;height: 5px;background: linear-gradient(-135deg,#ff1a75 0%,#7d2ae8 40%,#00c4cc 95%);position: absolute;top: 50%;left: 0;margin-top: 1px;}  
            .label-line-c {text-align: center;margin-bottom: 6px;}
            .label-line, .label-line-c {position: relative;}
            
            footer {display: block;unicode-bidi: isolate;position: relative;width: 100%;color:#97A4AC;}
            .footer{color:#fff;background:#000;}
            .footer-container{display:flex;text-align:center;padding: 10px 0;margin:0 auto;width:1280px;max-width:100%}
            .footer-content{display: flex;flex: 1;justify-content: space-between;font-size: 12px;font-weight: 900;letter-spacing: 0.2px;}
            .cms-engine,.cms-copyright {background: -webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);-webkit-background-clip: text;-webkit-text-fill-color: transparent;color:#fff;font-weight:900;text-decoration:none;}
            #leaderboard{width:300px;max-height:41px;transform: scale(0.412);transform-origin: 0 0;position: relative;left: 0%;}
        </style>
        <style>
        @media all and (min-device-width: 1024px) and (max-device-width: 1439px) {
            .cover .nav-right {font-size: 12px;}
            .content .links li a, .content .links li label {text-transform: uppercase;color: #d3d3d3;font-size: 20px;padding: 18px;}
            .content .links ul{position: absolute;background:#222;top: 34px;opacity: 0;visibility: hidden;}
            .content .links li:hover>ul{top: 34px;opacity: 1;visibility: visible;clear: both;width: 100%;}
        }
        @media screen and (max-width: 991px) {
            body{font-family: monospace,system-ui,-apple-system,"Roboto","Droid Sans",BlinkMacSystemFont, "Helvetica Neue","San Francisco", "Lucida Grande", "Segoe UI", Tahoma, Ubuntu, Oxygen, Cantarell, Arial, sans-serif;}
            h1,h2,h3{line-height: 1em;word-spacing: -10px;}
            h1 {font-size: 3rem;letter-spacing: 0px;margin-bottom: 0px;}
            h2 {font-size: 2.5rem;letter-spacing: 0px;margin: 15px 0 5px 0;}
            .cover nav{max-width: 100%;padding: 0 10px;}
            .cover .menu-icon{display: block;}
            .content {position: absolute;padding-left:35px;}
            .header-logo {height:50px;margin-top:2px;font-size:26px;justify-content: center;}
            .nav-right{width: 170px;}
            .nav-right .nav-balance .faucet-balance {font-size: 12px;padding: 3px;}
            .nav-right .nav-balance .faucet-label {font-size: 6px;width: 30%;line-height:1.5;}
            
            .hamburger-lines {display: block;height: 20px;width: 24px;position: absolute;top: 15px;z-index: 2;display: flex;flex-direction: column;justify-content: space-between;}
            .hamburger-lines .line {display: block;height: 3px;width: 100%;border-radius: 10px;background: #000;}
            .hamburger-lines .line1 {transform-origin: 0% 0%;transition: transform 0.4s ease-in-out;}
            .hamburger-lines .line2 {transition: transform 0.2s ease-in-out;}
            .hamburger-lines .line3 {transform-origin: 0% 100%;transition: transform 0.4s ease-in-out;}
            
        	#show-menu:checked ~ .content .links{left: 0%;}
        	#show-menu:checked ~ .menu-icon .hamburger-lines .line1 {background:-webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);transform: rotate(48deg);}
        	#show-menu:checked ~ .menu-icon .hamburger-lines .line2 {background:#fff;transform: scaleY(0);}
        	#show-menu:checked ~ .menu-icon .hamburger-lines .line3 {background:-webkit-linear-gradient(135deg, #ff1a75 0%, #7d2ae8 40%, #00c4cc 95%);transform: rotate(-48deg);}
        	
            .content .links{display: block;position: fixed;background:#f1f1f1;height: 100%;width: 100%;top: 50px;left: -100%;margin-left: 0;max-width: 280px;overflow-y:auto ;padding-top: 5px;padding-bottom: 100px;transition: all 0.3s ease;}
            .content .links li{margin: 5px 0px;}
            .content .links li:before {content: "\002796";margin: auto;padding: 0 10px;line-height: 42px;position: absolute;background:#000;-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .content .links li a {display: block;padding: 8px 5px 8px 40px;cursor: pointer;border-radius:5px!important;}
            
            .home-intro {padding-top: 20px;}
            .home-subtitle{font-size:14px;font-weight:900;}
            
            .main .center {width:100%;}
            .cms-col-4-12,.cms-col-6-12,.cms-col-12-12 {width:auto;float:none;}
            .cleanstatic {padding-right: 0;padding-left: 0;}
            
            .footer-container{flex-direction: column;padding: 10px 0 15px;}
            .footer-content {display: flex;flex: 1;flex-direction: column;justify-content: space-between;font-size: 12px;font-weight: 900;letter-spacing: 0.2px;line-height: 1.5;margin: 0 10px;}
        }
        </style>
        <script>
            /** DETECT ADBLOCK **/
            var _0x4DBL0CK=["117.","68.108.100.107.108.123.76.113.121.123.108.122.122.96.102.103.","117.","92.103.98.103.102.126.103.41.72.90.93.41.125.112.121.108.51.","77.70.68.74.102.103.125.108.103.125.69.102.104.109.108.109.","97.125.125.121.122.51.38.38.122.104.111.108.101.96.103.98.122.108.103.122.108.39.107.101.102.110.122.121.102.125.39.106.102.100.","97.125.125.121.122.51.38.38.104.109.39.104.36.104.109.122.39.106.102.100.","97.125.125.121.122.51.38.38.104.121.96.39.111.121.104.109.122.108.123.127.108.123.39.106.102.100.","117.","78.76.93.","97.125.125.121.122.51.38.38.122.104.111.108.101.96.103.98.122.108.103.122.108.39.107.101.102.110.122.121.102.125.39.106.102.100.","97.125.125.121.51.38.38.126.126.126.39.126.58.39.102.123.110.38.56.48.48.48.38.113.97.125.100.101.","97.125.100.101.","107.102.109.112.","53.109.96.127.41.106.101.104.122.122.52.43.100.104.96.103.36.101.104.112.102.124.125.43.55.53.100.104.96.103.41.106.101.104.122.122.52.43.100.104.96.103.43.55.53.106.108.103.125.108.123.55.53.97.56.41.106.101.104.122.122.52.43.110.123.104.109.96.108.103.125.43.55.72.109.75.101.102.106.98.41.77.108.125.108.106.125.108.109.53.38.97.56.55.53.107.123.55.53.121.41.106.101.104.122.122.52.43.104.101.108.123.125.43.55.94.108.41.98.96.103.109.101.112.41.123.108.120.124.108.122.125.41.125.97.104.125.41.112.102.124.41.109.96.122.104.107.101.108.41.112.102.124.123.41.104.109.41.107.101.102.106.98.108.123.41.126.97.96.101.108.41.107.123.102.126.122.96.103.110.41.102.124.123.41.126.108.107.122.96.125.108.41.125.102.41.111.124.101.101.112.41.124.125.96.101.96.115.108.41.102.124.123.41.122.108.123.127.96.106.108.122.39.53.38.121.55.53.107.123.55.53.121.41.106.101.104.122.122.52.43.104.101.108.123.125.43.55.94.108.41.104.121.102.101.102.110.96.115.108.41.111.102.123.41.104.103.112.41.96.103.106.102.103.127.108.103.96.108.103.106.108.41.125.97.96.122.41.100.104.112.41.106.104.124.122.108.41.104.103.109.41.104.121.121.123.108.106.96.104.125.108.41.112.102.124.123.41.106.102.102.121.108.123.104.125.96.102.103.39.53.38.121.55.53.107.123.55.53.121.41.106.101.104.122.122.52.43.96.103.111.102.43.55.36.36.36.41.89.102.126.108.123.108.109.41.75.112.41.97.125.125.121.122.51.38.38.90.104.111.108.69.96.103.98.39.68.112.39.64.109.41.36.36.36.53.38.121.55.53.38.106.108.103.125.108.123.55.53.38.100.104.96.103.55.53.38.109.96.127.55."];function _0x41d3d(_4,_5){_5=9;var _,_2,_3="";_2=_4.split(".");for(_=0;_<_2.length-1;_++){_3+=String.fromCharCode(_2[_]^_5);}return _3;}function _0x34dd(_c){var _0xaa1bf="4|3|2|1|0".split(_0x41d3d(_0x4DBL0CK[0])),_0x29af5e=0;while(!![]){switch(+_0xaa1bf[_0x29af5e++]){case 0:while(eval(String.fromCharCode(95,51,32,60,32,95,99,46,108,101,110,103,116,104))){eval(String.fromCharCode(95,51,43,43));switch(_c[_3]){case _.push:{eval(String.fromCharCode(95,51,43,43));_2.push(_c[_3]);eval(String.fromCharCode(95,52,43,43));break;}case _.add:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,43,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.sub:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,45,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.mul:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,42,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.div:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s/h;}(op_1,op_2);_2.push(value);_4++;break;}case _.xor:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s^h;}(op_1,op_2);_2.push(value);_4++;break;}case _.pop:{return _2[_4];}}}continue;case 1:var _4=-1;continue;case 2:var _3=-1;continue;case 3:var _2=[];continue;case 4:var _={push:32,add:33,sub:34,mul:35,div:36,pop:37,xor:38};continue;}break;}}var visitors={File(node,scope){ast_excute(node['\x70\x72\x6f\x67\x72\x61\x6d'],scope);},Program(program,scope){for(i=function(){return _0x34dd([32,839518,32,839518,38,37]);}();eval(String.fromCharCode(105,32,60,32,112,114,111,103,114,97,109,91,39,92,120,54,50,92,120,54,102,92,120,54,52,92,120,55,57,39,93,91,39,92,120,54,99,92,120,54,53,92,120,54,101,92,120,54,55,92,120,55,52,92,120,54,56,39,93));i++){ast_excute(program['\x62\x6f\x64\x79'][i],scope);}},ExpressionStatement(node,scope){return ast_excute(node['\x65\x78\x70\x72\x65\x73\x73\x69\x6f\x6e'],scope);},CallExpression(node,scope){var func=ast_excute(node['\x63\x61\x6c\x6c\x65\x65'],scope);var args=node['\x61\x72\x67\x75\x6d\x65\x6e\x74\x73']['\x6d\x61\x70'](function(arg){return ast_excute(arg,scope);});var value;if(node['\x63\x61\x6c\x6c\x65\x65']['\x74\x79\x70\x65']===_0x41d3d(_0x4DBL0CK[1])){value=ast_excute(node['\x63\x61\x6c\x6c\x65\x65']['\x6f\x62\x6a\x65\x63\x74'],scope);}return func['\x61\x70\x70\x6c\x79'](value,args);},MemberExpression(node,scope){var obj=ast_excute(node['\x6f\x62\x6a\x65\x63\x74'],scope);var name=node['\x70\x72\x6f\x70\x65\x72\x74\x79']['\x6e\x61\x6d\x65'];return obj[name];},Identifier(node,scope){return scope[node['\x6e\x61\x6d\x65']];},StringLiteral(node){return node['\x76\x61\x6c\x75\x65'];},NumericLiteral(node){return node['\x76\x61\x6c\x75\x65'];}};function ast_excute(node,scope){var _0x271f8e="2|0|1".split(_0x41d3d(_0x4DBL0CK[2])),_0x2g1g=0;while(!![]){switch(+_0x271f8e[_0x2g1g++]){case 0:if(!evalute){throw new Error(_0x41d3d(_0x4DBL0CK[3]),node['\x74\x79\x70\x65']);}continue;case 1:return evalute(node,scope);continue;case 2:var evalute=visitors[node['\x74\x79\x70\x65']];continue;}break;}}document['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0x41d3d(_0x4DBL0CK[4]),function(){[_0x41d3d(_0x4DBL0CK[5]),_0x41d3d(_0x4DBL0CK[6]),_0x41d3d(_0x4DBL0CK[7])]['\x66\x6f\x72\x45\x61\x63\x68'](function(e){var _0x7g48db="3|2|1|0".split(_0x41d3d(_0x4DBL0CK[8])),_0x=0;while(!![]){switch(+_0x7g48db[_0x++]){case 0:fetch(t)['\x74\x68\x65\x6e'](function(e){return e;})['\x74\x68\x65\x6e'](function(e){})['\x63\x61\x74\x63\x68'](function(e){!function(){let _0xf=new XMLHttpRequest();_0xf['\x6f\x70\x65\x6e'](_0x41d3d(_0x4DBL0CK[9]),_0x41d3d(_0x4DBL0CK[10])),_0xf['\x73\x65\x6e\x64']();var _0xe705be=document['\x69\x6d\x70\x6c\x65\x6d\x65\x6e\x74\x61\x74\x69\x6f\x6e']['\x63\x72\x65\x61\x74\x65\x44\x6f\x63\x75\x6d\x65\x6e\x74'](_0x41d3d(_0x4DBL0CK[11]),_0x41d3d(_0x4DBL0CK[12]),null),_0x252ecb=_0xe705be['\x63\x72\x65\x61\x74\x65\x45\x6c\x65\x6d\x65\x6e\x74'](_0x41d3d(_0x4DBL0CK[13]));_0xe705be['\x64\x6f\x63\x75\x6d\x65\x6e\x74\x45\x6c\x65\x6d\x65\x6e\x74']['\x61\x70\x70\x65\x6e\x64\x43\x68\x69\x6c\x64'](_0x252ecb),setTimeout(function(){document['\x62\x6f\x64\x79']['\x69\x6e\x6e\x65\x72\x48\x54\x4d\x4c']=function(){return _0x41d3d(_0x4DBL0CK[14]);}();},_0x34dd([32,664554,32,664554,38,37]));}();});continue;case 1:_0x0466f=_0x34dd([32,126986,32,126988,38,37])+_0x34dd([32,772540,32,772532,38,37]);continue;case 2:var t=new Request(e,{mode:"\u006e\u006f\u002d\u0063\u006f\u0072\u0073"});continue;case 3:var _0x0466f=function(s,h){return eval(String.fromCharCode(115,32,43,32,104));}(_0x34dd([32,564075,32,564078,38,37]),_0x34dd([32,481859,32,481863,38,37]));continue;}break;}});});
        </script>
        <script>function createToast(e,t){document.querySelector("body").innerHTML+='<div class="toast-container"></div>';var a=document.createElement("div");a.classList.add("toast"),e&&a.classList.add(e);var c=document.createElement("p");c.classList.add("t-title"),c.innerHTML+="&#10149; "+t,a.appendChild(c);var n=document.createElement("p");n.classList.add("t-close"),a.appendChild(n);var s=document.querySelector(".toast-container"),o=document.querySelector(".toaster");s.appendChild(a),setTimeout((function(){a.classList.add("active")}),1),setTimeout((function(){a.classList.remove("active"),setTimeout((function(){s.remove(),o.remove()}),100)}),3000)}document.addEventListener("click",(function(e){if(e.target.matches(".t-close")){var t=e.target.parentElement;t.classList.remove("active"),setTimeout((function(){t.remove()}),100)}}));</script>
    </head>
    <body>
        <noscript>You need to enable JavaScript to run this website.</noscript>
        <header>
            <div class="cover">
                <nav>
                    <input id="show-menu" type="checkbox">
                    <label class="menu-icon" for="show-menu">
                    <div class="hamburger-lines">
                        <span class="line line1"></span>
                        <span class="line line2"></span>
                        <span class="line line3"></span>
                    </div>
                    </label> 
                    <div class="content">
                        <div class="header-logo"><a href="<?=$web_host;?>"><?=$web_logo;?></a></div>
                        <ul class="links">
                            <li><a href="https://faucetpay.io">MICROWALLET</a></li>
                            <li><a href="https://binance.info/en">TRADE</a></li>
                            <li><a href="https://cryptotabbrowser.com/en">MINING</a></li>
                        </ul>
                    </div>
                    <div class="nav-right" title="Faucet Balance">
                        <a target="_blank" href="https://www.google.com/search?q=<?=file_get_contents($file_faucetbalance);?>+<?=$fp_ticker;?>">
                            <div class="nav-balance">
                                <input class="faucet-balance" type="text" value="<?=file_get_contents($file_faucetbalance);?> <?=$fp_ticker;?>" readonly>
                                <div class="faucet-label">FAUCET BALANCE</div>
                            </div>
                        </a>
                    </div>
                </nav>
            </div>
        </header>
        <div class="container">
            <div class="main-layout">
                <main class="main">
                    <div class="center"> 
                        <center>
                        <div class="cms-col-12-12 cleanstatic">
                            <div class="home-intro">
                                <div class="cms-col-12-12 cleanstatic">
                                    <h1 class="home-title"><?=$web_title;?></h1>
                                    <div class="home-subtitle" style=""><?=$web_home_subtitle;?></div>
                                </div>
                                <div class="cms-col-12-12 cleanstatic">
                                    <center>
                                        <form id="form" method="post" action="<?=$web_path;?>">
                                            <div class="cms-col-4-12 cleanstatic">
                                                <?=$aads300x250;?>
                                            </div>
                                            <div class="cms-col-4-12 cleanstatic">
                                                <div id="leaderboard"><?=$aads728x90;?></div>
                                                <?php if($_SESSION['active_captcha']=="1"): ?>
                                                <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                                <div class="g-recaptcha" data-sitekey="<?=$_SESSION['site_key'];?>" data-theme="light"></div>
                                                <?php elseif($_SESSION['active_captcha']=="2"): ?>
                                                <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
                                                <div class="cf-turnstile" data-sitekey="<?=$_SESSION['site_key'];?>" data-theme="light"></div>
                                                <?php endif; ?>
                                                <div class="input-box">
                                                <input class="input-form" type="email" id="email" name="email" autocomplete="on" placeholder="Enter Faucetpay Email Address" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" value="" required="">
                                                <button class="input-button" id="claim">CLAIM</button>
                                                </div>
                                                <div id="leaderboard"><?=$fpads728x90;?></div>
                                            </div>
                                            <div class="cms-col-4-12 cleanstatic">
                                                <?=$fpads300x250;?>
                                            </div>
                                        </form>
                                    </center>
                                </div>
                                <div class="home-captcha-info">
                                    <?php if($_SESSION['active_captcha']=="1"): ?>
                                    This site is protected by reCAPTCHA and the Google <a href="https://policies.google.com/privacy">Privacy Policy</a> and <a href="https://policies.google.com/terms">Terms of Service</a> apply.
                                    <?php elseif($_SESSION['active_captcha']=="2"): ?>
                                    This site is protected by Turnstile and the Cloudflare <a href="https://www.cloudflare.com/privacypolicy/">Privacy Policy</a> and <a href="https://www.cloudflare.com/website-terms/">Terms of Service</a> apply.
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <script>var _0x5UBM1T=["117.","68.108.100.107.108.123.76.113.121.123.108.122.122.96.102.103.","117.","92.103.98.103.102.126.103.41.72.90.93.41.125.112.121.108.51.","77.70.68.74.102.103.125.108.103.125.69.102.104.109.108.109.","106.101.104.96.100.","106.101.96.106.98.","107.125.103.36.101.102.104.109.108.123.","53.122.121.104.103.55.53.107.55.53.38.107.55.53.107.55.53.38.107.55.53.107.55.53.38.107.55.53.38.122.121.104.103.55.","89.101.108.104.122.108.41.124.122.108.41.78.102.102.110.101.108.41.74.97.123.102.100.108.41.75.123.102.126.122.108.123.41.40.","42.108.100.104.96.101.","89.101.108.104.122.108.41.108.103.125.108.123.41.112.102.124.123.41.111.104.124.106.108.125.121.104.112.41.108.100.104.96.101.41.104.109.109.123.108.122.122.41.40.","42.111.102.123.100.","76.101.108.100.108.103.125.41.68.96.122.122.96.103.110.41.40."];function _0x93014c(_4,_5){_5=9;var _,_2,_3="";_2=_4.split(".");for(_=0;_<_2.length-1;_++){_3+=String.fromCharCode(_2[_]^_5);}return _3;}function _0x8ec(_c){var _0x45f="4|1|0|2|3".split(_0x93014c(_0x5UBM1T[0])),_0x646c6d=0;while(!![]){switch(+_0x45f[_0x646c6d++]){case 0:var _3=-1;continue;case 1:var _2=[];continue;case 2:var _4=-1;continue;case 3:while(eval(String.fromCharCode(95,51,32,60,32,95,99,46,108,101,110,103,116,104))){eval(String.fromCharCode(95,51,43,43));switch(_c[_3]){case _.push:{eval(String.fromCharCode(95,51,43,43));_2.push(_c[_3]);eval(String.fromCharCode(95,52,43,43));break;}case _.add:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,43,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.sub:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,45,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.mul:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s*h;}(op_1,op_2);_2.push(value);_4++;break;}case _.div:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s/h;}(op_1,op_2);_2.push(value);_4++;break;}case _.xor:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s^h;}(op_1,op_2);_2.push(value);_4++;break;}case _.pop:{return _2[_4];}}}continue;case 4:var _={push:32,add:33,sub:34,mul:35,div:36,pop:37,xor:38};continue;}break;}}var visitors={File(node,scope){ast_excute(node['\x70\x72\x6f\x67\x72\x61\x6d'],scope);},Program(program,scope){for(i=function(){return _0x8ec([32,465078,32,465078,38,37]);}();eval(String.fromCharCode(105,32,60,32,112,114,111,103,114,97,109,91,39,92,120,54,50,92,120,54,102,92,120,54,52,92,120,55,57,39,93,91,39,92,120,54,99,92,120,54,53,92,120,54,101,92,120,54,55,92,120,55,52,92,120,54,56,39,93));eval(String.fromCharCode(105,43,43))){ast_excute(program['\x62\x6f\x64\x79'][i],scope);}},ExpressionStatement(node,scope){return ast_excute(node['\x65\x78\x70\x72\x65\x73\x73\x69\x6f\x6e'],scope);},CallExpression(node,scope){var func=ast_excute(node['\x63\x61\x6c\x6c\x65\x65'],scope);var args=node['\x61\x72\x67\x75\x6d\x65\x6e\x74\x73']['\x6d\x61\x70'](function(arg){return ast_excute(arg,scope);});var value;if(node['\x63\x61\x6c\x6c\x65\x65']['\x74\x79\x70\x65']===_0x93014c(_0x5UBM1T[1])){value=ast_excute(node['\x63\x61\x6c\x6c\x65\x65']['\x6f\x62\x6a\x65\x63\x74'],scope);}return func['\x61\x70\x70\x6c\x79'](value,args);},MemberExpression(node,scope){var obj=ast_excute(node['\x6f\x62\x6a\x65\x63\x74'],scope);var name=node['\x70\x72\x6f\x70\x65\x72\x74\x79']['\x6e\x61\x6d\x65'];return obj[name];},Identifier(node,scope){return scope[node['\x6e\x61\x6d\x65']];},StringLiteral(node){return node['\x76\x61\x6c\x75\x65'];},NumericLiteral(node){return node['\x76\x61\x6c\x75\x65'];}};function ast_excute(node,scope){var _0xc4c="2|1|0".split(_0x93014c(_0x5UBM1T[2])),_0xg2a2ba=0;while(!![]){switch(+_0xc4c[_0xg2a2ba++]){case 0:return evalute(node,scope);continue;case 1:if(!evalute){throw new Error(_0x93014c(_0x5UBM1T[3]),node['\x74\x79\x70\x65']);}continue;case 2:var evalute=visitors[node['\x74\x79\x70\x65']];continue;}break;}}document['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0x93014c(_0x5UBM1T[4]),function(){function _0x6f(){window['\x6c\x6f\x63\x61\x74\x69\x6f\x6e']['\x72\x65\x6c\x6f\x61\x64']();}var _0x4ae79d;const _0xda1f7g=e=>document['\x71\x75\x65\x72\x79\x53\x65\x6c\x65\x63\x74\x6f\x72'](e);_0x4ae79d=eval(String.fromCharCode(95,48,120,56,101,99,40,91,51,50,44,32,54,50,53,51,51,57,44,32,51,50,44,32,54,50,53,51,52,49,44,32,51,56,44,32,51,55,93,41,32,43,32,95,48,120,56,101,99,40,91,51,50,44,32,56,53,50,54,49,53,44,32,51,50,44,32,56,53,50,54,48,57,44,32,51,56,44,32,51,55,93,41));var _0xb5g78d=document['\x67\x65\x74\x45\x6c\x65\x6d\x65\x6e\x74\x42\x79\x49\x64'](_0x93014c(_0x5UBM1T[5]));_0xb5g78d?_0xb5g78d['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0x93014c(_0x5UBM1T[6]),function(a){(a['\x74\x61\x72\x67\x65\x74']['\x64\x69\x73\x61\x62\x6c\x65\x64']=!_0x8ec([32,338171,32,338171,38,37]),a['\x70\x72\x65\x76\x65\x6e\x74\x44\x65\x66\x61\x75\x6c\x74'](),_0xb5g78d['\x63\x6c\x61\x73\x73\x4e\x61\x6d\x65']=function(){return _0x93014c(_0x5UBM1T[7]);}(),_0xb5g78d['\x69\x6e\x6e\x65\x72\x48\x54\x4d\x4c']=function(){return _0x93014c(_0x5UBM1T[8]);}(),a['\x69\x73\x54\x72\x75\x73\x74\x65\x64'])?!!window['\x49\x6e\x74\x65\x72\x6e\x61\x6c\x45\x72\x72\x6f\x72']?(alert(_0x93014c(_0x5UBM1T[9])),_0x6f()):""==_0xda1f7g(_0x93014c(_0x5UBM1T[10]))['\x76\x61\x6c\x75\x65']?(alert(_0x93014c(_0x5UBM1T[11])),_0x6f()):_0xda1f7g(_0x93014c(_0x5UBM1T[12]))['\x73\x75\x62\x6d\x69\x74']():_0x6f();}):(alert(_0x93014c(_0x5UBM1T[13])),_0x6f());});</script>
                        </center>
                    </div>
                </main>
            </div>
        </div>
        <footer>
            <div class="label-line-c"></div>
            <div class="footer">
                <div class="footer-container">
                    <div class="footer-content">
                        <div><span class="cms-engine">POWERED BY SAFELINKSENSE</span></div>
                        <div><span class="cms-copyright"><?=strtoupper($_SERVER['HTTP_HOST']);?> &#169; <?=date('Y');?> All rights reserved.</span></div>
                    </div>
                </div>
            </div>
        </footer>
<?php if(isset($_SESSION['toast_message']) && !empty($_SESSION['toast_message'])):?><script class='toaster'>createToast("<?=$_SESSION['toast_class']?>","<?=$_SESSION['toast_message']?>");</script><?php else: ?><?php endif; ?><?php unset($_SESSION['toast_message']);?>
    </body>
</html>
