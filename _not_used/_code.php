<? require_once "_code_once.php" ?>
<?

$root_mmenu_hashkey = "";
$root_mmenu_id = $id;

if ($entity == "mmenu") {
	$mmenu_hashkey = "";
	$mmenu_id = $id;
	$print_href = "mmenu.php?id=$id&print=1";
} else {
	if (!isset($mmenu_id)) {
		$mmenu_hashkey = $entity;

		$debug_query = 0;
// нет смысла создавать mmenu для avacancy-reply.php?id=2, но пусть пока так
		$mmenu_hashkey_eq = "=" . substr(strrchr($_SERVER["REQUEST_URI"], "/"), 1);
		if ($rewrite_engine_on == 1) $mmenu_hashkey_eq .= ".php";
		$mmenu_id = select_field("id", array("hashkey" => $mmenu_hashkey_eq, "deleted" => 0), "mmenu");

		if ($mmenu_id == "") {
			$mmenu_hashkey_eq = "=" . substr(strrchr($_SERVER["SCRIPT_FILENAME"], "/"), 1);
			$mmenu_id = select_field("id", array("hashkey" => $mmenu_hashkey_eq, "deleted" => 0), "mmenu");
		}

		if ($mmenu_id == "") {
			$mmenu_id = select_field("id", array("hashkey" => $mmenu_hashkey, "deleted" => 0), "mmenu");
		}
		$debug_query = 0;
	}
}

//echo "entity=[$entity] mmenu_id=[$mmenu_id]<br>";
$fromend_root_tree_content = select_root_tree_content("mmenu", $mmenu_id);
//pre($fromend_root_tree_content);
$root_tree_content = array_reverse($fromend_root_tree_content);
//pre($root_tree_content);

$fromend_root_tree = array_keys($fromend_root_tree_content);
$root_tree = array_reverse($fromend_root_tree);
$root_mmenu_id = $root_tree[0];
if (isset($root_tree[1])) $root_mmenu_id = $root_tree[1];
//print_r($root_tree);
//print_r($root_mmenu_id);

// для редиректа если что-то в развороте не так
$href_mmenu_upper_level = "/";
if (count($root_tree) > 1) {
	$mmenu_row_upper = $fromend_root_tree_content[$root_tree[count($root_tree)-2]];
//	pre($mmenu_row_upper);
	$href_mmenu_upper_level = mmenu_hrefto($mmenu_row_upper);
}


if (strpos($_SERVER["SCRIPT_FILENAME"], "print") !== false) $print = 1;


//$root_mmenu_row = select_entity_row(array("id" => $root_mmenu_id), "mmenu");

//$mmenu_row = select_entity_row(array("id" => $mmenu_id), "mmenu");
$mmenu_row = $fromend_root_tree_content[$mmenu_id];
//print_r($mmenu_row);
$mmenu_ident = hash_by_tpl($mmenu_row, "#ident#");
$mmenu_title = hash_by_tpl($mmenu_row, "#title#");
$mmenu_pagetitle = hash_by_tpl($mmenu_row, "#pagetitle#");
$mmenu_meta_keywords = hash_by_tpl($mmenu_row, "#meta_keywords#");
$mmenu_meta_description = hash_by_tpl($mmenu_row, "#meta_description#");

$mmenu_hashkey = $mmenu_row["hashkey"];
$mmenu_tpl_list_item = hash_by_tpl($mmenu_row, "#tpl_list_item#", "_global:entity", 1, 0);
$mmenu_tpl_list_wrapper = hash_by_tpl($mmenu_row, "#tpl_list_wrapper#", "_global:entity", 1, 0);


if ($title == "") $title = $mmenu_title;
if ($title == "") $title = $mmenu_ident;
if ($pagetitle == "" && $mmenu_pagetitle != "") $pagetitle = $mmenu_pagetitle;
if ($pagetitle == "" && $title != "") $pagetitle = $title;
if ($pagetitle != "") $pagetitle = $pagetitle_separator . $pagetitle;

if ($meta_keywords == "") $meta_keywords = $mmenu_meta_keywords;
if ($meta_keywords == "") $meta_keywords = $pagetitle;
if ($meta_description == "") $meta_description = $mmenu_meta_description;



$tpl_img_content = <<< EOT
<div class="image" style="width: #IMG_WIDTH#px;">
<a href="#IMG_POPUPHREF#"><img src="#IMG_RELPATH#" border="0" alt="#IMG_TXT#" #IMG_WH#></a>
<p style="width: #IMG_WIDTH#px;">#IMG_TXT#</p>
</div>
EOT;

$mmenu_img_wrapped = prepare_img($tpl_img_content, "IMG_CONTENT", $mmenu_id, "mmenu");
$mmenu_content = hash_by_tpl($mmenu_row, "#CONTENT#", "mmenu");
$mmenu_content = hash_by_tpl($mmenu_img_wrapped, $mmenu_content);



$path_home_HTML = $path_HTML = "<a href=/>$site_name</a>";
//$path_HTML = "";

$mmenu_id_backup = $mmenu_id;
foreach ($root_tree as $mmenu_id) {
//	$mmenu_row_tmp = select_entity_row(array("id" => $mmenu_id), "mmenu");
	$mmenu_row_tmp = $fromend_root_tree_content[$mmenu_id];
	if (isset($mmenu_row_tmp["id"]) && $mmenu_row_tmp["published"] == 1) {
//		pre($mmenu_row_tmp);

		$tpl = <<< EOT
<a href="@mmenu_hrefto@">#IDENT#</a>
EOT;

		if ($path_HTML != "") $path_HTML .= $path_separator;
		$path_HTML .= hash_by_tpl($mmenu_row_tmp, $tpl);
	}
}
$mmenu_id = $mmenu_id_backup;

$imgs_preload = "";

$title_right = "";


?>