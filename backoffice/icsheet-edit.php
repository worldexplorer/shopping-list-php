<?

require_once "../_lib/_init.php";


$entity_fields = array (
	"id" => array ("", "ro"),
	"ident" => array ("", "ro"),
	"content" => array ("", "ro"),
	"icwhose" => array("", "table_ro", "ident"),
//	"~1" => array("װאיכ", "table_ro", "ident"),
);

$no_savebutton = 1;

?>

<? include "_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "_edit_fields.php" ?>
<? include "_bottom.php" ?>
