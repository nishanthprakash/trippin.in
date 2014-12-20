<?php


error_reporting(E_ALL);

require_once 'includes/summarizer.php';
require_once 'includes/html_functions.php';

$summarizer = new Summarizer();

if (!empty($_POST['text'])){

	$text = $_POST['text'];
	

	$text = normalizeHtml($text);

	$rez = $summarizer->summary($text);

	

	$summary = implode(' ',$rez);
	//echo '</pre>';
}

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div align='center'>
<form method='POST' action='test_summarizer.php'>
<h3>Text Summarizer</h3>
<textarea name='text' cols='50' rows='10'><?php 
	echo !empty($_POST['text'])?htmlspecialchars($_POST['text']):''; 
?></textarea><br/>
<input type='submit' name='submit' value='Summarize'>
</form>
<?php
	if(!empty($summary)) echo $summary;
?>
</div>