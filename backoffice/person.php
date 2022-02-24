<?
require_once "../_lib/_init.php";

// $debug_query = 1;

//$list_left_additional_fields .= ", count(distinct game.id) as game_cnt";


// $list_left_additional_joins .= ""
// 	. " left join auths auth on auth.person=e.id"
// ;

// $list_left_additional_fields .= ""
// 	. ", group_concat(distinct auths.id, '=', auths.date_created, ':', auths.auth order by auths.id separator '~~') as person_auths"
// ;

// $tpl_login_password = <<< EOT
// <a title='Login via userId+password' href="javascript:popup_url('../index.php?l_person_id=#ID#&l_passwd=#PASSWD#&mode=login_person&l_email=#EMAIL#', 'person_#ID#', '')">$msg_tag_shortcut</a>
// EOT;

$tpl_login_auth = <<< EOT
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../auth.php?l_auth=#AUTH#', 'person_#ID#', '')">$msg_tag_shortcut</a>
<a title='Login via token [#AUTH#]' href="javascript:popup_url('../index.php?auth=#AUTH#', 'person_#ID#', '')">#AUTH#</a>
EOT;

$tpl_single = "<a href='auth-edit.php?id=#ID#'>#IDENT#</a>";
$tpl_multiple = "<a href='auth-edit.php?id=#ID#'>#IDENT_TRUNCATED#</a>";

$table_columns = array (
	"id" => array("", "serno"),
	"date_created" => array("", "timestamp"),

	//"~3" => array("Log in", "ahref", "<a href=/login.php?login=#PHONE#&password=#COOKIE# target=_blank>$msg_tag_shortcut Log in</a>", "6em"),
	//"~3" => array("Log in", "ahref", $tpl_login_password, "6em"),
	//"ident" => array($entity_msg_h, "hrefedit"),
	"~2" => array($entity_msg_h, "ahref", "$tpl_login_auth <a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	"ident" => array("", "textfield", "", "11em", "10em"),

	"phone" => array("", "textfield", "", "11em", "10em"),
	"email" => array("", "textfield", "", "11em", "10em"),

	// "password" => array("", "textfield", "", "11em", "10em"),
	//"auth" => array("", "textfield", "", "11em", "10em"),
	// "auth" => array("", "ahref", "$tpl_login_auth"),
	// "person_auths" => array("Авторизации", "groupconcat_to_ahref", "", $tpl_single, $tpl_multiple),
	"~4" => array("Авторизации", "ahref", "<a href='auth.php?person=#ID#'>#AUTH_CNT#</a>"),
	
	//"game-HASHKEY_ALREADY_USED" => array("", "cnt"),
	//"game" => array("", "cnt"),
	//"game_ident" => array("", "groupconcat"),

	// "female" => array("", "checkbox"),
	// "unsubscribed" => array("", "checkbox"),
	
	"username" => array("", "textfield", "", "11em", "10em"),
	"color" => array("", "textfield", "", "7em", "6em"),

	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


$header_include .= <<<EOT
<script src="js/jquery-3.2.1.slim.min.js" type="text/javascript"></script>

<script>

var ${entity}_columnIndexes_forViewing = [1, 2, 3, 6];
var ${entity}_columnIndexes_forEditing = [1, 2, 5, 7, 8, 9];

/*
$(document).ready(function() {
	var viewing_or_editing = getCookie('{$entity}_showColumns');
	if (viewing_or_editing == "editing") {
		showColumns_forEditing_selected('{$entity}', ${entity}_columnIndexes_forViewing, ${entity}_columnIndexes_forEditing);
	} else {
		// if no cookie was ever set - it's set now to "viewing"
		showColumns_forViewing_selected('{$entity}', ${entity}_columnIndexes_forViewing, ${entity}_columnIndexes_forEditing);
	}
})
*/

</script>

EOT;

$topline_right_fromSubmenu_show = true;

?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>