<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"icdict_ident" => array("", "view", "15em"),
	//"~2" => array("Значения справочника", "ahref", "<a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	"~2" => array($entity_msg_h, "ahref", "<a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	"ident" => array("", "textfield", "", "17em", "16em"),
//	"hashkey" => array ("", "textfield", "", "15em", "16em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>