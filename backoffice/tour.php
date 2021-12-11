<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	//"date_published" => array("", "date"),
	"game_ident" => array("", "ahref", "<a href=game.php?id=#GAME#>#GAME_IDENT#</a>"),
	
	//"ident" => array($entity_msg_h, "hrefedit"),
	"~2" => array($entity_msg_h, "ahref", "<a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	"ident" => array("", "textfield", "", "17em", "16em"),

	//"tour" => array("", "cnt", "подпункты: "),
	"question" => array("", "cnt"),

	"~3" => array("Судить", "ahrefcenter", "<nobr><a href=m2m_team_question.php?game=#GAME#&tour=#ID#>судить тур</a></nobr>"),
	
	"blitz" => array("", "checkbox"),
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


?>

<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>