<?

require_once "../_lib/_init.php";

//$debug_query = true;

$question_row = array();
if ($id > 0) {
	$question_row = select_entity_row();
	$game_selected = $question_row["game"];
//	pre("game_selected[$game_selected]");
	if ($question_row["tour"] > 0) {
		$tour_selected = $question_row["tour"];
//		pre("tour_selected2[$tour_selected]");
		
		$tour_row = select_entity_row(array("id" => $tour_selected), "tour");
//		pre("tour_row[" . pr($tour_row) . "]");
		if (isset($tour_row) && $game_selected != $tour_row["game"]) {
			//$tour_selected = select_field("id", array("game" => $game_selected), "tour");
			//pre("tour_selected3[$tour_selected]");
//			$game_selected = $tour_row["game"];
//			pre("game_selected2[$game_selected]");
		}
	}
} else {
	$game_selected = get_number("game");
	if ($game_selected == 0) {
		$game_selected = select_field("id", 0, "game");
	}
	
	$tour_selected = get_number("tour");
	if ($tour_selected == 0) {
		$tour_selected = select_field("id", array("game" => $game_selected), "tour");
	}

	if ($mode != "update") $layer_opened_nr = 2;
//	pre("tour_selected[$tour_selected]");
}

if ($layer_opened_nr == 0) $layer_opened_nr = 1;

//pre("game_selectedXX[$game_selected]");


if ($mode == "update") {
	if (isset($_REQUEST["tour"]) == false || $_REQUEST["tour"] == "") $_REQUEST["tour"] = "0";
}


$tpl_controlled = <<< EOT
<tr>
	<td align="right" nowrap>
		<label for="#dict_table#:correct[#dict_id#]"><font color="#dict_color#">#dict_ident#</font></label>
	</td>
	<td width=10></td>
	<td>
		<input type=text size="25" name="#dict_table#[#dict_id#][content]" value="#m2m_content#" />
	</td>
	<td width=10>
		<input type=checkbox size=3 name="#dict_table#[#dict_id#][correct]" id="#dict_table#:correct[#dict_id#]" #m2m_correct_checked# />
	</td>
	<td align="right" nowrap>
		<font color="gray">#dict_answer#</font>
	</td>
</tr>
EOT;

$m2m_team_question_fixed4select = array("game" => $game_selected);
$m2m_team_question_fixed4insert = array("game" => $game_selected, "tour" => $tour_selected);

$answer = "'" . $question_row["answer"] . "'";
$m2m_team_question_fixed_additional = array($answer => "dict_answer");

$entity_fields = array (
	"ident" => array ("", "textfield", ""),
	"answer" => array ("", "textfield", ""),
	
//	"~1columned_open" => array ("Верные ответы", "columned_open"),
	"team" => array ("Верные ответы", "m2mtfcontrolled",
		"m2m_team_question", 
		"m2m_game_team",
		$m2m_team_question_fixed4select,
		$m2m_team_question_fixed4insert,
		$m2m_team_question_fixed_additional),
//	"~1columned_close" => array ("", "columned_close"),

	
	"~3_open" => array ("Детали вопроса", "layer_open"),

//	"game" => array ("", "select_soft", get_number("game")),
//	"tour" => array ("", "select_soft", get_number("tour")),
	
	"~2columned_open" => array ("", "columned_open"),
	"game" => array ("", "radio_table", "ident", "", array("published" => 1)),
	"tour" => array ("", "radio_table", "ident", "", array("published" => 1, "game" => $game_selected)),
	"~2columned_close" => array ("", "columned_close"),

	//"brief" => array ("Кратко<br><br>в список<br>команд", "freetext_200", ""),
	"brief" => array ("", "textarea_3", ""),
	//"content" => array ("Описание<br><br>в карточку команды,<br>справа от фото", "freetext", ""),
	"content" => array ("", "textarea_10", ""),
	"~3_close" => array ("Детали вопроса", "layer_close"),

	"~service_layer-open" => array ("", "layer_open"),
	"date_created" => array ("", "timestampro", ""),
	"date_updated" => array ("", "timestampro", ""),
	"~service_layer-close" => array ("", "layer_close"),
	
	//"published" => array ("", "checkbox", 1, "@bo_href_preview@"),
	"published" => array ("", "checkbox", 1),
);

?>

<? require "../_lib/_entity_edit.php" ?>
<? require_once "_top.php" ?>
<? require "../_lib/_edit_fields.php" ?>
<? require_once "_bottom.php" ?>
