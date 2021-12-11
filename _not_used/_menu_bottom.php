<!-- BEGIN _menu_bottom.php -->
<?

$_menu_bottom = "";

$tpl_cur = $tpl = <<< EOT
<nobr><a href="@mmenu_hrefto@" class="footerLinks" title="#IDENT#">#IDENT#</a></nobr>
&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
EOT;

$tpl_cur = $tpl = <<< EOT
	<li><a href="@mmenu_hrefto@" title="#IDENT#"><span>#IDENT#</a></span></a></li>

EOT;


$menu_top_root_id = 5;
//$_menu_bottom = tree_tpl($tpl, $tpl_cur, "mmenu", $root_mmenu_id, $menu_top_root_id, array("published" => 1), 1, 1);
$_menu_bottom = entity_list_tpl($tpl, $tpl_cur, "mmenu", 0, array("parent_id" => $menu_top_root_id, ""));

//$query_bottom = "select * from mmenu where published=1 and published_legend=1 and deleted=0";
//$_menu_bottom = query_by_tpl($query_bottom, $tpl);

/*
echo <<< EOT
<ul class="menu footernav">
$_menu_bottom
</ul>

EOT;
*/
?>

<!-- 
<ul class="menu footernav">
	<li class=" first order1 item310"><a href="/index.php?option=com_contact&amp;view=contact&amp;id=6&amp;Itemid=310"><span>Контакты</span></a></li>
	<li class=" middle order2 item311"><a href="/index.php?option=com_content&amp;view=article&amp;id=66&amp;Itemid=311"><span>Обмен ссылками</span></a></li>
	<li class=" middle order3 item312"><a href="/index.php?option=com_content&amp;view=article&amp;id=70&amp;Itemid=312"><span>Прайс-лист</span></a></li>
	<li class=" middle order4 item313"><a href="/index.php?option=com_content&amp;view=article&amp;id=64&amp;Itemid=313"><span>Прием ведет...</span></a></li>
	<li class=" last order5 item314"><a href="/index.php?option=com_content&amp;view=article&amp;id=69&amp;Itemid=314"><span>Прикрепление на лечение</span></a></li>
</ul>
 -->
 
 
 
<!-- END _menu_bottom.php -->

              <article class="span3 fright">
                   <ul class="list">
                    <li><a href="#">Learn to Skydive</a></li>
                    <li><a href="#">Safety Articles</a></li>
                    <li><a href="#">Fatality Database</a></li>
                    <li><a href="#">Skydiving Disciplines</a></li>
                    <li><a href="#">Safety &amp; Training Forum</a></li>
                  </ul>
              </article>
              <article class="span3 fright">
                  <ul class="list">
                    <li><a href="#">Be aware of the risk</a></li>
                    <li><a href="#">Choose a method of training</a></li>
                    <li><a href="#">Find a Drop Zone</a></li>
                    <li><a href="#">Set a date and jump!</a></li>
                    <li><a href="#">Get licensed</a></li>
                  </ul>
              </article>