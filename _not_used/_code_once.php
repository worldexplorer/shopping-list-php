<? require_once "_lib/_init.php" ?>
<?


$iccontent_multi_list = array();
function product_iccontent_by_tpl($fixed_hash
			, $tpl = "<li><b>#IDENT#</b> #ICCONTENT#</li>"
			, $tpl_find_semicolumn = ": "
			, $tpl_replace_semicolumn = " "
			, $tpl_multi = "<li><b>#IDENT#</b> #ICCONTENT_WRAPPED#</li>"
			, $tpl_multi_item = "<a href='javascript:alert(\"сюда можно кликнуть и распечатаются другие товары содержащие такое же свойство\")'<span title='#ICDICT_CONTENT#'>#ICDICT_IDENT#</span></a>",
			$tpl_multi_item_separator = ", "
			, $m2m_table = "m2m_product_iccontent", $icwhose_id = 1, $icmulti_silent = 1) {

	global $iccontent_multi_list;
	$filled_iccontent_list = array();
	$ret = "";

	$query = "select ic.id as id, ic.ident as ident, ic.ictype as ictype, ic.icdict as icdict"
		. ", ic.param1 as param1, ic.param2 as param2"
		. ", icdc.ident as icdict_ident, icdc.content as icdict_content"
		. ", t.hashkey as ictype_hashkey, m2m.iccontent, m2m.iccontent_tf1"
		. " from ic ic"
		. " inner join ictype t on ic.ictype=t.id"
		. " inner join $m2m_table m2m on m2m.ic=ic.id"
//		. " left outer join icdictcontent icdc on m2m.ic=ic.id and iccontent=icdc.id and icdc.published=true and icdc.deleted=false"
		. " left outer join icdict icd on ic.icdict=icd.id and icd.published=true and icd.deleted=false"
		. " left outer join icdictcontent icdc on icdc.icdict=icd.id and m2m.iccontent=icdc.id and icdc.published=true and icdc.deleted=false"
		. " where ic.deleted=false and ic.published=true and t.published=true and t.deleted=false"
		. sqlcond_fromhash($fixed_hash, "", " and ")
		. " and ic.icwhose=" . $icwhose_id
		. " order by ic." . get_entity_orderfield("ic");
//	$ret = query_by_tpl($query, $tpl);

	$qa = select_queryarray($query);
//	pre($qa);

	$i = 0;
	foreach ($qa as $row) {
		$row["rows_total"] = count($qa);
		$row["i"] = ++$i;
		
		switch ($row["ictype_hashkey"]) {
			case "CHECKBOX":
				if ($row["iccontent"] == 1) $row["iccontent_wrapped"] = $row["ic_ident"];
				break;
			
			case "NUMBER":
			case "TEXTAREA":
			case "TEXTFIELD":
				if ($row["iccontent"] != "") {
//					pre($row);
					$matches = array();
//					preg_match("/(.*): (.*)/", $row["ident"], $matches);		//Размеры: [сюда ]м
//					pre($matches);
					preg_match("/(.*)$tpl_find_semicolumn(.*)/", $row["ident"], $matches);
					if (count($matches) == 3) {
						$row["iccontent_wrapped"] = $matches[1] . $tpl_replace_semicolumn . $row["iccontent"] . " " . $matches[2];
						$row["ident"] = $matches[1] . $tpl_replace_semicolumn;
						$row["iccontent"] = $row["iccontent"] . " " . $matches[2];
					} else {
						$row["iccontent_wrapped"] = $row["ident"] . $tpl_replace_semicolumn . $row["iccontent"];
						$row["ident"] = $row["ident"] . $tpl_replace_semicolumn;
					}
				}
				break;
			
			case "SELECT":
				if ($row["iccontent"] != "") {
					$row["iccontent_wrapped"] = $row["ident"] . ": " . select_field("ident",
						array("id" => $row["iccontent"], "published" => 1, "deleted" => 0),
						"icdictcontent");
				}
				break;
			
			case "ICSELECT":
				if ($row["icdict_ident"] != "") {
//					$row["iccontent"] = $row["icdict_ident"];
//					$row["iccontent"] = $row["icdict_ident"];
					$row["iccontent_wrapped"] = $row["ident"] . " " . $row["icdict_ident"];
				}
				break;
			
			case "ICMULTICHECKBOX":
			case "ICMULTISELECT":
			case "ICRADIO":
				$new_icmulti_hash = array (
					"id" => $row["id"],
					"ident" => $row["ident"],
					"icdictcontent" => array(),
					"iccontent_wrapped" => "",
					);
				$ic = $row["id"];

				$iccontent_multi_keys = array_keys($iccontent_multi_list);
				$icmulti_hash = in_array($ic, $iccontent_multi_keys) ? $iccontent_multi_list[$ic] : $new_icmulti_hash;
				if ($icmulti_hash["ident"] != $row["ident"]) $icmulti_hash = $new_icmulti_hash;

				$icmulti_hash["icdictcontent"][] = $row["icdict_ident"];
				if ($row["icdict_ident"] != "") {
					$matches = array();
//					preg_match("/(.*): (.*)/", $row["icdict_ident"], $matches);		//Размеры: [сюда ]м
					preg_match("/(.*)$tpl_find_semicolumn(.*)/", $row["icdict_ident"], $matches);
//					pre($matches);
					if (count($matches) == 3) {
						$row["icdict_ident"] = $matches[1] . $tpl_replace_semicolumn . $row["iccontent_tf1"] . $matches[2];
					}
				}
//				pre($row);


				$hash_adapted_for_tpl = array_merge($row, array("iccontent_wrapped" => $row["icdict_ident"]));
				if (count($icmulti_hash["icdictcontent"]) > 1) $icmulti_hash["iccontent_wrapped"] .= $tpl_multi_item_separator;
				$icmulti_hash["iccontent_wrapped"] .= hash_by_tpl($hash_adapted_for_tpl, $tpl_multi_item);
				
				$iccontent_multi_list[$ic] = $icmulti_hash;
//				pre($iccontent_multi_list);
				

				if ($icmulti_silent == 0) $row["iccontent_wrapped"] = $icmulti_hash["iccontent_wrapped"];
				break;
			
			default:
				break;
		}

		if (isset($row["iccontent_wrapped"])) $filled_iccontent_list[] = $row;
	}
		
	$i = 0;
//	pre($filled_iccontent_list);
	foreach ($filled_iccontent_list as $row) {
		$row["rows_total"] = count($filled_iccontent_list);
		$row["i"] = ++$i;
		$ret .= hash_by_tpl($row, $tpl);
//		pre($row);
	}

//	pre($iccontent_multi_list);

	foreach ($iccontent_multi_list as $row) {
		$row["rows_total"] = count($iccontent_multi_list);
		$row["i"] = ++$i;
		$ret .= hash_by_tpl($row, $tpl_multi);
	}


	return $ret;
}


