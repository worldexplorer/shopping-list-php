<?

require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	"message_pinned" => array ("Pinned Id", "textfieldro"),
	"message_pinned_text" => array ("Pinned Txt", "textarea_3", ""),
	"person_created" => array ("", "select_hard", "ident"),
	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),

	"published" => array ("", "checkbox", 1)
);

// $debug_query = 1;

?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
