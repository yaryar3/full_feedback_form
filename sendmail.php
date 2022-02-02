<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	
	$mail->setFrom($_POST['email'], $_POST['name']);
	
	$mail->addAddress('flames07@ya.ru');
	
	$mail->Subject = 'Обращение в техподдержку';

	
	$body = '<h1>Заявка!</h1>';
	
	if(trim(!empty($_POST['name']))){
		$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
	}
	if(trim(!empty($_POST['email']))){
		$body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
	}
	if(trim(!empty($_POST['phone']))){
		$body.='<p><strong>Номер телефона:</strong> '.$_POST['phone'].'</p>';
	}
	if(trim(!empty($_POST['select1']))){
		$body.='<p><strong>Категория запроса:</strong> '.$_POST['select1'].'</p>';
	}
	if(trim(!empty($_POST['inst']))){
		$body.='<p><strong>Ник в инстаграмме:</strong> '.$_POST['inst'].'</p>';
	}
	if(trim(!empty($_POST['select2']))){
		$body.='<p><strong>По какому продукту вопрос:</strong> '.$_POST['select2'].'</p>';
	}
	if(trim(!empty($_POST['message']))){
		$body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
	}
	
	//Прикрепляем файл
	if (!empty($_FILES['image']['tmp_name'])) {
		//путь загрузки файла
		$filePath = __DIR__ . "/files/" . $_FILES['image']['name']; 
		//загрузка файл
		if (copy($_FILES['image']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Скриншот в письме</strong>';
			$mail->addAttachment($fileAttach);
		}
	}

	$mail->Body = $body;

	//Отправка
	if (!$mail->send()) {
		$message = 'Ошибка';
	} else {
		$message = 'Данные отправлены!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>