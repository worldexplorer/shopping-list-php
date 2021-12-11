<? require_once "_lib/_init.php" ?>
<? require_once "_code_once.php" ?>
<?


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
	<title><?=$site_name?><?=$pagetitle_separator?> фрейм с авторизацией</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="pragma" content="no-cache">

	<meta name="keywords" content="фрейм с авторизацией">
	<meta http-equiv="keywords" content="фрейм с авторизацией">

	<link rel="stylesheet" type="text/css" href="default.css">
	<script src="script.js"></script>

</head>


<body >

<table align="center" class="border" cellpadding=5><tr><td>

<? if ($unhashed["person"] == 0) { ?>
<?

if (!isset($l_login)) $l_login = get_string("l_login");
if (!isset($l_passwd)) $l_passwd = get_string("l_passwd");

$stickme = 1;
if ($mode != "" && get_string("stickme") == "") $stickme = 0;
$stickme_checked = ($stickme == 1) ? "checked" : "";
?>

<table>
<form method=post name=form_auth_top action="auth.php" target=_parent>
<input type=hidden name=mode value=login_person>

<tr><td>Логин:</td><tr>
<tr><td><input type=text size=15 class="lp" name="l_login" id="l_login" value="<?=$l_login?>"></td></tr>

<tr><td>Пароль:</td><tr>
<tr><td><input type="password" size=15 class="lp" name="l_passwd" id="l_passwd" value="<?=$l_passwd?>"></td></tr>

<tr><td><input type=checkbox name=stickme <?=$stickme_checked?> id="stickme" title="Прислать печенье, чтобы не вводить логин и пароль каждый раз."><label for=stickme>запомнить</label></td></tr>
<tr><td align=center><input type=submit onclick="javascript:auth_submit('form_auth_top')"  value="войти"></td></tr>

<!--tr><td><a href="javascript:popup_pwreminder()">напомнить пароль</a></td></tr>
<tr><td><a href="register.php" target=_parent>зарегистрироваться</a></td></tr>
<tr><td><a href="mmenu.php?id=127&popup=1" target=_blank>помощь pop-up</a></td></tr-->

<tr><td><a href="javascript:fill_incognito()">войти инкогнито</a></td></tr>

</table>

<script>
function fill_incognito() {
	a_login = document.form_auth_top.l_login
	a_passwd = document.form_auth_top.l_passwd

	if (a_login.value == "") a_login.value = "incognito"
	if (a_passwd.value == "") a_passwd.value = "1234567"
}

function auth_top_submit() {
	a_login = document.form_auth_top.l_login
	a_passwd = document.form_auth_top.l_passwd

	if (a_login.value == "") alert ("Вы не указали Логин")
	else if (a_passwd.value == "") alert ("Пароль не может быть пустым")
	else document.form_auth_top.submit()
}
</script>

<? } else { ?>

<table align="center">
<tr>
	<td>Пользователь:<br>
	<!--?=$unhashed["person_ident_short"]?-->
	<a href="profile.php" target=_parent><?=$unhashed["person_ident_short"]?></a><br><br>
	</td>
</tr>
<tr>
	<td><a href="auth.php?mode=logoff" target=_parent>Выход</a></td>
</tr>
</table>

<? } ?>


</td></tr></table>

<!--p align=right>[<?= round(getmicrotime() - $start_execution_time, 2) ?> sec]</p-->


</body>
</html>