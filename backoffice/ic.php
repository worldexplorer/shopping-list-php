<?

require_once "../_lib/_init.php";

$table_columns = array (
	"id" => array("", "sernoupdown"),

	"icwhose_ident" => array("", "view"),
	"ident" => array("", "hrefedit"),
	"icdict_ident" => array("", "hrefedit", "<a href=icdictcontent.php?icdict=#ICDICT#>#ICDICT_IDENT#</a>"),
	//"icdict_ident" => array("", "ahrefcenter"),

	"ictype_ident" => array("", "view"),

	"hashkey" => array("", "view"),
	"obligatory" => array("", "checkbox"),
	"inbrief" => array("", "checkbox"),
	"sorting" => array("", "checkbox"),
	
	//"published_bo" => array("", "checkbox"),
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//$debug_query = 1;
$list_left_additional_fields = " , icd.ident as icdict_ident, count(distinct icdc.id) as icdictcontent_cnt";
$list_left_additional_joins = " left outer join icdict icd on e.icdict=icd.id and icd.deleted=false"
	. " left outer join icdictcontent icdc on icdc.icdict=icd.id and icdc.deleted=false"
	;
$list_left_fields_groupby .= ", icdict_ident";

?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>