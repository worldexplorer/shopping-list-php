<? require_once "_code.php" ?>
<?

//plog(pr($uprofile));
//plog(pr($_COOKIE));

$title .= " " . $unhashed["person_ident"] . " ?";
$mmenu_content = hash_by_tpl($unhashed, $mmenu_content);

$person_ident = $unhashed["person_ident"];
if ($mode == "logoff") {
	logoff_person();
	redirect("auth.php");
}

$mmenu_content = hash_by_tpl($unhashed, $mmenu_content);

?>

<? require "_top.php" ?>

<? // if (isset($_SESSION["person"]) && $_SESSION["person"] > 0) { ?>
<? if ($unhashed["person"] > 0 && $mode != "logoff") { ?>

	<?=$mmenu_content?>
	
	<table border=0 align-disabled=center>
	<form method="post">
	<input type=hidden name=mode value=logoff>
		
	<tr valign=top>
		<td>
			<input type=submit value="    Да    ">
			<input type=button value=" Отмена " onclick="javascript:history.back()">
		</td>
	</tr>
	
	</form>
	</table>
<? } else { ?>
	
	<? 
	$msg_logged_off = select_field("content", array("hashkey" => "MSG_LOGGED_OFF"), "constant");
	$table = hash_by_tpl(array("person_ident" => $person_ident), $msg_logged_off);
	?>
	
	<?=$table?>
	
	<? //require "auth.php" ?>

<? } ?>

<? require "_bottom.php" ?>
