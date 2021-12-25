<?

require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	"show_pgroup" => array ("", "checkbox", 1),
	"show_price" => array ("", "checkbox", 1),
	"show_qnty" => array ("", "checkbox", 1),
	"show_weight" => array ("", "checkbox", 1),

	"person_created" => array ("", "select_hard", "ident"),
	"person_purchased" => array ("", "select_soft", "ident"),
	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),

	"comment_above" => array ("", "textarea_3"),
	"comment_below" => array ("", "textarea_3", ""),

	"room" => array ("", "select_hard", "ident"),

	"published" => array ("", "checkbox", 1)
);

// $debug_query = 1;

?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
