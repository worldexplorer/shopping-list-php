<?

require_once "../_lib/_init.php";

//$subitems_cnt = select_field("count(id)", array("parent_id" => $id));
//pre($fixed_hash);

//$debug_query = 1;

///////// CRAZY START
$entity_m2mfixed_list = array (
//	"m2m_game_team" => array("game", "team"),
);

// PRESENT (m2m_game_team from _constant.php):
// SELECT_TABLE_ALL: [select e.id, e.ident as ident, e.published from mzgb_game e
//						inner join mzgb_m2m_game_team m2m on m2m.game=e.id and m2m.published=1 and m2m.deleted=0
//						where 1=1 and e.deleted=0
//						group by e.id order by e.manorder asc]
// ABSENT (m2m_game_team commented out):
// SELECT_TABLE_ALL: [select e.id, e.ident as ident, e.published from mzgb_game e where 1=1 and e.deleted=0 order by e.manorder asc]


$entity_fixed_list = array (
	//hacky
	//"game" => array("team"),
	//"team" => array("game"),
);
///////// CRAZY END

$game_selected = 0;
$tour_ident = "ADD_TOUR_FIRST";
if ($id > 0) {
	$tour_row = select_entity_row();
	$game_selected = $tour_row["game"];
//	pre("game_selected[$game_selected]");
	$tour_ident = hash_by_tpl($tour_row, "#IDENT#");
} else {
	$game_selected = get_number("game");
	if ($game_selected == 0) {
		$game_selected = select_field("id", 0, "game");
	}
}

$game_ident = "ADD_TOUR_FIRST";
if ($game_selected > 0) {
	$game_row = select_entity_row(array("id" => $game_selected), "game");
	$game_ident = $game_row["ident"];
}

if ($id > 0 && $mode == "") $layer_opened_nr = 1;



$tpl_outer = <<< EOT
<div style='float: left; margin: 0 2ex 2ex 0; padding: 1ex; border: 1px solid gainsboro'>
	<div style='text-align: center; border: 0px solid gainsboro'>
		<a href='javascript:ilayer_switch("team_#GROUP_ID#")'><b>#GROUP_IDENT#: #CORRECT_CNT# верных в [$tour_ident]</b></a>
	</div>
	<div id='layer_team_#GROUP_ID#' style='display:#INNER_STYLE_DISPLAY#; padding: 2ex'>
		<table cellpadding=1 cellspacing=0>
			#GROUP_CONTENT__CBX_TF#
		</table>
	</div>
</div>
EOT;



$tpl_controlled = <<< EOT
<tr>
	<td>#I#.</td>
	<td width=10></td>
	<td align="right" nowrap>
		<label for="#GROUP_ENTITY#:#GROUP_ID#_#dict_table#:correct[#dict_id#]"><font color="#dict_color#">#dict_ident#</font></label>
	</td>
	<td width=10></td>
	<td>
		<input type=text size="25" name="#GROUP_ENTITY#[#GROUP_ID#][#dict_table#][#dict_id#][content]" value="#m2m_content#" />
	</td>
	<td width=10></td>
	<td width=10>
		<input type=checkbox size=3
			name="#GROUP_ENTITY#[#GROUP_ID#][#dict_table#][#dict_id#][correct]" #m2m_correct_checked#
			id="#GROUP_ENTITY#:#GROUP_ID#_#dict_table#:correct[#dict_id#]"
			/>
	</td>
	<td width=10></td>
	<td>
		<font color=gray><a href=question-edit.php?id=#ID# target=_blank>$msg_tag_shortcut #ANSWER#</a></font>
	</td>
</tr>
EOT;

$subitems_cnt = select_field("count(id)", array("game" => $game_selected), "tour");
$questions_cnt = select_field("count(id)", array("tour" => $id), "question");

$header_include .= <<<EOT
<script src="js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>

<script>
//var allOuter_selector = "form#form_edit div[id^='layer_team']";
var allOuter_selector = "div[id^=layer_team_]";

var teamsExpanded_cookieName = "${entity}_teamsExpanded";

function teamsExpanded_toggle() {
	var allOuter = $(allOuter_selector);
	if (allOuter.length == 0) {
		var errmsg = "ZERO_TEAMS_LINKED " + allOuter_selector
			+ ", check participanting teams in игра[$game_ident] => изменить"
			;
		alert(errmsg);
		debugger;
		return;
	}
	
	var firstOuter = allOuter[0];
	var teamsExpanded = $(firstOuter).css("display") == "none";
	if (teamsExpanded) {
		teams_expand();
	} else {
		teams_collapse();
	}
}

