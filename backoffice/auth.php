<?
require_once "../_lib/_init.php";


$tpl_login_password = <<< EOT
<a title='Login via userId+password' href="javascript:popup_url('../index.php?l_person_id=#ID#&l_passwd=#PASSWD#&mode=login_person&l_email=#EMAIL#', 'person_#ID#', '')">$msg_tag_shortcut</a>
EOT;

$tpl_login_auth = <<< EOT
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../auth.php?l_auth=#AUTH#', 'person_#ID#', '')">$msg_tag_shortcut</a>
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../index.php?auth=#AUTH#', 'person_#ID#', '')">#AUTH#</a>
EOT;


$table_columns = array (
	"id" => array("", "serno"),
	"date_created" => array("", "timestamp"),

	"person_ident" => array("", "ahref", "<a href='person-edit.php?id=#PERSON#'>#PERSON_IDENT#</a>"),

	"~2" => array($entity_msg_h, "ahref", "$tpl_login_password <a href=#ENTITY#-edit.php?id=#ID#>___ #IDENT#</a>"),
	"ident" => array("", "textfield", "", "11em", "10em"),

	"email" => array("", "textfield", "", "11em", "10em"),
	"phone" => array("", "textfield", "", "11em", "10em"),
	"code" => array("", "textfield", "", "6em", "5em"),
	//"auth" => array("", "textfield", "", "11em", "10em"),
	"auth" => array("", "ahref", "$tpl_login_auth"),
	
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);

// $debug_query = 1;
?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>