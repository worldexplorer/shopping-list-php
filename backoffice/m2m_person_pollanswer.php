<?

require_once "../_lib/_init.php";

$poll = get_number("poll");
$poll_ident = "POLL_NOT_SELECTED";
if ($poll == 0) $poll = select_last_published("id", array(), "poll");
if ($poll == 0) $poll = 1;

$pollanswer = get_number("pollanswer");
$pollanswer_ident = "POLLANSWER_NOT_SELECTED";
if ($pollanswer == 0) $pollanswer = select_first_published("id", array("poll" => $poll), "pollanswer");
if ($pollanswer == 0) $pollanswer = 1;

$orderby_person = get_entity_orderby("person");
$query_person = <<<EOT
select t.*
from person t
inner join m2m_person_pollanswer m2m on m2m.person=t.id	and m2m.published=1 and m2m.deleted=0
inner join poll g on g.id=m2m.poll				and   g.published=1 and   g.deleted=0
where m2m.poll=$poll							and   t.published=1 and   t.deleted=0
order by t.$orderby_person
EOT;

$person = get_number("person");
$person_ident = "TEAM_NOT_SELECTED";
//$debug_query = 1;
if ($person == 0) $person = select_field_firstRow_byQuery("id", $query_person, "ROUND_ARBITER");
if ($person == 0) $person = 1;
//pre($person, "person");


$orderby_pollanswer = get_entity_orderby("pollanswer");
$query_answers = <<<EOT
select pa.id, pa.ident, m2m.poll, m2m.pollanswer, m2m.person, m2m.iccontent as person_answer
from pollanswer pa
left join m2m_person_pollanswer		m2m on m2m.pollanswer=pa.id		and m2m.published=1 and m2m.deleted=0
	and m2m.person=$person		and m2m.pollanswer=$pollanswer		and m2m.poll=$poll
where pa.id=$pollanswer										and   pa.published=1 and   pa.deleted=0
order by pa.$orderby_pollanswer
EOT;

$poll_href = $poll > 0 ? "poll-edit.php?id=$poll" : "poll.php";
$pollanswer_href = $pollanswer > 0 ? "pollanswer-edit.php?id=$pollanswer" : "pollanswer.php?poll=$poll";
//$pollanswer_href = $poll > 0 ? "pollanswer.php?poll=$poll" : "pollanswer.php";
//$person_href = $person > 0 ? "person-edit.php?id=$person" : "person.php";
$person_href = $poll > 0 ? "person.php?poll=$poll" : "person.php";
$pollanswer_href = $poll > 0 && $pollanswer > 0
	? "pollanswer.php?poll=$poll&pollanswer=$pollanswer"
	: "pollanswer.php";


$inserted_colon_updated = "";
$stats_detailed = "";
if ($mode == "update") {
	//pre($_REQUEST, "_REQUEST");
	//pre(get_array("pollanswer"), "get_array(pollanswer)");

	$dict_table = "pollanswer";
	$fieldshash_byid = get_array("pollanswer");
	$m2m_tablename_4update = "m2m_person_pollanswer";
	$m2m_fixed4select = array("poll" => $poll, "pollanswer" => $pollanswer, "person" => $person);
	$m2m_fixed4insert = array();
	//$m2m_hash_base = array();

	$inserted_colon_updated = m2mtfcontrolled_update(
		$dict_table, $fieldshash_byid, $m2m_tablename_4update,
		$m2m_fixed4select, $m2m_fixed4insert
	//, $m2m_hash_base
	);

	list($inserted, $updated) = explode(":", $inserted_colon_updated);
	$stats_detailed = <<< EOT
<div style="text-align:right; width: 13ex; color:gray">
	добавлено: $inserted<br />
	обновлено: $updated
</div>
EOT;

}

$tpl_poll = <<<EOT
<tr>
	<td><input type=radio name=poll value=#id# id="poll_#id#" #checked#
			onclick="javascript:form_submit('m2m_selector')" /></td>
	<td></td>
	<td><label for="poll_#id#"><a href="$entity.php?poll=#ID#">#IDENT#</a></label></td>
</tr>

EOT;

