<?

require_once "../_lib/_init.php";

$list_left_fields .=
	  ", person_created.ident as person_created_ident"
//	. ", count(participants.id) as participants_cnt"
;

$list_left_m2mjoins .=
	  " left join person person_created"
		. " on person_created.id=e.person_created and person_created.deleted=0"
//	. " left join m2m_room_person m2m_participants"
//		. " on m2m_participants.room=e.id and m2m_participants.deleted=0"
//	. " left join person participants"
//		. " on participants.id=m2m_participants.person and participants.deleted=0"
;

$list_left_fields_groupby =
	 ", person_created_ident"
//	. ", participants_cnt"
;

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"person_created" => array("", "ahref",
		"<a href=person.php?id=#PERSON_CREATED#>#PERSON_CREATED_IDENT#</a>"),

	"ident" => array("", "hrefedit"),
//	"ident" => array("", "textfield", "", "11em", "10em"),

	"person_ident" => array("Участники", "groupconcat"),
	"message" => array("", "cnt"),
	"product" => array("", "cnt"),
	"pgroup" => array("", "cnt"),
	
//	"message_pinned" => array("Pinned", "view"),
//	"message_pinned_text" => array("Pinned", "view"),
	"~1" => array("Pinned Txt", "ahref",
		"#MESSAGE_PINNED# <a href=message-edit.php?id=#MESSAGE_PINNED#>#MESSAGE_PINNED_TEXT#</a>"),
	"~2" => array("Img", "ahref", "#img_cnt#"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

// $debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
