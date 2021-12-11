<!-- BEGIN _menu_top.php -->
<?

$_menu_top = "";

function target_blank($row) {
	$ret = "";
	if ($row["id"] == 7 || $row["id"] == 8) $ret = "target=_blank";
	return $ret;
}

$tpl = <<< EOT
<td nowrap><div class=menutop><a href="@mmenu_hrefto@"
	onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('mmenu_#ID#','','#IMG_MOVER_RELPATH#',1)"><img
	name="mmenu_#ID#" border="0" src="#IMG_FREE_RELPATH#" #IMG_FREE_WH# alt="#IDENT#" @add_mover_preload@></a></div></td>
EOT;

$tpl_cur = <<< EOT
<td nowrap><div class=menutop><a href="@mmenu_hrefto@"><img border="0" src="#IMG_MOVER_RELPATH#" #IMG_FREE_WH# alt="#IDENT#"></a></div></td>
EOT;


$tpl = <<< EOT
<a href="@mmenu_hrefto@">#IDENT#</a>
EOT;

$tpl_cur = <<< EOT
<a href="@mmenu_hrefto@" class=cur>#IDENT#</a>
EOT;

$tpl_separator = "";

//$menu_top_root_id = 2;
//$_menu_top = tree_tpl($tpl, $tpl_cur, "mmenu", $root_mmenu_id, $menu_top_root_id, array("published" => 1), 1, 1);
//$_menu_top = entity_list_tpl($tpl, $tpl_cur, "mmenu", 0, array("parent_id" => $menu_top_root_id));

$_menu_top = mmenuleaf_anchor("MMENU_TOP", $tpl, $tpl_cur, 0, $tpl_separator);


echo <<< EOT
<div class="menutop">
$_menu_top
</div>
EOT;


?>
<!-- END _menu_top.php -->