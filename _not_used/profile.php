<? require "_code.php" ?>
<?

if ($unhashed["customer"] == 0) redirect("auth.php?alertmsg=�������� �����������", 0);


$markers_hash = array (
	"cname" => $unhashed["customer_row"]["ident"],
//	"contract_number" => $unhashed["customer_row"]["contract_number"],
	"contract_discount" => $unhashed["customer_row"]["contract_discount"],
	"phone" => $unhashed["customer_row"]["phone"],
	"fax" => $unhashed["customer_row"]["fax"],
	"address" => $unhashed["customer_row"]["address"],
	"manager_name" => $unhashed["customer_row"]["manager_name"],
	"manager_email" => $unhashed["customer_row"]["manager_email"],

	"submit_HTMLrow" => "<tr><td colspan=3 align=right><input type='button' onclick='form_edit_submit()' value='��������� ������ �� ��������� ������'></td></tr>"
);
//$cookie_debug = 1;
$markers_hash = gethash_bytplhash($markers_hash, 0);
$markers_hash["manager_email"] = trim($markers_hash["manager_email"]);


$tpl = <<< EOT
<table border=0>
<form method=post name=form_edit id=form_edit>
<input type=hidden name=mode value=update>
<tr>
	<td align=right><font color=red>*</font> ��� �������</td>
	<td></td>
	<td><input type="text" size="20" id="ident" name="ident" value="#CNAME#"></td>
</tr>

<!--tr>
	<td align=right><font color=red>*</font> ����� ��������</td>
	<td></td>
	<td><input type="text" size="20" id="contract_number" name="contract_number" value="#CONTRACT_NUMBER#"></td>
</tr-->

<tr>
	<td align=right><font color=red>*</font> �������� ������</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="contract_discount" name="contract_discount" value="#CONTRACT_DISCOUNT#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> �������</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="phone" name="phone" value="#PHONE#"></td>
</tr>

<!--tr>
	<td align=right><font color=red>*</font> ����</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="fax" name="fax" value="#FAX#"></td>
</tr-->

<tr>
	<td align=right><font color=red>*</font> ����� ��������</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="address" name="address" value="#ADDRESS#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ��� ��������� (����. �����)</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="manager_name" name="manager_name" value="#MANAGER_NAME#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ��� ���������� ����������</td>
	<td></td>
	<td colspan=3><input type="text" size="20" id="manager_email" name="manager_email" value="#MANAGER_EMAIL#"></td>
</tr>


<tr><td height=20></td></tr>

#SUBMIT_HTMLROW#

</form>
</table>
EOT;

//http://localhost:8066/analytica/backoffice/customer-edit.php?id=2
$request_uri = $_SERVER["REQUEST_URI"];
$relpath = dirname($_SERVER["REQUEST_URI"]);
if (strlen($relpath) > 1) $relpath .= "/";


$customer_edit_url = "http://" . $_SERVER["HTTP_HOST"] . ":" . $relpath . "backoffice/customer-edit.php?id=" . $unhashed["customer"];
$markers_hash["customer_edit_url"] = $customer_edit_url;



if ($mode == "update" && $errormsg == "" && $markers_hash["cname"] == "") {
	$errormsg = "������� �������� ��������";
}

/*
if ($mode == "update" && $errormsg == "" && $markers_hash["contract_number"] == "") {
	$errormsg = "������� ����� ��������";
}
*/

if ($mode == "update" && $errormsg == "" && $markers_hash["contract_discount"] == "") {
	$errormsg = "������� ������";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["phone"] == "") {
	$errormsg = "������� �������";
}

/*
if ($mode == "update" && $errormsg == "" && $markers_hash["fax"] == "") {
	$errormsg = "������� ����";
}
*/

if ($mode == "update" && $errormsg == "" && $markers_hash["manager_name"] == "") {
	$errormsg = "������� ��� ��������� (����. �����)";
}

if ($mode == "update" && $errormsg == "" && $markers_hash["manager_email"] == "") {
	$errormsg = "������� ��� ���������� ����������";
}

$form = hash_by_tpl($markers_hash, $tpl);
$markers_hash["form_submitted"] = $form;


if ($mode == "update" && $errormsg == "") {
	$update_hash = array (
		"ident" => $markers_hash["cname"],
		"contract_number" => $markers_hash["contract_number"],
		"contract_discount" => $markers_hash["contract_discount"],
		"phone" => $markers_hash["phone"],
		"fax" => $markers_hash["fax"],
		"address" => $markers_hash["address"],
		"manager_name" => $markers_hash["manager_name"],
		"manager_email" => $markers_hash["manager_email"],
		"remote_address" => $_SERVER["REMOTE_ADDR"]
	);

//	update($update_hash, array("id" => $unhashed["customer"]), "customer");
//	$markers_hash["ident"] = $markers_hash["cname"];


	$customer_row_prefixed = array_addkeyprefix($customer_row, "DB_");
//	$admtail = $admtail_tpl;
//	$admtail = hash_by_tpl($markers_hash, $admtail);
//	echo $admtail = hash_by_tpl($customer_row_prefixed, $admtail);
//	$alertmsg = send_mtpl("USERPROFILE_CHANGE_REQUEST", $markers_hash, $markers_hash["email"]);

	$markers_hash = array_merge($markers_hash, $customer_row_prefixed);
	$alertmsg = send_mtpl("USERPROFILE_CHANGE_REQUEST", $markers_hash);
	$errormsg = "";

	$insert_hash = array (
		"ident" => select_field("ident", array("hashkey" => "USERPROFILE_CHANGE_REQUEST"), "mtpl") . " / " . $markers_hash["cname"],
		"content" => $form . $admtail . "<p>$errormsg</p>",
		"remote_address" => $_SERVER["REMOTE_ADDR"],
		"date_created" => "CURRENT_TIMESTAMP",
		"date_published" => "CURRENT_TIMESTAMP",
	);
	insert($insert_hash, "sentlog");
}


