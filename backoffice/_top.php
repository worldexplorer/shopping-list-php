<? if ($is_inline == 0) { ?>
<html>


<head>
<?
if (isset($title_string)) {
	$title_string = $pagetitle_separator . $title_string;
} else {
	$title_string = "";

	if ($entity_msg_h != "" && $entity_msg_h != "Entity_msg") {
		$title_string .= $pagetitle_separator . $entity_msg_h;
	}
	if ($id > 0) {
		$title_string .= $pagetitle_separator . select_field("ident");
	}
}

$title_string = stripslashes($title_string);
$title_string = strip_tags($title_string);
?>
<title><?=$site_name?> <?=$title_string?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?=$html_content_type_encoding_charset?>">
<link href="default.css" type="text/css" rel="stylesheet">

<!--link rel="shortcut icon" href="/favicon.gif" type="image/gif">
<link rel="icon" href="/favicon.gif" type="image/gif"-->

<? if ($FTB_version == "303-disabled") { ?>
<link href="/_FTB303/FTB-<?=$FTB_Style?>.css" type="text/css" rel="stylesheet">
<script src="/_FTB303/FTB-Utility.js" type="text/javascript"></script>
<script src="/_FTB303/FTB-FreeTextBox.js" type="text/javascript"></script>
<script src="/_FTB303/FTB-ToolbarItems.js" type="text/javascript"></script>
<script src="/_FTB303/FTB-Pro.js" type="text/javascript"></script>
<? } ?>


<script src="js/script.js" type="text/javascript"></script>

<script>
function body_onload() {
<? if ($alertmsg != "") { ?>
	alert('<?=$alertmsg?>')
<? } ?>
<? if ($_submenu_forms != "") { ?>
	focus_itname("q", "form_submenu")
<? } ?>
}
</script>


<? if ($header_include != "") { ?>
<!-- header_include -->
<?=$header_include?>
<!-- /header_include -->
<? } ?>

</head>

<body onload="body_onload()">

<? if ($body_include != "") { ?>
<!-- body_include -->
<?=$body_include?>
<!-- /body_include -->
<? } ?>

<?
$mobile = $entity == "m2m_team_question" && get_number("team") > 0;
$outerTable_width = $mobile ? "" : "width=100%";
?>

<table cellpadding=0 cellspacing=0 border=0 <?=$outerTable_width?> >
<tr valign=top>

<!--td width=50-->
<td width=1>
	<?
		$uncollapser = "";
		$menu_collapser_display = "block";
		if ($entity == "m2m_team_question" && get_number("team") > 0) {
			$menu_collapser_display = "none";
			$uncollapser = <<<EOT
<a href='javascript:uncollapse()'><img src='img/down.gif' width='10' height='6' hspace=6 border='0' alt=''>Вернуться из мобильной в полноценную версию</a>&nbsp;&nbsp;
EOT;
			echo "<style>body {margin: 0}</style>";
		}
	?>
	<div id='layer_999' style='display: <?=$menu_collapser_display?>'>	
		<? require "_menu.php" ?>
	</div>
</td>
<? require "_submenu.php" ?>
<?=$_submenu_forms?>
<td style="width:1px;"></td>
<td>

<table cellpadding=0 cellspacing=3>
<tr><td><?=$uncollapser?><?=$errormsg?>&nbsp;</td></tr>
</table>
<table cellpadding=0 cellspacing=3 width=100%>

<tr><td colspan=2>

<!-- TOP END -->
<? } ?>
