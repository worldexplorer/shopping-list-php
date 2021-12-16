<?

require_once "../_lib/_init.php";

//$debug_query = 1;

$list_left_additional_joins .= ""
	. " left join m2m_team_question m2m_correct		on   m2m_correct.question=e.id and   m2m_correct.correct=1"
	. " left join m2m_team_question m2m_incorrect	on m2m_incorrect.question=e.id and m2m_incorrect.correct=0"
	;
$list_left_additional_joins .= ""
	. " left join team teams_correct	on   teams_correct.id=  m2m_correct.team"
	. " left join team teams_incorrect	on teams_incorrect.id=m2m_incorrect.team"
	;

	
//$teams_orderdir = get_entity_orderdir("team");
//$teams_orderfield = get_entity_orderfield("team");
//$teams_orderby = $teams_orderfield . " " . $teams_orderdir;

$teams_orderby = get_entity_orderby("team");

$list_left_additional_fields .= ""
	. ",		count(distinct m2m_correct.id)			as correct_cnt"
//	. ", group_concat(distinct teams_correct.ident)		as correct_teams_ident"
	. ", group_concat(distinct teams_correct.id, '=', teams_correct.ident order by teams_correct.$teams_orderby separator '~~') 		as correct_teams_ident"
	. ", 		count(distinct m2m_incorrect.id)		as incorrect_cnt"
//	. ", group_concat(distinct teams_incorrect.ident) 	as incorrect_teams_ident"
	. ", group_concat(distinct teams_incorrect.id, '=', teams_incorrect.ident order by teams_incorrect.$teams_orderby separator '~~')	as incorrect_teams_ident"
	;

	
$tpl_single = "<a href='team-edit.php?id=#ID#'>#IDENT#</a>";
$tpl_multiple = "<a href='team-edit.php?id=#ID#'>#IDENT_TRUNCATED#</a>";
	
$table_columns = array (
	"id" => array("", "sernoupdown"),
	
	"game_ident" => array("", "ahref", "<a href=game-edit.php?id=#GAME#>#GAME_IDENT#</a>"),
	"tour_ident" => array("", "ahref", "<a href=tour-edit.php?id=#TOUR#>#TOUR_IDENT#</a>"),

	//"ident" => array($entity_msg_h, "hrefedit"),
	"~2" => array($entity_msg_h, "ahref", "<a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	"ident" => array("", "textfield", "", "21em", "20em"),

	"~3" => array("Correct", 	"ahrefcenter", "<a href='m2m_team_question.php?question=#ID#'>#correct_cnt#</a>"),
	"~4" => array("Incorrect", 	"ahrefcenter", "<a href='m2m_team_question.php?question=#ID#'>#incorrect_cnt#</a>"),
	
	"correct_teams_ident" => array("Правильно ответили"	, "groupconcat_to_ahref", "", $tpl_single, $tpl_multiple),
	"incorrect_teams_ident" => array("Неправильно ответили"	, "groupconcat_to_ahref", "", $tpl_single, $tpl_multiple),
	
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);



$header_include .= <<<EOT
<script src="js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>

<script>

var ${entity}_columnIndexes_forViewing = [9, 10];
var ${entity}_columnIndexes_forEditing = [1, 2, 6, 11, 12];


$(document).ready(function() {
	var viewing_or_editing = getCookie('{$entity}_showColumns');
	if (viewing_or_editing == "editing") {
		showColumns_forEditing_selected('{$entity}', ${entity}_columnIndexes_forViewing, ${entity}_columnIndexes_forEditing);
	} else {
		// if no cookie was ever set - it's set now to "viewing"
		showColumns_forViewing_selected('{$entity}', ${entity}_columnIndexes_forViewing, ${entity}_columnIndexes_forEditing);
	}
})

</script>

EOT;

$topline_right_fromSubmenu_show = true;

?>

<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>