function teams_expand() {
	var allOuter = $(allOuter_selector);
	if (allOuter.length == 0) {
		var errmsg = "ZERO_TEAMS_LINKED " + allOuter_selector
			+ ", check participanting teams in игра[$game_ident] => изменить"
			;
		alert(errmsg);
		debugger;
		return;
	}
	allOuter.show();
	setCookie(teamsExpanded_cookieName, "yes", cookieExpires_inDays);
	var qc = getCookie(teamsExpanded_cookieName);
}

function teams_collapse() {
	var allOuter = $(allOuter_selector);
	if (allOuter.length == 0) {
		var errmsg = "ZERO_TEAMS_LINKED " + allOuter_selector
			+ ", check participanting teams in игра[$game_ident] => изменить"
			;
		alert(errmsg);
		debugger;
		return;
	}
	allOuter.hide();
	setCookie(teamsExpanded_cookieName, "no", cookieExpires_inDays);
	var qc = getCookie(teamsExpanded_cookieName);
}

$(document).ready(function() {
	var teamsExpanded = getCookie(teamsExpanded_cookieName);
	if ("~" + teamsExpanded == "~undefined") teamsExpanded = "no";

	if (teamsExpanded == "yes") {
		teams_expand();
	} else {
		teams_collapse();
	}
})

</script>

EOT;

$m2m_fixed4select_outer__teams4game = array("game" => $game_selected);
$m2m_fixed4insert_content__questions4tour = array("game" => $game_selected, "tour" => $id);

$m2mtfcontrolledgrouped_groups_expander = "<div style='margin: 10px'><a href=javascript:teamsExpanded_toggle()>Раскрыть / схлопнуть ответы всех команд</a></div>";
$m2mtfcontrolledgrouped_groups_expanded = false;

$m2mtfcontrolledgrouped_outer_leftjoin_tables = " LEFT JOIN m2m_team_question m2mcnt ON m2mcnt.game=m2m_team4game.game AND m2mcnt.team=m2m_team4game.team AND m2mcnt.tour=$id AND m2mcnt.correct=1";
$m2mtfcontrolledgrouped_outer_leftjoin_fields = ", count(m2mcnt.id) as correct_cnt";
//CONFUSING $m2mtfcontrolledgrouped_outer_leftjoin_sorting = "correct_cnt desc, ";
$m2mtfcontrolledgrouped_outer_leftjoin_groupby = " GROUP BY team.id";


$additional_fields_fixedhash = array("q.answer" => "answer");


$entity_fields_top = array (
	"ident" => array ("", "textfield", ""),
	//"date_published" => array ("", "datetime_date", ""),
);

$entity_fields_middle = array (
	"~3" => array ("", "ahref", "<a href=m2m_team_question.php?game=$game_selected&tour=$id>Судить тур [#IDENT#] игры [$game_ident]</a>"),

//	"~1columned_open" => array ("", "layer_open"),
//	"team" => array (" ", "m2mtfcontrolled", "m2m_team_question", 
//		"m2m_game_team", array("game" => $game_selected)),
//	"~1columned_close" => array ("Верные ответы", "layer_close"),
	
	
	"question" => array ("Верные ответы", "m2mtfcontrolledgrouped", "m2m_team_question",
		"m2m_game_team",
		$m2m_fixed4select_outer__teams4game,
		"team",
		$m2m_fixed4insert_content__questions4tour,
		$additional_fields_fixedhash
		),
);
	
$entity_fields_bottom = array (
	"~service_layer-open" => array ("", "layer_open"),
	//"brief" => array ("Кратко<br><br>в список<br>команд", "freetext_200", ""),
	"brief" => array ("", "textarea", ""),
	//"content" => array ("Описание<br><br>в карточку команды,<br>справа от фото", "freetext", ""),
	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),
	"~service_layer-close" => array ("", "layer_close"),
	
	//"parent_id" => array ("", "select_table_tree_root", "tour"),
	//"~1" => array ("$subitems_cnt", "ahref", "<a href=$entity.php?parent_id=$id>вопросы этого тура</a>"),	
	"question-HASHKEY_ALREADY_USED" => array ("", "cnt", "#MASTER_ENTITY# тура [#IDENT#]"),
	//"~1" => array ("$questions_cnt", "ahref", "<a href=question.php?game=$game_id&tour=$id>вопросы этого тура</a>"),

	"game" => array ("", "select_soft"),
	"blitz" => array ("", "checkbox", ""),
	
	"published" => array ("", "checkbox", 1),
);

$entity_fields = $entity_fields_top;
if ($id > 0) $entity_fields = array_merge($entity_fields, $entity_fields_middle);
$entity_fields = array_merge($entity_fields, $entity_fields_bottom);


?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
