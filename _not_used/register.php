<? require "_code.php" ?>
<?

$person_row = array();
if (isset($unhashed["person"]) && $unhashed["person"] > 0 && $mode == "update") {
	setcookie($auth_cookie_name);
	$unhashed["person"] = 0;
	$unhashed["person_ident"] = "";
	$unhashed["person_ident_short"] = "";
	$unhashed["person_row"] = array();
}

$date_birth = get_date("date_birth");
$date_birth_datehash = parse_datetime($date_birth);
//pre($date_birth_datehash);
$select_date_birth = select_date("date_birth", $date_birth_datehash, "birthdate");
$date_birth = $date_birth_datehash["year"] . "-" . $date_birth_datehash["month"] . "-" . $date_birth_datehash["day"];

$markers_hash = array (
	"login" => "",
	"passwd" => "",
	"passwd2" => "",
	"email" => "",
	"cname" => "",
	"city" => "",

	"confirm_img" => "",
	"confirm_id" => md5(uniqid($_SERVER["REMOTE_ADDR"])),
	"confirm" => "",
	"askme_clause" => urlencode("отсутствует картинка с изображением проверочного кода при регистрации пользователя"),

	"submit_HTMLrow" => ($mode == "")
		? "<tr><td colspan=2><td align=left><input type='button' onclick='form_edit_submit_with_passwds_are_equal()' value='Зарегистрироваться'></td></tr>"
		: "<tr><td colspan=2><td align=left><input type='button' onclick='form_edit_submit_with_passwds_are_equal()' value='Зарегистрироваться ещё раз'></td></tr>"
		,
);
//$cookie_debug = 1;
$markers_hash = gethash_bytplhash($markers_hash, 0);
//pre($markers_hash);

//$markers_hash["select_gender_my"] = boolean_hash("gender_my", $markers_hash["gender_my"], $gender_my_hash);
//$markers_hash["select_gender_search"] = boolean_hash("gender_search", $markers_hash["gender_search"], $gender_search_hash2);
//$markers_hash["select_city"] = select_table_all("city", $markers_hash["city"], "ident", "", array(), "- не указано -", 0);


$markers_hash["email"] = trim($markers_hash["email"]);


// Visual Confirmation
define('CONFIRM_TABLE', 'qqn_regconfirm');
$userdata['session_id'] = session_id();


$confirm_image = "";
$confirm_db = "";


$confirm_id = $markers_hash["confirm_id"];

$confirm_img_tpl = "<img src='register_confirmimg.php?mode=confirm&id=#CONFIRM_ID#"
	. "&SID=" . session_id()
	. "' alt='' title='' width=320 height=50 align=left>";

$markers_hash["confirm_img"] = hash_by_tpl($markers_hash, $confirm_img_tpl);


//pre($markers_hash);


$tpl = <<< EOT
<table border=0>
<form method=post name=form_edit id=form_edit>
<input type=hidden name=mode value=update>
<input type=hidden name=confirm_id value="#CONFIRM_ID#">
<tr>
	<td align=right><font color=red>*</font> Логин</td>
	<td width=10></td>
	<td><input type="text" size="20" id="login" name="login" value="#LOGIN#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> Пароль</td>
	<td></td>
	<td><input type="text" size="20" id="passwd" name="passwd" value="#passwd#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> Пароль ещё раз</td>
	<td></td>
	<td><input type="text" size="20" id="passwd2" name="passwd2" value="#passwd2#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> Ваш Email</td>
	<td></td>
	<td><input type="text" size="20" id="email" name="email" value="#EMAIL#">
</td></tr>

<tr>
	<td align=right><font color=red>*</font> Ваше имя</td>
	<td></td>
	<td><input type="text" size="20" id="cname" name="cname" value="#CNAME#"></td>
</tr>

<tr><td height=10></td></tr>

<tr>
	<td align=right>если справа<br>отсутствует картинка,<br><a href="askme.php?subject=#ASKME_CLAUSE#">сообщите нам об этом</a></td>
	<td></td>
	<td>#CONFIRM_IMG#</td>
</tr>
<tr> 
	<td align=right><font color=red>*</font> Код на картинке</td>
	<td></td>
	<td><input type="text" size="20" maxlength="6" id="confirm" name="confirm" value="#CONFIRM#"></td>
