<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array("", "textfield", "", "11em", "10em"),
	"brief" => array("", "textfield", "", "11em", "10em"),
	"fpoint" => array("Дробное", "checkbox"),
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
