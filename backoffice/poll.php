<? require_once "../_lib/_init.php" ?>
<?

$person_cnt = select_field("count(id)", array("published" => 1), "person");

$tpl_poll_rendered = <<< EOT
<a href="javascript:popup_url('poll-rendered.php?id=#ID#', 'poll_rendered_#ID#', '')">$msg_tag_shortcut</a>
EOT;

$table_columns = array (
	"id" => array("", "sernoupdown"),
//	"ident" => array("", "hrefedit"),

	"ident" => array("", "ahref", "$tpl_poll_rendered <a href=#ENTITY#-edit.php?id=#ID#>#IDENT#</a>"),
	
//	"icdict_cnt" => array("Вопросы", "ahref", "<center><a href=icdict.php?icwhose=#ICWHOSE#>вопросы: #ICDICT_CNT#</a></center>", "13em"),
	
	"icdictcontent_cnt" => array("Состав", "ahref", "<center><a href=pollanswer.php?poll=#ID#>состав:&nbsp;#ICDICTCONTENT_CNT#</a></center>"),
	
	"person_cnt" => array("Кому", "ahref", "<center><a href=pollanswer.php?poll=#ID#>кому:&nbsp;$person_cnt</a></center>"),
	
	"person_replied_cnt" => array("Ответили", "ahref", "<center><a href=m2m_person_pollanswer.php?poll=#ID#>ответили:&nbsp;#PERSON_REPLIED_CNT#</a></center>"),
	
//	"cnt" => array("Вариантов ответов", "ahref", "<center><a href=pollanswer.php?poll=#ID#>вариантов ответов: #CNT#</a></center>", "13em"),

	"tooltip" => array("", "hrefedit"),
	"comment_above" => array("", "hrefedit"),
	"comment_below" => array("", "hrefedit"),

	"gender_explicit" => array("", "checkbox", "", "style='width:9ex'"),
	"published" => array("", "checkbox"),
	"~delete" => array("", "checkboxdel")
);


//$debug_query = 1;
$list_left_additional_fields = " , count(distinct icd.id) as icdict_cnt, count(distinct icdc.id) as icdictcontent_cnt, count(distinct pre.id) as person_replied_cnt";
$list_left_additional_joins = " left outer join icdict icd on e.icwhose=icd.icwhose and icd.deleted=false and icd.icwhose=e.icwhose"
	. " left outer join icdictcontent icdc on icdc.icdict=icd.id and icdc.deleted=false"
	. " left outer join m2m_person_pollanswer pre on pre.poll=e.id and pre.deleted=false"
	;

?>
<? require "../_lib/_updown.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_list.php" ?>
<? require_once "_bottom.php" ?>