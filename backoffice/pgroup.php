<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"room" => array("Создано в чате", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),

	"ident" => array("", "textfield", "", "11em", "10em"),
	"product" => array("", "cnt"),
	"puritem" => array("Закуплено", "cnt"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//$debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
