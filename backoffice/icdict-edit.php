<?

require_once "../_lib/_init.php";

$fixed_fields = array("icwhose");

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	"hashkey" => array ("", "textfield", ""),
	"icwhose" => array ("", "select_hard", "ident"),
	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),
//	"~1" => array ("", "ahref", "<a href='icdictcontent.php?icdict=$id'>–едактировать значени¤ справочника</a>"),

	"published" => array ("", "checkbox", "", true)
);
?>

<? include "_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "_edit_fields.php" ?>
<? include "_bottom.php" ?>
