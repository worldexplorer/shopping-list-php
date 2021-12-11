<? require "_code.php" ?>
<?

if ($mmenu_hashkey != "") {
	$bo_href = "$mmenu_hashkey.php";

	if ($mmenu_tpl_list_item != "") {
		$table = entity_list_tpl($mmenu_tpl_list_item, $mmenu_tpl_list_item, $mmenu_hashkey);

		if ($mmenu_tpl_list_wrapper != "") {
			$table = hash_by_tpl(array("list_items" => $table), $mmenu_tpl_list_wrapper);
		}

	}
	
	if ($table != "") {
		if (!preg_match("/#LIST_ITEMS#/i", $mmenu_content)) $mmenu_content .= "#LIST_ITEMS#";
		$mmenu_content = hash_by_tpl(array("list_items" => $table), $mmenu_content);
	}
}

/*
if ($mmenu_content == "") {
	$mmenu_content =  <<< EOT
        <div class="row">
             <article class="span4">
               <h2>Under Construction</h2>
               <div class="img-indent">
                 <figure class="img-polaroid"><img src="img/page-1-img.jpg" alt=""></figure>
                 <p>To edit this page click on the &copy; sign at the bottom of this page</p>
               </div>
             </article>
        </div>
EOT;
}
*/

?>
<? require "_top.php" ?>

<?=$mmenu_content?>

<? require "_bottom.php" ?>