<?

require_once "../_lib/_init.php";


$list_left_fields .=
	    ", person_created.ident as person_created_ident"
	  . ", person_purchased.ident as person_purchased_ident"
;

$list_left_m2mjoins .=
	  " left join person person_created"
		. " on person_created.id=e.person_created and person_created.deleted=false"
	. " left join person person_purchased"
		. " on person_purchased.id=e.person_purchased and person_purchased.deleted=false"
;

$list_left_fields_groupby =
	  ", person_created_ident"
	. ", person_purchased_ident"
;

$table_columns = array (
	"id" => array("", "sernoupdown"),

//	"room" => array("", "view"),
	"room" => array("", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),

	"person_created" => array("", "ahref",
		"<a href=person.php?id=#PERSON_CREATED#>#PERSON_CREATED_IDENT#</a>"),
	"persons_can_edit" => array("", "textfield", "", "6em", "5em"),
	"purchased" => array("", "checkbox"),
	"person_purchased" => array("", "ahref",
		"<a href=person.php?id=#PERSON_PURCHASED#>#PERSON_PURCHASED_IDENT#</a>"),

	"ident" => array('', "hrefedit"),
//	"~ident" => array("", "textfield", "", "11em", "10em"),

	"puritem" => array("Позиций", "cnt"),

	
//	"message" => array("Msg", "ahref", "#MESSAGE#"),
//	"comment_above" => array("comment above", "textfield", "", "11em", "10em"),
//	"comment_below" => array("comment below", "textfield", "", "11em", "10em"),

//	"comment_above" => array("comment above", "view"),
//	"comment_below" => array("comment below", "view"),

	"price_total" => array("Price", "ahref", "#PRICE_TOTAL#"),
	"weight_total" => array("Weight", "ahref", "#WEIGHT_TOTAL#"),

	"show_pgroup" => array("Грп", "checkbox"),
	"show_price" => array("Цена", "checkbox"),
	"show_qnty" => array("Колво", "checkbox"),
	"show_weight" => array("Вес", "checkbox"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

// $debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