</tr>

<tr> 
	<td></td>
	<td></td>
	<td>вводите латинские буквы заглавными!!!<br>цифра "ноль" перечёркнута по диагонали</td>
</tr>

<tr><td height=20></td></tr>

#SUBMIT_HTMLROW#

</form>
</table>
EOT;

if ($mode == "update" && $errormsg == "" && $markers_hash["login"] == "") {
	$errormsg = "Укажите логин";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["passwd"] == "") {
	$errormsg = "Укажите пароль";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["passwd2"] == "") {
	$errormsg = "Укажите повтор пароля";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["passwd"] != $markers_hash["passwd2"]) {
	$errormsg = "Введённый пароль и повтор пароля не совпадают; проверьте и введите ещё раз";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["email"] == "") {
	$errormsg = "Укажите свой email";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["cname"] == "") {
	$errormsg = "Укажите своё имя";
}

/*
if ($mode == "update" && $errormsg == "" && $markers_hash["confirm"] == "") {
	$errormsg = "Укажите код на картинке";
}
*/


if ($mode == "update" && $errormsg == "") {
	$sql = 'SELECT code  FROM ' . CONFIRM_TABLE . " WHERE session_id = '" . $userdata['session_id']
			. "' AND confirm_id = '$confirm_id'";
	if (!($result = mysqli_query($cms_dbc, $sql)))	{
		die("Could not obtain confirm code [$sql]");
	}
	
	// If we have a row then grab data else create a new id
	if ($row = mysqli_fetch_assoc($result))	{
		$confirm_db = $row['code'];
	} else {
		pre($row);
		$errormsg = "Ошибка чтения подверждающего кода";
	}
	mysqli_free_result($result);
}

if ($mode == "update" && $errormsg == "" && $markers_hash["confirm"] != $confirm_db) {
	$errormsg = "Не совпадает код на картинке: латинские буквы - заглавные, цифра ноль перечёркнута по диагонали";
}

if ($mode == "" || ($mode == "update" && $errormsg != "")) {
	$sql = 'DELETE FROM ' .  CONFIRM_TABLE . " WHERE date_updated < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 5 MINUTE)";
	if (!mysqli_query($cms_dbc, $sql))	{
		die("Could not delete stale confirm data [$sql]");
	}

	$sql = 'SELECT COUNT(session_id) AS attempts FROM ' . CONFIRM_TABLE
		. " WHERE session_id = '" . $userdata['session_id'] . "'";
	if (!($result = mysqli_query($cms_dbc, $sql))) {
		die("Could not obtain confirm code count [$sql]");
	}

	if ($row = mysqli_fetch_assoc($result)) {
		if ($row['attempts'] > 5 && $mode == "update") {
			$errormsg = "Превышено количество попыток, попробуйте через 5 минут";
			sleep(10);
//			die("Too_many_registers [$sql]");
		}
	}
	mysqli_free_result($result);
}

if ($mode == "" || ($mode == "update" && $errormsg != "")) {
	$confirm_chars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',  'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',  'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9');

	list($usec, $sec) = explode(' ', microtime()); 
	mt_srand($sec * $usec); 

	$max_chars = count($confirm_chars) - 1;
	$code = '';
	for ($i = 0; $i < 6; $i++) {
		$code .= $confirm_chars[mt_rand(0, $max_chars)];
	}

	$confirm_id = md5(uniqid($_SERVER["REMOTE_ADDR"]));
	$markers_hash["confirm_id"] = $confirm_id;
	$markers_hash["confirm_img"] = hash_by_tpl($markers_hash, $confirm_img_tpl);

	$sql = 'INSERT INTO ' . CONFIRM_TABLE . " (confirm_id, session_id, code) VALUES ('$confirm_id', '"
		. $userdata['session_id'] . "', '$code')";
	if (!mysqli_query($cms_dbc, $sql)) {
		die("Could not insert new confirm code information [$sql]");
	}

	unset($code);
}

