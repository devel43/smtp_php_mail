<?php


$smtp_server = "smtp.beget.ru";	// Адрес smtp сервера
$smtp_login = "admin@bastion-kolomna.ru";	// Логин почтового сервера(если домен русский, то использовать "punchcode")
$smtp_pass = "mc28kR0eHw}n5";	// Пароль почтового сервера


//Тема письма
$mail_subject = "Тема этого письма крайне информативна";


// Адрес получателя
$target_email = "devel43@gmail.com";

//От кого письмо(текст)
$from_name = "отправитель";

//Заголовок в письме
$into_mail_subject = "Тестовый заголовок в письме";




$name = stripslashes($_POST['name']);
$phone = stripslashes($_POST['phone']);
$subject2 = stripslashes($_POST['service']);
$message2 = stripslashes($_POST['message']);

function get_data($smtp_conn)
{
  $data="";
  while($str = fgets($smtp_conn,515))
  {
    $data .= $str;
    if(substr($str,3,1) == " ") { break; }
  }
  return $data;
}

$post = (!empty($_POST)) ? true : false;
$post = (!empty($_POST)) ? true : false;



// настройка заголовков для почтовиков
$header="Date: ".date("D, j M Y G:i:s")." +0700\r\n";
$header.="From: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($from_name)))."?= <" . $from_name . ">\r\n";
$header.="X-Mailer: The Bat! (v3.99.3) Professional\r\n";
$header.="Reply-To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($from_name)))."?= <" . $from_name . ">\r\n";
$header.="X-Priority: 3 (Normal)\r\n";
$header.="Message-ID: <172562218.".date("YmjHis")."@mail.ru>\r\n";
$header.="To: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($from_name)))."?= <INFO@xn----8sbitikm1ac.xn--p1ai>\r\n";
$header.="Subject: =?UTF-8?Q?".str_replace("+","_",str_replace("%","=",urlencode($mail_subject)))."?=\r\n";
$header.="MIME-Version: 1.0\r\n";
$header.="Content-Type: text/html; charset=UTF-8\r\n";
$header.="Content-Transfer-Encoding: 8bit\r\n";



// вёрстка самого письма
$text=
"<html lang='ru'>
	<body style='color:#333;'>
		<h1>".$into_mail_subject."</h1>
		<p><b>Имя: </b>".$name."</p>
		<p><b>Телефон или email: </b>".$phone."</p>
		<p><b>Тема сообщения: </b>".$subject2."</p>
		<p><b>Ттекст сообщения: </b>".$message2."</p>
	</body>
</html>";





$smtp_conn = fsockopen($smtp_server, 2525,$errno, $errstr, 10); 

$data = get_data($smtp_conn);

fputs($smtp_conn,"EHLO " . $smtp_server . "\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,"AUTH LOGIN\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,base64_encode($smtp_login)."\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,base64_encode($smtp_pass)."\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,"MAIL FROM:" . $smtp_login . "\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,"RCPT TO:" . $target_email ."\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,"DATA\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,$header."\r\n".$text."\r\n.\r\n");
$data = get_data($smtp_conn);

fputs($smtp_conn,"QUIT\r\n");
$data = get_data($smtp_conn);

$code = substr($data,0,3);

echo $code;

?>