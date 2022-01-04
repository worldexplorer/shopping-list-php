<?

ini_set("asp_tags", 0);
ini_set("magic_quotes_gpc", 0);

ini_set("error_reporting", E_ALL);
//ini_set("error_reporting", 0);
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);

ini_set("session.use_cookies", 1);
ini_set("session.use_only_cookies", 1);

ini_set("register_globals", 0);
ini_set("session.bug_compat_42", 1);
ini_set("session.bug_compat_warn", 1);

//ini_set("mysql.trace_mode", 0);
ini_set("max_execution_time", 60);
//setlocale (LC_ALL, "ru_RU");

ini_set("upload_max_filesize", "5M");
ini_set("post_max_size", "5M");
ini_set("memory_limit", "32M");

ini_set("zlib.output_compression", 1);
ini_set("zlib.output_compression_level", 9);

date_default_timezone_set("America/New_York");

//ini_set("gpc_order", "CGP");
//ini_set("variables_order", "CGPS");


if (!defined("TABLE_PREFIX")) define("TABLE_PREFIX", "ibs_");

if (strpos($_SERVER["SERVER_NAME"], "dev.webie.ru") !== false
	|| strpos($_SERVER["SERVER_NAME"], "localhost") !== false
//	|| strpos($_SERVER["SERVER_NAME"], "powersportsdepot.ca") !== false
	) {
	if (!defined("UPLOAD_PREFIX")) define("UPLOAD_PREFIX", "ibs/");
	if (!defined("LIB_PREFIX")) define("LIB_PREFIX", "ibs/");
} else {
	if (!defined("UPLOAD_PREFIX")) define("UPLOAD_PREFIX", "ibs/");
	if (!defined("LIB_PREFIX")) define("LIB_PREFIX", "");
}

$lib_prefix = LIB_PREFIX;

/*
if (!defined("TABLE_PREFIX")) define("TABLE_PREFIX", "ppro_");
if (!defined("UPLOAD_PREFIX")) define("UPLOAD_PREFIX", "ppro_");
if (!defined("LIB_PREFIX")) define("LIB_PREFIX", "ppro/");
$lib_prefix = LIB_PREFIX;
*/

if (!isset($_SERVER["SERVER_ADDR"])) {
	$_SERVER["DOCUMENT_ROOT"] = "C:/Program Files/Apache/Apache2/htdocs/radiotochka.net/www/t34";
	$_SERVER["SCRIPT_FILENAME"] = basename($_SERVER["PATH_TRANSLATED"]);
//	$_SERVER["PHP_SELF"] = $_SERVER["SCRIPT_FILENAME"];
	$_SERVER["SCRIPT_NAME"] = substr($_SERVER["PATH_TRANSLATED"], strlen($_SERVER["DOCUMENT_ROOT"]));
	$_SERVER["REQUEST_URI"] = $_SERVER["SCRIPT_NAME"];
}

$left0_right1_hash = array(0 => "закладки слева", 1 => "закладки справа");

$include_path = ini_get("include_path");

$ips = (strpos(strtolower($_SERVER["PATH"]), "win") !== false) ? ";" : ":";
$include_path = ini_get("include_path");

$new_include_path = ""
//	. $include_path . $ips
	. "." . $ips
//	. "../_lib" . $ips
	. $_SERVER["DOCUMENT_ROOT"] . $ips
	;
if (LIB_PREFIX != "") $new_include_path .= $_SERVER["DOCUMENT_ROOT"] . "/" . LIB_PREFIX . "_lib/" . $ips;
$new_include_path .= $_SERVER["DOCUMENT_ROOT"] . "/_lib/" . $ips;

ini_set("include_path", $new_include_path);

//ini_set("include_path", $include_path . $ips . "../_lib");
//ini_set("include_path", $include_path . $ips . $_SERVER["DOCUMENT_ROOT"]);

//echo "<pre>/_lib/_init.php: include_path=[" . ini_get("include_path") . "]</pre>";
//phpinfo();

if (!isset($max_execution_time)) $max_execution_time = ini_get("max_execution_time");

// backoffice and backoffice-ro
if (!isset($in_backoffice)) {
	$in_backoffice = 0;
	if (strstr($_SERVER["SCRIPT_NAME"], "backoffice") != FALSE) $in_backoffice = 1;
}

$in_backoffice_readonly = 0;
if (strstr($_SERVER["SCRIPT_NAME"], "backoffice-ro") != FALSE) $in_backoffice_readonly = 1;
$in_backoffice_readonly_msg = "Бэкоффис работает в режиме «только для чтения».\\nНикаких изменений не производилось.";



require_once "_constant.php";

// start MULTILINGUAL SUPPORT INIT

if (!isset($lang_multi_support)) $lang_multi_support = 1;
if (!isset($lang_database_default)) $lang_database_default = "en";
if (!isset($lang_face_default)) $lang_face_default = "en";
if (!isset($lang_backoffice_default)) $lang_backoffice_default = "en";
if (!isset($lang_backoffice_order)) $lang_backoffice_order = array("en", "fr", "ru");
if (!isset($lang_existing)) $lang_existing = array("en", "fr", "ru");
if (!isset($lang_backoffice_out_of_order_force_print)) $lang_backoffice_out_of_order_force_print = 1;
if (!isset($lang_current)) $lang_current = "en";
if (!isset($content_type_charset)) $content_type_charset = "";

// current entity name calculation [entity name]=[table name]=[page name]
if (!isset($entity)) {
	$entity = $_SERVER["PHP_SELF"];
	$entity = substr(strrchr($entity, "/"), 1);
	$entity = substr($entity, 0, strrpos($entity, "."));

	$root_end = strpos($entity, "-");
	if ($root_end > 0) {
//		echo $root_end;
		$entity = substr($entity, 0, $root_end);
	}

/*	reserved for multilanguage pages like "mmenu-en.php" to change entity table
	$tokenpos = strpos($entity, "-");
	if (is_integer($tokenpos)) {
		$lang = substr($entity, $tokenpos+1);
		$entity = substr($entity, 0, $tokenpos);
	}
*/

}
//echo $entity;



$_lang_bo_ahrefs = "";
//if ($lang_multi_support == 1
//	&& $in_backoffice == 1
//		) {
/*
	$lang_existing = array();
	//	pre(getcwd());
	if ($ml_handle = opendir("../_lib/")) {
	//	    echo "Directory handle: $handle\n";
	//	    echo "Files:\n";
	
	    while (false !== ($ml_fname = readdir($ml_handle))) {
	//	        echo "$fname<br>";
	    	$matches = array();
	    	preg_match("~_msg-(.*)\.php~", $ml_fname, $matches);
	//	    	pre($matches);
	    	if (isset($matches[1])) {
	    		$lang_existing[] = $matches[1];
	    	}
	    }
	    closedir($ml_handle);
	}
*/
	
	//	pre($lang_existing);
	
	//$lang_cookied_hash = array ("lang" => "en");
	$lang_current = ($in_backoffice == 1) ? $lang_backoffice_default : $lang_face_default;
	$lang_cookied_hash = array ("lang" => $lang_current);
	$lang_cookied_hash = gethash_bytplhash($lang_cookied_hash, 1, 1);
	$lang_current = $lang_cookied_hash["lang"];
	//pre($lang_cookied_hash);
	
	if (!in_array($lang_current, $lang_existing)) {
		$lang_current = ($in_backoffice == 1) ? $lang_backoffice_default : $lang_face_default;
	}

	require_once "_messages.php";
		
	
	$request_uri = $_SERVER["REQUEST_URI"];
	$self_uri = basename($_SERVER["REQUEST_URI"]);

	$request_uri = preg_replace("~([\?|&])?lang=(\S*)~", "", $request_uri);
	//	pre($request_uri);
	$url_separator = (strpos($request_uri, "?") === false) ? "?" : "&";

	$lang_backoffice_out_of_order = array();
	foreach ($lang_existing as $lang) {
		if (!in_array($lang, $lang_backoffice_order)) {
			$lang_backoffice_out_of_order[] = $lang;
			continue;
		}
		$selected = ($lang == $lang_current) ? "class=cur" : "";

		if ($_lang_bo_ahrefs != "") $_lang_bo_ahrefs .= " | ";
		$lang_title = $lang_hashkey[$lang];
		$_lang_bo_ahrefs .= "<a href='${request_uri}${url_separator}lang={$lang}' $selected title='$lang'>$lang_title</a>";
	}
	
//	pre($lang_backoffice_out_of_order);
	
	if (count($lang_backoffice_out_of_order) > 0 && $lang_backoffice_out_of_order_force_print == 1) {
		foreach ($lang_backoffice_out_of_order as $lang) {
			$selected = ($lang == $lang_current) ? "class=cur" : "";
			if ($_lang_bo_ahrefs != "") $_lang_bo_ahrefs .= " | ";
			$_lang_bo_ahrefs .= "<a href='${request_uri}${url_separator}lang={$lang}' $selected>$lang</a>";
		}	
	}


//	pre($msg_bo_add);
//	require_once "_msg-" . $makers_hash["lang"] . ".php";

//}


if (isset($lang_content_type_charset_hash[$lang_current]) && $lang_content_type_charset_hash[$lang_current] != "") {
	$content_type_charset = "; " . $content_type_charset;
}

// end MULTILINGUAL SUPPORT INIT


require_once "_mysqli.php";

require_once "_sendmail.php";
require_once "_input_types.php";
require_once "_link_types.php";
require_once "_img_layer.php";
require_once "_trtables.php";

require_once "_compositecontent.php";
require_once "_compositebidirect.php";
require_once "_compositeiccontent.php";
require_once "_input_control.php";

//require_once "geocalc-php-1.2/GeoCalc.class.php";
//$oGC = new GeoCalc();



define("OPTIONS_ONE_SPACE", "&nbsp;&nbsp;&nbsp;");
define("OPTIONS_COLOR_BLACK", "#000000");
define("OPTIONS_COLOR_WHITE", "#FFFFFF");
define("OPTIONS_COLOR_GRAY", "#AAAAAA");
define("BACKGROUND_COLOR_WHATSAPP", "#b5ce775c");

