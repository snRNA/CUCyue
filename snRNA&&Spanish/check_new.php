<?php
$token = '0';
if(isset($_POST['stuid'])){
	$stuid=$_POST['stuid'];
}
else
{
	returnquery('1',$token);
}
?> 

<?php
include ("../new/php/token.php");
$token = genToken();
$cookieVerify = dirname(__FILE__)."/checkusr/".$_POST['stuid'].".tmp";
$cookieSuccess = dirname(__FILE__)."/checkusr/".$_POST['stuid']."p.tmp";


$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "http://jw.cuc.edu.cn/academic/index.jsp");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieVerify);
$rs = curl_exec($ch);
curl_close($ch); 

// 带上cookie抓取验证码，必须带上cookie，否则验证码不对应
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, "http://jw.cuc.edu.cn/academic/getCaptcha.do");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieVerify);
$rs = curl_exec($ch);
// 把验证码在本地生成，二次拉取验证码可能无法通过验证
$captcha_image = "checkusr/".$_POST['stuid']."verify.jpg";
@file_put_contents($captcha_image,$rs);
curl_close($ch); 


include ("../new/php/conn.php");
$result = mysql_query("INSERT INTO captcha(stuid,token,cookie,url)VALUES('$stuid','$token','$cookieVerify','$captcha_image')");
if(!$result)
{
	returnquery('2',$token);
}
returnquery('0',$token);
?>

<?php
function returnquery($error_code,$token){
    $val['flag'] = $error_code;
    $val['token'] = $token;
    $json = json_encode($val);
    unset ($val);       
    echo $json; 
    exit;
}
?>