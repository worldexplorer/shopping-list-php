<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array("Словами", "view"),

	"room" => array("", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),
	"purchase" => array("", "ahref", "<a href=purchase-edit.php?id=#PURCHASE#>#PURCHASE_IDENT#</a>"),
	"pgroup" => array("", "ahref", "<a href=pgroup-edit.php?id=#PGROUP#>#PGROUP_IDENT#</a>"),
	"product" => array("", "ahref", "<a href=purchase-edit.php?id=#PRODUCT#>#PRODUCT_IDENT#</a>"),

	"qnty" => array("qnty", "textfield", "", "6em", "5em"),
	"comment" => array("comment", "textfield", "", "11em", "10em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//$debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
