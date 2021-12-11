<? require "_code.php" ?>
<?

$poll = $id;


$m2mcb_colcnt = 1;
$radio_colcnt = 7;


$backrow_tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <font class="name"><label for="#IT_NAME#">#IT_TXT#</label></font></td>
	<td>#IT_WRAPPED# #IT_GRAYCOMMENT_GRAY#</td>
</tr>
EOT;
$backrow_obligatory_sign = "<font color=red title='это поле обязательно для заполнения'>*</font>&nbsp;&nbsp;";

$icwhose_id_selected = 0;
if ($poll > 0) {
	$poll_row = select_entity_row(array("id" => $poll), "poll");
//	$icwhose_row = select_entity_row(array("id" => $poll_row("icwhose")), "icwhose");
//	$icwhose_id_selected = $icwhose_row["id"];
	$icwhose_id_selected = select_field("id", array("id" => $poll_row["icwhose"]), "icwhose");
}

//$m2m_table = "m2m_{$entity}_iccontent";
$m2m_table = "m2m_person_pollanswer";		// pointing to an existing m2m table with person=0 => zero selection; I need no personal data here anyway
$m2m_fixedhash = array();
$absorbing_fixedhash = array("poll" => "_global:id");
//"inbrief" => 

$multicompositeiccontent_wrap_into_layer_open = false;


$in_backoffice_backup = $in_backoffice;
$in_backoffice = 0;

$backrow_tpl_backup = $backrow_tpl;
$backrow_tpl = <<<EOT
<tr style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#" valign=top>
	<td>
		#OBLIGATORY_SIGN# <font class="name"><label for="#IT_NAME#">#IT_TXT#</label></font>
		<div style="padding: 1ex 0 1ex 4ex">
			#IT_WRAPPED#
		</div>
	</td>
</tr>
EOT;

$icwhose_rendered = multicompositeiccontent(
	$m2m_table, $m2m_fixedhash, $absorbing_fixedhash,
	$icwhose_id_selected
	);

if ($poll > 0) {	
	$tpl_comment_above = "";
	if ($poll_row["comment_above"] != "") {
		$tpl_comment_above = <<<EOT
				<tr style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#">
					<td>
						#COMMENT_ABOVE#
					</td>
				</tr>
EOT;
	}

	$tpl_comment_below = "";
	if ($poll_row["comment_below"] != "") {
		$tpl_comment_below = <<<EOT
				<tr style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#">
					<td>
						#COMMENT_BELOW#
					</td>
				</tr>
EOT;
	}

	$tpl_save_label = $msg_bo_save;
	if ($poll_row["save_button_label"] != "") {
		$tpl_save_label = $poll_row["save_button_label"];
	}


	$icwhose_rendered = <<<EOT
<tr>
	<td></td>
	<td>
		<div style="padding: 2ex; border: 1px solid gainsboro; background-color: #BACKGROUND_COLOR_WHATSAPP#; float: left" title="#TOOLTIP#">
			<h1>#IDENT#</h1>
			<table cellspacing=0 cellpadding=5>
				$tpl_comment_above
				$icwhose_rendered
				$tpl_comment_below
				<tr style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#">
					<td align=center>
						<div style="padding: 1ex 0 1ex 0">
							<input type=submit value="$tpl_save_label">
						</div>
					</td>
				</tr>
			</table>
		</div>
	</td>
</tr>	
EOT;

	$icwhose_rendered = hash_by_tpl($poll_row, $icwhose_rendered);
	
	$markers = array("BACKGROUND_COLOR_WHATSAPP" => BACKGROUND_COLOR_WHATSAPP);
	$icwhose_rendered = hash_by_tpl($markers, $icwhose_rendered);
	
}


$in_backoffice = $in_backoffice_backup;
$backrow_tpl = $backrow_tpl_backup;



?>
<? require "_top.php" ?>

<?=$mmenu_content?>

<form>
<table cellpadding=0 cellspacing=0><?=$icwhose_rendered?></table>
</form>

<? require "_bottom.php" ?>
