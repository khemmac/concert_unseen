<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>TEST PAGE</title>
	</head>
	<body>
		<h1><?= form_error() ?></h1>
		<?= form_open_multipart('test/upload_submit'); ?>
		<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />
		<?= form_close() ?>
	</body>
</html>