define("OPTIONS_COLOR_AHREF", "#0D2B88");
//define("OPTIONS_COLOR_BLUE", "#0D2B88");
define("OPTIONS_COLOR_LIGHTBLUE", "#EFF4F9");
//define("OPTIONS_COLOR_ORANGE", "#FF812D");
//define("OPTIONS_COLOR_ORANGE", "#FA8843");
//define("OPTIONS_COLOR_ORANGE", "#EEF832");
define("OPTIONS_COLOR_ORANGE", "#FF6633");
define("OPTIONS_COLOR_YELLOWBG", "#EEF832");

define("OPTIONS_COLOR_OLIVE", "#666633");
define("OPTIONS_COLOR_GREEN", "#009900");
define("OPTIONS_COLOR_MAROON", "#990000");
define("OPTIONS_COLOR_BROWN", "#996633");

define("COLOR_ENABLED", "#000000");
define("COLOR_DISABLED", "#AAAAAA");




if (get_number("phpinfo") == 1) echo phpinfo();

$_REQUEST = array_merge($_GET, $_POST);




$input_size = array (
	"number" => 20,
	"text" => 80,			//93
	"freetext" => 500,		//93
	"file" => 67,			//78
	"multi" => 5,
	"number_insidelayer" => 15,
	"text_insidelayer" => 70,
	"freetext_insidelayer" => 500,
	"file_insidelayer" => 56
);

if (!isset($no_freetext)) $no_freetext = get_number("no_freetext");
$freetext2textarea = array (
	"freetext" => "textarea_10",
	"freetext_200" => "textarea_3",
	"freetext_450" => "textarea_24",
	"freetext_600" => "textarea_24"
);
if (!isset($as_freetext)) $as_freetext = get_number("as_freetext");


$datetime_fmt = "%d-%b-%Y %H:%M:%S";
$date_fmt = "%d-%b-%Y";

$datetime_fmt = "%Y-%m-%d %H:%M:%S";
$date_fmt = "%Y-%m-%d";
$time_fmt = "%H:%M:%S";

$datetime_fmt_mysql_like = "%Y-%m-%d %H:%M:%S";
$timestamp_fmt_mysql_like = "%Y%m%d%H%M%S";

$timestamp_fmt = "%Y%m%d%H%M%S";

/*
$months = array(" ", "январь", "февраль", "март", "апрель", "май", "июнь",
					"июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");

$months_when = array(" ", "января", "февраля", "марта", "апреля", "мая", "июня",
					"июля", "августа", "сентября", "октября", "ноября", "декабря");

$months_when_short = array(" ", "янв", "фев", "мар", "апр", "мая", "июн",
					"июл", "авг", "сен", "окт", "ноя", "дек");
*/

$months = array(" ", "January", "February", "March", "April", "May", "June",
					"July", "August", "September", "October", "November", "December");

$months_when = $months;

$months_when_short = array(" ", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
					"Jul", "Aug", "Sep", "Oct", "Nov", "Dec");


$gendre_male_hash = array (1 => "мужской", 0 => "женский");
$gendre_female_hash = array (0 => "мужской", 1 => "женский");

$tristate_opthash = array(0 => "&nbsp;", 1 => "да", 2 => "нет");


// system-wide variables
$onload = "";
$errormsg = "";
$alertmsg = get_string("alertmsg");
$no_alert = get_number("no_alert");
$debugmsg = "";
$table = "";
$importlog = "";
$fetchlog = "";
$plog = "";

$html_content_type_encoding_charset = "windows-1251";

// face header variables
if (!isset ($pagetitle)) $pagetitle = "";
if (!isset ($title)) $title = "";
if (!isset ($meta_keywords)) $meta_keywords = "";
if (!isset ($meta_description)) $meta_description = "";
if (!isset ($itnames_jsarray)) $itnames_jsarray = "";
if (!isset ($header_include)) $header_include = "";
if (!isset ($body_include)) $body_include = "";

// used to skip _top && _bottom when including many files
if (!isset($is_inline)) $is_inline = get_number("is_inline");

if (!isset($wrap_imglayer)) $wrap_imglayer = 1;

// user-space debugging options
if (!isset($debug)) $debug = get_number("debug");
if (!isset($debug_query)) $debug_query = 0;
if (!isset($debug_cache)) $debug_cache = 0;
if (!isset($freeze_cache)) $freeze_cache = 0;
if (!isset($debug_sendmail)) $debug_sendmail = 0;
if (!isset($debug_img)) $debug_img = 0;
if (!isset($debug_cookies)) $debug_cookies = 0;
if (!isset($debug_session)) $debug_session = 0;
if (!isset($debug_rewrite)) $debug_rewrite = 0;
if (!isset($debug_lang)) $debug_lang = 0;


//_submenu part

if (!isset($_submenu)) $_submenu = "";
if (!isset($_submenu_forms)) $_submenu_forms = "";
if (!isset($_submenu_hash)) $_submenu_hash = array();
if (!isset($_submenu_searchpage)) $_submenu_searchpage = "#ENTITY#.php";
if (!isset($spanstyle)) $spanstyle = "";
if (!isset($_submenu_rowlimit)) $_submenu_rowlimit = 20;





// userspace list customization
$no_del_warning = 0;
$no_pager = 0;

// message_board.php in rich caused silly notices, turned off path calculation
// Undefined index: is_heredoc in C:\projects\richclub\htdocs\richclub\_code_once.php on line 671
$no_path_HTML = 0;


// userspace list entity-edit customization
$no_topline = 0;
$no_bottomline = 0;

$topline_left_fromSubmenu = "";
//$topline_right_fromSubmenu = "";
$topline_right_fromSubmenu_show = false;



// userspace entity-edit customization
$no_f5 = 0;
$no_prevnext = 0;
$prevnext_published = 0;	// can display non-published elements
$no_savebutton = 0;
$no_backoffice_fields_in_edit_form = 0;
$no_backtolist = 0;
$custom_bottomline = "";
$savebutton_tag = "";
$backtolist_href = "";
$form_edit_method = "post";
// see below $no_add, $no_del


// userspace system routines customization
if (!isset($img_rename0_copy1_moveupload2)) $img_rename0_copy1_moveupload2 = 0;
if (!isset($slashes_ok0_strip1)) $slashes_ok0_strip1 = 0;



// system-wide runtime
$id = get_number("id");
$mode = get_string("mode");
$action = get_string("action");
$kw = get_string("kw");
$q = get_string("q");

// if left empty, automatic bo-href-calculation will be done in face/_bottom.php
$bo_entity = "";
$bo_id = 0;
$bo_href = "";


// printing page without navigation; see face/default.css
$print = get_number("print");
$print_href = "";

$popup = get_number("popup");


$today_dt_datetime = "0000-00-00 00:00:00";
if ($id == 0) $today_dt_datetime = strftime("%Y-%m-%d %H:%M:%S");
$today_datehash = parse_datetime($today_dt_datetime);
$today_uts = datehash_2uts($today_datehash);

$today_ts_datetime = "00000000000000";
if ($id == 0) $today_ts_datetime = strftime("%Y%m%d%H%M%S");

$today_date = strftime("%Y-%m-%d");
$today_datetime = strftime("%Y-%m-%d %H:%M:%S");



// hard to understand, but it happens
$force_selectall_onedit = 0;
$updatemanorder_whileinsert = 1;
$multiflatcontent_mayupdate = 1;

// if not present in _REQUEST, then leave it unchanged; used for gsmtracker for partial update
// affected mostly while runing mkupdatefields_fromform()
if (!isset($selective_update_onedit)) $selective_update_onedit = get_number("selective_update_onedit");


$rows_updated_onedit = 0;
$files_updated_onedit = 0;
$report_rows_updated_onedit = 1;


// layers are hiding large blocks, used anywhere, managed with layer_xxxx() in script.js
$layers_total = 0;
$layer_ident = "";
$layer_inside = 0;
$layer_opened_nr = get_number("layer_opened_nr");



if (!defined("TABLE_PREFIX")) define("TABLE_PREFIX", "");
$non_prefixed_fields = array("id", "published", "deleted", "brief", "brief_no_freetext", "content", "content_no_freetext", "parent_id", "iccontent_tf1");
// поля из-под fixed тоже non-prefixed оказываются


if (!isset($no_add) && in_array($entity, $no_addentity_list)) $no_add = 1;
if (!isset($no_add)) $no_add = 0;
if (!isset($no_del) && in_array($entity, $no_delentity_list)) $no_del = 1;
if (!isset($no_del)) $no_del = 0;
if (!isset($no_search) && isset($no_search_list) && in_array($entity, $no_search_list)) $no_search = 1;
if (!isset($no_search)) $no_search = 0;

if (!defined("UPLOAD_PREFIX")) define("UPLOAD_PREFIX", "");
$matches = array();
preg_match("/(.+)/", UPLOAD_PREFIX, $matches);
$upload_subdir = isset($matches[1]) ? $matches[1] . "/" : "";

$upload_base = "/upload/";
if (!is_writable($_SERVER["DOCUMENT_ROOT"] . $upload_base)) {
	$dirmade = mkdir($_SERVER["DOCUMENT_ROOT"] . $upload_base);
	$chmoded = chmod($_SERVER["DOCUMENT_ROOT"] . $upload_base, 0777);
	$errormsg .= "<b>Создан каталог [$upload_base]</b> [$dirmade][$chmoded]<br>";
}

$upload_relpath = $upload_base . $upload_subdir;
$tmp_relpath = $upload_base . "tmp/";

$upload_abspath = $upload_path = $_SERVER["DOCUMENT_ROOT"] . $upload_relpath;
if (!is_writable($upload_abspath)) {
	$dirmade = mkdir($upload_abspath);
	$chmoded = chmod($upload_abspath, 0777);
	$errormsg .= "<b>Создан каталог [$upload_abspath]</b> [$dirmade][$chmoded]<br>";
}

$tmp_path = $_SERVER["DOCUMENT_ROOT"] . $tmp_relpath;
if (!is_writable($tmp_path)) {
	$dirmade = mkdir($tmp_path);
	$chmoded = chmod($tmp_path, 0777);
	$errormsg .= "<b>Создан каталог [$tmp_path]</b> [$dirmade][$chmoded]<br>";
}

// hide __fixed.php comments, for xls gen
if (!isset($in_silent_mode)) $in_silent_mode = 0;



if (!isset($ondelete_jsmsg)) {
	$ondelete_jsmsg = "С ненужных элементов лучше снимать галку [Опубликовано].\\n"
					. "Вы уверены что хотите удалить?";
}

