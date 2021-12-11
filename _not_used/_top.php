<html>

<head>
	<title><?=$site_name?><?=$pagetitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$html_content_type_encoding_charset?>">
	<meta http-equiv="pragma" content="no-cache">

<? if ($meta_keywords != "") { ?>
	<meta name="keywords" content="<?=$meta_keywords?>">
	<meta http-equiv="keywords" content="<?=$meta_keywords?>">
<? } ?>

<? if ($meta_description != "") { ?>
	<meta name="description" content="<?=$meta_description?>">
	<meta http-equiv="description" content="<?=$meta_description?>">
<? } ?>

	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700,700italic|Playfair+Display:400,700&subset=latin,cyrillic">
  	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.css">

	<link rel="stylesheet" type="text/css" href="css/decorations.css">
	<link rel="stylesheet" type="text/css" href="css/default.css">
	<link rel="stylesheet" type="text/css" href="css/images.css">
	<link rel="stylesheet" type="text/css" href="css/inputs.css">
	<link rel="stylesheet" type="text/css" href="css/lists.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/poll.css">
	<link rel="stylesheet" type="text/css" href="css/tables.css">
	
	<script src="script.js" type="text/JavaScript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>

<? if ($alertmsg != "") { ?>
<!-- moved to _bottom because of Mozilla shows clean page -->
<!--script>
alert("<?=$alertmsg?>");
</script-->
<? } ?>

<!-- jsv_flush_validation_functions_and_core -->
<?=jsv_flush_validation_functions_and_core()?>
<!-- /jsv_flush_validation_functions_and_core -->

<?
/*
if ($jsv_body != "") {
	echo <<< EOT
<script>
function form_edit_submit() {
//	alert ("validations here");
	$jsv_body
	
	document.form_edit.submit()
}
</script>

EOT;
	echo jsv_core();
}
*/
?>

</head>

<body <?=$onload?> >


<?
if ($entity == "auth-DISABLED") {
	echo <<< EOT
<br><br>
<iframe src="_auth_frame.php" width="160" height="240" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" name="auth_frame"></iframe>
EOT;
}

?>

<div class=content>
<!-- TOP END -->
