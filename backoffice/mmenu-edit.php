<?
require_once "../_lib/_init.php";

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
//	"annotation" => array ("", "textfield", "", "label for the left column (2nd level only)"),

//	"brief" => array ("", "freetext_450", ""),

	"content" => array ("", "textarea_18", ""),
//	"content" => array ("", "freetext_450", ""),

//	"~11" => array("IMG_CONTENT", "img_layer"),
//	"~14" => array("IMG_COLUMN_LEFT", "img_layer"),
//	"~17" => array("IMG_COLUMN_RIGHT", "img_layer"),

//	"~16" => array("IMG_MMENU_PGROUP", "img_layer"),
//	"~12" => array("IMG_MMENU", "img_layer"),
//	"~13" => array("IMG_PGHEADER", "img_layer"),
//	"~14" => array("IMG_LEFTCOL", "img_layer"),
//	"~15" => array("IMG_RIGHTCOL", "img_layer"),
//	"~17" => array("IMG_TEASERONPARENT", "img_layer"),

//	"~1_open" => array ("Служебные картинки", "layer_open"),
//	"~1_close" => array ("Служебные картинки", "layer_close"),


//	"~mmenuimg_layer-open" => array ("", "layer_open"),
//	"img_header" => array ("Заголовок", "image"),
//	"img_free" => array ("", "image"),
//	"img_mover" => array ("", "image"),

//	"~151" => array ("", "ahref", "&nbsp;"),
//	"img_small_free" => array ("", "image"),
//	"img_small_mover" => array ("", "image"),
//	"img_small_current" => array ("", "image"),

//	"img_ctx_top" => array ("", "image"),
//	"img_ctx_left" => array ("", "image"),
//	"~mmenuimg_layer-close" => array ("", "layer_close"),



	"~service_layer-open" => array ("", "layer_open"),

	"pagetitle" => array ("", "textfield", ""),
	"title" => array ("", "textfield", ""),
	"meta_keywords" => array ("", "textarea_3", ""),
	"meta_description" => array ("", "textarea_3", ""),
//	"banner_top" => array ("Баннер в шапке", "select_soft", "banner"),

//	"left0_right1" => array ("На этой странице", "boolean_hash", $left0_right1_hash, "фыва"),
//	"banner_sky" => array ("Баннер-небоскрёб", "select_soft"),

//	"tpl_list_item" => array ("<a name=tpl></a>Шаблон для элемента", "textarea", ""),
//	"tpl_list_wrapper" => array ("Шаблон для списка элементов<br>(не для страниц-разворотов)", "textarea", ""),

	"is_drone" => array ("", "checkbox", 0, ""),
	"is_heredoc" => array ("", "checkbox", 1, ""),
	"hashkey" => array ("", "textfield", ""),

//	"top_comment" => array ("Комментарий в меню", "textarea_3", ""),
//	"bgcolor" => array ("Цвет бэкграунда", "textfield", ""),

	"parent_id" => array ("", "select_table_tree_root"),
//	"is_inline" => array ("Блоком на родителе", "checkbox"),
//	"published_legend" => array ("", "checkbox", 0),
//	"published_sitemap" => array ("", "checkbox", 0),
	"~service_layer-close" => array ("", "layer_close"),

//	"~1_open" => array ("Классификаторы", "columned_open"),
	"published" => array ("", "checkbox", 1, "@bo_href_preview@"),
//	"~1_close" => array ("Краткое описание и полное содержимое (для отсканированных текстов)", "columned_close"),	
);

//if ($id == 10) {
//	$row_pgheader = array ("~13" => array("IMG_TOP", "img_layer"));
//	$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
//} else {
//	$row_pgheader = array ("~17" => array("IMG_COLUMN_LEFT", "img_layer"));
//	$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
//}

if (isset($id) && $id > 0) {
/*	
	//echo "entity=[$entity] mmenu_id=[$mmenu_id]<br>";
	$fromend_root_tree_content = select_root_tree_content("mmenu", $id);
	//pre($fromend_root_tree_content);
	$fromend_root_tree = array_keys($fromend_root_tree_content);
	$mmenu_level_depth = count($fromend_root_tree);

	if ($mmenu_level_depth == 2) {
		$row_pgheader = array ("~17" => array("Image for the left column", "ahref", "This only appears for the left menu items on 2nd level";			//(currently $mmenu_level_depth)"));
		//$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
		unset($entity_fields["annotation"]);	// should be in else { HERE } below (!!!)
	} else {
		$row_pgheader = array ("~17" => array("IMG_COLUMN_LEFT", "img_layer"));
		$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
	}
*/

	$parent_id_local = select_field("parent_id");
	$parent_row = select_entity_row(array("id" => $parent_id_local));
	//pre($parent_row);
	if ($parent_row["hashkey"] == "MMENU_LEFT") {
		$row_pgheader = array ("~17" => array("IMG_COLUMN_LEFT", "img_layer"));
		$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
	}
	
	
} else {
	$row_pgheader = array ("~17" => array("Image for the left column", "ahref", "This only appears for the Left Menu items"));
	$entity_fields = array_insert($entity_fields, "~service_layer-open", $row_pgheader);
}

$pricelist_valid_entity_fields = array (
	"file1" => array ("Прайс в PDF", "upload"),
	"file1_comment" => array ("", "textarea", ""),
	"~31" => array ("", "ahref", "&nbsp;"),

/*	"file2" => array ("", "upload"),
	"file2_comment" => array ("", "textarea", ""),
	"~32" => array ("", "ahref", "&nbsp;"),

	"file3" => array ("", "upload"),
	"file3_comment" => array ("", "textarea", ""),
	"~33" => array ("", "ahref", "&nbsp;"),

	"file4" => array ("", "upload"),
	"file4_comment" => array ("", "textarea", ""),
	"~34" => array ("", "ahref", "&nbsp;"),

	"file5" => array ("", "upload"),
	"file5_comment" => array ("", "textarea", ""),
	"~35" => array ("", "ahref", "&nbsp;"),
*/
);
/*
$pricelist_redirect_entity_fields = array (
//	"~filesattached_layer-open" => array ("Прайс-лист в PDF</a> (загружать только в пункт меню [<a href=mmenu-edit.php?id=52&layer_opened_nr=3>Нижнее меню -> Прайс-лист</a>])<a>", "layer_open"),
	"~31" => array ("", "ahref", "Общий полный прайс-лист клиники в PDF"
		. "можно загружать только в пункт меню"
		. " [<a href=mmenu-edit.php?id=52&layer_opened_nr=2>Нижнее меню -> Прайс-лист</a>]"),
//	"~filesattached_layer-close" => array ("Прайс-лист в PDF</a> (загружать только в пункт меню [<a href=mmenu-edit.php?id=52&layer_opened_nr=3>Нижнее меню -> Прайс-лист</a>])<a>", "layer_close"),
);

if ($id > 0 &&
		(strpos(select_field("hashkey"), "pricelist") !== false || $id == 52)
	) {
	$entity_fields = hash_insert_after($entity_fields, $pricelist_valid_entity_fields, "~filesattached_layer-open");
} else {
	$entity_fields = hash_insert_after($entity_fields, $pricelist_redirect_entity_fields, "~filesattached_layer-open");
}
*/

?>
<? require "_entity_edit.php" ?>
<? require "_top.php" ?>
<? require "_edit_fields.php" ?>
<? require "_bottom.php" ?>