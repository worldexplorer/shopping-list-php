<? require_once "../_lib/_init.php" ?>
<?

$table_columns = array (
	"id" => array("", "sernoupdown"),
	"ident" => array($entity_msg_h, "hrefedit"),
//	"cnt" => array("Голосов", "ahref", "<center><a href=pollanswer-edit.php?id=#ID#&layer_opened_nr=1>голосов: #CNT#</a></center>", "8em"),
//	"cnt" => array("Голосов", "ahref", "<center><a href=pollanswer-edit.php?id=#ID#&layer_opened_nr=1>голосов: #CNT#</a></center>", "8em"),
	"multicb" => array ("", "checkbox"),
	"published" => array("", "checkboxro"),
	"~delete" => array("", "checkboxdel")
);


/*
require_once "../_lib/__fixed.php";
$fixed_cond = sqlcond_fromhash($fixed_hash, "e", " and ");
$list_query = "select e.*, count(p.id) as cnt"
	. " from $entity e"
	. " left join pollvote p on p.{$entity}=e.id and p.deleted=0 and p.published=1"
	. " where 1=1 $fixed_cond"
	. " and e.deleted=0"
	. " group by e.id"
	. " order by e." . get_entity_orderby($entity)
	;
*/

?>

<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>