/*
if ($mode == "update" && $errormsg == "") {
	$person_row = select_entity_row(array("email" => $markers_hash["email"]), "person");
	if (isset($person_row["id"])) {
		 if ($person_row["published"] == 0) $errormsg = "Ваш аккаунт был временно деактивирован, обратитесь к <a href='mmenu.php?id=35'>администратору</a>";
		 if ($person_row["deleted"] == 1) $errormsg = "Ваш аккаунт был удалён, обратитесь к <a href='mmenu.php?id=35'>администратору</a>";
	}
}
*/


if ($mode == "update" && $errormsg == "") {
	$person_row = select_entity_row(array("email" => $markers_hash["email"]), "person");
	if (isset($person_row["id"])) {
		$email = $markers_hash["email"];

		 if ($person_row["deleted"] == 0 && $person_row["published"] == 1) {
			$errormsg = "Пользователь с e-mail [" . $markers_hash["email"] . "] уже зарегистрирован, <br>попробуйте <a href='javascript:popup_pwreminder(\"" . $markers_hash["email"] . "\")'>напомнить пароль</a>.";

			$mmenu_content .= <<<EOT
<script>
//alert("Пользователь с email [$email] уже существует, попробуйте напомнить пароль.")
popup_pwreminder("$email")
</script>
EOT;
		}

		if ($person_row["published"] == 0) {
		 	$errormsg = "Ваш аккаунт был временно деактивирован, обратитесь к <a href='askme.php?subject=" . urlencode("Пользователь " . $markers_hash["email"] . " деактивирован") . "'>администратору</a>";
		 }
		 if ($person_row["deleted"] == 1) {
		 	$errormsg = "Ваш аккаунт был удалён, обратитесь к <a href='askme.php?subject=" . urlencode("Пользователь " . $markers_hash["email"] . " удалён") . "'>администратору</a>";
		 }
	}
}

if ($mode == "update" && $errormsg == "") {
	$person_row = select_entity_row(array("login" => $markers_hash["login"]), "person");
	if (isset($person_row["id"])) {
		 $errormsg = "Логин [" . $markers_hash["login"] . "] уже занят; если это Ваш - обратитесь к <a href='askme.php?subject=" . urlencode("Логин " . $markers_hash["login"] . " уже занят") . "'>администратору</a>";
	}
}




// here, so early, to send filled form if required and save it to sentlog
$form = hash_by_tpl($markers_hash, $tpl);

/*
$date_birth_datehash = parse_datetime($date_birth);

$age = $today_datehash["year"] - $date_birth_datehash["year"];
if ($today_datehash["month"] > $date_birth_datehash["month"]) {
	$age--;
} else if ($today_datehash["month"] == $date_birth_datehash["month"]) {
	if ($today_datehash["day"] > $date_birth_datehash["day"]) {
		$age--;
	}
}
*/

//pre($today_datehash);
//pre($date_birth_datehash);
//pre($age);
	

