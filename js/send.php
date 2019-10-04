 <?php
 
	$to = 'sank.webdev@ya.ru';


	$mail  = substr( $_POST['email'], 0, 64 );
	$tel = substr( $_POST['tel'], 0, 64 );
	$name = substr( $_POST['name'], 0, 64 );
	$width = substr( $_POST['width'], 0, 64 );
	$height = substr( $_POST['height'], 0, 64 );
	$type = substr( $_POST['type'], 0, 64 );
	$email   = "admin@website.com";
	$message = substr( $_POST['message'], 0, 1000 );
	$form = substr( $_POST['form'], 0, 1000 );
 
 
	$body = "";

	if ($name) {
		$body .= "Имя:\r\n".$name."\r\n\r\n";
	}

	if ($tel) {
		$body .= "Контактный телефон:\r\n".$tel."\r\n\r\n";
	}
	
	if ($mail) {
		$body .= "E-mail:\r\n".$mail."\r\n\r\n";
	}

	if ($width) {
		$body .= "Ширина:\r\n".$width."\r\n\r\n";
	}

	if ($height) {
		$body .= "Высота:\r\n".$height."\r\n\r\n";
	}

	if ($type) {
		$body .= "Тип зеркала:\r\n".$type."\r\n\r\n";
	}
	
	if ($message) {
		$body .= "Сообщение:\r\n".$message."\r\n\r\n";
	}

	if ($form) {
		$body .= "Форма:\r\n".$form;
	}
 
	send_mail($to, $body, $email, $filepath, $filename);





// Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($to, $body, $email, $filepath, $filename)
{
	$subject = 'Заявка с сайта ' . $_SERVER['HTTP_HOST'];
	$boundary = "--".md5(uniqid(time())); // генерируем разделитель
	$headers = "From: ".$email."\r\n";   
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
	$multipart = "--".$boundary."\r\n";
	$multipart .= "Content-type: text/plain; charset=\"utf-8\"\r\n";
	$multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

	$body = $body."\r\n\r\n";
 
	$multipart .= $body;

	$file = '';

	if (isset($_FILES['file'])) {
		
		echo "file - ok\n";
		foreach($_FILES as $attachment){

			$filepath = $attachment['tmp_name'];
			$filename = $attachment['name'];


			for ($i=0; $i < count($filepath); $i++) { 

				if ( !empty( $filepath[$i] ) ) {

					print_r($filename[$i]);
					echo "\n";

					$fp = fopen($filepath[$i], "r");
					if ( $fp ) {
						$content = fread($fp, filesize($filepath[$i]));
						fclose($fp);
						$file .= "--".$boundary."\r\n";
						$file .= "Content-Type: application/octet-stream\r\n";
						$file .= "Content-Transfer-Encoding: base64\r\n";
						$file .= "Content-Disposition: attachment; filename=\"".$filename[$i]."\"\r\n\r\n";
						$file .= chunk_split(base64_encode($content))."\r\n";
					}
				}

			}

		}

	} else {
		echo "file - error";
	}

	




	$multipart .= $file."--".$boundary."--\r\n";
	mail($to, $subject, $multipart, $headers);
}
?>







<!--   ######  ##     ##  #######  ########  ########  -->
<!--  ##    ## ##     ## ##     ## ##     ##    ##     -->
<!--  ##       ##     ## ##     ## ##     ##    ##     -->
<!--   ######  ######### ##     ## ########     ##     -->
<!--        ## ##     ## ##     ## ##   ##      ##     -->
<!--  ##    ## ##     ## ##     ## ##    ##     ##     -->
<!--   ######  ##     ##  #######  ##     ##    ##     -->




<!--
if ($name) {
		$body .= "<b>Имя:</b><br>".$name."<br><br>";
	}

	if ($tel) {
		$body .= "<b>Контактный телефон:</b><br>".$tel."<br><br>";
	}
	
	if ($mail) {
		$body .= "<b>E-mail:</b><br>".$mail."<br><br>";
	}
	
	if ($message) {
		$body .= "<b>Сообщение:</b><br>".$message."<br><br>";
	}

	if ($form) {
		$body .= "<b>Форма:</b><br>".$form;
	}
 
	send_mail($to, $body, $email, $filepath, $filename);





// Вспомогательная функция для отправки почтового сообщения с вложением
function send_mail($to, $body, $email, $filepath, $filename)
{
	$subject = 'Заявка с сайта ' . $_SERVER['HTTP_HOST'];
	$boundary = "--".md5(uniqid(time())); // генерируем разделитель
	$headers = "From: ".$email."\r\n";   
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .="Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";
	$multipart = "--".$boundary."\r\n";
	$multipart .= "Content-type: text/html; charset=\"utf-8\"\r\n";
	$multipart .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

	$body = $body."\r\n\r\n";
 
	$multipart .= $body;

	$file = '';


	$multipart .= $file."--".$boundary."--\r\n";
	mail($to, $subject, $multipart, $headers);
}
?>
-->