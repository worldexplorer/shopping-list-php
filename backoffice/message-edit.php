<?

require_once "../_lib/_init.php";

$entity_fields = array (
	// "ident" => array ("", "textfield", ""),
	//"date_published" => array ("", "datetime_date", ""),
	"content" => array ("", "textarea", ""),
	
	"room" => array ("", "select_soft"),
	"person" => array ("", "select_soft"),

	"persons_sent" => array("", "arrayint"),
	"persons_read" => array("", "arrayint"),

	"replyto_id" => array("", "number"),
	"forwardfrom_id" => array("", "number"),


	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),

	"edited" => array ("", "checkbox", false),
	"published" => array ("", "checkbox", 1),
);

// $debug_query = 1;
?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