// colorizing dropdown entity list
$published_opthash_colorized = array (
	  "published_0" => "<option value='#ID#' style='color: #OPTIONS_COLOR_MAROON#' #SELECTED#>#IDENT#</option>"
	, "published_1" => "<option value='#ID#' style='color: #OPTIONS_COLOR_GREEN#' #SELECTED#>#IDENT#</option>"
);

$published_opthash_standard = array (
	  "published_0" => "<option value='#ID#' style='color: #OPTIONS_COLOR_GRAY#' #SELECTED#>#IDENT#</option>"
	, "published_1" => "<option value='#ID#' style='color: #OPTIONS_COLOR_BLACK#' #SELECTED#>#IDENT#</option>"
);

$published_opthash = ($in_backoffice == 1) ? $published_opthash_standard : $published_opthash_colorized;



// human-readable entity name
$entity_msg = isset($entity_list[$entity]) ? $entity_list[$entity] : "entity_msg";
//$entity_msg_h = ucfirst($entity_msg);
$entity_msg_h = $entity_msg;

// used mostly in backoffice when adding new record

$add_msg	= (isset($add_entity_msg_list[$entity]))
				   ? $add_entity_msg_list[$entity] : "новую запись";
$ident_new	= (isset($new_entity_ident_list[$entity]))
				   ? $new_entity_ident_list[$entity] : "новый/ая [$entity_msg]";
$open_msg	= preg_replace("~^\w*\s*~", "", $add_msg);



function ident_from_ident_new($entity) {
	global $new_entity_ident_list;
	
	$msig = " //ident_from_ident_new($entity)";
	if (!isset($new_entity_ident_list[$entity])) return "NO_ENTITY_DEFINED new_entity_ident_list[$entity]" + msig;
	$ident_new = $new_entity_ident_list[$entity];
// split() DEPRECATED as of PHP 5.3.0
//	$ident_new_splitted = split(":", $ident_new);
//	$ident_new_splitted = preg_split("~:~", $ident_new);
	$ident_new_splitted = explode(" ", $ident_new);
//	pre($ident_new_splitted);
	$ident_new_splitted__without_word_new = array_shift($ident_new_splitted);
	$ret = implode(" ", $ident_new_splitted);
//	$ret = strtoupper(ONLY_FIRST_LETTER_CAPITALIZE);

	return $ret;
}


$popupface_href_tpl = "/#ENTITY#.php?id=#ID#";
if (LIB_PREFIX != "") $popupface_href_tpl = "/" . LIB_PREFIX . "#ENTITY#.php?id=#ID#";
$force_published = get_number("force_published");

// for edit pages such as product-edit.php
$bo_href_preview = ($id == 0) ? ""
	: "<a href='/$entity.php?id=$id' target=_blank style='color: "
		. OPTIONS_COLOR_GRAY . "'>$msg_tag_shortcut $msg_bo_preview</a>"
	;