$table_poll = "";
//for ($i=10; $i <= 12; $i++) {
//	$row["id"] = $i;
$query_poll = "select * from poll where published=1 and deleted=0 order by " . get_entity_orderby("poll");
$qa_poll = select_queryarray($query_poll, "poll");
foreach ($qa_poll as $row) {
	$row["checked"] = $row["id"] == $poll ? "checked" : "";
	if ($row["id"] == $poll) $poll_ident = hash_by_tpl($row, "#IDENT#");

	$tpl_ident = $row["id"] == $poll ? "<b>#IDENT#</b>" : "#IDENT#";
	$row["ident"] = hash_by_tpl($row, $tpl_ident);

	$table_poll .= hash_by_tpl($row, $tpl_poll);
}



$tpl_pollanswer = <<<EOT
<tr>
	<td><input type=radio name=pollanswer value=#id# id="pollanswer_#id#" #checked#
			onclick="javascript:form_submit('m2m_selector')" /></td>
	<td></td>
	<td><label for="pollanswer_#id#"><a href="$entity.php?poll=$poll&pollanswer=#ID#&person=$person">#IDENT#</label></td>
</tr>

EOT;

$table_pollanswer = "";
//for ($i=1; $i <= 7; $i++) {
//	$row["id"] = $i;
$query_pollanswer = "select * from pollanswer where poll=$poll and published=1 and deleted=0 order by " . get_entity_orderby("pollanswer");
$qa_pollanswer = select_queryarray($query_pollanswer, "pollanswer");
foreach ($qa_pollanswer as $row) {
	$row["checked"] = $row["id"] == $pollanswer ? "checked" : "";
	if ($row["id"] == $pollanswer) $pollanswer_ident = hash_by_tpl($row, "#IDENT#");

	$tpl_ident = $row["id"] == $pollanswer ? "<b>#IDENT#</b>" : "#IDENT#";
	$row["ident"] = hash_by_tpl($row, $tpl_ident);

	$table_pollanswer .= hash_by_tpl($row, $tpl_pollanswer);
}



$tpl_person = <<<EOT
<tr>
	<td><input type=radio name=person value=#id# id="person_#id#" #checked#
			onclick="javascript:form_submit('m2m_selector')" /></td>
	<td></td>
	<td><label for="person_#id#"><a href="$entity.php?poll=$poll&pollanswer=$pollanswer&person=#ID##scrolldown">#IDENT#</a></label></td>
</tr>

EOT;

$table_person = "";
$qa_person = select_queryarray($query_person, "person");
$columns = 3;
$items_in_one_column = round(count($qa_person) / $columns) + 1;
foreach ($qa_person as $row) {
//for ($i=1; $i <= 32; $i++) {
//	$row["id"] = $i;
//	if ($i == 17) {		
	$new_column_when_zero = round($row["i"] % $items_in_one_column);
	$make_new_column = $new_column_when_zero == 1 && $row["i"] > $items_in_one_column;
	if ($make_new_column) {
		$table_person .= <<< EOT
				</table>
				<table cellspacing=2 style="float:left; margin-left-disabled:2ex">
EOT;

	}
	$row["checked"] = $row["id"] == $person ? "checked" : "";
	if ($row["id"] == $person) $person_ident = hash_by_tpl($row, "#IDENT#");
	$table_person .= hash_by_tpl($row, $tpl_person);
}




