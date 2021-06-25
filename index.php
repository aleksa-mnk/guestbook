<?php

$commentsFolder = __DIR__ . '/messages';
if (!is_dir($commentsFolder)) {
	mkdir($commentsFolder);
}

$author = $_POST['author'];
$email = $_POST['email'];
$text = $_POST['message'];

if (trim($author) != "" && trim($text) != "" && filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$time = microtime();
	$file = $commentsFolder."/$time.txt";
	$fp = $author."\n";
	$fp .= $email."\n";
	$fp .= $text;
	file_put_contents($file, $fp);
} else {
	echo '<span>Error while adding your message.</span>';
}

$commentFiles = array_slice(scandir($commentsFolder), 2);
foreach ($commentFiles as $commentFile) {
	$fileContent = file("$commentsFolder/$commentFile");
	echo '<p>'.htmlspecialchars($fileContent[0]).'</p>';
	echo '<a href="mailto:'. htmlspecialchars($fileContent[1]) .'">' . htmlspecialchars($fileContent[1]) . '</a>';
	echo '<p>';
	foreach (array_slice($fileContent, 2) as $commentLine) {
		echo htmlspecialchars($commentLine);
	}
	echo '</p>';
}
?>

<form method="POST">
	<p>Your name: <input type="text" name="author"/></p>
	<p>Email: <input type="text" name="email"/></p>
	<p>Comment: <textarea name="message"></textarea></p>
	<p><input type="submit"/></p>
</form>