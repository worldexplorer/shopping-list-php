<?

//$poll = 2;

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
//$absorbing_fixedhash = array("poll" => "_global:id");
$absorbing_fixedhash = $in_backoffice
	? array("poll" => $poll)
	: array("poll" => $poll, "person" => $unhashed["person"]);
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

//$debug_query = 1;
$poll_rendered = multicompositeiccontent(
	$m2m_table, $m2m_fixedhash, $absorbing_fixedhash,
	$icwhose_id_selected
	);
//$debug_query = 0;

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


	$person_index_among_poll_admins = -1;
	if (isset($unhashed) && isset($unhashed["person"])) {
		$person_index_among_poll_admins = strpos($poll_row["admins_csv"], $unhashed["person"]);
//		echo	'$unhashed[person]: ' . $unhashed["person"] . '<br>' .
//				'$poll_row[admins_csv]: ' . $poll_row["admins_csv"] . '<br>' .
//				'$person_index_among_poll_admins: ' . $person_index_among_poll_admins . '<br>';
	} else {
		pr('NOT: isset($unhashed) && isset($unhashed["person"])');
	}	
	$person_is_poll_admin = $person_index_among_poll_admins === -1 ? 0 : 1;
//	echo '$person_is_poll_admin: ' . $person_is_poll_admin . '<br>';
	

	$caption_if_poll_admin = $person_is_poll_admin == 0 || $in_backoffice_backup == 0
		? "" : "<caption>Пользователю</caption>";
	$menu_for_user = <<<EOT
		<table>
			$caption_if_poll_admin
			<tr><td>
			<ul>
				<li><a href="javascript:alert('test')">я не #PERSON_IDENT#!</a></li>
				<li><a href="javascript:alert('test')">добавить в календарь: ICS</a></li>
				<li><a href="javascript:alert('test')">переправить тому кого нет в чате</a></li>
				<li><a href="javascript:alert('test')">отписаться насовсем</a></li>
				<li><a href="javascript:alert('test')">создать себе такой же опросник</a></li>
			</ul>
			</td></tr>
		</table>
EOT;

	
	$menu_for_admin = "";
	if ($person_is_poll_admin) {
		$menu_for_admin = <<<EOT
		<table class-DISABLED="admin-options">
			<caption>Админу</caption>
			<tr><td>
			<ul>
				<li><a href="javascript:alert('test')">отправить непроголосовавшим (6 из 19)</a></li>
				<li><a href="javascript:alert('test')">репост текущих результатов в чат (осталось 2 дня)</a></li>
				<li><a href="javascript:alert('test')">перевыставить на следующую неделю</a></li>
				<li><a href="javascript:alert('test')">добавить абонента, переправить</a></li>
				<li><a href="javascript:alert('test')">абоненты, статистика активности</a></li>
				<li><a href="backoffice/poll-edit.php?id=$poll">изменить опросник (чуть-чуть, если уже запущен)</a></li>
				<li><a href="backoffice/person-edit.php?id=#PERSON#">редактировать [#PERSON_IDENT#]</a></li>
				<li><a href="auth.php">перелогиниться</a></li>
			</ul>
			</td></tr>
		</table>
EOT;
		
	}



	$menu_for_backoffice = "";
	if ($in_backoffice_backup == 1) {
		$menu_for_backoffice = <<<EOT
			<table class="admin-options">
				<caption>Из бэкоффиса</caption>
				<tr><td>
				<ul>
					<!--li><a href="javascript:alert('test')">результаты голосования</a></li-->
					<li><a href="javascript:alert('test')">репост текущих результатов в чат</a></li>
					<li><a href="javascript:alert('test')">переправить тому кого нет в чате</a></li>
					<li><a href="javascript:alert('test')">отписаться насовсем</a></li>
					<li><a href="javascript:alert('test')">создать себе такой же опросник</a></li>
					<li><a href="javascript:popup_url('poll-rendered.php?id=#ID#', 'poll_rendered_#ID#', '')">$msg_tag_shortcut</a>
				</ul>
				</td></tr>
			</table>
EOT;
	}
	
	$poll_rendered_answers_table = $poll_row["gender_explicit"] == 0
		? poll_rendered_answers_table($poll_row)
		: poll_rendered_answers_table_with_gender($poll_row);

	$poll_rendered = <<<EOT
<tr>
	<td></td>
	<td>
		<div style="padding: 2ex; border: 1px solid gainsboro; background-color: #BACKGROUND_COLOR_WHATSAPP#; float: left; width: 60ex" title="#TOOLTIP#">
			<h2>#IDENT#</h2>
			<table cellspacing=0 cellpadding=5>
				$tpl_comment_above
				$poll_rendered
				$tpl_comment_below
				<tr style="background-color_DISABLED: #BACKGROUND_COLOR_WHATSAPP#">
					<td align=center>
						<div style="padding: 1ex 0 1ex 0">
							<script>
							function fake_save() {
								alert('реальный опросник будет сохраняться; это демо внешнего вида');
							}
							</script>
							<input type=button onclick="javascript:fake_save()" value="$tpl_save_label">
						</div>
					</td>
				</tr>
			</table>

			<table style="border:1px solid black; padding: 1ex">
				<caption>Результаты:</caption>
				$poll_rendered_answers_table
			</table>

			<br>
			<br>


			$menu_for_user

			$menu_for_admin
			
			$menu_for_backoffice
			

		</div>
	</td>
</tr>
EOT;

	$poll_rendered = hash_by_tpl($poll_row, $poll_rendered);
	
	$markers = array("BACKGROUND_COLOR_WHATSAPP" => BACKGROUND_COLOR_WHATSAPP);
	$poll_rendered = hash_by_tpl($markers, $poll_rendered);
	
	if (isset($unhashed)) {
		// #PERSON_IDENT# is valid for the front, not for the backoffice
		$poll_rendered = hash_by_tpl($unhashed, $poll_rendered);
	}
}

