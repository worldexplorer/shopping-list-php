<?

require_once "../_lib/_init.php";

$list_left_fields .=
	  ", punit.brief as punit_ident"
;

$list_left_additional_joins .=
	  " left join punit punit"
		. " on punit.id=product.punit and punit.deleted=false"
;

$list_left_fields_groupby =
	 ", punit_ident"
;


$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array("", "hrefedit"),

	"room" => array("", "ahref", "<a href=room-edit.php?id=#ROOM#>#ROOM_IDENT#</a>"),
	"purchase" => array("", "ahref", "<a href=purchase-edit.php?id=#PURCHASE#>#PURCHASE_IDENT#</a>"),
	"pgroup" => array("", "ahref", "<a href=pgroup-edit.php?id=#PGROUP#>#PGROUP_IDENT#</a>"),
	"product" => array("", "ahref", "<a href=purchase-edit.php?id=#PRODUCT#>#PRODUCT_IDENT#</a>"),

	"qnty" => array("qnty", "textfield", "", "6em", "5em"),
	"punit" => array("Ед", "ahref", "<a href=punit.php?id=#PUNIT#>#PUNIT_IDENT#</a>"),
	// "comment" => array("comment", "textfield", "", "11em", "10em"),

	"bought" => array("", "textfield", "", "3em", "2em"),
	"bought_qnty" => array("", "textfield", "", "6em", "5em"),
	"bought_price" => array("", "textfield", "", "6em", "5em"),
	"bought_weight" => array("", "textfield", "", "6em", "5em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//$debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?> 
