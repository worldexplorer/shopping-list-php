<html>

<head>
	<title><?=$site_name?><?=$pagetitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" >
	<meta http-equiv="pragma" content="no-cache">

<? if ($meta_keywords != "") { ?>
	<meta name="keywords" content="<?=$meta_keywords?>">
	<meta http-equiv="keywords" content="<?=$meta_keywords?>">
<? } ?>

<? if ($meta_description != "") { ?>
	<meta name="description" content="<?=$meta_description?>">
	<meta http-equiv="description" content="<?=$meta_description?>">
<? } ?>

	<link rel="stylesheet" type="text/css" href="default.css">
	<script src="script.js" type="text/JavaScript"></script>
	<script src="jquery.js" type="text/JavaScript"></script>
	<script src="jquery_custom.js" type="text/JavaScript"></script>

<? if ($alertmsg != "") { ?>
<!-- moved to _bottom because of Mozilla shows clean page -->
<!--script>
alert("<?=$alertmsg?>");
</script-->
<? } ?>

<?
if ($print == 1) {
	$onload .= " onload='window.print()'";
}
?>

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

<? if ($print == 1) echo "<noindex>" ?>

<body <?=$onload?> >

<table border=0 cellpadding=4 cellspacing=5 width=100%>

<? if ($popup == 0) { ?>
<? if ($print == 0) { ?>

<tr valign=top><td colspan=3 align=center class="border" height=1 ondblclick="javascript:popup_bo('constant-edit.php?id=3')"><?=$content_top?></td></tr>

<tr valign=top>
	<!--td class="border" align=center><?//$content_logo?></td-->
	<td colspan=3 class="border" height=1><? require "_menu_top.php" ?></td>
</tr>

<? if ($mmenu_id == 777) { ?>

<!--tr valign=top>
	<td rowspan=2 class="border" width=160>
	<table cellpadding=0 cellspacing=0 style="width:160px"></table>
	<?//require "_menu_left_hot.php" ?>
	</td>
</tr-->

<? } else { ?> 

<tr valign=top>
	<td rowspan=2 class="border" width=1%>
	<table cellpadding=0 cellspacing=0 style="width:160px; border:0px solid gray"><tr><td></td></tr></table>

<?
switch ($entity) {
/*	case "index":
		require "_menu_left_hot.php";
		break;
*/

	case "ngroup":
	case "news":
		require "_menu_left_ngroup.php";
		break;

/*	case "faq":
		require "_menu_left_consultant.php";
		break;
*/


	//case "index":
	case "cat":
	case "pgroup":
	case "product":
	case "search":
		require "_menu_left_pgrouptree.php";
		break;
	
	case "supplier":
		require "_menu_left_supplier-pmodel.php";
		break;

	case "mmenu":
		if ($mmenu_id == 6) {
			require "_menu_left_pgrouptree.php";
		} else {
			require "_menu_left.php";
		}
		break;

	default:
		require "_menu_left.php";
//		require "_menu_left_pgrouptree.php";
}
?>

<?
if ($entity != "auth") {
	echo <<< EOT
<br><br>
<iframe src="_auth_frame.php" width="160" height="240" marginwidth="0" marginheight="0" scrolling="no" frameborder="0" name="auth_frame"></iframe>
EOT;
}

?>

	</td>

	<td colspan=2 height=1><div class=path><?=$path_HTML?></div></td>
</tr>
<? } ?>

<? } // print?>
<? } // popup?>

<tr valign=top>
	<td class="border" style="padding-left: 3ex; padding-right: 3ex;" height=400 valign=top>
<? if ($mmenu_id != 333) { ?>
		<table cellpadding=0 cellspacing=0 width=100% border=0>
		<tr>
			<td><h3><?=$title?></h3></td>
			<td align=right><?=$title_right?></td>
		</tr>
		</table>
<? } ?>

	<div class=content>
<!-- TOP END -->