function setcontext_item() {
	global $entity, $id, $bo_href, $href_mmenu_upper_level;

	$bo_href = "$entity-edit.php?id=$id";
//	if ($id == 0) redirect($href_mmenu_upper_level, 0);
}


function mmenuleaf_anchor($hashkey
//	, $tpl_item = "<a href='@mmenu_hrefto@'><img src='#IMG_FREE_RELPATH#' #IMG_FREE_WH# border=0 alt='#IDENT#'></a>"
//	, $tpl_item_current = "<a href='@mmenu_hrefto@'><img src='#IMG_MOVER_RELPATH#' #IMG_FREE_WH# border=0 alt='#IDENT#'></a>"
//	, $tpl_item_separator = "<td><img src='img/m_shad_#I#.gif' alt=''></td>"
//	, $tpl_item_current_separator = "<td><img src='img/m_shad_2.gif' alt=''></td>"

	, $tpl_item = ""
	, $tpl_item_current = ""
	, $current = 0

	, $tpl_item_separator = ""
	, $tpl_item_current_separator = ""

	, $item_end = ""
		) {

/*
	$tpl_item = <<< EOT

<td><a href="@mmenu_hrefto@"><img src="#IMG_FREE_RELPATH#" #IMG_FREE_WH# name="MMENU_#ID#" onMouseOver="MM_swapImage('MMENU_#ID#','','#IMG_MOVER_RELPATH#',1)" onMouseOut="MM_swapImgRestore()" alt="#IDENT#"></a></td>

EOT;

	$tpl_item_current = <<< EOT

<td><a href="@mmenu_hrefto@"><img src="#IMG_MOVER_RELPATH#" #IMG_MOVER_WH# border=0 alt="#IDENT#"></a></td>

EOT;
*/

	global $root_tree;

	if ($current == 0) {
		$current = isset($root_tree[1]) ? $root_tree[1] : 0;
	}

	$ret = "";
	
	$parent_id = intval($hashkey);
	$parent_wcond = ($parent_id > 0) ? "id=$hashkey" : "hashkey='$hashkey'";
	
	$query = "select m.* from "
		. " " . TABLE_PREFIX . "mmenu m, " . TABLE_PREFIX . "mmenu parent"
		. " where parent.$parent_wcond and m.parent_id=parent.id"
		. " and m.published=true and m.deleted=false"
		. " order by m.manorder";
	
	$qa = select_queryarray($query);
	foreach ($qa as $row) {
		$row["entity"] = "mmenu";
		//$row = array_merge($row, entityrow_imgprepare("img_free", $row));
		//$row = array_merge($row, entityrow_imgprepare("img_mover", $row));

		$tpl = ($row["id"] == $current) ? $tpl_item_current : $tpl_item;
		$ret .= hash_by_tpl($row, $tpl);

		if ($row["i"] < $row["rows_total"]) {
//			$tpl = ($row["id"] == $current) ? $tpl_item_current_separator : $tpl_item_separator;
			$tpl = $tpl_item_separator;
			$ret .= hash_by_tpl($row, $tpl);
		}
		if ($row["i"] == $row["rows_total"]) $ret .= hash_by_tpl($row, $item_end);
	}

	return $ret;
}