if ($mode == "update" && $errormsg == "") {
	$insert_hash = array (
		"login" => $markers_hash["login"],
		"passwd" => $markers_hash["passwd"],
		"email" => $markers_hash["email"],
		"ident" => $markers_hash["cname"],
//		"city" => $markers_hash["city"],
		"published" => 1,
//		"date_birth" => $date_birth,
//		"age" => $age,
		"date_created" => "CURRENT_TIMESTAMP",
		"remote_address" => $_SERVER["REMOTE_ADDR"]
	);


	$idrandom_unique = 0;
	while ($idrandom_unique == 0) {
		$idrandom = rand(100000000, 999999999);		//4294967295
		$query = "select id from " . TABLE_PREFIX . "person where idrandom=$idrandom";
		$result = mysqli_query($cms_dbc, $query);
		if (mysql_num_rows($result) == 0) {
			$insert_hash["idrandom"] = $idrandom;
			$idrandom_unique = 1;
		}
	}
	

	$update_hash = array (
		"ident" => $markers_hash["cname"],
		"email" => $markers_hash["email"],
		"login" => $markers_hash["login"],
		"passwd" => $markers_hash["passwd"],
	);
	
	if (isset($person_row["id"])) {
//		update($update_hash, array("id" => $person_row["id"]), "person");
//		$markers_hash["person"] = $person_row["id"];
		
		$email = $markers_hash["email"];

		$mmenu_content .= <<<EOT


<script>
alert("Пользователь с email [$email] уже существует, попробуйте напомнить пароль.")
popup_pwreminder("$email")
</script>
EOT;

	} else {
		$markers_hash["person"] = insert($insert_hash, "person");
		$markers_hash["form_submitted"] = $form;
		$markers_hash["ident"] = $markers_hash["cname"];


//		$mail_sendSMTP = 0;
//		$mail_visor_debug = 1;

		$admtail = "";
		$alertmsg = send_mtpl("USER_REGISTERED", $markers_hash, $markers_hash["email"]);
//		pre("alertmsg = [$alertmsg]");
		$errormsg = "";
	
		$insert_hash = array (
			"ident" => select_field("ident", array("hashkey" => "USER_REGISTERED"), "mtpl") . " / " . $markers_hash["cname"],
			"content" => $form . $admtail . "<p>$errormsg</p>",
			"remote_address" => $_SERVER["REMOTE_ADDR"],
			"date_created" => "CURRENT_TIMESTAMP",
			"date_published" => "CURRENT_TIMESTAMP",
		);
		insert($insert_hash, "sentlog");

		$alertmsg_urlencoded = urlencode($alertmsg);
		$url_redirect = "auth.php?l_login=" . $markers_hash["login"] . "&alertmsg=$alertmsg_urlencoded";
		redirect($url_redirect, 0);

/*		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_redirect");


		$mmenu_content .= <<<EOT
<script>
//alert("$alertmsg_urlencoded")
location.href = "$url_redirect"
</script>

EOT;
*/
		$alertmsg = "";

	}


//	$sql = 'DELETE FROM ' . CONFIRM_TABLE . " WHERE confirm_id = '$confirm_id' AND session_id = '" . $userdata['session_id'] . "'";
//	if (!mysqli_query($cms_dbc, $sql)) die("Could not delete confirmation code [$sql]");

}


$table .= $form;

jsv_addvalidation("JSV_TF_CHAR", "login", "Логин");
jsv_addvalidation("JSV_TF_CHAR", "passwd", "Пароль");
jsv_addvalidation("JSV_TF_CHAR", "passwd2", "Пароль ещё раз");
jsv_addvalidation("JSV_TF_EMAIL", "email", "Ваш Email");
jsv_addvalidation("JSV_TF_CHAR", "cname", "Ваше имя");
//jsv_addvalidation("JSV_TF_CHAR", "city", "В каком городе Вы живёте");
//jsv_addvalidation("JSV_PLAINDATE_FILLED", "date_birth", "Дата рождения");
//jsv_addvalidation("JSV_TF_CHAR", "confirm", "Код на картинке");

if ($errormsg != "") $alertmsg = strip_tags($errormsg);

$onload = "onload='focus_on_first()'";
?>


<? require "_top.php" ?>

<?=$mmenu_content?>

<? if ($errormsg != "") { ?>
<h4><?=$errormsg?></h4>
<? } ?>

<table cellpadding=10 cellspacing=0 style="border: 1px solid #aaaaaa" align=center>
<tr><td>
<?=$table?>
</td></tr>
</table>


<script>
function focus_on_first() {
	vitem = form_find_it("login", "form_edit")
	debug = 0
	if (debug == 1) {
		confirmed = confirm("vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}

	if (vitem != null) vitem.focus()	
}

function form_edit_submit_with_passwds_are_equal() {

	passwd_item = form_find_it("passwd", "form_edit")
	passwd2_item = form_find_it("passwd2", "form_edit")

	if (
		passwd_item != null && passwd2_item != null
		&& passwd_item.value != "" && passwd2_item.value != ""
		&& passwd_item.value != passwd2_item.value
		) {

		debug = 0
		if (debug == 1) {
			confirmed = confirm("passwd [" + passwd_item + "]: value=[" + passwd_item.value + "] passwd2 [" + passwd2_item + "]: value=[" + passwd2_item.value + "]")
			if (!confirmed) return false
		}

		alert('Введённые пароли не совпадают, повторите ещё раз')
		passwd_item.focus()
		return false
	}

	form_edit_submit()
}
</script>


<? require "_bottom.php" ?>
