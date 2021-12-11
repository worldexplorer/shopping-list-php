<? require_once "../_lib/_init.php" ?>
<?

$poll = $id;
require "../_poll-rendered.php";		//$poll_rendered

?>



<html>
<head>
	<title><?=$site_name?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="default.css">
</head>
<body topmargin=0 bottommargin=0 leftmargin=0 rightmargin=0>

<center>

<table cellpadding=0 cellspacing=0><tr valign=center><td align=center>

<table cellpadding=0 cellspacing=0><?=$poll_rendered?></table>

<p><input type="button" value="закрыть" onclick="javascript:window.close();"></p>


</tr></td></table>
</center>

</body>

</html>