function mmenu_hrefto($row) {
	$ret = "";

	if ($row["is_drone"] == 1) {
		$ret = "#";		// feature to set "drone" but not clickable
		$row_child = select_entity_row(array("parent_id" => $row["id"], "published" => 1, "deleted" => 0), "mmenu");
		if (isset($row_child["id"])) $ret = mmenu_hrefto($row_child);
		return $ret;
	}

	if ($row["is_heredoc"] == 0) {
		$hashkey = $row["hashkey"];

		$controlchar = "";
		$len = strlen($hashkey);
		if ($len > 1) $controlchar = substr($hashkey, 0, 1);
	
		switch($controlchar) {
			case "=":
				$ret = substr($hashkey, 1);
				break;
	
			default:
				$ret = 	$hashkey . ".php";
		}
	
	} else {
		$ret = 	"mmenu.php?id=" . $row["id"];
	}

	return $ret;
}


function sendorder($body) {
	global $path_back;
	
	$order_subscriber = select_field("content", array("hashkey" => "MAILTO_ORDER_ALL"), "constant");
	$subject = strip_tags($path_back);
//	$subject = html_entity_decode($subject);
	$body = "<p>$subject</p>" .  $body;

	sendmail($order_subscriber, $subject, $body);
//	pre ($body);

	$ret = "Спасибо за ваш вопрос...";

	return $ret;
}

$content_top = entity_tpl("#CONTENT#", "constant", array("hashkey" => "CONTENT_TOP"));
$content_bottom = entity_tpl("#CONTENT#", "constant", array("hashkey" => "CONTENT_BOTTOM"));


$auth_cookie_name_default = "NO_AUTH_COOKIE_RECEIVED";
$uprofile_default = array (
	$auth_cookie_name => $auth_cookie_name_default,
);

//$debug_cookies = 1;
$uprofile = gethash_bytplhash($uprofile_default, 0, 1);
//$debug_cookies = 0;

//pre($_REQUEST, "_REQUEST");
//pre($_GET, "_GET");
//pre($_POST, "_POST");
//pre($_COOKIE, "_COOKIE");
plog(pr($uprofile, "_code_once:uprofile"));





function user_login_ident_phone_email($person_row) {
	$ret = hash_by_tpl($person_row, "#IDENT#");
	if ($ret == "") {
		$ret = $person_row["phone"];
	}
	if ($ret == "") {
		$ret = $person_row["email"];
	}
	return $ret;
}

