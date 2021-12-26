<?

require_once "../_lib/_init.php";


$list_left_fields .=
	  ", count(m2m.id) as puritem_cnt"
;

$list_left_m2mjoins .=
	  " left join m2m_puritem_person m2m"
		. " on m2m.purchase=e.purchase"
;


$table_columns = array (
	"id" => array("", "sernoupdown"),
	"date_created" => array("", "date"),
	"room_ident" => array("", "ahref", "<a href=room.php?id=#ROOM#>#ROOM_IDENT#</a>"),
	"person_ident" => array("", "ahref", "<a href=person.php?id=#PERSON#>#PERSON_IDENT#</a>"),

	"persons_sent" => array("", "view"),
	"persons_read" => array("", "view"),

	"replyto_id" => array("", "textfield", "", "4em", "3em"),
	"forwardfrom_id" => array("", "textfield", "", "4em", "3em"),

	//"ident" => array($entity_msg_h, "hrefedit"),
	"~2" => array($entity_msg_h, "ahref", "<a href=#ENTITY#-edit.php?id=#ID#>#CONTENT#</a>"),
	// "ident" => array("", "textfield", "", "17em", "16em"),
	"content" => array("", "textfield", "", "17em", "16em"),

	//"tour" => array("", "cnt", "подпункты: "),
	// "question" => array("", "cnt"),
	"purchase_ident" => array("", "ahref", "<a href=purchase-edit.php?id=#PURCHASE#>#PURCHASE_IDENT#</a>"),
	"puritem_cnt" => array("", "ahref", "<a href=puritem.php?purchase=#PURCHASE#>Продуктов: #PURITEM_CNT#</a>"),

	"edited" => array("", "checkbox"),
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

// $debug_query = 1;
?>

<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>