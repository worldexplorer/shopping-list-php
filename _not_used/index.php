<? require "_code.php" ?>
<?

$poll = 2;


$m2mcb_colcnt = 1;
$radio_colcnt = 7;


$backrow_tpl = <<< EOT
<div class=answer-option style="background-color:#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<div class=answer-line>
		#OBLIGATORY_SIGN#
		<label class=answer-line-label for="#IT_NAME#">
			#IT_TXT#
		</label>
	</div>
	<div class=answer-comment>
		#IT_WRAPPED#
		#IT_GRAYCOMMENT_GRAY#
	</div>
</div>
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
<div class=question-container style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#">
	#OBLIGATORY_SIGN#
	<label class="question" for="#IT_NAME#">#IT_TXT#</label>
	<div class=answers>
		#IT_WRAPPED#
	</div>
</div>
EOT;

$icwhose_rendered = multicompositeiccontent(
	$m2m_table, $m2m_fixedhash, $absorbing_fixedhash,
	$icwhose_id_selected
	);

if ($poll > 0) {	
	$tpl_comment_above = "";
	if ($poll_row["comment_above"] != "") {
		$tpl_comment_above = "#COMMENT_ABOVE#";
	}

	$tpl_comment_below = "";
	if ($poll_row["comment_below"] != "") {
		$tpl_comment_below = "#COMMENT_BELOW#";
	}

	$tpl_save_label = $msg_bo_save;
	if ($poll_row["save_button_label"] != "") {
		$tpl_save_label = $poll_row["save_button_label"];
	}


	$icwhose_rendered = <<<EOT
<div class="poll-container" style="background-color: #BACKGROUND_COLOR_WHATSAPP#" title="#TOOLTIP#">
	<h1>#IDENT#</h1>
	<div class=poll-comment-above>
		$tpl_comment_above
	</div>

	$icwhose_rendered

	<div class=poll-comment-below>
		$tpl_comment_below
	</div>

	<div class=poll-submit>
		<input type=submit value="$tpl_save_label">
	</div>
</div>
EOT;

	$icwhose_rendered = hash_by_tpl($poll_row, $icwhose_rendered);
	
	$markers = array(
		"BACKGROUND_COLOR_WHATSAPP" => BACKGROUND_COLOR_WHATSAPP,
		"PERSON_IDENT" => $unhashed["person_ident"],
	);
	$icwhose_rendered = hash_by_tpl($markers, $icwhose_rendered);
	
}


$in_backoffice = $in_backoffice_backup;
$backrow_tpl = $backrow_tpl_backup;



?>
<? require "_top.php" ?>

<?=$mmenu_content?>

<form>
	<?=$icwhose_rendered?>
</form>

<? require "_bottom.php" ?>
