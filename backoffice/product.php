<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"room" => array("Создано в чате", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),

	"pgroup" => array("", "ahref", "<a href=pgroup-edit.php?id=#PGROUP#>#PGROUP_IDENT#</a>"),
	"ident" => array("", "textfield", "", "11em", "10em"),

	"weight" => array("weight", "textfield", "", "6em", "5em"),
	"price_avg" => array("price_avg", "textfield", "", "6em", "5em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//$debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
