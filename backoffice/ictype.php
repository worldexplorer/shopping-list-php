<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array("", "hrefedit"),
	"hashkey" => array ("", "textfield", "", "15em", "14em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>