<?

require_once "../_lib/_init.php";

$fixed_fields = array("icdict");

$entity_fields = array (
	"ident" => array ("", "textarea_3", ""),
	"hashkey" => array ("", "textfield", ""),
	"label_style" => array ("", "textfield", ""),
	"tf1_width" => array ("", "number", 0),
	"tf1_incolumn" => array ("", "checkbox", 0),
	"icdict" => array ("", "select_hard", "ident"),

	"published" => array ("", "checkbox", 1)
);
?>

<? include "_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "_edit_fields.php" ?>
<? include "_bottom.php" ?>
