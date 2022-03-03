<?

require_once "../_lib/_init.php";

$entity_m2mfixed_list = array (
	// "m2m_room_person" => array("room", "person"),
);

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	// "date_published" => array ("", "datetime_date", ""),
	"content" => array ("", "textarea", ""),
	
	"room" => array ("", "select_soft", ""
		// , "WILL FAILL IF PERSONS ARE MISSING IN TARGET ROOM"
	),
	"person" => array ("", "select_soft"),
	"purchase" => array ("", "select_soft"),

	"persons_sent" => array("", "arrayint"),
	"persons_read" => array("", "arrayint"),

	"replyto_id" => array("", "number"),
	"forwardfrom_id" => array("", "number"),

	// "~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>@masterdepend_entity_hr@</a>"),

	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),

	"archived" => array ("", "checkbox", "", false),
	"edited" => array ("", "checkbox", "", false),
	// "published" => array ("", "checkbox", "", true),
	"deleted" => array ("", "checkbox", "", false),
);

// $debug_query = 1;
?>
<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
