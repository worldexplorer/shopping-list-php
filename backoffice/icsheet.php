<?

require_once "../_lib/_init.php";

$table_columns = array (
//	"id" => array("№", "ahref", "<center>#ID#</center>", "4ex"),
	"id" => array("", "sernoupdown"),
	"date_created" => array("", "timestamp"),
//	"date_updated" => array("", "timestamp"),
	"icwhose_ident" => array("", "view"),
	"ident" => array("", "hrefedit"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

require_once "../_lib/__fixed.php";
$list_query = "select ics.*, icw.ident as icwhose_ident"
	. " from icsheet ics"
	. " left outer join icwhose icw on ics.icwhose=icw.id"
	. " where ics.deleted=false " . sqlcond_fromhash($fixed_hash, "ics", " and ")
	. " order by ics." . get_entity_orderby("icsheet")
	;

?>

<? require "_updown.php" ?>
<? require_once "_top.php" ?>
<? require "_list.php" ?>
<? require_once "_bottom.php" ?>