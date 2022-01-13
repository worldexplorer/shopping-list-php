<?

require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),

	"show_pgroup" => array ("", "checkbox", "", true),
	"show_serno" => array ("", "checkbox", "", true),
	"show_qnty" => array ("", "checkbox", "", true),
	"show_price" => array ("", "checkbox", "", false),
	"show_weight" => array ("", "checkbox", "", false),

	"show_state_unknown" => array ("", "checkbox", "", true),
	"show_state_stop" => array ("", "checkbox", "", true),

	"room" => array ("", "select_hard", "ident"),
	"message" => array ("", "select_hard", "ident"),
	"puritem" => array ("", "cnt"),
	"person_created" => array ("", "select_hard", "ident"),
	"persons_can_edit" => array("", "arrayint"),
	"purchased" => array ("", "checkbox", "", true),
	"person_purchased" => array ("", "select_soft", "ident"),

	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),

	"comment_above" => array ("", "textarea_3"),
	"comment_below" => array ("", "textarea_3", ""),

	"published" => array ("", "checkbox", "", true)
);

// $debug_query = 1;

?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
