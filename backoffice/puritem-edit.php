<?

require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),

	"room" => array ("", "select_hard", "ident"),
	"purchase" => array ("", "select_hard", "ident"),

	"pgroup" => array ("", "select_soft", "ident"),
	"product" => array ("", "select_soft", "ident"),
	"qnty" => array("", "number"),

	"comment" => array ("", "textarea_3"),

	"bought" => array ("", "checkbox", "", false),
	"bought_qnty" => array("", "number"),
	"bought_price" => array("", "number"),
	"bought_weight" => array("", "number"),

	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),

	"published" => array ("", "checkbox", "", true),
	"deleted" => array ("", "checkbox", "", false),
);

// $debug_query = 1;

?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
