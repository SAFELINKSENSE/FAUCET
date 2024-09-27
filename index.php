<?php
/**
 * DEMO FAUCET : https://faucet.safelink.my.id
**/
error_reporting(0);
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
session_name('SAFELINKFAUCET');
session_start();
/******************************************************************************************************************/
/** YOU WILL NEED TO FILL IN OR EDIT A FEW LINES AFTER THIS IN ORDER FOR YOUR FAUCET SITE TO FUNCTION PROPERLY ! **/ 
/******************************************************************************************************************/
/**
 * If you have any questions about faucet installation, please contact us on 
 * WhatsApp : https://chat.whatsapp.com/ISHZGV0v4L819u53BLSy65
 * Twitter : https://x.com/safelinksense
**/
$web_logo = "FAUCET";
$web_title = "DOGE Faucet";
$web_subtitle = "Unlimited Claim No Timer";
$web_home_subtitle = "Unlimited claim no timer and Instant payouts to your faucetpay account";
$web_keyword = "Crypto, Cryptocurrency, FaucetPay, Unlimited, No Timer, Instant Payout, DOGE Faucet, Dogecoin Faucet,";
$web_description = "Claim free DOGE Faucet unlimited no timer by completing easy captcha tasks and visiting shortlinks.";
$web_about_cryptocurrency = "Dogecoin (DOGE) is based on the popular 'doge' Internet meme and features a Shiba Inu on its logo. The open-source digital currency was created by Billy Markus from Portland, Oregon and Jackson Palmer from Sydney, Australia, and was forked from Litecoin in December 2013. Dogecoin's creators envisaged it as a fun, light-hearted cryptocurrency that would have greater appeal beyond the core Bitcoin audience, since it was based on a dog meme. Tesla CEO Elon Musk posted several tweets on social media that Dogecoin is his favorite coin.";
/** 
 * FAUCETPAY 
 * https://faucetpay.io/page/faucet-admin
**/
$faucetpay_api_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$faucetpay_currency = "DOGE";
$faucetpay_amount = "100"; //=> 100 = 0.00000100 DOGE

/** 
 * GOOGLE RECAPTCHA
 * https://www.google.com/recaptcha/admin
**/
$recaptcha_site_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$recaptcha_secret_key = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

/** 
 * SAFELINK
 * https://safelink.my.id (Instant Payout to your FaucetPay)
**/
$faucetpay_email_address = "faucetpay@mail.com"; //=> change this to your faucetpay email address

/** 
 * BANNER ADS
 * WARNING ! change this to your iframe ad code (<iframe></iframe>)
**/
$ads_1_728x90 = ""; //=> top
$ads_2_728x90 = ""; //=> bottom

$ads_1_300x250 = ""; //=> left
$ads_2_300x250 = ""; //=> right

$ads_1_160x600 = ""; //=> left
$ads_2_160x600 = ""; //=> right

