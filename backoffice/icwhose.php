<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array($entity_msg_h, "hrefedit"),
	"ic" => array("", "cnt"),
	"icdict" => array("", "cnt"),
	"hashkey" => array("", "textfield", "", "19em", "18em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>