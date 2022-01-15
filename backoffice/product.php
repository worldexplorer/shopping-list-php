<?

require_once "../_lib/_init.php";

$list_left_fields .=
	  ", purchase_origin.ident as purchase_origin_ident"
;

$list_left_m2mjoins .=
	  " left join purchase purchase_origin"
		. " on purchase_origin.id=e.purchase_origin"
;

$list_left_fields_groupby =
	  ", purchase_origin_ident"
;

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"room" => array("Создано в чате", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),
	"purchase_origin" => array("Purchase", "ahref", "<a href=purchase-edit.php?id=#PURCHASE_ORIGIN#>#PURCHASE_ORIGIN_IDENT#</a>"),

	"pgroup" => array("", "ahref", "<a href=pgroup-edit.php?id=#PGROUP#>#PGROUP_IDENT#</a>"),
	"ident" => array("", "textfield", "", "11em", "10em"),

	"punit" => array("", "ahref", "<a href=punit.php?id=#PUNIT#>#PUNIT_IDENT#</a>"),
	"weight" => array("weight", "textfield", "", "6em", "5em"),
	"price_avg" => array("price_avg", "textfield", "", "6em", "5em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

$debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
