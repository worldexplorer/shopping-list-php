<?

require_once "../_lib/_init.php";

// $list_left_fields .=
// 	" , p.ident as person_ident"
// 	;

// $list_left_additional_joins .=
// 	" left outer join person p on e.person=p.id and p.deleted=false"
// ;

// $list_left_fields_groupby .=
// 	", icdict_ident"
// ;

if ($mode == "auth_regenerate" && $id > 0) {
	$row = select_entity_row();
	//pre($row);
	$seed = $row["id"] + ":" + time();
	$auth_new = md5($seed);
	//pre("seed[$seed] auth[$auth_new]");
	update(array("auth" => $auth_new));
	$row = select_entity_row();
	//pre($row);
}

$entity_fields = array (
	"ident" => array ("Персона", "textfield", ""),
	"person" => array("", "select_hard"),
	
	"email" => array ("", "textfield", ""),
	"phone" => array ("", "textfield", ""),
	"code" => array ("", "textfield", "", "Истёк 13 дней назад"),
	"auth" => array ("", "textfield", ""),
	"~login-auth" => array ("", "ahref",
		// "<a href=../auth.php?l_auth=#AUTH# target=_blank>$msg_tag_shortcut войти с лица токеном</a>" + 
		// "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" + 
		"<a href='?id=#ID#&mode=auth_regenerate'>[Перегенерировать Токен]</a>"
	),

	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),
	"lastip" => array ("", "ro", ""),
//	"lastip_auth" => array ("Посл авторизация токеном", "ro", ""),
	
	//"published" => array ("", "checkbox", 1, "@bo_href_preview@"),
	"published" => array ("", "checkbox", "", false),
	"deleted" => array ("", "checkbox", "", false),
);

//$debug_query = 1;
?>
<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
