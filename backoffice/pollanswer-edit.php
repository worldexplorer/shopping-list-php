<? require_once "../_lib/_init.php" ?>
<?

function pollvote_table($row) {
	global $cms_dbc, $id, $mode;
	$ret = "";

	if ($mode == "update") {
		$id_fordelete = get_array("vote_del");
//		pre ($id_fordelete);

		if (count($id_fordelete) > 0) {
			$del_query = "update pollvote set deleted=1 where id in (" . sqlin_fromarray($id_fordelete) . ")";
			pg_query($cms_dbc, $del_query) or die("DELETE failed:<br>$del_query<br>");

			$upd_query = "update pollanswer set votes = (votes - " . count($id_fordelete) . ") where id=$id";
			pg_query($cms_dbc, $upd_query) or die("DELETE failed:<br>$upd_query<br>");
		}

	}

	$tpl = <<< EOT
<tr>
	<td>#DATE_CREATED#</td>
	<td>#REMOTE_ADDRESS#</td>
	<td align=center><input type=checkbox name=vote_del[] value=#ID#></td>
</tr>
EOT;

	$query = "select * from pollvote where pollanswer=$id and deleted=0 order by " . get_entity_orderby("pollvote");
	$qa = select_queryarray($query);
	
	foreach ($qa as $row) {
		$ret .= hash_by_tpl($row, $tpl);
	}
	
	if ($ret == "") {
		$ret = "<tr><td colspan=3><b>Никто не голосовал за этот ответ</b></td></tr>";
	}
	
	$ret = <<< EOT
<table cellpadding=3 cellspacing=1 class=gw>
<tr>
	<th>Дата</th>
	<th>Адрес</th>
	<th>Удал</th>
</tr>
$ret
</table>
EOT;

	return $ret;
}

$pollanswer_cnt = 0;
if ($id > 0) {
	$pollanswer_cnt = select_field("count(id) as cnt", array("pollanswer" => $id, "deleted" => 0), "pollvote");
}

$entity_fields = array (
	"ident" => array ("Название", "textfield", ""),
//	"votes" => array ("Ответов", "number", 0),

	"~2_open" => array ("Ответы посетителей ($pollanswer_cnt)", "layer_open"),
	"~2" => array ("", "ahref", "@pollvote_table@"),
	"~2_close" => array ("Ответы посетителей ($pollanswer_cnt)", "layer_close"),
	
	"multicb" => array ("", "checkbox"),

	"published" => array ("Опубликовано", "checkbox", 1)
);

?>

<? include "../_lib/_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "../_lib/_edit_fields.php" ?>
<? include "_bottom.php" ?>
