<?
require_once "../_lib/_init.php";

function psql_minago($field, $as, $comma = '') {
	return "
	DATE_PART('day', CURRENT_TIMESTAMP - $field) * 24 + 
	DATE_PART('hour', CURRENT_TIMESTAMP - $field) * 60 +
	DATE_PART('minute', CURRENT_TIMESTAMP - $field)
		as $as $comma";
}

// http://www.sqlines.com/postgresql/how-to/datediff
$list_left_fields .= ', '
	. psql_minago('e.lastlogged', 'loggedin_minago', ',')
	. psql_minago('e.date_created', 'registered_minago')
	// . ", AGE(e.date_created) as age"
	// . ' count(msg.id) as msg_count'
;

// $list_left_m2mjoins .=
// 	  " left join purchase purchase_origin on purchase_origin.id=e.purchase_origin"
// 	   " left join message msg on msg.person=person.id"
// ;

// $list_left_fields_groupby =
// 	   ", purchase_origin_ident"
// ;


$tpl_login_password = <<< EOT
<a title='Login via userId+password' href="javascript:popup_url('../index.php?l_person_id=#ID#&l_passwd=#PASSWD#&mode=login_person&l_email=#EMAIL#', 'person_#ID#', '')">$msg_tag_shortcut</a>
EOT;

$tpl_login_auth = <<< EOT
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../auth.php?l_auth=#AUTH#', 'person_#ID#', '')">$msg_tag_shortcut</a>
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../index.php?auth=#AUTH#', 'person_#ID#', '')">#AUTH#</a>
EOT;


$table_columns = array (
	"id" => array("", "viewcenter"),
	// "date_created" => array("", "timestamp"),

	"~2" => array($entity_msg_h, "ahref", "$tpl_login_password <a href=#ENTITY#-edit.php?id=#ID#>___ #IDENT#</a>"),
	// "ident" => array("", "textfield", "", "11em", "10em"),

	"email" => array("", "textfield", "", "11em", "10em"),
	"phone" => array("", "textfield", "", "11em", "10em"),
	"code" => array("", "textfield", "", "6em", "5em"),
	//"auth" => array("", "textfield", "", "11em", "10em"),
	"auth" => array("", "ahref", "$tpl_login_auth"),

	// "rquseragent" => array("", "view"),
	// "rqip" => array("", "view"),
	// "rqsocketid" => array("", "view"),
	
	"registered_minago" => array("Reg", "view"),
	"loggedin_minago" => array("Log", "view"),
	// "age" => array("", "view"),

	"person_ident" => array("", "ahref", "<a href='person-edit.php?id=#PERSON#'>#PERSON_IDENT#</a>"),

	// "lastuseragent" => array("", "view"),
	"lastip" => array("", "view"),
	"lastsocketid" => array("", "view"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

// $debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>