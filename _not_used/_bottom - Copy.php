<?
plog(pr("\n\r\n\r"));
plog(pr($uprofile, "_bottom:uprofile"));
plog(pr($unhashed, "_bottom:unhashed"));
//plog(pr($_SESSION, "_bottom:_SESSION"));
//plog(pr($_REQUEST, "_bottom:_REQUEST"));
//plog(pr($_SERVER, "_bottom:_SERVER"));
//plog(pr($_COOKIE, "_bottom:_COOKIE"));
?>

<!-- BOTTOM BEGIN -->

<? if ($print == 0) { ?>
<? if ($popup == 0) { ?>

		</div>

		</td>
		<!--td rowspan=1 class="border" width=1%>
			<table cellpadding=0 cellspacing=0 style="width:220px; border:0px solid gray"><tr><td></td></tr></table>
<?
switch ($entity) {
/*	case "index":
		require "_menu_left_hot.php";
		break;
*/
	default:
//		require "_chart_right.php";
}
?>

		</td-->


	</tr>
	<tr valign=top><td colspan=3 align=center class="border" ondblclick="javascript:popup_bo('constant-edit.php?id=4')"><?=$content_bottom?></td></tr>

<? if ($bo_href == "") $bo_href = "mmenu-edit.php?id=$mmenu_id" ?>
	<tr><td colspan=3><p align=right><a href="#" onclick="javascript:popup_bo('<?=$bo_href?>')" class="gray">бэкоффис</a></p></td></tr>

<? } // print ?>
<? } // popup ?>


</table>

<!--p align=right>[<?= round(getmicrotime() - $start_execution_time, 2) ?> sec]</p-->
<? if ($layers_total > 0) echo "<script>layers_total=$layers_total</script>" ?>

<? if ($plog != "") { ?>
<pre><?=$plog?></pre>
<? } ?>


<? if ($alertmsg != "") { ?>
<script>
alert("<?=$alertmsg?>");
</script>
<? } ?>



</body>
<? if ($print == 1) echo "</noindex>" ?>
</html>
