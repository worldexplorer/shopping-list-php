<? require_once "../_lib/_init.php" ?>
<?

function pollanswer_cnt($row) {
	global $id;
	$ret = 0;
	
	$cnt = select_field("count(id) as cnt", array("poll" => $id, "deleted" => false), "pollanswer");
	if ($cnt > 0) $ret = $cnt;
	
	return $ret;
}


$debug_query = 0;

$poll = $id;
require "../_poll-rendered.php";		//$poll_rendered

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	
	"comment_above" => array ("", "textarea_3", ""),
	"tooltip" => array ("", "textarea_3", ""),
	"comment_below" => array ("", "textarea_3", ""),
	"save_button_label" => array ("", "textfield", "$msg_bo_save"),
	

	"icwhose" => array ("", "select_hard"),
//	"~1" => array ("", "icwhose_rendered"),
//	"~2" => array ("", "multicompositeiccontent"
//		, $m2m_table, $m2m_fixedhash, $absorbing_fixedhash
//		, $icwhose_id_selected, "COMMENT HERE"),



	"~whatsapp_rendering-open" => array ("", "layer_open"),
	"~2" => array ("", "ahref", $poll_rendered),
	"~whatsapp_rendering-close" => array ("", "layer_close"),
	
	"~votes_expected-open" => array ("Сколько ожидается голосов (15)", "layer_open"),
	"~3" => array ("", "ahref", "тут таблица"),
	"~votes_expected-close" => array ("Сколько ожидается голосов (15)", "layer_close"),
	
	"admins_csv" => array ("PERSON_ID<br> Aдминов,<br> CSV", "textfield", ""),
	"admins_notify_after_votes" => array ("Админам отправлять<br> updates email<br> после N голосов", "number", ""),

	"gender_explicit" => array ("", "checkbox", "", true),
	
	//"~11" => array ("[@masterdepend_cnt@]", "ahref", "<a href='@masterdepend_entity@.php?#ENTITY#=#ID#'>Варианты ответов для этого опросника</a>"),
	
	"published" => array ("", "checkbox", "", true)
);

?>

<? include "../_lib/_entity_edit.php" ?>
<? include "_top.php" ?>
<? include "../_lib/_edit_fields.php" ?>
<? include "_bottom.php" ?>