$table .= $form;

jsv_addvalidation("JSV_TF_CHAR", "ident", "�������� ��������");
//jsv_addvalidation("JSV_TF_CHAR", "contract_number", "����� ��������");
jsv_addvalidation("JSV_TF_CHAR", "contract_discount", "������");
jsv_addvalidation("JSV_TF_CHAR", "phone", "�������");
//jsv_addvalidation("JSV_TF_CHAR", "fax", "����");
jsv_addvalidation("JSV_TF_CHAR", "address", "����� ��������");
jsv_addvalidation("JSV_TF_CHAR", "manager_name", "��� ��������� (����. �����)");
jsv_addvalidation("JSV_TF_CHAR", "manager_email", "��� ���������� ����������");


if ($errormsg != "") $alertmsg = strip_tags($errormsg);

$onload = "onload='focus_on_first()'";


?>
<? require "_top.php" ?>

<?=$mmenu_content?>

<? if ($errormsg != "") { ?>
<h4><?=$errormsg?></h4>
<? } ?>

<table cellpadding=10 cellspacing=0 style="border: 0px solid #aaaaaa" align=center>
<tr><td>
<?=$table?>
</td></tr>
</table>

<script>
function focus_on_first() {
	vitem = form_edit_find_it("login", "form_edit")
	debug = 0
	if (debug == 1) {
		confirmed = confirm("vitem [" + vitem + "]: value=[" + vitem.value + "]")
		if (!confirmed) return false
	}

	if (vitem != null) vitem.focus()	
}
</script>


<? require "_bottom.php" ?>

<?

$admtail_tpl = <<< EOT
<hr>
<h2>������������ ����� ������</h2>
<table border=0>
<form method=post name=form_edit id=form_edit action="#CUSTOMER_EDIT_URL#">
<input type=hidden name=selective_update_onedit value=1>
<input type=hidden name=mode value=update>

<tr>
	<td align=right><font color=red>*</font> �������� ��������</td>
	<td></td>
	<td><span class="filled">#DB_IDENT#</span></td>
	<td><input type="text" size="20" id="ident" name="ident" value="#CNAME#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ����� ��������</td>
	<td></td>
	<td><span class="filled">#DB_CONTRACT_NUMBER#</span></td>
	<td><input type="text" size="20" id="contract_number" name="contract_number" value="#CONTRACT_NUMBER#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ������ �� ��������</td>
	<td></td>
	<td><span class="filled">#DB_CONTRACT_DISCOUNT#</span></td>
	<td colspan=3><input type="text" size="20" id="contract_discount" name="contract_discount" value="#CONTRACT_DISCOUNT#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> �������</td>
	<td></td>
	<td><span class="filled">#DB_PHONE#</span></td>
	<td colspan=3><input type="text" size="20" id="phone" name="phone" value="#PHONE#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ����</td>
	<td></td>
	<td><span class="filled">#DB_FAX#</span></td>
	<td colspan=3><input type="text" size="20" id="fax" name="fax" value="#FAX#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ����� ��������</td>
	<td></td>
	<td><span class="filled">#DB_ADDRESS#</span></td>
	<td colspan=3><input type="text" size="20" id="address" name="address" value="#ADDRESS#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ��� ��������� (����. �����)</td>
	<td></td>
	<td><span class="filled">#DB_MANAGER_NAME#</span></td>
	<td colspan=3><input type="text" size="20" id="manager_name" name="manager_name" value="#MANAGER_NAME#"></td>
</tr>

<tr>
	<td align=right><font color=red>*</font> ��� ���������� ����������</td>
	<td></td>
	<td><span class="filled">#DB_MANAGER_EMAIL#</span></td>
	<td colspan=3><input type="text" size="20" id="manager_email" name="manager_email" value="#MANAGER_EMAIL#"></td>
</tr>


<tr><td height=20></td></tr>

<tr><td colspan=4 align=center>
	<b>���� ��������� �������� ���������� ����� - ������ � ������������ �����</b><br>
	<b>����� ������� ������ ����� ����������� ������ �� �����</b><br>
	<input type="submit" value="������ �����������, ������������� �� �� �����"><br>
	<a href="#CUSTOMER_EDIT_URL#" target=_blank>������� ������� ������ ������� � ���������</a>
	</td></tr>


</form>
</table>
EOT;

?>