function user_found_set_cookie($person_row, $sendcookie = 1, $field_from_db_to_set_as_cookie = "auth") {
	global $unhashed, $auth_cookie_name;

	$id = $person_row["id"];
	$auth_from_db = $person_row[$field_from_db_to_set_as_cookie];
//	$ident = $person_row["ident"];		//НПО \"Альтернатива\"
//	$ident = hash_by_tpl($person_row, "#IDENT#");
	$ident = user_login_ident_phone_email($person_row);
	$published = $person_row["published"];

	$may_login = 1;

	if ($published == 0) {
		$ret = "Извините, доступ закрыт для [$ident].";
		$ret .= "<br>Ваш аккаунт [$ident] был деактивирован администратором.";
		$may_login = 0;
	}

	//$lastclick_datetime_datehash = parse_datetime($person_row["date_lastclick"]);
	//$lastclick_datetime_uts = datehash_2uts($lastclick_datetime_datehash);

	if ($may_login == 1) {
		$ret = "Пользователь [$ident] успешно авторизовался";
		if ($sendcookie == 1) {
			$days = 365;
			$expires = time() + 60*60*24*$days;
			//pre("setcookie $auth_cookie_name=[$auth_from_db] for [$days] days");
			setcookie($auth_cookie_name, $auth_from_db, $expires);
		}

		$unhashed["person"] = $id;
		$unhashed["person_ident"] = $ident;

		$short_length = (strlen($unhashed["person_ident"]) > 22) ? 22 : strlen($unhashed["person_ident"]);
		$unhashed["person_ident_short"] = substr($unhashed["person_ident"], 0, $short_length);

		if (session_id() == "") session_start();
		$_SESSION["person_row"] = $person_row;
		

		$update_hash = array (
			"date_lastclick" => "CURRENT_TIMESTAMP",
			"lastip" => $_SERVER["REMOTE_ADDR"],
			"lastip_auth" => "CURRENT_TIMESTAMP",
			"lastsid" => session_id(),
			"user_agent" => $_SERVER["HTTP_USER_AGENT"],
		);

		update($update_hash, array("id" => $id), "person");
	} else {
		logoff_person();
	}

}

function logoff_person($sendcookie = 1) {
	global $uprofile, $auth_cookie_name;
	
	$uprofile[$auth_cookie_name] = "JUST_LOGGED_OFF";
	if ($sendcookie == 1) setcookie($auth_cookie_name);

	$unhashed["person"] = 0;
	$unhashed["person_ident"] = "";
	$unhashed["person_ident_short"] = "";

	unset($_SESSION["person_row"]);
}

function login_auth($auth, $sendcookie = 1) {
	global $cms_dbc, $unhashed, $_SESSION, $uprofile, $auth_cookie_name;
	
	$ret = "";

	if ($auth == "") {
		$ret = "Не указан [Ваш Токен]";
		return $ret;
	}


	$person_id = 0;
	$query = "select * from " . TABLE_PREFIX . "person where auth='$auth' and deleted=false";
//	echo $query;
	$result = pg_query($cms_dbc, $query) or die("SELECT person failed");
	$num_rows = pg_num_rows($result);
	if ($num_rows == 0) {
		$unhashed["person"] = 0;
		$unhashed["person_ident"] = "";
		$unhashed["person_ident_short"] = "";

		unset($_SESSION["person"]);
		unset($_SESSION["person_ident"]);
		unset($_SESSION["person_ident_short"]);

		$ret = "Токен [$auth] не найден ни для одного пользователя";
		return $ret;
	}

	$row = pg_fetch_assoc($result);
//	pre($row);
	$ret = user_found_set_cookie($row, $sendcookie);
	$uprofile[$auth_cookie_name] = $auth;

	return $ret;
}

$unhashed = array (
	"person" => 0,
	"person_ident" => "",
);


$auth = get_string("auth");
if ($auth != "") {
	$uprofile[$auth_cookie_name] = $auth;
}

if ($uprofile[$auth_cookie_name] != "" && $uprofile[$auth_cookie_name] != $auth_cookie_name_default) {
	$errormsg_login = login_auth($uprofile[$auth_cookie_name]);
	if ($unhashed["person"] == 0) {
		$alertmsg = $errormsg = $errormsg_login;
	} else {
		plog($errormsg_login);
	}
} else {
	plog("UNAUTHORIZED //_code_once");
}


if ($mode == "logoff_person") {
	logoff_person();
}


if (isset($unhashed["person_ident"]) == false) {
	if (strpos($_SERVER["SCRIPT_NAME"], "my_") !== false) {
		$errormsg = "Пройдите пожалуйста авторизацию";
		redirect("auth.php?alertmsg=" . urlencode($errormsg));
	}
}

//$debug_query = 0;
//plog(pr($unhashed, "_code_once:unhashed"));
//plog(pr($_SESSION, "_code_once:_SESSION"));
//plog(pr($_REQUEST, "_code_once:_REQUEST"));
//plog(pr($_SERVER, "_code_once:_SERVER"));
//plog(pr($_COOKIE, "_code_once:_COOKIE"));


?>