$tpl_pollanswer = <<<EOT
<tr>
	<td>#I#.</td>
	<td align=right><label for="pollanswer_#id#">#IDENT#</label></td>
	<td></td>
	<td><input type=text size=15 name=pollanswer[#id#][content] value="#TEAM_ANSWER#" /></td>
	<td></td>
	<td><input type=checkbox name=pollanswer[#id#][correct] id="pollanswer_#id#" #checked# /></td>
	<td></td>
	<td><font color=gray><a href=pollanswer-edit.php?id=#ID# target=_blank>$msg_tag_shortcut#ANSWER#</a></font></td>
</tr>

EOT;

$pollanswer = 6;
$table_pollanswer = "";
//for ($i=0; $i <= 10; $i++) {
//	$row["id"] = $i;
//$debug_query = 1;
$qa_pollanswer = select_queryarray($query_answers, "m2m");
//$debug_query = 0;
foreach ($qa_pollanswer as $row) {
	$row["checked"] = $row["correct"] == 1 ? "checked" : "";
	$table_pollanswer .= hash_by_tpl($row, $tpl_pollanswer);
}


if ($mode == "update") {
	$errormsg = "Тур [$pollanswer_ident], Команда [$person_ident]: ответы сохранены [$inserted_colon_updated]";
}

$header_include .= <<<EOT
<script src="js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>

<script>
function uncollapse() {
	var nr = 999;
	if (layer_isopened(nr) == false) {
		//window.body.style.margin = 8;
		$("body").css("margin", 8);
	} else {
		$("body").css("margin", 0);
	}
	
	ilayer_switch(nr);
}
</script>
EOT;

?>

<? require_once "_top.php" ?>

    <style>
        input[radio] i {
            margin: 0;	/* opera shows nonsense in Ctrl-Shift-I */
        }
        input[radio], input:checkbox {
            cursor: pointer;
        }
        /*
		label {
			cursor: pointer;
		}
		label:hover {
			color: blue;
			text-decoration: underline;
		}
		*/
    </style>

    <script>
        function form_submit(form_name) {
            form = document.getElementById(form_name);
            form.submit();
        }

    </script>


    <div style="float: left">
        <form method=GET id=m2m_selector>
			<? if (get_number("pollanswer") == 0) { ?>
                <div style="float: left; border: 1px solid gainsboro; padding: 1ex 3ex 1ex 1ex; margin: 0 2ex 2ex 0">
                    <table cellpadding=2 cellspacing=0>
                        <tr><th colspan=3><a href=<?=$person_href?> target=_blank><?=$msg_tag_shortcut?>Опросник</a></th></tr>
						<?=$table_poll?>
                    </table>

                    <!--br/></br-->
                </div>
			<? } ?>
            <div style="float: left; border: 1px solid gainsboro; padding: 1ex 3ex 1ex 1ex; margin: 0 2ex 2ex 0">
                <table cellpadding=2 cellspacing=0>
                    <tr><th colspan=3><a href=<?=$pollanswer_href?> target=_blank><?=$msg_tag_shortcut?>Тур [<?=$poll_ident?>]</a></th></tr>
					<?=$table_pollanswer?>
                </table>
            </div>

            <div style="float: left; border: 1px solid gainsboro; padding: 1ex; margin: 0 2ex 2ex 0">
                <!--table cellpadding=2 cellspacing=0>
		<tr><th colspan=3><a href=<?=$poll_href?> target=_blank><?=$msg_tag_shortcut?>Команда</a></th></tr>
		<tr>
			<td>
				<table style="float:left">
				</table>
			</td>
		</tr>
	</table-->

                <center><b><a href=<?=$poll_href?> target=_blank><?=$msg_tag_shortcut?>Команда</a></b></center>
                <table  cellspacing=2 style="float:left; margin-left-disabled:2ex">
					<?=$table_person?>
                </table>
            </div>

        </form>
    </div>


    <!--div style="clear: both"></div-->
    <form method=POST action="m2m_person_pollanswer.php?poll=<?=$poll?>&pollanswer=<?=$pollanswer?>&person=<?=$person?>#scrolldown">
        <input type=hidden name=mode value=update />
        <input type=hidden name=poll value=<?=$poll?> />
        <input type=hidden name=pollanswer value=<?=$pollanswer?> />
        <input type=hidden name=person value=<?=$person?> />

        <div style="float: left; border: 1px solid gainsboro; padding: 1ex 3ex 1ex 1ex; margin: 0 2ex 0ex 0">
            <a name=scrolldown></a>
            <table cellpadding=2 cellspacing=0>
                <tr>
                    <th colspan=7><a href=<?=$pollanswer_href?> target=_blank><?=$msg_tag_shortcut?>[<?=$pollanswer_ident?>]: <?=$person_ident?></a></th>
                    <th align=left>галка если:</th>
                </tr>
				<?=$table_pollanswer?>
            </table>

            <br/>
            <table width=100%><tr valign=top>
                    <td width=30%><?=$stats_detailed?></td>
                    <td width=10></td>
                    <td width=30% align=center>
                        <input type=submit value="<?=$msg_bo_save?> [<?=$pollanswer_ident?>]: <?=$person_ident?>" />
                    </td>
                    <td width=30% align=right><a href=<?=$entity?>.php?poll=<?=$poll?>&pollanswer=<?=$pollanswer?>&person=<?=$person?>#scrolldown>Перечитать</a></td>
                    <td width=10></td>
                </tr>
            </table>
        </div>

        <div style="clear: both"></div>

    </form>

<? require_once "_bottom.php" ?>