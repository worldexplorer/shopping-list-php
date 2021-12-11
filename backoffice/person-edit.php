<? require_once "../_lib/_init.php" ?>
<?

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

//// BEGIN from product-edit.php

$backrow_tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <font class="name"><label for="#IT_NAME#">#IT_TXT#</label></font></td>
	<td>#IT_WRAPPED# #IT_GRAYCOMMENT_GRAY#</td>
</tr>
EOT;
$backrow_obligatory_sign = "<font color=red title='это поле обязательно для заполнения'>*</font>&nbsp;&nbsp;";

//$icwhose_id_properties = select_field("id", array("hashkey" => "PRODUCT_PROPERTIES"), "icwhose");

$m2m_table = "m2m_{$entity}_iccontent";
$m2m_fixedhash = array();
$absorbing_fixedhash = array($entity => "_global:id");

//	"~3" => array ("Свойства товара", "multicompositeiccontent"
//		, $m2m_table, $m2m_fixedhash, $absorbing_fixedhash, $icwhose_id_properties, "добавить новые свойства товара"),

//// END from product-edit.php


$m2mcb_colcnt = 4;




$composite_inputtype = "multicheckbox";

//$pgroup_table = "tour";
//$product_table = "question";
//$supplier_table = "team";
//$composite_team_question = array($product_table, $supplier_table);

//$compositecontent_select_pgroup_fixedhash	= array("published" => "1");
//$compositecontent_select_product_fixedhash	= array("published" => "1");
//$compositecontent_select_supplier_fixedhash	= array("published" => "1");
////$compositecontent_insert_fixedhash			= array($entity => $id);

$multicompositecontent_pgroup_expanded = true;
$multicompositecontent_product_expanded = true;

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	
	"phone" => array ("", "textfield", ""),
		
	"female" => array ("", "checkbox", 0),
	"unsubscribed" => array ("", "checkbox", 0),

//	"~1_layer-open" => array ("Авторизация", "layer_open"),
	"password" => array ("", "textfield", ""),
	"~login-password" => array ("", "ahref", "<a href=../auth.php?l_login=id#id# target=_blank>$msg_tag_shortcut войти с лица id+пароль</a>"),
	"auth" => array ("", "textfield", ""),
	"~login-auth" => array ("", "ahref", "<a href=../auth.php?l_auth=#AUTH# target=_blank>$msg_tag_shortcut войти с лица токеном</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='?id=#ID#&mode=auth_regenerate'>[Перегенерировать Токен]</a>"),
//	"~generate_auth" => array ("", "ahref", "<a href='?id=#ID#&mode=auth_regenerate'>Перегенерировать Токен</a>"),
//	"~1_layer-close" => array ("Авторизация", "layer_close"),



//	"productbypgroup" => array ("Ответы",
//							"multicompositecontent", "m2m_team_questions",
//							array("question"), 1),

//	"tour" => array ("Верные ответы", "multicompositecontent", "m2m_team_question",
//		$composite_team_question, 1, 0,
//		$pgroup_table, $product_table, $supplier_table),
	
//	"~3" => array ("Верные ответы", "multicb_questions_byTour_forGame_withTeamAnswers"),	
	
	"~3" => array ("Свойства", "multicompositeiccontent"
		, $m2m_table, $m2m_fixedhash, $absorbing_fixedhash
		//, "PRODUCT_PROPERTIES", "добавить новые свойства товара"
		, "PERSON_PROPERTIES", "добавить новые свойства персоны"
	),

	
	"~service_layer-open" => array ("", "layer_open"),
	//"brief" => array ("Кратко<br><br>в список<br>команд", "freetext_200", ""),
	//"brief" => array ("", "textarea", ""),
	//"~12" => array("IMG_PERSON", "img_layer"),
	//"content" => array ("Описание<br><br>в карточку команды,<br>справа от фото", "freetext", ""),
	
	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),
	"date_lastclick" => array ("", "timestampro", ""),
	"lastsid" => array ("", "ro", ""),
	"lastip" => array ("", "ro", ""),
	"user_agent" => array ("", "ro", ""),
	"lastip_login" => array ("Посл авторизация паролем", "ro", ""),
	"lastip_auth" => array ("Посл авторизация токеном", "ro", ""),
	"~service_layer-close" => array ("", "layer_close"),
	
	//"published" => array ("", "checkbox", 1, "@bo_href_preview@"),
	"published" => array ("", "checkbox", 1),
);


function multicb_questions_byTour_forGame_withTeamAnswers() {
	$ret = <<<EOT
<table cellpadding=0 cellspacing=0 style='border:1px solid gray'>
	<tr valign=top>
		<td style='padding-left: 1em; padding-right: 1em;'>$options</td>
	</tr>
</table>

EOT;

	return $ret;
}


?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
