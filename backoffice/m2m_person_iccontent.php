<?

require_once "../_lib/_init.php";

$table_columns = array (
//	"id" => array("№", "ahref", "<center>#ID#</center>", "4ex"),
	"id" => array("", "sernoupdown"),
	"date_created" => array("", "timestamp"),
//	"date_updated" => array("", "timestamp"),
	"person_ident" => array("", "ahref", "<a href=person-edit.php?id=#PERSON#&layer_open=1>#PERSON_IDENT#</a>"),
	"property_ident" => array("Свойство", "ahref", "<a href=person-edit.php?id=#PERSON#&layer_open=1>#PROPERTY_IDENT#</a>"),
	"iccontent" => array("Значение", "ahref", "<a href=person-edit.php?id=#PERSON#&layer_open=1>#ICCONTENT#</a>"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

//require_once "../_lib/__fixed.php";
$list_query = "select ics.*, ic.ident as property_ident, p.id as person, p.ident as person_ident"
	. " from m2m_person_iccontent ics"
	. " left outer join ic ic on ics.ic=ic.id"
	. " left outer join person p on ics.person=p.id"
	. " where ics.deleted=false "
	. " order by ics." . get_entity_orderby("icsheet")
;
//$debug_query = 1;
$no_add = 1;

?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>