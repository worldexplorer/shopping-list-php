<?


function multicompositeiccontent_voted($m2m_table, $fixed_hash, $absorbing_fixedhash, $icwhose_id) {
	global $mode, $debug_query, $debug_session;
	global $sheet_present_in_db, $sheet_had_errors, $backrow_tpl, $in_backoffice;
	global $backrow_not_obligatory_sign, $backrow_obligatory_sign, $backrow_obligatory_nojs_sign, $backrow_obligatory_jsonly_sign, $obligatory_field;
	global $published_opthash, $published_opthash_standard, $published_opthash_colorized;

	global $mcicc_copyform;
	$mcicc_copyform_tpl = "<input type='hidden' name='#IT_NAME#' value='#IT_VALUE#'>\n";

	$ret = "";
	
	$absorbed_fixedhash = absorb_fixedhash($absorbing_fixedhash);
//	pre("multicompositeiccontent");

//	pre($fixed_hash);
//	pre($absorbed_fixedhash);
	
/*
	$ic_has_jsv = entity_has_field("ic", "jsvalidator");

	$query = "select ic.id, ic.ident, ic.ictype, ic.icdict, ic.param1, ic.param2, ic.$obligatory_field as obligatory, ic.graycomment"
		. " , t.hashkey as ictype_hashkey"
		. " from ic ic, ictype t"
		. " where ic.deleted=false and ic.published=true and t.published=true and t.deleted=false"
		. " and ic.ictype=t.id"
		. " and ic.icwhose=" . $icwhose_id
		. " order by ic." . get_entity_orderfield("ic");

	if ($ic_has_jsv == 1) {
		$query = "select ic.id, ic.ident, ic.ictype, ic.icdict, ic.param1, ic.param2, ic.$obligatory_field as obligatory, ic.graycomment"
*/

		$published_field = ($in_backoffice == 1) ? "published_bo" : "published";
		$query = "select ic.*"
			. " , t.hashkey as ictype_hashkey, jsv.hashkey as jsv_hashkey"
			. " , icw.jsv_debug"
			. " , m2m.iccontent"
			. " from ic ic"
			. " inner join ictype t on ic.ictype=t.id"
			. " left outer join jsvalidator jsv on ic.jsvalidator=jsv.id"
			. " inner join icwhose icw on icw.id=" . $icwhose_id


// hoping nightmare will stop
//function sqlcond_fromhash($fixed_hash, $col_prefix = "", $startfrom = ""
//, $conjunction = "and",  $table_prefix = "", $addslashes = 1)

			. " left outer join $m2m_table m2m on m2m.ic=ic.id "
				. sqlcond_fromhash(array_merge($fixed_hash, $absorbed_fixedhash), "m2m", "and ")


			. " where ic.deleted=false and ic.$published_field=1 and t.published=true and t.deleted=false"
			. " and ic.icwhose=" . $icwhose_id
			. " group by ic.id"
			. " order by ic." . get_entity_orderfield("ic");
//	}


	$ic_rows = select_queryarray($query);
	//pre($ic_rows);
	//echo $query;


	$sheet_present_in_db = 0;
	$sheet_present_in_db_fixedhash = array_merge($fixed_hash, $absorbed_fixedhash);
	foreach ($ic_rows as $ic_row) {
		if ($ic_row["ictype_hashkey"] == "AHREF") continue;

		$sheet_present_in_db_fixedhash["ic"] = $ic_row["id"];
//		pre($sheet_present_in_db_fixedhash);
		$iccontent_indb_count = ($m2m_table != "m2m_nosave")
			? select_field("count(id)", $sheet_present_in_db_fixedhash, $m2m_table)
			: 0
			;

		if ($iccontent_indb_count > 0) $sheet_present_in_db++;
	}
//	echo $sheet_present_in_db;

	

	foreach ($ic_rows as $ic) {
		$ic["obligatory"] = $ic[$obligatory_field];		//$ic["obligatory_bo"] for backoffice and $ic["obligatory"] for face
//		pre($ic);
		$ic_output = "";
		$ictype_hashkey = $ic["ictype_hashkey"];
		$jsv_hashkey = $ic["jsv_hashkey"];

		$composite = $fixed_hash;
		$composite["ic"] = $ic["id"];

		$it_name = "mcicc_";
//		$it_name .= iccomposite_itname(array_keys($composite)) . ":";
		$it_name .= iccomposite_itvalue(array_keys($composite), $composite);

// updating
//		if ($mode == "update") {
//			multicompositeiccontent_update($m2m_table, $composite, $ic, $it_name, $absorbed_fixedhash);
//		}

// displaying
/*		$tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#">
	<td align="right" nowrap>#OBLIGATORY_HTML#<font class="name"><label for="#IT_NAME#" class="name">#IT_TXT#</label></font></td>
	<td width="100%">#IT_WRAPPED#</td>
</tr>
EOT;

		$tpl = <<< EOT
<tr bgcolor="#SHEET_ROW_BGCOLOR#">
	<td align=right nowrap>#OBLIGATORY_SIGN#<font class="name"><label for="#IT_NAME#" class="name">#IT_TXT#</label></font></td>
	<td width=100%>#IT_WRAPPED#</td>
</tr>

EOT;
*/
		$tpl = $backrow_tpl;

//		$it_name .= "[]";
		if (isset($_SESSION["mcicc_hash"]) && isset($_SESSION["mcicc_hash"][$it_name])) {
			$it_value = $_SESSION["mcicc_hash"][$it_name][0];
			if ($debug_session) pre("_SESSION[mcicc_hash][$it_name]=[" . pr($it_value) . "]");
		} else {
			$debug_query = 0;
			if ($m2m_table == "m2m_nosave") {
				$it_value = isset($_REQUEST[$it_name]) ? $_REQUEST[$it_name][0] : "";
			} else {
//				$debug_query = 1;
// nightmare before left join
				$it_value = select_field("iccontent", array_merge($composite, $absorbed_fixedhash), $m2m_table);
//				$it_value = $ic["iccontent"];
//				$debug_query = 0;
			}


			$debug_query = 0;
		}
		if ($mode == "copy") $it_value = get_string($it_name);

		$sheet_row_had_errors = 0;
		$ic_output = "";
		switch($ictype_hashkey) {
			case "RAWHTML":
				$ic_output = $ic["param1"];
				break;
			
			case "AHREF":
				$ic_output = ahref($it_name, $ic, $ic["param1"]);
				break;
			
			case "SELECT":
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

				if ($it_value == "") $it_value = select_first("id", array("icdict" => $ic["icdict"]), "icdictcontent");
				$query = "select id, ident, published"
						. " from icdictcontent"
						. " where icdict=" . $ic["icdict"]
						. " and deleted=false"
						. " order by manorder";

				$published_opthash_bak = $published_opthash;
				$published_opthash = $published_opthash_standard;

				if ($read_only == 0) {
					$ic_output = select_query($it_name, $it_value, $query);
				} else {
					$ic_output = select_field("ident", array("id" => $it_value), "icdictcontent");
				}

				$published_opthash = $published_opthash_bak;

				if ($ic["obligatory"] == 1 && $it_value == 0) $sheet_row_had_errors = 1;
				
				break;

			case "ICSELECT":
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

				$query = "select id, ident, published"
						. " from icdictcontent"
						. " where icdict=" . $ic["icdict"] . " and published=true and deleted=false"
						. " order by manorder";

				$published_opthash_bak = $published_opthash;
				$published_opthash = $published_opthash_standard;

				if ($read_only == 0) {
					$ic_output = select_query($it_name, $it_value, $query);
				} else {
					$ic_output = select_field("ident", array("id" => $it_value), "icdictcontent");
				}

				$published_opthash = $published_opthash_bak;

				if ($ic["obligatory"] == 1 && $it_value == 0) $sheet_row_had_errors = 1;

				break;

/*
			case "ICRADIO":
//				pre($ictype_hashkey);

				if ($mode == "copy") $it_value = get_arrayfirst($it_name);

				$ic_output = icradio($ic["icdict"], $it_value, $it_name, $read_only);

//				$ic_output = icmulti($ic["icdict"], $it_value, "icadio", $it_name, $read_only, $it_iccontent_tf1_dbarray, $icmulti_colcnt);

				if ($ic["obligatory"] == 1 && $it_value == 0) $sheet_row_had_errors = 1;

				break;
*/

			case "ICMULTISELECT":
			case "ICMULTICHECKBOX":
			case "ICRADIO":
//				$debug_query = 1;

				if (isset($_SESSION["mcicc_hash"]) && isset($_SESSION["mcicc_hash"][$it_name])) {
					$it_value_dbarray = $_SESSION["mcicc_hash"][$it_name];
					if ($debug_session) pre("_SESSION[mcicc_hash][$it_name]=[" . pr($it_value) . "]");
				} else {
					$debug_query = 0;
					$it_value_dbarray = ($m2m_table != "m2m_nosave")
						? select_fieldarray("iccontent"
								, array_merge($composite, $absorbed_fixedhash, array("deleted" => false))
								, $m2m_table)
						: array()
						;
					$debug_query = 0;
				}

				if ($mode == "copy") $it_value_dbarray = get_array($it_name);
//				echo "$ictype_hashkey: $it_name " . pr($it_value_dbarray) . "<br>";

//				pre($it_value_dbarray);

				$it_iccontent_tf1_dbarray = array();

				foreach ($it_value_dbarray as $it_value_item) {
					$itname_tf1 = $it_name . "_" . $it_value_item . "_tf1";
//					$itname_tf1 = $it_name . "_" . $it_value_item . "_" . $ic["icdict"] . "_tf1";

					if (isset($_SESSION["mcicc_hash"][$itname_tf1])) {
						$it_tf1_value = $_SESSION["mcicc_hash"][$itname_tf1];
						if ($debug_session) pre("_SESSION[mcicc_hash][$itname_tf1]=[" . pr($it_tf1_value) . "]");

						$it_iccontent_tf1_dbarray[] = $_SESSION["mcicc_hash"][$itname_tf1];
					}
				}

				if (count($it_iccontent_tf1_dbarray) == 0) {
					if ($m2m_table != "m2m_nosave" && entity_has_field($m2m_table, "iccontent_tf1") == 1) {
						$debug_query = 0;
						$it_iccontent_tf1_dbarray = select_fieldarray("iccontent_tf1"
							, array_merge($composite, $absorbed_fixedhash, array("deleted" => false))
							, $m2m_table);
						$debug_query = 0;
//						pre($it_iccontent_tf1_dbarray);
					}
				}

				if ($mode == "copy") {
					foreach ($it_value_dbarray as $it_value_item) {
						$it_iccontent_tf1_dbarray[] = get_string($it_name . "_" . $it_value_item . "_tf1");
					}
//					echo "$ictype_hashkey TF1: $it_name " . pr($it_iccontent_tf1_dbarray) . "<br>";
				}

//				$debug_query = 0;



				$icdict = $ic["icdict"];
				$icdict_hashkey = select_field("hashkey", array("id" => $icdict), "icdict");
				
				switch ($icdict_hashkey) {
					case "PGROUPTREE_SUPPLIERCLICKABLE":
						$ic_output = "ICMULTISELECT - PGROUPTREE_SUPPLIERCLICKABLE";
						if ($read_only == 0) {
							$ic_output = multicompositecontent("supplierbypgroup"
								, $m2m_table, array("pgroup", "supplier"), 1);
						} else {
//							$ic_output = "ICMULTISELECT - PGROUPTREE_SUPPLIERCLICKABLE $read_only";
							$ic_output = multicompositecontent("supplierbypgroup_ro", $m2m_table, array("pgroup", "supplier"), 1);
						}

						break;
				
					case "PGROUPTREE_PGROUPCLICKABLE":
						$ic_output = "ICMULTISELECT - PGROUPTREE_PGROUPCLICKABLE";
//						$ic_output = multicompositecontent("supplierbypgroup"
//							, $m2m_table, array("pgroup", "supplier"), 1);
						break;
				
					default:
//						$ic_output .= "ICMULTISELECT - SIMPLE DICTIONNARY";
//						$it_name .= "[]";	// icmulti handles itself
						$ic_output .= icmulti($icdict, $it_value_dbarray, $ictype_hashkey, $it_name, $read_only, $it_iccontent_tf1_dbarray, $ic["param1"]);

				}

				if ($ic["obligatory"] == 1 && count($it_value_dbarray) == 0) $sheet_row_had_errors = 1;

				break;

			case "TEXTAREA":
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

				if ($read_only == 0) {
					$ic_output = textarea($it_name, $it_value, $ic["param1"]);
				} else {
					$ic_output = ro($it_name, $it_value, $ic["param1"]);
				}
				if ($ic["obligatory"] == 1 && $it_value == "") $sheet_row_had_errors = 1;
				break;

			case "TEXTFIELD":
//				echo "$ictype_hashkey: $it_name $it_value<br>";
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

				if ($read_only == 0) {
					$ic_output = textfield($it_name, $it_value, $ic["param1"]);
				} else {
					$ic_output = ro($it_name, $it_value, $ic["param1"]);
				}
				if ($ic["obligatory"] == 1 && $it_value == "") $sheet_row_had_errors = 1;
				break;

			case "NUMBER":
//				echo "$ictype_hashkey: $it_name $it_value<br>";
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

				if ($read_only == 0) {
					$ic_output = number($it_name, $it_value, $ic["param1"]);
				} else {
					$ic_output = ro($it_name, $it_value, $ic["param1"]);
				}
				if ($ic["obligatory"] == 1 && $it_value == "") $sheet_row_had_errors = 1;
				break;

			case "TEXTAREA_SCROLL":
//				echo "$ictype_hashkey: $it_name $it_value<br>";
				$ic_output = textarea_scroll($ic);
				break;


			case "UPLOAD":
				if (isset($_FILES[$it_name])) {
					if (is_uploaded_file($_FILES[$it_name]["tmp_name"])) {
						$it_value = $_FILES[$it_name]["name"];
					}
				}
				$ic_output = $ictype_hashkey($it_name, $it_value, $ic["param1"]);
				break;

			case "FORMULA":
//				echo "$ictype_hashkey($it_name, $it_value, ${ic['param1']}, ${ic['hashkey']}, $ic_rows)<br>";
				$ic_output = $ictype_hashkey($it_name, $it_value, $ic["param1"], $ic["hashkey"], $ic_rows);
				break;

			case "DATE":
			case "TIMESTAMP_DATE":
//				echo "$ictype_hashkey($it_name, $it_value, " . $ic["param1"] . ")";
//				pre($ic);
				$ic_output = $ictype_hashkey($it_name, $it_value, $ic["param1"]);
				break;

			default:
				if ($mode == "copy") $it_value = get_arrayfirst($it_name);
				$it_name .= "[]";

//				echo "$ictype_hashkey($it_name, $it_value, " . $ic["param1"] . ")";
				$ic_output = $ictype_hashkey($it_name, $it_value, $ic["param1"]);

				if ($ic["obligatory"] == 1 && $it_value == "") $sheet_row_had_errors = 1;
		}

		if (isset($mcicc_copyform)) {
			switch($ictype_hashkey) {
				case "ICMULTISELECT":
				case "ICMULTICHECKBOX":
//					pre($it_iccontent_tf1_dbarray);
					foreach ($it_value_dbarray as $it_value_item) {
						$mcicc_copyform .= hash_by_tpl(
							array("it_name" => $it_name . "[]", "it_value" => $it_value_item)
							, $mcicc_copyform_tpl
							);
					}

					if (entity_has_field($m2m_table, "iccontent_tf1") == 1) {
						for ($i=0; $i<count($it_value_dbarray); $i++) {
							$mcicc_copyform .= hash_by_tpl(
								array("it_name" => $it_name . "_" . $it_value_dbarray[$i] . "_tf1"
									, "it_value" => $it_iccontent_tf1_dbarray[$i])
								, $mcicc_copyform_tpl
								);
						}
					}

					break;
	
				default:
					$mcicc_copyform .= hash_by_tpl(
						array("it_name" => $it_name, "it_value" => $it_value), $mcicc_copyform_tpl
						);
			}
		}


		$row = array();
		$row["id"] = $ic["id"];
		$row["it_txt"] = $ic["ident"];
		$row["it_hashkey"] = $ic["hashkey"];

		if ($read_only == 0) {
			if ($ic["obligatory"] == 1) {
				$row["obligatory_sign"] = ($jsv_hashkey == "") ? $backrow_obligatory_sign : $backrow_obligatory_nojs_sign;
			} else {
				$row["obligatory_sign"] = $backrow_not_obligatory_sign;
				if ($in_backoffice == 1) {
					$row["obligatory_sign"] = ($jsv_hashkey == "") ? $backrow_not_obligatory_sign : $backrow_obligatory_jsonly_sign;
				}
			}
			if ($ignore_jsv_finally == 0 && $ic["obligatory"] == 1) {
				$row["obligatory_sign"] = jsv_addvalidation($jsv_hashkey, $it_name, $ic["ident"], $ic["jsv_debug"], $form_name);
			}

		} else {
			$row["obligatory_sign"] = $backrow_not_obligatory_sign;
		}
		$row["it_name"] = $it_name;
		$row["it_wrapped"] = $ic_output;

		$row["it_graycomment"] 		= (isset($ic["graycomment"]) && $ic["graycomment"] != "")
			? $ic["graycomment"] : "";
		$row["it_graycomment_gray"]	= (isset($ic["graycomment"]) && $ic["graycomment"] != "")
			? "<font style='color: " . OPTIONS_COLOR_GRAY . "'>" . $ic["graycomment"] . "</font>"
			: "";



//	echo "$obligatory_field=[" . $ic["obligatory"] . "] it_name=[$it_name] it_value=[$it_value] sheet_row_had_errors=[$sheet_row_had_errors] sheet_present_in_db=[$sheet_present_in_db]<br>";

		$sheet_row_bgcolor = OPTIONS_COLOR_LIGHTBLUE;
		if ($sheet_row_had_errors == 1 && $sheet_present_in_db > 0) {
			$sheet_had_errors = 1;
			$sheet_row_bgcolor = OPTIONS_COLOR_YELLOWBG;
		}
/*	
		if ($sheet_row_had_errors == 1 && ($sheet_present_in_db == 0 && $mode == "update")) {
			$sheet_had_errors = 1;
			$sheet_row_bgcolor = OPTIONS_COLOR_ORANGE;
		}
*/
		$row["sheet_row_bgcolor"] = $sheet_row_bgcolor;
//		pre($ic);
//		pre($row);
//		pre($tpl);

		if ($ictype_hashkey == "RAWHTML") {
			$ret .= $ic_output;
		} else {
			$ret .= hash_by_tpl($row, $tpl);
		}
	}

//	echo "child: sheet_present_in_db=[$sheet_present_in_db] sheet_had_errors=[$sheet_had_errors]";
	return $ret;
}


?>
