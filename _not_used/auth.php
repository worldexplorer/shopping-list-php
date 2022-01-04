<? require "_code.php" ?>
<?

//if (isset($unhashed["person"]) && $unhashed["person"] > 0 && $mode == "") {
//	redirect("poll.php");
//}

if (isset($unhashed["person"]) && $unhashed["person"] > 0 && $mode == "logoff") {
	logoff_person();
}

$l_login = get_string("l_login");
$l_passwd = get_string("l_passwd");
$l_passwd_md5 = get_number("l_passwd_md5");
$l_auth = get_string("l_auth");

$email = get_string("email");

$stickme = 1;
if ($mode != "" && get_string("stickme") == "") $stickme = 0;
$stickme_checked = ($stickme == 1) ? "checked" : "";

$redirect = 1;
if ($mode != "" && get_string("redirect") == "") $redirect = 0;
$redirect_checked = ($redirect == 1) ? "checked" : "";


function login_password($login, $passwd, $sendcookie = 1, $passwd_md5 = 0) {
	global $cms_dbc, $unhashed, $alertmsg, $onload, $today_datetime_uts, $site_ident;
	
	$ret = "";

	if ($login == "" && $ret == "") $ret = "Не указан [Ваш login]";
	if ($passwd == "" && $ret == "") $ret = "Не указан [Ваш пароль]";

	if ($ret != "") {
		return $ret;
	}


	$person_id = 0;
	$query = "select *, md5(auth) as auth_from_db from " . TABLE_PREFIX . "person where login='$login' and deleted=false";
//	echo $query;
	$result = pg_query($cms_dbc, $query) or die("SELECT person failed");
	$num_rows = pg_num_rows($result);
	if ($num_rows == 0) {
		$ret = "Login [$login] не зарегистрирован";
		return $ret;
	}

	$db_passwd = $row["passwd"];
	//	if ($passwd_md5 == 0) $passwd = md5($passwd);
		if ($passwd == $db_passwd) {
	
		} else {
	//		$onload = "onload='popup_pwreminder(\"" . $email . "\")'";
			$ret = "Неверный пароль для [$login]";
			if ($sendcookie == 1) setcookie($auth_cookie_name);
	
			$unhashed["person"] = 0;
			$unhashed["person_ident"] = "";
			$unhashed["person_ident_short"] = "";
	
			unset($_SESSION["person"]);
	//		unset($_SESSION["person_ident"]);
	//		unset($_SESSION["person_ident_short"]);
		}
	

	$row = pg_fetch_assoc($result);
//	pre($row);
	$ret = user_found_set_cookie($row, $sendcookie);

	return $ret;
}



$errormsg_login = "";
if ($mode == "login_password") {
	$errormsg_login = login_password($l_login, $l_passwd, $stickme, $l_passwd_md5);
}

if ($mode == "login_auth") {
	$errormsg_login = login_auth($l_auth, $stickme);
}


$hrefto = "";

if ($mode == "login_password" || $mode == "login_auth") {
	if ($unhashed["person"] > 0) {
//		$hrefto = "logged.php";
//		redirect($hrefto, 0);

//		header("Location: http://" . $_SERVER["HTTP_HOST"] . "/logged.php");
//		exit();


//		$logged_page_is_published = select_field("published", array("deleted" => 0, "hashkey" => "logged"), "mmenu");
//		$logged_page_is_published = intval($logged_page_is_published);

//		if ($logged_page_is_published == 1) {
//			$hrefto = "logged.php?from=auth";
//			$onload = "onload=redirect_logged()";
//		} else {
			$hrefto = "index.php?from=auth";
			$onload = "onload=redirect_index()";
//		}
		
		if ($redirect == 1) {
			redirect($hrefto, 0);
		} else {
			$onload = "";
			
			$uprofile_default = array (
				$auth_cookie_name => "NO_AUTH_COOKIE_RECEIVED",
			);
			//$debug_cookies = 1;
			$uprofile = gethash_bytplhash($uprofile_default, 0, 1);
			//$debug_cookies = 0;
			
			plog(pr($uprofile, "AUTH.PHP:uprofile"));
		}
	}
}

//$alertmsg = $errormsg_login;

if ($onload == "") {
	$onload = "onload='" . (($l_login == "") ? "focus_login()" : "focus_passwd()") . "'";
}

?>


<? require "_top.php" ?>

<?=$mmenu_content?>

<p><font color="FF0000"><b><?=$errormsg_login?></font></b></p>