/** 
 * BACKUP IF ADS EMPTY OR NOT SET
**/
$backup728x90 = "<img src='https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiX2KxZNVbxgIt1E1sWOmcFnyRId62xn2fKUkYhXAQYEP9dVNjKG7m9ON4yVwiAxHBjEy7bpMq03k2U8ouuzs2nxqrPAjhrtju-kFzkPkycrOUvSMiFvq2H1f4ZoXGlutb1zU_jDd6uMv_SCOMb-re164gubMcWRhlowmI8VfxxOtYCU16DQSUy_id8IXWG/s16000/728x90.gif'>";
$backup300x250 = "<img src='https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgMclRxikUipuIyRMwWwYTjCs8F0rkpLy7DRnsVM7w7nlD153tzE9NNQlUXlQ5tbzEBA_BgCWAz8HjNozQvF4KGhW36QnuwyMKQMfCCgsh8a2AfzFsSU_6efzFkht74SpllQwMDR-uk8ukyN1sAytkR1asEujO0I28mrOgm3qhInaZYWv3U0B8YtaPddmmA/s1600/300x250.gif'>";
$backup160x600 = "<img src='https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg6c1rgnhXCJ2M1Mg5vwUhjr6h7bSUsJtYAwC4NHH4lJt54RDUYXBFhtvaNXAcqMP2o43-5UM8WmcnAfCW5xu-jpIU451-uVthM2lJr7NScSX9ood-wZ3BgdFq8hLRMAmq3WqNdAsRBzKSfiT9DA8nCXeGYv4ulrA78Sg1CzK3K7rLQooCMYUprK1jKw2F9/s16000/160x600.gif'>";
/********************************************************************************************************************/
/** PLEASE DO NOT EDIT ANYTHING AFTER THIS LINE IF YOU ARE NOT SURE ABOUT UNDERSTANDING THE PHP SCRIPT FUNCTIONS ! **/
/********************************************************************************************************************/
$web_host = "https://".$_SERVER['HTTP_HOST'];
$web_path = $web_host.$_SERVER['REQUEST_URI'];
if(!file_exists('favicon.ico') || !file_exists('favicon.png')){
    $web_favicon = "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEj7-04qHZc5ItSWSXebuhGxf4cTPesYpx3VdNoy7kfGBvVXqFmKt_V1DDxkvc8qCb2invySRSr5ZBzuaTcLGMI-TrCvh7upfr3SvS1P-PBfUSTCyogNiWhhNlxu2oXdrWWL-lNimiTzuBBvZeLhyW9QT38b00uUbo_4Cg5JyX80XD4r_VvzmTxSwZte4Id5/s16000/favicon.png";
} else {
    if(!file_exists('favicon.ico')){
        $web_favicon = $web_host."/favicon.png";
    } else {
        $web_favicon = $web_host."/favicon.ico";
    }
}
$faucetpay_balance = "FAUCETBALANCE.txt";
if(!file_exists($faucetpay_balance)){file_put_contents($faucetpay_balance,"0.00000000");}
$query_string = explode('=',$_SERVER['QUERY_STRING']);
$p_array = array('logout');
$qs_array = array('sl','p');
$qs = trim(strtolower($query_string[0]));
function terminate(){session_destroy();die(header("Location: https://".$_SERVER['HTTP_HOST']));}
function googleRECAPTCHA($response,$recaptcha_secret_key){
    if(!empty($response)){
        $captchaurl = "https://www.google.com/recaptcha/api/siteverify?secret=".trim($recaptcha_secret_key)."&response=".trim($response);   
        $curl = curl_init();
        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1,CURLOPT_URL => $captchaurl,));
        $data = curl_exec($curl);
        $result = json_decode($data, true);
        curl_close($curl);
        if((!empty($result)) && (intval($result["success"]) != 0)){
            $_SESSION['captcha']="1";
        } else {
            $_SESSION['captcha']="2";
        }
    } else {
        $_SESSION['captcha']="2";
    }
}
function sendPAYMENT($faucetpay_api_key,$faucetpay_currency,$faucetpay_amount,$faucetpay_balance){
    if(isset($_SESSION['claim_user'])){
        $user = $_SESSION['claim_user'];
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL =>"https://faucetpay.io/api/v1/send",
            CURLOPT_POST => 1,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_POSTFIELDS => ['api_key'=>$faucetpay_api_key,'currency'=>strtoupper($faucetpay_currency),'amount'=>$faucetpay_amount,'to'=>$user,],
        ]);
        $faucetpay_result = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($faucetpay_result, true);
        if(!empty($json) && $json["status"] == "200"){
            $reward = substr(sprintf('%.16f',($faucetpay_amount/100000000)),0,-8);
            file_put_contents($faucetpay_balance,$json["balance_bitcoin"]);
            $_SESSION['toast_class'] = 'success';
            $_SESSION['toast_message'] = $reward." ".strtoupper($faucetpay_currency)." has been sent to your Faucetpay account &#10003;";
        }elseif(!empty($json) && $json["status"] == "402"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "The faucet does not have sufficient funds for this transaction.";
        }elseif(!empty($json) && $json["status"] == "403"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "Invalid API Key used. Please login to your FaucetPay account and use a valid API Key.";
        }elseif(!empty($json) && $json["status"] == "405"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "Invalid amount of payment to the user.";
        }elseif(!empty($json) && $json["status"] == "410"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "Invalid currency provided.";
        }elseif(!empty($json) && $json["status"] == "456"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "The address does not belong to any user.";
        }elseif(!empty($json) && $json["status"] == "457"){
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "Account Blacklisted !";
        } else {
            $_SESSION['toast_class'] = 'error';
            $_SESSION['toast_message'] = "FaucetPay Server Offline !";
        }
    } else {
        session_destroy();
        die(header("Location: https://".$_SERVER['HTTP_HOST']));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(in_array($qs,$qs_array)){
        if(($qs=='sl' && array_key_exists('HTTP_REFERER',$_SERVER) && !empty($_SERVER['HTTP_REFERER']))){
            if(isset($_SESSION['claim_user']) && !empty($_SESSION['claim_user']) && !empty($_SESSION['claim_hash'])){
                $claim_hash_request = $_REQUEST['sl'];
                if(ctype_alnum($claim_hash_request) && strlen($claim_hash_request) == '32'){
                    if($claim_hash_request == $_SESSION['claim_hash']){
                        $claim_hash = md5($_SESSION['claim_user'].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].time().rand(111111111,999999999));
                        $_SESSION['claim_hash']=$claim_hash;
                        sendPAYMENT($faucetpay_api_key,strtoupper($faucetpay_currency),$faucetpay_amount,$faucetpay_balance);
                        die(header('Location: '.$web_host));
                    } else {
                        die(header('Location: '.$web_host));
                    }
                } else {
                    terminate();
                }
            } else {
                terminate();
            }
        } elseif(($qs=='p' &&  $_REQUEST['p']="logout")){
            terminate();
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
        terminate();
    } else {
        if(($_SERVER["HTTP_SEC_FETCH_DEST"]=="document" && $_SERVER["HTTP_SEC_FETCH_MODE"]=="navigate")){
            if((isset($_SESSION['claim_user']) && !empty($_SESSION['claim_user']))){
                if((array_key_exists('g-recaptcha-response',$_POST) && $_POST['g-recaptcha-response'] != "")){
                    googleRECAPTCHA(trim($_POST['g-recaptcha-response']),$recaptcha_secret_key);
                    if($_SESSION['captcha']=="1"){
                        $claim_hash = md5($_SESSION['claim_user'].$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].time().rand(111111111,999999999));
                        $_SESSION['claim_hash']=$claim_hash;
                        $sl_user = strtolower($faucetpay_email_address);
                        $sl_link = $web_host."/?sl=".$claim_hash;
                        $sl_base = "https://safelink.my.id/?api=".trim($sl_user)."&url=".trim($sl_link);
                        $sl_curl = curl_init();
                        curl_setopt_array($sl_curl, array(CURLOPT_RETURNTRANSFER => TRUE,CURLOPT_URL => $sl_base,));
                        $sl_json = json_decode(curl_exec($sl_curl), TRUE);
                        curl_close($sl_curl);
                        if ($sl_json['status'] === "success") {
                            die(header('Location: '.$sl_json['SafeLink']));
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
                } else {
                    $_SESSION['toast_class'] = 'error';
                    $_SESSION['toast_message'] = 'Captcha Failed, please try again !';
                    die(header('Location: '.$web_host));
                }
            } else {
                if(empty($_POST['email'])){
                    session_destroy();
                    session_start();
                    $_SESSION['toast_class'] = 'error';
                    $_SESSION['toast_message'] = 'Please enter your Faucetpay email address !';
                    die(header('Location: '.$web_host));
                } else {
                    $address = strtolower(trim($_POST['email']));
                    $email = filter_var($address, FILTER_SANITIZE_EMAIL);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $_SESSION['toast_class'] = 'error';
                        $_SESSION['toast_message'] = 'Invalid Faucetpay email address !';
                        die(header('Location: '.$web_host));
                    } else {
                        $curl = curl_init();
                        curl_setopt_array($curl,[
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL =>'https://faucetpay.io/api/v1/checkaddress',
                            CURLOPT_POST => 1,
                            CURLOPT_POSTFIELDS => ['api_key'=>$faucetpay_api_key,'address'=>$address],
                            CURLOPT_MAXREDIRS => 10,
                            CURLOPT_CONNECTTIMEOUT => 5,
                            CURLOPT_TIMEOUT => 5,
                        ]);
                        $response = curl_exec($curl);
                        curl_close($curl);
                        $json = json_decode($response, true);
                        if(!empty($json) && $json["status"]=="200"){
                            $claim_hash = md5($address.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'].time().rand(1,9999999999));
                            $_SESSION['claim_user']=$address;
                            $_SESSION['claim_hash']=$claim_hash;
                            $_SESSION['toast_class']='success';
                            $_SESSION['toast_message']='Login Success !';
                            die(header('Location: '.$web_host));
                        } else {
                            $_SESSION['toast_class']='error';
                            $_SESSION['toast_message']='Unable to connect to FaucetPay server !';
                            die(header('Location: '.$web_host));
                        }
                    }
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
            body{margin: 0;padding: 0;background-color:#fafcfe;color:#000;font-family: cursive,system-ui,-apple-system,"Roboto","Droid Sans",BlinkMacSystemFont, "Helvetica Neue","San Francisco", "Lucida Grande", "Segoe UI", Tahoma, Ubuntu, Oxygen, Cantarell, Arial, sans-serif;display: flex;min-height: 100vh;flex-direction: column;transition: background-color 0.4s ease-in;transition: transform 0.4s ease-out;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;}
            a{color:#2962ff;text-decoration:none}
            h1,h2{margin: 1px auto;text-align:center;text-transform:uppercase;}
            h1 {font-size: 2.2rem;}
            h2 {font-size: 2.5rem;}
            h3 {font-size: 1.5rem;}
            .header{background: #fff;position: fixed;width: 100%;z-index:99;box-shadow: rgba(0, 0, 0, 0.1) 0px 2px 8px 0px;}
            .header input[type="checkbox"],.header .menu-icon{display: none;}
            .nav{width:1280px;max-width: 100%;position: relative;display: flex;margin: 0 auto;height: 40px;align-items:center;justify-content:space-between;}
            .logo {font-size:2em;font-weight: 900;height:auto;padding: 0;letter-spacing:0px;align-items: center;}
            
            .navigation{display: flex;align-items:center;justify-content: center;}
            .navigation .links{margin-left: 35px;display: flex;}
            .navigation .links ul{position: absolute;background:#fff;top: 35px;opacity: 0;visibility: hidden;cursor:pointer;}
            .navigation .links li{position: relative;list-style: none;}
            .navigation .links li label{display: none;}
            .navigation .links li a,.navigation .links li span,.navigation .links li label{text-transform: uppercase;color:#999;font-weight:900;font-size:16px;padding:14px 16px;}
            .navigation .links li a:hover {color:#000;}
            .navigation .links li:hover>ul{background:#1a73e8;top: 31px;opacity: 1;visibility: visible;transition: all 0.3s ease;}
            .navigation .links ul li a{display: block;width: 100%;font-size: 14px;line-height: 30px;}
            .navigation .links ul ul{position: absolute;top: 0;right: calc(-65% + 5px);}
            .navigation .links ul li{position: relative;}
            .navigation .links ul li:hover ul{top: 0;}
            .navigation .links ul a{color:#fff;}
            .navigation .links li span.desktop-link:after{content: '\25BC';color:#1a73e8;position:relative;padding: 0px 0px 0px 10px;transition: .25s all ease;pointer-events: none;}
            
            .nav-right{color:#32fbe2;font-size:18px;cursor: pointer;line-height: 50px;width: 160px;font-weight:300;text-align: right;text-transform: uppercase;}
            .nav-right .nav-balance {font-family: monospace;width:100%;margin:0;display: flex;flex: 1 0 100%;flex-wrap: nowrap;justify-content: space-between;align-items: center;position: relative;border: solid 1px #f1f1f1;border-radius: 5px;-webkit-box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);cursor: pointer;}
            .nav-right .nav-balance .input-balance {font-family: monospace;width: 100%;max-width: 100%;height: 30px;font-size: 15px;font-weight: 900;border: 1px solid #d3d3d3;border-radius: 0;border-top-left-radius: 5px;border-bottom-left-radius: 5px;padding: 3px;display: block;float: left;background: #fff;color: #000;outline: none;text-align: center;cursor: pointer;}
            .nav-right .nav-balance .input-label {letter-spacing: 0.5px;width:30%;height: 30px;line-height:1.2;font-size: 15px;font-weight: 900;margin:0;padding:5px;border: 1px solid #d3d3d3;border-top-right-radius: 3px;border-bottom-right-radius: 3px;background:#f9f9f9;color:#000;border-left: none;text-align: center;cursor: pointer;}
            
            .container {flex: 1 auto;display: flex;flex-direction: column;justify-content: center;text-align: center;}
            .home-layout {display: flex;flex-direction: column;flex: 1 auto;align-items: center;justify-content:flex-start;margin: 0;padding:50px 10px 5px;}
            .home-main {display: flex;align-items: flex-start;justify-content:center;width: 100%;max-width: 1280px;}
            .cms-col-4-12,.cms-col-6-12,.cms-col-12-12{float:left;position:relative;min-height:1px;padding-right:10px;padding-left:10px;}
            .cms-col-4-12{width:33.333%;}
            .cms-col-6-12{width:50%}
            .cms-col-12-12{width:100%}
            .cleanstatic {padding-right: 0;padding-left: 0;}
            .light-neon {font-family:cursive;color: #fff;-webkit-text-fill-color: #fff;-webkit-text-stroke-width: 2px;-webkit-text-stroke-color: #4285f4;}
            .home-title{max-width:728px;text-align:center;}
            .home-subtitle{max-width:728px;color: #000;margin-bottom:10px;text-align:center;}
            .content{display: flex;align-items:center;justify-content: center;}
            .box-content{width:100%;max-width:1280px;overflow: auto;display: block;padding: 10px 5px;margin: 0 0 10px 0;background-color: #fff;border-radius: 4px;box-shadow:0px 3px 1px -2px rgba(0, 0, 0, 0.2), 0px 2px 2px 0px rgba(0, 0, 0, 0.14), 0px 1px 5px 0px rgba(0, 0, 0, 0.12),0px 0px 24px 0px rgba(26, 32, 47, 0.1)}
            .box-dotted-warning {background:#fff3db;color:#b37700;margin:0 5px 5px;padding: 5px;font-size: 10px;line-height: 1.5;border: 2px solid #b37700;border-radius: 0.25rem;border-style: dotted;}
            .box-dotted-info {background:#aecbfa;margin:0 5px;padding: 5px;font-size: 14px;line-height: 1.5;border: 2px solid #1a73e8;border-radius: 0.25rem;border-style: dotted;}
            
            .login-box{width:100%;max-width:300px;margin:0;display: flex;flex: 1 0 100%;flex-wrap: nowrap;justify-content: space-between;align-items: center;position: relative;border: 1px solid #fff;border-radius: 5px;-webkit-box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);box-shadow:0 0 7px 0 rgba(0, 0, 0, 0.15);}
            .login-input{font-family:monospace;width: 100%;min-width:300px;height: 40px;font-size: 12px;font-weight: 900;border:1px solid #4285f4;border-radius: 0;border-radius: 3px;padding: 5px;display: block;float: left;background:#fff;color:#000;outline: none;text-align: center;}
            .default-btn {display: inline-block;z-index:1;width:300px;margin:5px 0;font-weight:600;font-size:14px;background:#4285f4;color:#fff;border:2px solid #1057a9;border-radius: 3px;padding:12px 17px 12px;line-height:1;-webkit-transition:all ease .5s;transition:all ease .5s;text-align:center;position:relative;cursor: pointer;overflow:hidden}
            .default-btn-disabled {display: inline-block;z-index:1;width:300px;margin:5px 0;font-weight:600;font-size:14px;background:#f2dede;color:#ed564e;border:2px solid #ed564e;border-radius: 3px;padding:12px 17px 12px;line-height:1;-webkit-transition:all ease .5s;transition:all ease .5s;text-align:center;position:relative;cursor: not-allowed;overflow:hidden}
            .default-btn:hover {background:#1057a9;color:#fff}
            
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
            
            footer {width:100%;display:block;position:relative;color:#fff;background:#2845ae;font-size: 12px;font-weight: 900;letter-spacing: 0.2px;border-top: 5px solid #4285f4;text-decoration:none;}
            .footer-container{width:1280px;max-width:100%;margin:0 auto;padding: 10px 0;text-align:center;}
            .footer-content{display: flex;justify-content: space-between;}
        </style>
        <style>
        @media all and (min-device-width: 1024px) and (max-device-width: 1439px) {
            .header .nav-right {font-size: 12px;}
            .navigation .links li a, .navigation .links li span, .navigation .links li label {text-transform: uppercase;color: rgba(0,0,0,.54);font-size: 16px;padding: 9px 12px;cursor:pointer;}
            .navigation .links li:hover>ul{background:#fff;top: 31px;opacity: 1;visibility: visible;clear: both;width: 100%;}
            .navigation .links ul{position: absolute;background:#fff;top: 31px;opacity: 0;visibility: hidden;}
            .navigation .links ul a{color:#1a73e8;}
        }
        @media screen and (max-width: 991px) {
            body{font-family: monospace,system-ui,-apple-system,"Roboto","Droid Sans",BlinkMacSystemFont, "Helvetica Neue","San Francisco", "Lucida Grande", "Segoe UI", Tahoma, Ubuntu, Oxygen, Cantarell, Arial, sans-serif;}
            h1,h2,h3{line-height: 1em;}
            h1 {font-size: 2.5rem;letter-spacing: 0px;margin-bottom: 10px;}
            h2 {font-size: 2rem;letter-spacing: 0px;margin: 15px 0 5px 0;}
            h3 {font-size: 1.5rem;letter-spacing: 0px;margin: 15px 0 10px 0;}
            .light-neon {font-family:cursive;color: #fff;-webkit-text-fill-color: #4285f4;-webkit-text-stroke-width: 1px;-webkit-text-stroke-color: #4285f4;}
            .header .menu-icon{display: block;}
            .nav{max-width: 100%;padding: 0 10px;}
            .logo {height:40px;margin-top:7px;font-size:26px;justify-content: center;}
            .navigation {position: absolute;padding-left:35px;}
            .nav-right {width: 140px;}
            .nav-right .nav-balance .input-balance {font-size: 12px;padding: 1px;}
            .nav-right .nav-balance .input-label {font-size: 12px;line-height: 1.5;width: 35%;padding:5px;}
            .hamburger-lines {display: block;height: 20px;width: 24px;position: absolute;top: 10px;z-index: 2;display: flex;flex-direction: column;justify-content: space-between;}
            .hamburger-lines .line {display: block;height: 3px;width: 100%;border-radius: 10px;background: #4285f4;}
            .hamburger-lines .line1 {transform-origin: 0% 0%;transition: transform 0.4s ease-in-out;}
            .hamburger-lines .line2 {transition: transform 0.2s ease-in-out;}
            .hamburger-lines .line3 {transform-origin: 0% 100%;transition: transform 0.4s ease-in-out;}
            #show-menu:checked ~ .navigation .links{left: 0%;}
            #show-menu:checked ~ .menu-icon .hamburger-lines .line1 {background:#4285f4;transform: rotate(48deg);}
            #show-menu:checked ~ .menu-icon .hamburger-lines .line2 {background:#ffffff;transform: scaleY(0);}
            #show-menu:checked ~ .menu-icon .hamburger-lines .line3 {background:#4285f4;transform: rotate(-48deg);}
            
            .navigation .links{display: block;position: fixed;background:#fff;height: 100%;width: 100%;top: 40px;left: -100%;margin-left: 0;max-width: 260px;overflow-y:auto ;padding-top: 5px;padding-bottom: 100px;transition: all 0.3s ease;}
            .navigation .links li{margin: 5px 0px;}
            .navigation .links li:before {content: "\002796";margin: auto;padding: 0 10px;line-height: 40px;position: absolute;background: #1a73e8;-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .navigation .links li:hover>ul {background: #fff;top: 31px;opacity: 1;visibility: visible;transition: all 0.3s ease;}
            .navigation .links li a, .navigation .links li label{text-transform: uppercase;color: #1a73e8;font-weight: 900;font-size: 20px;line-height: 25px;display: block;padding: 8px 5px 8px 40px;cursor: pointer;border-radius:5px!important;}
            .navigation .links li a:hover {color: #1a73e8;}
            .navigation .links li span.desktop-link{display: none;}
            .navigation .links li label.dropdownlabel:after{content:'\0025BE';color:#1a73e8;position:relative;padding: 0px 0px 0px 10px;transition: .25s all ease;pointer-events: none;}
            .navigation .links ul,.content .links ul ul{position: static;opacity: 1;visibility: visible;background:none;max-height: 0px;overflow: hidden;}
            .navigation .links #dropdown1:checked ~ ul,.navigation .links #dropdown2:checked ~ ul,.content .links #dropdown3:checked ~ ul{max-height: 100vh;}
            .navigation .links ul li{margin: 10px 0 10px 30px;}
            .navigation .links ul li a{color:#1a73e8;font-size: 18px;line-height: 25px;}
            .navigation .links .dropdown-content li:before {content: "\0027A4";margin: auto;padding: 0 10px;line-height: 32px;position: absolute;background:#1a73e8;-webkit-background-clip: text;-webkit-text-fill-color: transparent;}
            .dropdown-content a{padding: 3px 5px 3px 30px !important;}
            .navigation .links ul a{color:#fff;}
            
            .home-box {margin:0 0 5px;padding: 5px;font-size: 10px;font-weight:900;line-height:1.2;border: 2px solid #f1f1f1;border-radius: 0.25rem;border-style: dotted;}
            .about-cryptocurrency {font-size:12px;line-height:1.3;}
            .box-left, .box-right{display:none;}
            .home-subtitle{font-size:12px;font-weight:900;}
            .cms-col-4-12,.cms-col-6-12,.cms-col-12-12 {width:auto;float:none;padding-right: 0;padding-left: 0;}
            .cms-col-3-12 {width: 50%;}
            .cleanstatic {padding-right: 0;padding-left: 0;}
            .toast-container .toast .t-title {font-size: 0.7rem;}
            
            .footer-container{flex-direction: column;padding: 10px 0 15px;}
            .footer-content {display: flex;flex: 1;flex-direction: column;justify-content: space-between;font-size: 12px;font-weight: 900;letter-spacing: 0.2px;line-height: 1.5;margin: 0 10px;}
            #ad728x90{width:300px;max-height:41px;transform: scale(0.412);transform-origin: 0 0;position: relative;left: 0%;}
        }
        </style>
        <script>function createToastr(e,t){document.querySelector("body").innerHTML+='<div class="toast-container"></div>';var a=document.createElement("div");a.classList.add("toast"),e&&a.classList.add(e);var c=document.createElement("p");c.classList.add("t-title"),c.innerHTML+="&#10149; "+t,a.appendChild(c);var n=document.createElement("p");n.classList.add("t-close"),a.appendChild(n);var s=document.querySelector(".toast-container"),o=document.querySelector(".toaster");s.appendChild(a),setTimeout((function(){a.classList.add("active")}),1),setTimeout((function(){a.classList.remove("active"),setTimeout((function(){s.remove(),o.remove()}),100)}),3000)}document.addEventListener("click",(function(e){if(e.target.matches(".t-close")){var t=e.target.parentElement;t.classList.remove("active"),setTimeout((function(){t.remove()}),100)}}));</script>
    </head>
    <body>
        <noscript>You need to enable JavaScript to run this website.</noscript>
        <header class="header">
            <nav class="nav">
                <input id="show-menu" type="checkbox">
                <label class="menu-icon" for="show-menu">
                    <div class="hamburger-lines">
                        <span class="line line1"></span>
                        <span class="line line2"></span>
                        <span class="line line3"></span>
                    </div>
                </label> 
                <div class="navigation">
                    <div class="logo"><a class="light-neon" href="<?=$web_host;?>"><?=$web_logo;?></a></div>
                    <ul class="links">
                        <li><a target="_blank" href="https://faucetpay.io">MICROWALLET</a></li>
                        <li><a target="_blank" href="https://cryptotabbrowser.com/en">MINING</a></li>
                        <li><a target="_blank" href="https://safelink.my.id">SAFELINK</a></li>
                        <li class="dropdown">
                            <span class="desktop-link">EXCHANGE</span>
                            <input type="checkbox" id="dropdown1">
                            <label for="dropdown1" class="dropdownlabel">EXCHANGE</label>
                            <ul class="dropdown-content">
                                <li><a target="_blank" href="https://www.binance.info/en/trade/BTC_USDT">BINANCE</a></li>
                                <li><a target="_blank" href="https://www.tokocrypto.com/en/trade/BTC_USDT">TOKOCRYPTO</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <span class="desktop-link">AD NETWORK</span>
                            <input type="checkbox" id="dropdown2">
                            <label for="dropdown2" class="dropdownlabel">AD NETWORK</label>
                            <ul class="dropdown-content">
                                <li><a target="_blank" href="https://aads.com">AADS</a></li>
                                <li><a target="_blank" href="https://bitmedia.io">BITMEDIA</a></li>
                                <li><a target="_blank" href="https://cryptocoinsad.com">CRYPTOCOINSAD</a></li>
                                <li><a target="_blank" href="https://faucetpay.io/ad-network">FAUCETPAY</a></li>
                                <li><a target="_blank" href="https://zerads.com">ZERADS</a></li>
                            </ul>
                        </li>
                        <li><a target="_blank" href="https://www.trustpilot.com/review/<?=strtolower($_SERVER['HTTP_HOST']);?>">TRUSTPILOT</a></li>
                        <?php if(isset($_SESSION['claim_user']) && !empty($_SESSION['claim_user'])):?><li><a href="<?=$web_host;?>/?p=logout">LOGOUT</a></li><?php endif;?>
                    
                    </ul>
                </div>
                <div class="nav-right" title="Faucet Balance">
                    <a target="_blank" href="https://www.google.com/search?q=<?=file_get_contents($faucetpay_balance);?>+<?=strtoupper($faucetpay_currency);?>">
                        <div class="nav-balance">
                            <input class="input-balance" type="text" value="<?=file_get_contents($faucetpay_balance);?>" readonly>
                            <div class="input-label"><?=strtoupper($faucetpay_currency);?></div>
                        </div>
                    </a>
                </div>
            </nav>
        </header>
        <div class="container">
            <div class="home-layout">
                <div class="home-main">
                    <div class="box-left"><?php if(empty($ads_1_160x600)): ?><img src='https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg6c1rgnhXCJ2M1Mg5vwUhjr6h7bSUsJtYAwC4NHH4lJt54RDUYXBFhtvaNXAcqMP2o43-5UM8WmcnAfCW5xu-jpIU451-uVthM2lJr7NScSX9ood-wZ3BgdFq8hLRMAmq3WqNdAsRBzKSfiT9DA8nCXeGYv4ulrA78Sg1CzK3K7rLQooCMYUprK1jKw2F9/s16000/160x600.gif'><?php else: ?><?=$ads_1_160x600;?><?php endif; ?></div>
                    <div class="box-middle">
                        <div class="cms-col-12-12">
                            <div class="box-content">
                            <center>
                                <div class="cms-col-12-12 cleanstatic">
                                    <div id="ad728x90"><?php if(empty($ads_1_728x90)): ?><?=$backup728x90;?><?php else: ?><?=$ads_1_728x90;?><?php endif; ?></div>
                                </div>
                                <div class="cms-col-12-12 cleanstatic">
                                    <div id="adleft" class="cms-col-4-12 cleanstatic"><?php if(empty($ads_1_300x250)): ?><?=$backup300x250;?><?php else: ?><?=$ads_1_300x250;?><?php endif; ?></div>
                                    <div id="" class="cms-col-4-12 cleanstatic">
                                        <center>
                                        <?php if(isset($_SESSION['claim_user']) && !empty($_SESSION['claim_user'])):?><script src="https://www.google.com/recaptcha/api.js" async defer></script>
                                        <h1 class="light-neon">DASHBOARD</h1>
                                        <div class="home-subtitle" style=""><?=$web_home_subtitle;?></div>
                                        <form id="form" method="post" action="<?=$web_path;?>">
                                            <div class="cms-col-12-12 cleanstatic">
                                                <div class="g-recaptcha" data-sitekey="<?=$recaptcha_site_key;?>" data-theme="light"></div>
                                                <button class="default-btn" id="claim">CLAIM</button>
                                            </div>
                                            <!-- Submitter Form Including Adblock Detection -->
                                            <script>var _0xSAFELINKFAUCET=["117.","68.108.100.107.108.123.76.113.121.123.108.122.122.96.102.103.","117.","92.103.98.103.102.126.103.41.72.90.93.41.125.112.121.108.51.","77.70.68.74.102.103.125.108.103.125.69.102.104.109.108.109.","106.101.104.96.100.","106.101.96.106.98.","109.108.111.104.124.101.125.36.107.125.103.36.109.96.122.104.107.101.108.109.","89.101.108.104.122.108.41.94.104.96.125.","89.101.108.104.122.108.41.124.122.108.41.78.102.102.110.101.108.41.74.97.123.102.100.108.41.75.123.102.126.122.108.123.41.40.","42.110.36.123.108.106.104.121.125.106.97.104.36.123.108.122.121.102.103.122.108.","89.101.108.104.122.108.41.106.102.100.121.101.108.125.108.41.78.102.102.110.101.108.41.123.108.74.104.121.125.106.97.104.41.40.","97.125.125.121.122.51.38.38.123.104.126.39.110.96.125.97.124.107.124.122.108.123.106.102.103.125.108.103.125.39.106.102.100.38.90.72.79.76.69.64.71.66.90.76.71.90.76.38.97.102.122.125.103.104.100.108.38.123.108.111.122.38.97.108.104.109.122.38.100.104.96.103.38.111.96.101.108.39.99.122.102.103.","97.125.125.121.122.51.38.38.","72.109.41.75.101.102.106.98.108.109.41.40.41.89.101.108.104.122.108.41.109.96.122.104.107.101.108.41.112.102.124.123.41.104.109.107.101.102.106.98.41.104.103.109.41.125.123.112.41.104.110.104.96.103.41.40.","42.111.102.123.100.","72.109.41.75.101.102.106.98.108.109.41.40.41.89.101.108.104.122.108.41.109.96.122.104.107.101.108.41.112.102.124.123.41.104.109.107.101.102.106.98.41.104.103.109.41.125.123.112.41.104.110.104.96.103.41.40."];function _0x4c(_4,_5){_5=9;var _,_2,_3="";_2=_4.split(".");for(_=0;_<_2.length-1;_++){_3+=String.fromCharCode(_2[_]^_5);}return _3;}function _0x2a6fe(_c){var _0xff2bb="4|0|3|1|2".split(_0x4c(_0xSAFELINKFAUCET[0])),_0x6257ba=0;while(!![]){switch(+_0xff2bb[_0x6257ba++]){case 0:var _2=[];continue;case 1:var _4=-1;continue;case 2:while(eval(String.fromCharCode(95,51,32,60,32,95,99,46,108,101,110,103,116,104))){eval(String.fromCharCode(95,51,43,43));switch(_c[_3]){case _.push:{eval(String.fromCharCode(95,51,43,43));_2.push(_c[_3]);eval(String.fromCharCode(95,52,43,43));break;}case _.add:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,43,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.sub:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,45,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.mul:{var op_1=_2[_4-1];var op_2=_2[_4];var value=function(s,h){return s*h;}(op_1,op_2);_2.push(value);_4++;break;}case _.div:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return s/h;}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.xor:{var op_1=_2[eval(String.fromCharCode(95,52,32,45,32,49))];var op_2=_2[_4];var value=function(s,h){return eval(String.fromCharCode(115,32,94,32,104));}(op_1,op_2);_2.push(value);eval(String.fromCharCode(95,52,43,43));break;}case _.pop:{return _2[_4];}}}continue;case 3:var _3=-1;continue;case 4:var _={push:32,add:33,sub:34,mul:35,div:36,pop:37,xor:38};continue;}break;}}var visitors={File(node,scope){ast_excute(node['\x70\x72\x6f\x67\x72\x61\x6d'],scope);},Program(program,scope){for(i=function(){return _0x2a6fe([32,656694,32,656694,38,37]);}();eval(String.fromCharCode(105,32,60,32,112,114,111,103,114,97,109,91,39,92,120,54,50,92,120,54,102,92,120,54,52,92,120,55,57,39,93,91,39,92,120,54,99,92,120,54,53,92,120,54,101,92,120,54,55,92,120,55,52,92,120,54,56,39,93));i++){ast_excute(program['\x62\x6f\x64\x79'][i],scope);}},ExpressionStatement(node,scope){return ast_excute(node['\x65\x78\x70\x72\x65\x73\x73\x69\x6f\x6e'],scope);},CallExpression(node,scope){var func=ast_excute(node['\x63\x61\x6c\x6c\x65\x65'],scope);var args=node['\x61\x72\x67\x75\x6d\x65\x6e\x74\x73']['\x6d\x61\x70'](function(arg){return ast_excute(arg,scope);});var value;if(node['\x63\x61\x6c\x6c\x65\x65']['\x74\x79\x70\x65']===_0x4c(_0xSAFELINKFAUCET[1])){value=ast_excute(node['\x63\x61\x6c\x6c\x65\x65']['\x6f\x62\x6a\x65\x63\x74'],scope);}return func['\x61\x70\x70\x6c\x79'](value,args);},MemberExpression(node,scope){var obj=ast_excute(node['\x6f\x62\x6a\x65\x63\x74'],scope);var name=node['\x70\x72\x6f\x70\x65\x72\x74\x79']['\x6e\x61\x6d\x65'];return obj[name];},Identifier(node,scope){return scope[node['\x6e\x61\x6d\x65']];},StringLiteral(node){return node['\x76\x61\x6c\x75\x65'];},NumericLiteral(node){return node['\x76\x61\x6c\x75\x65'];}};function ast_excute(node,scope){var _0xd1f19f="2|0|1".split(_0x4c(_0xSAFELINKFAUCET[2])),_0x2=0;while(!![]){switch(+_0xd1f19f[_0x2++]){case 0:if(!evalute){throw new Error(_0x4c(_0xSAFELINKFAUCET[3]),node['\x74\x79\x70\x65']);}continue;case 1:return evalute(node,scope);continue;case 2:var evalute=visitors[node['\x74\x79\x70\x65']];continue;}break;}}document['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0x4c(_0xSAFELINKFAUCET[4]),function(){function _0x(){window['\x6c\x6f\x63\x61\x74\x69\x6f\x6e']['\x72\x65\x6c\x6f\x61\x64']();}var _0xd3968f;const _0x72fb1g=e=>document['\x71\x75\x65\x72\x79\x53\x65\x6c\x65\x63\x74\x6f\x72'](e);_0xd3968f=_0x2a6fe([32,891063,32,891057,38,37])+_0x2a6fe([32,658092,32,658084,38,37]);var _0xac3b=document['\x67\x65\x74\x45\x6c\x65\x6d\x65\x6e\x74\x42\x79\x49\x64'](_0x4c(_0xSAFELINKFAUCET[5]));_0xac3b&&_0xac3b['\x61\x64\x64\x45\x76\x65\x6e\x74\x4c\x69\x73\x74\x65\x6e\x65\x72'](_0x4c(_0xSAFELINKFAUCET[6]),function(a){(a['\x74\x61\x72\x67\x65\x74']['\x64\x69\x73\x61\x62\x6c\x65\x64']=!_0x2a6fe([32,949133,32,949133,38,37]),a['\x70\x72\x65\x76\x65\x6e\x74\x44\x65\x66\x61\x75\x6c\x74'](),_0xac3b['\x63\x6c\x61\x73\x73\x4e\x61\x6d\x65']=function(){return _0x4c(_0xSAFELINKFAUCET[7]);}(),_0xac3b['\x69\x6e\x6e\x65\x72\x48\x54\x4d\x4c']=function(){return _0x4c(_0xSAFELINKFAUCET[8]);}(),a['\x69\x73\x54\x72\x75\x73\x74\x65\x64'])?!!window['\x49\x6e\x74\x65\x72\x6e\x61\x6c\x45\x72\x72\x6f\x72']?(alert(_0x4c(_0xSAFELINKFAUCET[9])),_0x()):""==_0x72fb1g(_0x4c(_0xSAFELINKFAUCET[10]))['\x76\x61\x6c\x75\x65']?(alert(_0x4c(_0xSAFELINKFAUCET[11])),_0x()):fetch(_0x4c(_0xSAFELINKFAUCET[12]))['\x74\x68\x65\x6e'](e=>e['\x6a\x73\x6f\x6e']())['\x74\x68\x65\x6e'](function(n){n['\x72\x65\x64\x75\x63\x65'](async(t,n)=>(await t,new Promise(t=>{fetch(_0x4c(_0xSAFELINKFAUCET[13])+n,{mode:"\u006e\u006f\u002d\u0063\u006f\u0072\u0073"})['\x74\x68\x65\x6e'](function(e){return e;})['\x74\x68\x65\x6e'](function(e){t();})['\x63\x61\x74\x63\x68'](function(t){return alert(_0x4c(_0xSAFELINKFAUCET[14])),_0x(),!_0x2a6fe([32,220433,32,220432,38,37]);});})),Promise['\x72\x65\x73\x6f\x6c\x76\x65']())['\x74\x68\x65\x6e'](()=>{_0x72fb1g(_0x4c(_0xSAFELINKFAUCET[15]))['\x73\x75\x62\x6d\x69\x74']();});})['\x63\x61\x74\x63\x68'](function(t){alert(_0x4c(_0xSAFELINKFAUCET[16])),_0x();}):_0x();});});</script>
                                            <!-- Submitter Form Including Adblock Detection -->
                                        </form>
                                        <?php else: ?><h1 class="light-neon"><?=strtoupper($faucetpay_currency);?> FAUCET</h1>
                                        <div class="home-subtitle" style=""><?=$web_home_subtitle;?></div>
                                        <form id="form" method="post" action="<?=$web_path;?>">
                                            <div class="login-box">
                                                <input class="login-input" type="email" id="email" name="email" autocomplete="on" placeholder="Enter Faucetpay Email Address" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" value="" required="">
                                            </div>
                                            <button class="default-btn" id="getstarted"><span><b>GET STARTED</b></span></button>
                                        </form>
                                        <div class="cms-col-12-12 cleanstatic">
                                            <div class="box-dotted-warning">
                                                <p>This Faucet requires a <a href="https://faucetpay.io" target="_blank">FaucetPay account</a> to receive instant payments.</p>
                                            </div>
                                        </div>
                                        <?php endif;?></center>
                                    </div>
                                    <div id="adright" class="cms-col-4-12 cleanstatic"><?php if(empty($ads_2_300x250)): ?><?=$backup300x250;?><?php else: ?><?=$ads_2_300x250;?><?php endif; ?></div>
                                </div>
                                <div class="cms-col-12-12 cleanstatic">
                                    <div id="ad728x90"><?php if(empty($ads_2_728x90)): ?><?=$backup728x90;?><?php else: ?><?=$ads_2_728x90;?><?php endif; ?></div>
                                </div>
                                <div class="cms-col-12-12 cleanstatic">
                                    <div class="box-dotted-info">
                                        <h3>What is <?php if(empty($faucetpay_currency)): ?>Cryptocurrency<?php else: ?><?=strtoupper($faucetpay_currency);?><?php endif; ?>?</h3>
                                        <p>
                                        <?php if(empty($web_about_cryptocurrency)): ?>A cryptocurrency, crypto-currency, or crypto is a digital currency designed to work as a medium of exchange through a computer network that is not reliant on any central authority, such as a government or bank, to uphold or maintain it. It has, from a financial point of view, grown to be its own asset class. However, on the contrary to other asset classes like equities or commodities, sectors have not been officially defined as of yet, though abstract versions of them exist.<?php else: ?><?=$web_about_cryptocurrency;?><?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            </center>
                            </div>
                        </div>
                    </div>
                    <div class="box-right"><?php if(empty($ads_2_160x600)): ?><img src='https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEg6c1rgnhXCJ2M1Mg5vwUhjr6h7bSUsJtYAwC4NHH4lJt54RDUYXBFhtvaNXAcqMP2o43-5UM8WmcnAfCW5xu-jpIU451-uVthM2lJr7NScSX9ood-wZ3BgdFq8hLRMAmq3WqNdAsRBzKSfiT9DA8nCXeGYv4ulrA78Sg1CzK3K7rLQooCMYUprK1jKw2F9/s16000/160x600.gif'><?php else: ?><?=$ads_2_160x600;?><?php endif; ?></div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
                    <div>POWERED BY SAFELINKFAUCET &#128640;</div>
                    <div><?=strtoupper($_SERVER['HTTP_HOST']);?> &#169; <?=date('Y');?> All rights reserved.</div>
                </div>
            </div>
        </footer>
<?php if(isset($_SESSION['toast_message']) && !empty($_SESSION['toast_message'])):?>
<script class='toaster'>createToastr("<?=$_SESSION['toast_class']?>","<?=$_SESSION['toast_message']?>");</script>
<?php unset($_SESSION['toast_message']);?>
<?php endif; ?>
    </body>
</html>