function bo_href_preview($row) {
//	global $id, $entity
//	if ($id > 0) {
//		$ret =  "<a href='/$entity.php?id=$id' target=_blank style='color: "
//			. OPTIONS_COLOR_GRAY . "'>предварительный просмотр</a>";


	global $open_msg, $popupface_href_tpl;
	global $msg_bo_faceopen, $msg_bo_preview, $msg_tag_shortcut;

	$ret = "";

	if ($popupface_href_tpl == "") return $ret;

	$href_face_tpl = $popupface_href_tpl;
	$href_face_tpl .= (!isset($row["published"]) || $row["published"] == 0) ? "&force_published=true" : "";
	$target_blank = (strpos($popupface_href_tpl, "popup") !== false) ? "" : "target='_blank'";


//	pre($row);
	if (isset($row["id"]) && $row["id"] > 0) {
		$row["href_face"] = hash_by_tpl($row, $href_face_tpl);
		$row["open_msg"] = $open_msg;
		$row["ident_urlencoded"] = htmlspecialchars(hash_by_tpl($row, "#IDENT#"));
		$options_color_gray = OPTIONS_COLOR_GRAY;

		$tpl = <<< EOT
<a href="#HREF_FACE#" $target_blank title="$msg_bo_faceopen
#OPEN_MSG#
[#IDENT_URLENCODED#]" style="color: $options_color_gray">$msg_tag_shortcut $msg_bo_preview</a>
EOT;

		$ret = hash_by_tpl($row, $tpl);

	}
	return $ret;
}


// for list pages such as product.php
function popup_face($row) {
	global $open_msg, $popupface_href_tpl, $msg_bo_faceopen, $msg_tag_shortcut;
	$ret = "";

	if ($popupface_href_tpl == "") return $ret;
	$href_face_tpl = $popupface_href_tpl;
	$href_face_tpl .= ($row["published"] == 0) ? "&force_published=true" : "";
	$target_blank = (strpos($popupface_href_tpl, "popup") !== false) ? "" : "target='_blank'";

	$row["href_face"] = hash_by_tpl($row, $href_face_tpl);
	$row["open_msg"] = $open_msg;
	$row["ident_urlencoded"] = htmlspecialchars(hash_by_tpl($row, "#IDENT#"));

	$tpl = <<< EOT
<a href="#HREF_FACE#" $target_blank title="$msg_bo_faceopen
#OPEN_MSG#
[#IDENT_URLENCODED#]
">$msg_tag_shortcut</a>
EOT;

	$ret = hash_by_tpl($row, $tpl);
	
	return $ret;
}



$insert_basehash = array(
	"date_created" => "CURRENT_TIMESTAMP",
	"ident" => $ident_new
);

$update_basehash = array();

// freetext adds absolute link prefixed when switching design and html mode
$strip_from_freetext = array(
	"http://" . $_SERVER["HTTP_HOST"],
	"/backoffice",
	);

$freetext_fields = array();
$tinymce_skipjs = 0;


$m2mcb_colcnt = 4;
$radio_colcnt = 1;

$column_serno = "sernoupdown";
$manorder_field = "manorder";
$manorder_move_page_tpl = "#ENTITY#";
$swapdbfields_move_page_tpl = "#ENTITY#-edit.php?id=#ID#";
if (get_entity_orderfield($entity) != $manorder_field) $column_serno = "serno";

// system-wide, entity-dependable preset for backoffice list, seems to be unuseful
$table_columns = array (
	"id" => array("№", $column_serno),
	"date_created" => array("Дата создания", "timestamp"),
//	"date_updated" => array("Дата обновления", "timestamp"),
	"ident" => array($entity_msg_h, "hrefedit"),
	"published" => array("Опубл", "checkbox"),
	"~1" => array("Удал", "checkboxdel")
);

// system-wide, preset for backoffice list, better performance
$list_query = "";
$list_query_cnt = "";
//redefined in _lib/_messages.php $list_empty_msg = "<b>Нет данных</b>";

$list_left_fields = "";
$list_left_o2mjoins = "";
$list_left_m2mjoins = "";
$list_left_m2mjoins_got_backhref = 0;

$list_left_additional_fields = "";
$list_left_additional_joins = "";



// list templates, managed now automatically from $table_columns in _lib/_list.php
$header_tpl = "";
$item_tpl = "";

// kernel shit, don't touch
$fixed_cond = "";
$fixed_suffix = "";
$fixed_hiddens = "";
//$fixed_getfirstfromdb = 1;
if (!isset($fixed_getfirstfromdb_array)) $fixed_getfirstfromdb_array = array();
$fixed_getfirstfromdb = (in_array($entity, $fixed_getfirstfromdb_array)) ? 1 : 0;

if (!isset($fixed_hash)) $fixed_hash = array();
if (!isset($fixed_fields)) $fixed_fields = array();
if (!isset($entity_swapdbfields_list)) $entity_swapdbfields_list = array();
if (!isset($no_entity_img_leftjoin)) $no_entity_img_leftjoin = array();
if (!isset($img_leftjoin_table)) $img_leftjoin_table = "img";


if (isset($entity_fixed_list)) {
	if (isset($entity_fixed_list[$entity])) {
		if (is_array($entity_fixed_list[$entity])) {
			$fixed_fields = $entity_fixed_list[$entity];
		}
	}
}


/*
if (isset($entity_m2mfixed_list[$entity])) {
	$m2mfixed = $entity_m2mfixed_list[$entity];
	$m2mfixed_dependtable = $m2mfixed[0];
}

//$m2mfixed_dependtable = "";
//pre("m2mfixed_dependtable = $m2mfixed_dependtable");
*/
	

require "__fixed.php";

if (!isset($fixedlike_list)) $fixedlike_list = array("id", "ident");
if (isset($entity_fixedlike_list[$entity])) $fixedlike_list = $entity_fixedlike_list[$entity];
$list_left_joined_like_list = array();

if (!isset($list_url_suffix)) $list_url_suffix = hrefsuffix_fromhash($fixed_hash, "?");
if (!isset($list_query_cond)) $list_query_cond = $o2mfixed_cond . $m2mfixed_cond;
if (!isset($list_query_like_cond)) $list_query_like_cond = "";

if ($q != "") {
	$list_query_like_cond = sqlcond_like_fromlist($fixedlike_list, $q, "e", " and ");

	$list_url_suffix .= ($list_url_suffix == "") ? "?" : "&";
	$list_url_suffix .= "q=" . urlencode($q);
}



function get_m2m_dependtable($entity, $dependant_entity = "") {
	global $entity_m2mfixed_list;
	$ret = "";
	
	if ($entity == $dependant_entity) return $ret;
	if (!is_array($entity_m2mfixed_list)) return $ret;

	foreach ($entity_m2mfixed_list as $m2m_dependtable => $deplist_array) {
//		pre("entity[$entity] dependant_entity[$dependant_entity] m2m_dependtable[$m2m_dependtable] deplist_array[" . pr($deplist_array) . ")");
		if (in_array($entity, $deplist_array)) {
			if ($dependant_entity != "") {
				if (in_array($dependant_entity, $deplist_array)) $ret = $m2m_dependtable;
			} else {
				 $ret = $m2m_dependtable;
			}
		}

		if ($ret != "") break;
	}
	
	return $ret;
}


function get_entity_ismaster_for($entity) {
	global $entity_fixed_list;
	$ret = array();
	
	if ($entity == "parent_id") pre("wrong usage of get_entity_ismaster_for($entity)");
	if (isset($entity_fixed_list[$entity]) && in_array("parent_id", $entity_fixed_list[$entity])) {
		$ret[] = $entity;
	}
	
	foreach ($entity_fixed_list as $master => $deplist_array) {
//		pre("entity[$entity] entity_fixed_list[$entity_fixed_list] deplist_array[" . pr($deplist_array) . ")");
		if (in_array($entity, $deplist_array)) {
			 $ret[] = $master;
		}
	}
	
	return $ret;
}



$order_field = get_entity_orderfield();
$order_dir = get_entity_orderdir();



// kernel list defaults 
$prev_center_next = "";
$href_prev = "";
$href_next = "";

$backrow_bgcolor = OPTIONS_COLOR_WHITE;
$backrow_not_obligatory_sign = "&nbsp;";
$backrow_obligatory_sign = "<font color=red>*</font>";
$backrow_obligatory_jsonly_sign = "<font color=" . OPTIONS_COLOR_GREEN . ">*</font>";
$backrow_obligatory_nojs_sign = "<font color=" . OPTIONS_COLOR_OLIVE . ">*</font>";

$obligatory_field = ($in_backoffice == 1) ? "obligatory_bo" : "obligatory";

$backrow_tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <font class="name"><label for="#IT_NAME#">#IT_TXT#</label></font></td>
	<td>#IT_WRAPPED#</td>
</tr>
EOT;

$backrow_tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <label for="#IT_NAME#">#IT_TXT#</label></td>
	<td>#IT_WRAPPED# #IT_GRAYCOMMENT_GRAY#</td>
</tr>
EOT;

$backrow_tpl_message_under_it_txt = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <label for="#IT_NAME#">#IT_TXT#</label> #MESSAGE_UNDER_IT_TXT#</td>
	<td>#IT_WRAPPED# #IT_GRAYCOMMENT_GRAY#</td>
</tr>
EOT;

$backrow_tpl_message_under_it_wrapped = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#" title="#IT_GRAYCOMMENT#">
	<td align=right width=1% nowrap>#OBLIGATORY_SIGN# <label for="#IT_NAME#">#IT_TXT#</label></td>
	<td>#IT_WRAPPED# #IT_GRAYCOMMENT_GRAY# #MESSAGE_UNDER_IT_TXT#</td>
</tr>
EOT;


$backrow_tpl_backup = "backrow_tpl_backup is empty";


$backrow_columned_tpl = <<< EOT
<td>
	<div><label for="#IT_NAME#">#IT_TXT#</label><div>
	<div>#IT_GRAYCOMMENT_GRAY#</div>
	#IT_WRAPPED#
</td>
<td width=20></td>
EOT;



// pager, may be set at amy time, userspace and kernel

if (!isset($rows_per_page)) {
	$rows_per_page = 20;
	$rows_per_page = (get_number("rows_per_page") > 0) ? get_number("rows_per_page") : 20;
}

if (!isset($pages_per_frame)) {
//	$pages_per_frame = 20;
	$pages_per_frame = (get_number("pages_per_frame") > 0) ? get_number("pages_per_frame") : 20;
}

$pg = get_number("pg");
if (!isset($no_pg999999)) $no_pg999999 = 0;

$limit_sql = " limit $rows_per_page";
$rows_total = 0;
$pager_HTML = "";

if (!isset($pagetitle_separator)) $pagetitle_separator = "&nbsp;&nbsp;|&nbsp;&nbsp;";
if (!isset($path_separator)) $path_separator = "&nbsp;&nbsp;|&nbsp;&nbsp;";
if (!isset($path_home_HTML)) $path_home_HTML = "<a href=/>$site_name</a>";
if (!isset($path_HTML)) $path_HTML = $path_home_HTML;



// system-wide routines


function get_string($name) {
	$ret = "";
//	if ($ret == "" && isset($_GET[$name])) $ret = $_GET[$name];
//	if ($ret == "" && isset($_POST[$name])) $ret = $_POST[$name];

	if ($ret == "" && isset($_REQUEST[$name])) $ret = $_REQUEST[$name];
//	$ret = urldecode($ret);
	return $ret;
}

function get_number($name) {
	return (float) get_string($name);
}

function get_cstring($name) {
	$named_prefixed = prefix_cookie_name($name);
	$ret = isset($_COOKIE[$named_prefixed]) ? $_COOKIE[$named_prefixed] : "";
	return $ret;
}

function get_cnumber($name) {
	return (float) get_cstring($name);
}

function gethash_bytplhash($tplhash
		, $absorb_in_cookie = 1, $get_first_from_cookie = 0
		, $checkboxes_array = array(), $mode_for_checkboxes_update = "update"
		, $tplhash_name = "") {
	global $debug, $debug_cookies, $mode;
	$ret = array();

	foreach ($tplhash as $tplkey => $tplvalue) {
		$value = $tplvalue;

		// email from ic gets into markers_hash for sending letters to customer
		if (strstr($tplkey, "mcicc_") === true) {
			$value_array = get_array($tplkey);
			$rvalue = isset($value_array[0]) ? $value_array[0] : "";
			$cvalue = intval($rvalue);
		} else {
			$rvalue = get_string($tplkey);
			$cvalue = get_cstring($tplkey);
		}

		if ($debug_cookies == 1) {
			$tplkey_prefixed = prefix_cookie_name($tplkey);
			plog("[$tplkey] :: tplvalue=[$tplvalue] : _REQUEST=[$rvalue] : _COOKIE[$tplkey_prefixed]=[$cvalue]");
		}

		if ($rvalue == "") {
			if ($debug_cookies == 1) plog("[$tplkey] :: _REQUEST == []");
			if ($cvalue != "" && $get_first_from_cookie == 1) $value = $cvalue;
		} else {
			$value = $rvalue;
			if ($absorb_in_cookie == 1 && $rvalue != $cvalue) {
				prefixed_setcookie($tplkey, $rvalue);
				if ($debug_cookies == 1) plog("[$tplkey] :: setting cookie to [$rvalue]");
			}
		}
		
		if (in_array($tplkey, $checkboxes_array)) {
			$cb_value = get_string($tplkey);
			$cb_checked = $cb_value == "on" || $cb_value == "1";
			
			$cb_log = "\tcbox[$tplkey]: ";
			if ($mode == $mode_for_checkboxes_update) {
				$value = $cb_checked ? 1 : 0;
				
				$cb_log .= "value=[$value]"
					. " (taken from cb_checked[$cb_checked] <= REQUEST[$tplkey]=[$cb_value])"
					. ": in mode=[$mode_for_checkboxes_update]"
					;
					
				if ($absorb_in_cookie == 1) {
					prefixed_setcookie($tplkey, $value);
					if ($debug_cookies == 1) plog("[$tplkey] :: setting checkbox cookie to [$value]");
				}
			} else {
				$value = intval($value);
				$cb_log .= "value=[$value]"
					. " (taken from tplhash[$tplhash_name])"
					. ": in mode[$mode]!=[$mode_for_checkboxes_update]"
					. " (despite cb_checked[$cb_checked] => REQUEST[$tplkey]=[$cb_value])"
					;
			}
			if ($debug == 1) plog(pr($cb_log));
		}

		$ret[$tplkey] = $value;
		if ($debug_cookies == 1) plog("[$tplkey] :: returning [$value]");
	}

	return $ret;
}

function gethash_bytplhash_nocheckboxes($tplhash, $absorb_in_cookie = 1
		, $get_first_from_cookie_instead_tpl = 0, $get_first_from_cookie_onsubmit = 0
		, $mode_submit = 0, $handle_mode_submit_bymyself = 1) {
			
	global $debug_cookies, $mode, $msg_bo_empty;
	$ret = array();
	
	if ($debug_cookies == 1) {
		echo <<< EOT
gethash_bytplhash(tplhash, absorb_in_cookie = $absorb_in_cookie, get_first_from_cookie_instead_tpl = $get_first_from_cookie_instead_tpl, get_first_from_cookie_onsubmit = $get_first_from_cookie_onsubmit, mode_submit = $mode_submit, handle_mode_submit_bymyself = $handle_mode_submit_bymyself)<br><br>
EOT;
	}
	
	if ($handle_mode_submit_bymyself == 1 && $mode_submit == 0 && $mode == "update") $mode_submit = 1;
	if ($debug_cookies == 1) echo "mode_submit = $mode_submit<br>";

	foreach ($tplhash as $tplkey => $tplvalue) {
		$value = $tplvalue;
		$cvalue = get_cstring($tplkey);
		$rvalue = get_string($tplkey);

		if ($get_first_from_cookie_instead_tpl == 1 && $cvalue != "") $value = $cvalue;
		if ($get_first_from_cookie_onsubmit == 1 && $mode_submit == 1 && $cvalue != "") $value = $cvalue;

		if ($mode_submit == 1 && $rvalue != "") {
			if ($absorb_in_cookie == 1 && $rvalue != $cvalue) {
				prefixed_setcookie($tplkey, $rvalue, time() + 60*60*24*30);	// 30days
				if ($debug_cookies == 1) echo "[$tplkey] :: setting cookie to [$rvalue]<br>";
			}
			$value = $rvalue;
			if ($debug_cookies == 1) echo "[$tplkey] :: tplvalue=[$tplvalue] : _REQUEST=[$rvalue] : _COOKIE=[$cvalue] returning [$value]<br>";
		} else {
			if ($debug_cookies == 1) echo "[$tplkey] :: rvalue = $msg_bo_empty<br>";
		}

		$ret[$tplkey] = $value;
		if ($debug_cookies == 1) echo "[$tplkey] :: returning [$value]<br>";
	}

	return $ret;

}

function prefix_cookie_name($key, $separator = "~") {
	global $site_ident, $debug_cookies;

	$prefix = $site_ident;
	if ($_SERVER["SERVER_PORT"] != "80") {
		$prefix = str_replace($_SERVER["SERVER_NAME"], $site_ident, $_SERVER["HTTP_HOST"]);
//		$dirname = dirname($_SERVER["REQUEST_URI"]);
//		if (substr($dirname, 0, 1) == "/") $dirname = substr($dirname, 1, strlen($dirname));
//		$prefix .= $dirname;
	}
	return $prefix . $separator . $key;
}

function prefixed_setcookie($cname, $value = "", $expiration_date = 0) {
	global $debug_cookies;
	
	$from_now_30_days = time() + 60*60*24*30;
	if ($expiration_date == 0) $expiration_date = $from_now_30_days;
	

	$cname_prefixed = prefix_cookie_name($cname);

//	pre("prefixed_setcookie($$cname, $value, $timestamp)");

	if ($value == "") {
		if ($debug_cookies == 1) plog("\tsetcookie[$cname_prefixed] REMOVED:[$value]");
		setcookie($cname_prefixed);
		return;
	}
	
	if ($expiration_date == 0) {
		if ($debug_cookies == 1) plog("\tsetcookie[$cname_prefixed] REMOVED:[$value] EXPIRES[$expiration_date])");
		setcookie($cname_prefixed, $value);
		return;
	}
	
	if ($debug_cookies == 1) {
		$cookie_old = get_cstring($cname);
		$added_or_replaced = $cookie_old == ""
			? "ADDED[$value]"
			: "REPLACED[$cookie_old]=>[$value]";
		plog("\tsetcookie[$cname_prefixed] $added_or_replaced, EXPIRES[$expiration_date]");
	}
	setcookie($cname_prefixed, $value, $expiration_date);
}



function gethash_bytplhash_mcicc($tplhash, $absorb_in_cookie = 1, $get_first_from_cookie = 0) {
	global $debug_cookies, $site_ident;
	$ret = array();

	foreach ($tplhash as $tplkey => $tplvalue) {
		$tplkey_cookie = $site_ident . "_" . $tplkey;
		$value = $tplvalue;

		$rvalue = get_string($tplkey);
		$cvalue = get_cstring($tplkey_cookie);

		// email from ic gets into markers_hash for sending letters to customer
		if (strstr($tplkey, "mcicc_") !== false) {
			$value_array = get_array($tplkey);
			$rvalue = isset($value_array[0]) ? $value_array[0] : "";
			$cvalue = intval($rvalue);
		}

		if ($debug_cookies == 1) echo "[$tplkey] :: tplvalue=[$tplvalue] : _REQUEST=[$rvalue] : _COOKIE[$tplkey_cookie]=[$cvalue]<br>";

		if ($rvalue == "") {
			if ($debug_cookies == 1) echo "[$tplkey] :: _REQUEST == []<br>";
			if ($cvalue != "" && $get_first_from_cookie == 1) $value = $cvalue;
		} else {
			$value = $rvalue;
			if ($absorb_in_cookie == 1 && $rvalue != $cvalue) {
				setcookie($tplkey_cookie, $rvalue, time() + 60*60*24*30);
				if ($debug_cookies == 1) echo "[$tplkey] :: setting cookie to [$rvalue]<br>";
			}
		}

		$ret[$tplkey] = $value;
		if ($debug_cookies == 1) echo "[$tplkey] :: returning [$value]<br>";
	}

	return $ret;
}

function get_date($name) {
	$ret = "";
	if (get_string("{$name}_year") != "") {
		$month = get_number("{$name}_month");
		if ($month == 0) $month = 1;
		$day = get_number("{$name}_day");
		if ($day == 0) $day = 1;

		$ret =
			sprintf("%04d", get_number("{$name}_year")) . "-" .
			sprintf("%02d", $month) . "-" .
			sprintf("%02d", $day) . " " .
			sprintf("%02d", get_number("{$name}_hour")) . ":" .
			sprintf("%02d", get_number("{$name}_minute")) . ":" .
			sprintf("%02d", get_number("{$name}_second"));
	}

	return $ret;
}

function get_arrayfirst($it_name) {
	$ret = 0;

	$value_arr = get_array($it_name);
	if (count($value_arr) > 0) $ret = $value_arr[0];

	return $ret;
}

function get_array($it_name) {
	$ret = array();

	if (isset($_REQUEST[$it_name])) {
		$ret = $_REQUEST[$it_name];
	}
	
	return $ret;
}




function get_sstring($name, $absorb = 1) {
	$ret = "";

	if ($absorb == 1) $_SESSION[$name] = get_string($name);
	if (isset($_SESSION[$name])) $ret = $_SESSION[$name];

	return $ret;
}

function get_snumber($name, $absorb = 1) {
	$ret = 0;

	if ($absorb == 1) $_SESSION[$name] = get_number($name);
	if (isset($_SESSION[$name])) $ret = $_SESSION[$name];

	return $ret;
}

function get_sarray($name, $absorb = 1) {
	$ret = array();

	if ($absorb == 1) $_SESSION[$name] = get_array($name);
	if (isset($_SESSION[$name])) $ret = $_SESSION[$name];
	
	return $ret;
}




function ts2human($ts) {
	global $date_fmt, $datetime_fmt;
	$ret = "<!--ts2human(): error-->";

	$year_ = 0;
	$month_ = 0;
	$day_ = 0;
	$hour_ = 0;
	$minute_ = 0;
	$sec_ = 0;


	$matches = array();
	preg_match ("/(....)-(..)-(..) (..):(..):(..)/", $ts, $matches);
//	print_r($matches); echo "<br>";

	if (count($matches) > 0) {
		$year_ = $matches[1];
		$month_ = $matches[2];
		$day_ = $matches[3];
		$hour_ = $matches[4];
		$minute_ = $matches[5];
		$sec_ = $matches[6];
	} else {
		$matches = array();
		preg_match ("/(....)(..)(..)(..)(..)(..)/", $ts, $matches);
//		print_r($matches);
	
		if (count($matches) > 0) {
			$year_ = $matches[1];
			$month_ = $matches[2];
			$day_ = $matches[3];
			$hour_ = $matches[4];
			$minute_ = $matches[5];
			$sec_ = $matches[6];
		}
	}


	$unix_timestamp = @mktime ($hour_, $minute_, $sec_, $month_, $day_, $year_);

	//windows debug
	if (
		($hour_ < 0 || $minute_ < 0 || $sec_ < 0 || $month_ < 0 || $day_ < 0 || $year_)
		&& isset($_SERVER["WINDIR"])
		) {
//		pre("ts2human($ts)");
	}

	if ($hour_ == 0 && $minute_ == 0 && $sec_ == 0) {
		$ret = strftime($date_fmt, $unix_timestamp);
	} else {
		$ret = strftime($datetime_fmt, $unix_timestamp);
	}



	return $ret;
}

function getmicrotime(){ 
    list($usec, $sec) = explode(" ",microtime()); 
    return ((float)$usec + (float)$sec); 
}

$start_execution_time = getmicrotime();

function makestrict($string_long, $separator = "_") {
	$ret = "";

	$ret = $string_long;
// price_1 / currency_1
	$pos = strpos($ret, $separator);
	$len = strlen($ret);
	if ($pos > 0) $ret = substr($ret, 0, $pos);

	return $ret;
}




function get_entity_orderfield($entity_ = "_global:entity") {
	global $entity, $entity_orderby_list, $manorder_field;
	$ret = "";
	
//	if ($entity_ == "_global") $entity_ = $entity;
	$entity_ = absorb_variable($entity_);

	if (isset($entity_orderby_list)) {
		if (isset($entity_orderby_list[$entity_])) {
			$ret = $entity_orderby_list[$entity_];
		}
	}

	if ($ret == "") {
		$ret = $manorder_field;
	} else {
// split() DEPRECATED as of PHP 5.3.0
//		list($field, $direction) = split(" ", $ret);
		list($field, $direction) = explode(" ", $ret);
		$ret = $field;
	}
	
	return $ret;
}

function get_entity_orderdir($entity_ = "_global:entity") {
	global $entity, $entity_orderby_list;
	$ret = "";
	
//	if ($entity_ == "_global") $entity_ = $entity;
	$entity_ = absorb_variable($entity_);

	if (isset($entity_orderby_list)) {
		if (isset($entity_orderby_list[$entity_])) {
			$ret = $entity_orderby_list[$entity_];
		}
	}

	if ($ret == "") {
		$ret = "asc";
	} else {
// split() DEPRECATED as of PHP 5.3.0
//		list($field, $direction) = split(" ", $ret);
		list($field, $direction) = explode(" ", $ret);
		$ret = $direction;
	}
	
	return $ret;
}



function get_entity_orderby($entity_ = "_global:entity") {
	global $entity;
	$ret = "";
	
//	if ($entity_ == "_global") $entity_ = $entity;
	$entity_ = absorb_variable($entity_);

	$orderfield = get_entity_orderfield($entity_);
	$orderdir = get_entity_orderdir($entity_);

	$ret = "$orderfield $orderdir";
	
	return $ret;
}


function get_entity_revorderby($entity_ = "_global:entity") {
	global $entity;
	$ret = "";
	
//	if ($entity_ == "_global") $entity_ = $entity;
	$entity_ = absorb_variable($entity_);

	$orderfield = get_entity_orderfield($entity_);
	$orderdir = get_entity_orderdir($entity_);

//	echo "was[$entity_][$orderdir] ";
	if ($orderdir == "asc") $orderdir = "desc";
	else $orderdir = "asc";
//	echo "became[$entity_][$orderdir] ";

	$ret = "$orderfield $orderdir";
	
	return $ret;
}


// big deal sorting tables, will be used backoffice-widely

function orderby_split($rq_param = "orderby", $set_global = 1) {
	global $entity_orderby_list, $entity, $url_suffix, $fixed_suffix;
	$ret = "";

	$orderby = get_string($rq_param);
	if ($orderby != "") {
		if ($fixed_suffix != "") $fixed_suffix .= "&";
		$fixed_suffix .= "$rq_param=$orderby";

// split() DEPRECATED as of PHP 5.3.0
//		$entities_orderby_list = split(":", $orderby);
//		$entities_orderby_list = preg_split("~:~", $orderby);
		$entities_orderby_list = explode(":", $orderby);
//		pre($entities_orderby_list);

		foreach ($entities_orderby_list as $field_direction) {
			if ($ret != "") $ret .= ", ";
			$ret .= str_replace ("-", " ", $field_direction);
		}
	}

	if ($ret == "") $ret = $entity_orderby_list[$entity];
	if ($set_global == 1) $entity_orderby_list[$entity] = $ret;

	return $ret;
}

function redirect($rel_or_abs_url, $debug = 0, $force_die = 1) {
	$abs_urlpath = "/";

	$url_script = basename($rel_or_abs_url);
	$url_path = dirname($rel_or_abs_url);
	$url_path = str_replace("\\", "/", $url_path);
	$cur_path = dirname($_SERVER["SCRIPT_NAME"]);

	if ($cur_path == "\\") $cur_path = "/";

	if ($cur_path != "/") {
		if ($url_path != ".") {
			if ($url_path == "") {
				$abs_urlpath = "/" . basename(LIB_PREFIX);
			} else if (substr($url_path, 0, 1) == "/") {
				$abs_urlpath = "/" . basename(LIB_PREFIX) . $url_path;
			} else {
				$abs_urlpath = $cur_path . "/" . $url_path . "/";
			}
		} else {
			$abs_urlpath = $cur_path . "/";
		}
	} else {
		if ($url_path != ".") {
			if (substr($url_path, 0, 1) == "/") {
				$abs_urlpath = $url_path . "/";
			} else {
				$abs_urlpath = "/" . $url_path . "/";
			}
		}
	}

	$absolute_url = "http://" . $_SERVER["HTTP_HOST"] . $abs_urlpath . $url_script;
	
	if ($debug == 1) {
		echo "rel_or_abs_url=[$rel_or_abs_url]<br>\n";
		echo "url_script=[$url_script]<br>\n";
		echo "url_path=[$url_path]<br>\n";
		echo "_SERVER[SCRIPT_NAME]=[" .  $_SERVER["SCRIPT_NAME"] . "]<br>\n";
		echo "cur_path=[$cur_path]<br>\n";
		echo "absolute_url=[$absolute_url]<br>\n";
	} else {
		header("Location: " . $absolute_url);
//		header();
		if ($force_die == 1) die();
	}
}

function absorb_fixedhash($fixed_hash = array()) {
	$absorbed_fixedhash = array();

	foreach ($fixed_hash as $key => $value) {
		$absorbed_key = absorb_variable($key);
		$absorbed_value = absorb_variable($value);

		$absorbed_fixedhash[$absorbed_key] = $absorbed_value;
	}
//	pre($absorbed_fixedhash);
	
	return $absorbed_fixedhash;
}

function absorb_variable($vpointer) {
//	$ret = "";

	if (is_string($vpointer)) {
		if (substr($vpointer, 0, 7) == "_global") {  // like "_global:id"
// split() DEPRECATED as of PHP 5.3.0
//			$vpointer_splitted = split (":", $vpointer);
//			$vpointer_splitted = preg_split("~:~", $vpointer);
			$vpointer_splitted = explode(":", $vpointer);
//			pre($vpointer_splitted);
			$global_name = $vpointer_splitted[1];
			$ret = $GLOBALS[$global_name];
		} else {
			$ret = $vpointer;
		}
	} else {
		$ret = $vpointer;
	}

	return $ret;
}


function spaces_bylevel($level = 0) {
	$spaces = "";
	for ($j=1; $j < $level; $j++) $spaces .= OPTIONS_ONE_SPACE;
	return $spaces;
}

function possible_html($content) {
//	$content = stripslashes($content);			// turned off for textarea not to eat typed \
	if (strip_tags($content) == $content) {
//		$content = str_replace("\n", "<br>", $content);
		$content = nl2br($content);
	}
	return $content;
}

function pre($variable, $varname = "") {
	if ($varname != "") {
		echo "[$varname]:";
	}
	echo "<pre style='font-family: Courier New; font-size: 10px;'>";
	print_r($variable);
	echo "</pre>";
}

function pr($variable, $varname = "") {
	ob_start();
	if ($varname != "") {
		echo "[$varname]:";
	}
	$ret = "";

	print_r($variable);
	$ret = ob_get_clean();
	
	return $ret;
}

function plog($str, $appendix = "\n") {
	global $plog;
	
//	$str = str_replace ("\n", "\r\n", $str);
	$plog .= $str . $appendix;
}

function array_insert($hashWhereTo, $keyToInsertBefore, $hash2insert) {
	$ret = array ();
	foreach ($hashWhereTo as $key => $value) {
		if ($key == $keyToInsertBefore) {
			foreach ($hash2insert as $keyInserting => $valueInserting) {
				//echo "inserting key[$keyInserting] before[$keyToInsertBefore] with content[" . pr($valueInserting) . "]";
				$ret[$keyInserting] = $valueInserting;
			}
		}
		$ret[$key] = $value;
	}
	return $ret;
}


// JSV should be updated!

$no_jsv = 0;
$jsv_body = "";
$jsv_forms_hash = array();
$jsv_core = "";
$focus_itname = "";
$FTB_StartUpArray = "";

function jsv_core() {
	global $jsv_core, $jsv_body;

	$ret = "";

	if ($jsv_core == "") {
		if ($jsv_body != "") {
			$tpl = <<< EOT
function #HASHKEY#(str) {
	regexp = #CONTENT#
	return regexp.test(str)
}

EOT;

//			$ret = entity_list_tpl($tpl, "", "jsvalidator", 0);

			$query = "select * from jsvalidator where published = 1 and content != '' and hashkey not in ('', 'JSV_NONE')";
			$ret = query_by_tpl($query, $tpl);
		}

			$ret = <<< EOT

<!--jsv_core-->
<script>
$ret

function isPlainDateFilled(it_name, debug, form_name) {
	ret = false
	
	form_name = (arguments.length >= 3) ? arguments[2] : "form_edit";
	vitem = form_find_it(it_name + "_year", form_name)
	if (debug == 1) {
		confirmed = confirm("it_name [" + it_name + "] vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
		confirmed = confirm("vitem.value == 0 [" + (vitem.value == 0) + "] vitem.value == '0' [" + (vitem.value == '0') + "]")
		if (!confirmed) return false
	}
	if (vitem.value == 0) return false

	vitem = form_find_it(it_name + "_month", form_name)
	if (debug == 1) {
		confirmed = confirm("it_name [" + it_name + "] vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}
	if (vitem.value == 0) return false

	vitem = form_find_it(it_name + "_day", form_name)
	if (debug == 1) {
		confirmed = confirm("it_name [" + it_name + "] vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}
	if (vitem.value == 0) return false

	return true
}

function focusPlainDateFailure(it_name, form_name) {
	ret = null
	
	form_name = (arguments.length >= 2) ? arguments[1] : "form_edit";
	vitem = form_find_it(it_name + "_day", form_name)
//	if (vitem.value == 0) ret = vitem
	if (vitem.value == 0) {
		vitem.focus()
		return
	}
	
	vitem = form_find_it(it_name + "_month", form_name)
//	if (vitem.value == 0) ret = vitem
	if (vitem.value == 0) {
		vitem.focus()
		return
	}

	vitem = form_find_it(it_name + "_year", form_name)
//	if (vitem.value == 0) ret = vitem
	if (vitem.value == 0) {
		vitem.focus()
		return
	}

//	if (ret != null) ret.focus()
}


function isMulticheckboxChecked(it_name, debug, form_name) {

	form_name = (arguments.length >= 3) ? arguments[2] : "form_edit";

	vitem_array = form_find_it(it_name, form_name)
	if (debug) alert (vitem_array.length)
	
	for (i=0; i < vitem_array.length ; i++) {
		vitem = vitem_array[i]
		if (debug) alert ("ic.id=" + vitem.id + "; checked=" + vitem.checked)
		if (vitem.checked == true) return true
	}

	return false
}

function focusMulticheckboxFirst(it_name, form_name) {
	form_name = (arguments.length >= 2) ? arguments[1] : "form_edit";
	vitem_array = form_find_it(it_name, form_name)
	if (vitem_array.length > 0) {
		vitem_array[0].focus()
	}
}


</script>
<!--/jsv_core-->

EOT;
	}

	return $ret;
}


function jsv_addvalidation($jsv_hashkey, $it_name, $it_name_txt = "", $debug = 0, $form_name = "form_edit", $write_jsv_code_to_output = 1) {
	global $layer_inside, $layers_total, $no_jsv, $jsv_body;
	global $backrow_not_obligatory_sign, $backrow_obligatory_sign;
	global $jsv_forms_hash, $msg_fields;
	global $msg_bo_jsv_checkbox_not_checked, $msg_bo_jsv_fieldcheck_failed;

	$ret = $backrow_not_obligatory_sign;
	
	if ($it_name_txt == "" && isset($msg_fields[$it_name])) $it_name_txt = $msg_fields[$it_name];

	$it_name_txt = str_replace("<br>", " ", $it_name_txt);
	$it_name_txt = str_replace("<br />", " ", $it_name_txt);
	$it_name_txt = str_replace("\r\n", " ", $it_name_txt);
	$it_name_txt = strip_tags($it_name_txt);
	
	$js_validation = "";

	if ($jsv_hashkey != "" && $jsv_hashkey != "JSV_NONE") {
		$ret = $backrow_obligatory_sign;

		$layer_open_call = "// layer_switch_forceopened($layers_total)";
		if ($layer_inside == 1 && $layers_total > 0) $layer_open_call = "layer_switch_forceopened($layers_total)";
		
		switch ($jsv_hashkey) {
			case "JSV_TF_CHAR":
			case "JSV_TF_CHAR_LOGINSET":
			case "JSV_TF_DIGIT":
			case "JSV_TF_DIGITS":
			case "JSV_TF_PHONE":
			case "JSV_TF_ELETTERS":
			case "JSV_TF_RLETTERS":
			case "JSV_TF_EMAIL":
			case "JSV_TF_SHORTURL":
			case "JSV_SELECT_SELECTED":
				$js_validation .= <<< EOT
	vitem = form_find_it("$it_name", "$form_name")	//include null processing to other jsv func (date...)
	debug = $debug
	if (debug == 1) {
		confirmed = confirm("$it_name [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}
	if (vitem != null) {
		if (!$jsv_hashkey(vitem.value)) {
			alert('$msg_bo_jsv_fieldcheck_failed: "$it_name_txt"')
			$layer_open_call
			vitem.focus()
			return false
		}
	} else {
		if (debug == 1) {
			confirmed = confirm("$it_name [" + vitem + "]: value=[" + vitem.value + "]")
			if (!confirmed) return false
		}
	}


EOT;
				break;
			
			case "JSV_MULTISELECT_SELECTED":
				echo "jsv_addvalidation: no handler for jsv_hashkey=[$jsv_hashkey]<br>";
				break;

			case "JSV_MULTICHECKBOX_CHECKED":
			case "JSV_RADIOGROUP_SELECTED":
//				echo "jsv_addvalidation: no handler for jsv_hashkey=[$jsv_hashkey]<br>";
/*
<label for="ic_6">Ассортимент магазина</label>
<input type=checkbox name='ic_6[]' id='ic_6_6_20' value='20'  checked > Цифровые фотокамеры
<input type=checkbox name='ic_6[]' id='ic_6_6_21' value='21'          > МР3-плееры
<input type=checkbox name='ic_6[]' id='ic_6_6_22' value='22'  checked > Мыши
*/
				$js_validation .= <<< EOT

	if (!isMulticheckboxChecked("${it_name}[]", $debug, "$form_name")) {
		alert('$msg_bo_jsv_fieldcheck_failed: "$it_name_txt"')
		$layer_open_call
		focusMulticheckboxFirst("${it_name}[]", "$form_name")
		return false
	}

EOT;
				break;

			case "JSV_CHECKBOX_CHECKED":
//				echo "jsv_addvalidation: no handler for jsv_hashkey=[$jsv_hashkey]<br>";
/*
<input type="checkbox" name="agreed" id ="agreed">
*/
				$js_validation .= <<< EOT


	vitem = form_find_it("$it_name", "$form_name")	//include null processing to other jsv func (date...)
	debug = $debug
	if (debug == 1) {
		confirmed = confirm("$it_name [" + vitem + "]: checked=[" + vitem.checked + "] value=[" + vitem.value + "]")
		if (!confirmed) return false
	}


	if (vitem != null) {
		if (vitem.checked != true) {
			alert('$msg_bo_jsv_checkbox_not_checked "$it_name_txt"')
			$layer_open_call
			vitem.focus()
			return false
		}
	} else {
		if (debug == 1) {
			confirmed = confirm("$it_name [" + vitem + "]: value=[" + vitem.value + "]")
			if (!confirmed) return false
		}
	}

EOT;
				break;


			case "JSV_RADIOGROUP_CHECKED":
//				echo "jsv_addvalidation: no handler for jsv_hashkey=[$jsv_hashkey]<br>";
/*
<input type=radio name='delivery' id='delivery_1' value='1'  > <label for='delivery_1' >курьером за пределами МКАД г. Москвы</label>
<input type=radio name='delivery' id='delivery_2' value='2'  > <label for='delivery_2' >курьером за пределами МКАД г. Москвы</label>
<input type=radio name='delivery' id='delivery_3' value='3'  > <label for='delivery_3' >по Московской области и городам России</label>
<input type=radio name='delivery' id='delivery_4' value='4'  > <label for='delivery_4' >Заказы со статусом САМОВЫВОЗ</label>
*/
				$js_validation .= <<< EOT


	vitem_array = form_find_it("$it_name", "$form_name")	//include null processing to other jsv func (date...)
	debug = $debug
	if (debug == 1) {
		confirmed = confirm("$it_name [" + vitem_array + "]: length=[" + vitem_array.length + "]")
		if (!confirmed) return false
	}

	first_for_focus = null
	anything_cheched = true
	if (vitem_array.length > 0) {
		anything_cheched = false
		
		for (i=0; i < vitem_array.length ; i++) {
			vitem = vitem_array[i]
			if (debug == 1) alert ("id=" + vitem.id + "; checked=" + vitem.checked)
			if (first_for_focus == null) first_for_focus = vitem
			if (vitem.checked == true) {
				anything_cheched = true
				break
			}
		}
	}

	if (anything_cheched == false) {
		alert('Выберите "$it_name_txt"')
		$layer_open_call
		if (debug == 1) alert ("first_for_focus id=" + first_for_focus.id)
		if (first_for_focus != null) first_for_focus.focus()
		return false
	}


EOT;
				break;


			case "JSV_PLAINDATE_FILLED":
				$js_validation .= <<< EOT

	if (!isPlainDateFilled("$it_name", $debug, "$form_name")) {
		alert('$msg_bo_jsv_fieldcheck_failed: "$it_name_txt"')
		$layer_open_call
		focusPlainDateFailure("$it_name", "$form_name")
		return false
	}

EOT;
				break;

			default:
				echo "jsv_addvalidation: no handler for jsv_hashkey=[$jsv_hashkey]<br>";
		}

		if ($write_jsv_code_to_output == 1) $jsv_body .= $js_validation;
// $jsv_body deprecated, we use now $jsv_forms_hash and jsv_flush_validation_functions()
// but still might be used for one-form-per-page to compose customized body of form_edit_submit()
/*		
if ($jsv_body != "") {
	echo <<< EOT
<script>
function form_edit_submit() {
	//	alert ("validations here");
	$jsv_body
	
	document.form_edit.submit()
}
</script>

EOT;
*/

		if (!isset($jsv_forms_hash[$form_name])) $jsv_forms_hash[$form_name] = "";
		$jsv_forms_hash[$form_name] .= $js_validation;

	}
	
//	pre($jsv_forms_hash);
	
	return $ret;
}


function jsv_flush_validation_functions() {
	global $jsv_forms_hash;

	$ret = "";

	foreach ($jsv_forms_hash as $form_name => $js_validation) {
		$ret .= <<< EOT

function ${form_name}_submit() {
	//	alert ("validations here");
	$js_validation
	
	document.${form_name}.submit()
}

EOT;

	}
	

	$ret = <<< EOT
	
<!-- jsv_flush_validation_functions() -->
<script>
$ret
</script>
<!-- /jsv_flush_validation_functions() -->

EOT;

	return $ret;
}



function jsv_flush_validation_functions_and_core() {
	global $jsv_forms_hash;
	$ret = "";

//	pre($jsv_forms_hash);
	
	if (count($jsv_forms_hash) > 0) {
		$ret = jsv_flush_validation_functions();
		$ret .= jsv_core();
	}
	return $ret;
}




$rewrite_engine_on = 0;

function hashkey_addprefix($hash, $prefix, $selected_only = array(), $erase_old = 0) {
	$ret = array();

	foreach ($hash as $key => $value) {
		if (count($selected_only) > 0 && in_array($key, $selected_only)) {
			if ($erase_old == 0) $ret[$key] = $value;
		$ret[$prefix . $key] = $value;
		} else {
			$ret[$key] = $value;
		}
	}

	return $ret;
}

function hashkey_setsamevalue($hash, $samevalue, $selected_only = array(), $overwrite_existing = 1) {
	$ret = array();

	foreach ($hash as $key => $value) {
		if (count($selected_only) > 0 && in_array($key, $selected_only)) {
			$ret[$key] = $samevalue;
		} else {
			$ret[$key] = $value;
		}
	}

	return $ret;
}


function product_vadd($row) {
	$ret = 0;
	
	if ($row["price_1"] > 0 && $row["price_buy1"] > 0) {
		$ret = ($row["price_1"] - $row["price_buy1"]) / $row["price_buy1"] * 100;
		$ret = round($ret, 2);
	}
	
	$ret = number_format($ret, 2, '.', '');
	$ret .= "%";
	return $ret;
}

function firstwords_stripped_brief($row) {
	return strip_tags(firstwords_stripped($row, 10, "brief", 0));
}

function firstwords_stripped_content($row) {
	return strip_tags(firstwords_stripped($row, 10, "content", 0));
}


function firstwords_stripped($row, $word_limit = 15
		, $field_from = "brief", $get_second_field = 1, $field_if_empty = "content", $force_is_empty = 0
		, $regexp = "~ ~", $flags = PREG_SPLIT_DELIM_CAPTURE
		, $separator = " "
		, $debug = 0
		) {

	$ret = "";

//	$content = $row[$field_from];
	$content = hash_by_tpl($row, "#$field_from#");
	$content = strip_tags($content);
	
	if (($content == "" && $get_second_field == 1) || $force_is_empty == 1) {
//		$content = $row[$field_if_empty];
		$content = hash_by_tpl($row, "#$field_if_empty#");
		$content = strip_tags($content);
	}
	
	if (strlen($content) > 0) {
		$splitted_content = preg_split ($regexp, $content, $word_limit + 1, $flags);
		if ($debug == 1) {
			pre($regexp);
			pre($splitted_content);
		}
		
		for ($i=0; $i<count($splitted_content); $i++) {
			$ret .= $splitted_content[$i];
			if ($i < count($splitted_content)-1) $ret .= $separator;
			if ($i == $word_limit-1) break;
		}
		
		if (count($splitted_content) == $word_limit + 1) $ret .= "…";
	}
	
	return $ret;
}


function firstletters_truncate($str, $letter_limit = 8) {
	$ret = $str;

	if (strlen($str) > $letter_limit) {
		$ret = substr($str, 0, $letter_limit) . "…";
	}
	
	return $ret;
}


function is_first_field_in_swapdbfields($current_field_name) {
	global $entity_swapdbfields_list, $entity;

	$ret = 0;
	
	if (!isset($entity_swapdbfields_list[$entity])) return $ret;
	$swapdbfields_array = $entity_swapdbfields_list[$entity];

	foreach ($swapdbfields_array as $fieldgroup_array) {
		if (isset($fieldgroup_array[0]) && $fieldgroup_array[0] == $current_field_name) return 1;
	}
	
	return $ret;
}

function is_last_field_in_swapdbfields($current_field_name) {
	global $entity_swapdbfields_list, $entity;

	$ret = 0;
	
	if (!isset($entity_swapdbfields_list[$entity])) return $ret;
	$swapdbfields_array = $entity_swapdbfields_list[$entity];

	foreach ($swapdbfields_array as $fieldgroup_array) {
		$last_index = count($fieldgroup_array)-1;
		if (isset($fieldgroup_array[$last_index]) && $fieldgroup_array[$last_index] == $current_field_name) return 1;
	}
	
	return $ret;
}

function get_swapdbfields_array_withfirst($first_field_name) {
	global $entity_swapdbfields_list, $entity;

	$ret = array();

	if (!isset($entity_swapdbfields_list[$entity])) return $ret;
	$swapdbfields_array = $entity_swapdbfields_list[$entity];

	foreach ($swapdbfields_array as $fieldgroup_array) {
		if (isset($fieldgroup_array[0]) && $fieldgroup_array[0] == $first_field_name) return $fieldgroup_array;
	}

	return $ret;
}

function get_swapdbfields_index_withfirst($first_field_name) {
	global $entity_swapdbfields_list, $entity;

	$ret = 0;

	if (!isset($entity_swapdbfields_list[$entity])) return $ret;
	$swapdbfields_array = $entity_swapdbfields_list[$entity];

	for ($i=0; $i<count($swapdbfields_array); $i++) {
		$fieldgroup_array = $swapdbfields_array[$i];
		if (isset($fieldgroup_array[0]) && $fieldgroup_array[0] == $first_field_name) return $i;
//		pre($fieldgroup_array);
//		pre($i);
	}

	return $ret;
}

/*
function date_published($row) {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row["date_published"]);
//	pre($row["date_published"]);
//	pre($date_hash);
	$day = intval($date_hash["day"]);
	$month = intval($date_hash["month"]);
	$year = intval($date_hash["year"]);
	$ret = $day . " " . $months_when[$month] . " " . $year;

	return $ret;
}

function date_published_noyear($row) {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row["date_published"]);
//	pre($row["date_published"]);
//	pre($date_hash);
	$day = intval($date_hash["day"]);
	$month = intval($date_hash["month"]);
	$ret = $day . " " . $months_when[$month];

	return $ret;
}

function date_published_shortyear($row) {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row["date_published"]);
//	pre($row["date_published"]);
//	pre($date_hash);
	$day = intval($date_hash["day"]);
	$month = intval($date_hash["month"]);
	$year = substr($date_hash["year"], 2, 2);
	$ret = $day . " " . $months_when[$month] . " " . $year;

	return $ret;
}

function date_published_num($row) {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row["date_published"]);
//	pre($row["date_published"]);
//	pre($date_hash);
	$day = $date_hash["day"];
	$month = $date_hash["month"];
	$year = $date_hash["year"];
	$ret = $day . "." . $month . "." . $year;

	return $ret;
}

function date_published_GMT($row, $field_from = "date_published") {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row[$field_from]);
	if ($date_hash["hour"] == "00" && $date_hash["minute"] == "00" && $date_hash["second"] == "00") {
		$date_hash["hour"] = "13";
		}
//	pre($date_hash);

	$date_uts = datehash_2uts($date_hash);
	$ret = strftime("%a, %d %b %Y %H:%M:%S +0300", $date_uts);		//Sat, 14 Jan 2006 19:55:00 +0300

	return $ret;
}


function date_started($row) {
	return date_published_shortyear(array("date_published" => $row["date_started"]));
}

function date_finished($row) {
	return date_published_shortyear(array("date_published" => $row["date_finished"]));
}
*/
function date_chatted($row, $length = "short", $days_ago = 0) {
	global $months_when;
	$ret = "";

	$date_hash = parse_datetime($row["date_created"]);
//	pre($date_hash);

	$day = $date_hash["day"];
	$month = $date_hash["month"];
//	$month = $months_when[intval($month)];
	$year = $date_hash["year"];

	$hour = $date_hash["hour"];
	$minute = $date_hash["minute"];

	if ($length == "short") {
		$ret = $hour . ":" . $minute;
	} else {
		if ($days_ago == -1) {
			$ret = "����� " . $hour . ":" . $minute;
		} else if ($days_ago == -2) {
			$ret = "��������� " . $hour . ":" . $minute;
		} else {
			$ret = $day . "." . $month . " " . $hour . ":" . $minute;
	}
	}

	return $ret;
}


function idrandom_cleanse($ret) {
	$ret = trim($ret);
	$ret = str_replace("-", "", $ret);
	$ret = preg_replace("~^0+~", "", $ret);
	return $ret;
}
	

function idrandom_formatted($row, $fname = "idrandom") {
	$ret = $row[$fname];

	$ret = idrandom_cleanse($ret);
	$ret = sprintf("%012s", $ret);

//	$triplets = preg_split($ret, 3);
//	$ret = implode("-", $triplets);

	$ret = substr($ret, 0, 3) . "-" . substr($ret, 3, 3) . "-" . substr($ret, 6, 3) . "-" . substr($ret, 9, 3);

	return $ret;
}
	
function seconds_to_hhmmss($seconds = 1763) {
	$ret = "";
	
	if (!is_numeric($seconds)) return $ret;

	$seconds_in_day = 60*60*24;
	$seconds_in_hour = 60*60;
	$seconds_in_minute = 60;

	$days = 0;
	if ($seconds >= $seconds_in_day) {
		$days = floor($seconds / $seconds_in_day);
		$seconds %= $seconds_in_day;
		$ret .= $days . "d ";
	}

	if ($seconds >= $seconds_in_hour) {
		$hours = floor($seconds / $seconds_in_hour);
		$seconds %= $seconds_in_hour;
		$ret .= sprintf("%02d", $hours) . ":";
	} else {
		if ($days > 0) {
			$ret .= "00:";
	}
	}

	if ($seconds >= $seconds_in_minute) {
		$minutes = floor($seconds / $seconds_in_minute);
		$seconds %= $seconds_in_minute;
		$ret .= sprintf("%02d", $minutes) . ":";
	} else {
		$ret .= "00:";
	}

	$sec = sprintf("%02d", $seconds);
	$ret .= $sec;
	
	return $ret;
}



function append_global_string($appending_text, $varname = "errormsg", $separator = "; ") {
	$htmlspecial_varnames = array("errormsg", "alertmsg");

	global $$varname;
	if (!isset($$varname)) return;

	$value = $$varname;
	if ($value != "") $value .= $separator;
	if (in_array($varname, $htmlspecial_varnames)) $appending_text = htmlspecialchars($appending_text);
	$value .= $appending_text;
	$$varname = $value;

	return $value;
}


function append_errormsg($appending_text, $separator = "; ") {
	return append_global_string($appending_text, "errormsg", $separator);
}

function append_alertmsg($appending_text, $separator = "; ") {
	return append_global_string($appending_text, "alertmsg", $separator);
}

function append_debugmsg($appending_text, $separator = "; ") {
	global $debug;
	if ($debug == 0) return;
	return append_global_string($appending_text, "debugmsg", $separator);
}



function prepend_global_string($prepending_text, $varname = "errormsg", $separator = "; ") {
	$htmlspecial_varnames = array("errormsg", "alertmsg");

	global $$varname;
	if (!isset($$varname)) return;

	$value = $$varname;
	if (in_array($varname, $htmlspecial_varnames)) $prepending_text = htmlspecialchars($prepending_text);
	if ($value != "") $prepending_text .= $separator;
	$value = $prepending_text . $value;
	$$varname = $value;

	return $value;
}

function prepend_errormsg($prepending_text, $separator = "; ") {
	return prepend_global_string($prepending_text, "errormsg", $separator);
}

function prepend_alertmsg($prepending_text, $separator = "; ") {
	return prepend_global_string($prepending_text, "alertmsg", $separator);
}






function revgeo($lat, $lng) {
	$ret = "";
	
	$url = "http://ws.geonames.org/findNearestAddress?lat=$lat&lng=$lng";
	$ch = curl_init($url);
	plog("revgeo(ch=[" . $ch . "]");

	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$xml = curl_exec($ch);
	curl_close($ch);
	
/*
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<geonames>
<address>
<street>Whitman Ct</street>
<streetNumber>329</streetNumber>
<lat>37.44025185878796</lat>
<lng>-122.15213369950403</lng>
<distance>0.03</distance>
<postalcode>94301</postalcode>
<placename>Palo Alto</placename>
	
<adminCode2>085</adminCode2>
<adminName2>Santa Clara</adminName2>
<adminCode1>CA</adminCode1>
<adminName1>California</adminName1>
<countryCode>US</countryCode>
</address>
</geonames>
*/


	$streetNumber = get_xmltag_content($xml, "streetNumber");
	$street = get_xmltag_content($xml, "street");
	$adminName1 = get_xmltag_content($xml, "adminName1");
	$placename = get_xmltag_content($xml, "placename");
	$adminCode1 = get_xmltag_content($xml, "adminCode1");
	$postalcode = get_xmltag_content($xml, "postalcode");
		
//	$ret = "$streetNumber $street, $placename, $adminCode1 $postalcode";
//	if ($ret == " , ,  ") $ret = "";

	if ($streetNumber != "") $ret .= "$streetNumber ";
	if ($street != "") $ret .= "$street, ";
	if ($placename != "") $ret .= "$placename, ";
	if ($adminCode1 != "00") $ret .= "$adminCode1";
	if ($postalcode != "") $ret .= " $postalcode";

	return $ret;
}

function get_xmltag_content ($xml, $tag = "placename") {
	global $debug;
	$ret = "";

//	if ($debug == 1) plog($xml);
		$matches = array();
	preg_match("~.*<$tag(\s+.*)?>(.*)</$tag(\s+.*)?>.*~si", $xml, $matches);
	if (isset($matches[2])) {
//		if ($debug == 1) plog(pr($matches));
		$ret = $matches[2];
		}

	return $ret;
}



function bearing2hr($bearing = -1) {
	$ret = "";

	if ($bearing >= 0 && $bearing < 22.5) $ret = "S";
	elseif ($bearing >= 22.5 && $bearing < 67.5) $ret = "SouthWest";
	elseif ($bearing >= 67.5 && $bearing < 112.5) $ret = "West";
	elseif ($bearing >= 112.5 && $bearing < 157.5) $ret = "NorthWest";
	elseif ($bearing >= 157.5 && $bearing < 202.5) $ret = "North";
	elseif ($bearing >= 202.5 && $bearing < 247.5) $ret = "NorthEast";
	elseif ($bearing >= 247.5 && $bearing < 295.5) $ret = "East";
	elseif ($bearing >= 295.5 && $bearing < 337.5) $ret = "SouthEast";
	elseif ($bearing >= 337.5 && $bearing <= 360) $ret = "South";
	else $ret = "UnknownDirection";

	return $ret;
}

function speed2hr($speed = 0, $ucfirst = 0) {
	$ret = "";

	if ($speed > 0 && $speed < 1.5) $ret = "floating";
	if ($speed > 4) $ret = "walking";
	if ($speed > 8) $ret = "running";
	if ($speed > 15) $ret = "driving";
	if ($speed > 100) $ret = "rushing";
	if ($speed > 250) $ret = "flying";
	
	if ($ucfirst == 1) $ret = ucfirst($ret);
	
	return $ret;
}


?>