<table border=0><tr valign=top><td>

	<table>
	<form method="get" name=form_login_auth>
	<input type=hidden name=mode value=login_auth>
		<tr>
			<td width=50><font color=red>*</font> Токен</td>
			<td width=10></td>
			<td><input type=text size=33 name=l_auth value="<?=$l_auth?>"></td>
		</tr>
		
		<tr>
			<td colspan=3 align=center></td>
		</tr>
		
		<tr>
			<td colspan=2></td>
			<td>
				<table>
				<tr>
					<td><input type=checkbox name=stickme <?=$stickme_checked?> id="stickme_auth" title="Прислать печенье, чтобы не вводить логин и пароль каждый раз."></td>
					<td><label for=stickme_auth>запомнить мой вход<br>на этом компьютере</label></td>
				</tr>
				<tr>
					<td><input type=checkbox name=redirect <?=$redirect_checked?> id="redirect_auth"></td>
					<td><label for=redirect_auth>403_REDIRECT => Poll</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?=$hrefto?>"><?=$hrefto?></a>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan=2></td>
			<td><input type=button onclick="javascript:form_login_auth_submit()" value="войти auth-токеном"></td>
		</tr>
	</form>
	</table>

</td>
</tr>
</table>




<br><br><br>



<table border=0><tr valign=top><td>

	<table>
	<form method="get" name=form_login_password>
	<input type=hidden name=mode value=login_password>
		<tr>
			<td width=50><font color=red>*</font> Логин</td>
			<td width=10></td>
			<td><input type=text size=20 name=l_login value="<?=$l_login?>"></td>
		</tr>
		
		<tr>
			<td><font color=red>*</font> Пароль</td>
			<td></td>
			<td><input type=password size=20 name=l_passwd value="<?=$l_passwd?>"></td>
		</tr>
		<tr>
			<td colspan=3 align=center></td>
		</tr>
		
		<tr>
			<td colspan=2></td>
			<td>
				<table>
				<tr>
					<td><input type=checkbox name=stickme <?=$stickme_checked?> id="stickme_password" title="Прислать печенье, чтобы не вводить логин и пароль каждый раз."></td>
					<td><label for=stickme_password>запомнить мой вход на этом компьютере</label></td>
				</tr>
				<tr>
					<td><input type=checkbox name=redirect <?=$redirect_checked?> id="redirect_password"></td>
					<td><label for=redirect_password>403_REDIRECT => Poll</label>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?=$hrefto?>"><?=$hrefto?></a>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		
		<tr>
			<td colspan=2></td>
			<td><input type=button onclick="javascript:form_login_password_submit()" value="войти под своим именем"></td>
		</tr>
	</form>
	</table>

</td>
<td width=20></td>
<td>

	<table border=0 align=left>
		<tr>
			<td></td>
			<td><a href="javascript:popup_pwreminder()">напомнить пароль</a></td></tr>
		</tr>
		<tr>
			<td></td>
			<td><a href="javascript:fill_incognito()">войти инкогнито</a></td></tr>
		</tr>
	</table>

</td></tr>
</table>

<? if ($unhashed["person_ident"] != "") { ?>
<br><br><br>

<table>
<form method="get" name=form_logoff>
<input type=hidden name=mode value=logoff>
	<tr>
		<td width=50></td>
		<td width=10></td>
		<td><input type=submit value="Logoff [<?=$unhashed["person_ident"]?>] //auth.php?mode=logoff"></td>
	</tr>
</form>
</table>


<table>
<form method="get" name=form_logoff_person>
<input type=hidden name=mode value=logoff_person>
	<tr>
		<td width=50></td>
		<td width=10></td>
		<td><input type=submit value="Logoff [<?=$unhashed["person_ident"]?>] //_code_once.php?mode=logoff_person"></td>
	</tr>
</form>
</table>

<? } ?>



<script>
function redirect_index() {
	location.href = "index.php?from=auth_403_failed";
}
function redirect_logged() {
	location.href = "logged.php";
}
function redirect_sheet() {
	location.href = "person_sheet.php";
}

function focus_login() {
	vitem = form_edit_find_it("l_login", "form_login_password")
	debug = 0
	if (debug == 1) {
		confirmed = confirm("vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}

	if (vitem != null) vitem.focus()	
}

function focus_passwd() {
	vitem = form_edit_find_it("l_passwd", "form_login_password")
	debug = 0
	if (debug == 1) {
		confirmed = confirm("vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}

	if (vitem != null) vitem.focus()	
}

function fill_incognito() {
	a_login = document.form_login_password.l_login
	a_passwd = document.form_login_password.l_passwd

	if (a_login.value == "") a_login.value = "incognito"
	if (a_passwd.value == "") a_passwd.value = "1234567"
}

</script>


<? require "_bottom.php" ?>