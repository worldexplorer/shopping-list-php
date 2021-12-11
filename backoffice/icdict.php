<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"icwhose_ident" => array("", "view", "22em"),
	"ident" => array($entity_msg_h, "hrefedit"),
	"icdictcontent" => array("", "cnt"),
//	"hashkey" => array ("Ключ", "textfield", ""),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>