require "_multicompositeiccontent-voted.php";

function poll_rendered_answers_table($poll_row) {
	$ret = <<<EOT
	<tr>
		<th></th>
		<th>Голоса</th>
	</tr>
	<tr>
		<td>Да, приду на сальсу 19:00</td>
		<td align=center>5</td>
	</tr>
	<tr>
		<td>Да, приду на бачату 20:00</td>
		<td align=center>4</td>
	</tr>
	<tr>
		<td>Не придут сегодня</td>
		<td align=center>0</td>
	</tr>
	<tr>
		<td>Абонемент заморожен:</td>
		<td align=center>3</td>
	</tr>
	<tr>
		<td colspan=2><hr /></td>
	</tr>
	<tr>
		<td>Отписалось:</td>
		<td align=center>1</td>
	</tr>
	<tr>
		<td>Пока не проголосовали</td>
		<td align=center>8</td>
	</tr>
	<tr>
		<td>Всего разослано</td>
		<td align=center>11</td>
	</tr>
EOT;
	return $ret;
}


function poll_rendered_answers_table_with_gender($poll_row) {
	$ret = <<<EOT
	<tr>
		<th></th>
		<th>Мужчины</th>
		<th>Женщины</th>
	</tr>
	<tr>
		<td>Всего разослано</td>
		<td align=center>11</td>
		<td align=center>13</td>
	</tr>
	<tr>
		<td>Да, приду на сальсу 19:00</td>
		<td align=center>5</td>
		<td align=center>3</td>
	</tr>
	<tr>
		<td>Да, приду на бачату 20:00</td>
		<td align=center>4</td>
		<td align=center>4</td>
	</tr>
	<tr>
		<td>Пока не проголосовали</td>
		<td align=center>8</td>
		<td align=center>6</td>
	</tr>
	<tr>
		<td>Не придут сегодня</td>
		<td align=center>1</td>
		<td align=center>0</td>
	</tr>
	<tr>
		<td>Абонемент заморожен:</td>
		<td align=center>1</td>
		<td align=center>3</td>
	</tr>
	<tr>
		<td>Отписалось:</td>
		<td align=center>0</td>
		<td align=center>1</td>
	</tr>
EOT;
	return $ret;
}


$in_backoffice = $in_backoffice_backup;
$backrow_tpl = $backrow_tpl_backup;



?>
<?
//	<form>
//	<table cellpadding=0 cellspacing=0><?=$poll_rendered? ></table>
//	</form>
?>
