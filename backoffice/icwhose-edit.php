<?

require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	"hashkey" => array ("", "textfield", ""),
//	"~1" => array ("", "ahref", "<a href=ic.php?icwhose=$id>Редактировать поля анкеты</a>"),
	"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),
	"brief" => array ("", "freetext_200", ""),

	"published" => array ("", "checkbox", 1)
);

?>

<? include "_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "_edit_fields.php" ?>
<? include "_bottom.php" ?>
