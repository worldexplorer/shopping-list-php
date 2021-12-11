<?

$fname_common = array(
	" " => "_",
	"/" => "_",
	"\\" => "_",
//	"." => "_",
	"#" => "_",
	"\"" => "_",
	"'" => "_",
	"?" => "_",
	"%20" => "_",
	":" => "_",
	"{" => "_",
	"}" => "_",
	"*" => "_"
);

$win_tran = array(
	"А" => "A",
	"Б" => "B",
	"В" => "V",
	"Г" => "G",
	"Д" => "D",
	"Е" => "E",
	"Ё" => "E",
	"Ж" => "ZH",
	"З" => "Z",
	"И" => "I",
	"Й" => "'",
	"К" => "K",
	"Л" => "L",
	"М" => "M",
	"Н" => "N",
	"О" => "O",
	"П" => "P",
	"Р" => "R",
	"С" => "S",
	"Т" => "T",
	"У" => "U",
	"Ф" => "F",
	"Х" => "H",
	"Ц" => "C",
	"Ч" => "CH",
	"Щ" => "SCH",
	"Ш" => "SH",
	"Ь" => "'",
	"Ы" => "Y",
	"Ъ" => "'",
	"Э" => "E",
	"Ю" => "YU",
	"Я" => "YA",
	"а" => "a",
	"б" => "b",
	"в" => "v",
	"г" => "g",
	"д" => "d",
	"ё" => "e",
	"э" => "e",
	"е" => "e",
	"ж" => "zh",
	"з" => "z",
	"и" => "i",
	"й" => "i'",
	"к" => "k",
	"л" => "l",
	"м" => "m",
	"н" => "n",
	"о" => "o",
	"п" => "p",
	"р" => "r",
	"с" => "s",
	"т" => "t",
	"у" => "u",
	"ф" => "f",
	"х" => "h",
	"ц" => "c",
	"ч" => "ch",
	"ш" => "sh",
	"щ" => "sсh",
	"ь" => "'",
	"ы" => "y",
	"ъ" => "'",
	"ю" => "yu",
	"я" => "ya"
);

$win_tran2russian = array_flip ($win_tran);

$dos_tran = array(
	"Ђ" => "A",
	"Ѓ" => "B",
	"‚" => "V",
	"ѓ" => "G",
	"„" => "D",
	"…" => "E",
	"р" => "E",
	"†" => "ZH",
	"‡" => "Z",
	"€" => "I",
	"‰" => "'",
	"Љ" => "K",
	"‹" => "L",
	"Њ" => "M",
	"Ќ" => "N",
	"Ћ" => "O",
	"Џ" => "P",
	"ђ" => "R",
	"‘" => "S",
	"’" => "T",
	"“" => "U",
	"”" => "F",
	"•" => "H",
	"–" => "C",
	"—" => "Ch",
	"™" => "SCH",
	"" => "SH",
	"њ" => "'",
	"›" => "Y",
	"љ" => "'",
	"ќ" => "E",
	"ћ" => "YU",
	"џ" => "YA",
	" " => "a",
	"Ў" => "b",
	"ў" => "v",
	"Ј" => "g",
	"¤" => "d",
	"Ґ" => "e",
	"р" => "e",
	"¦" => "zh",
	"§" => "z",
	"Ё" => "i",
	"©" => "i",
	"Є" => "k",
	"«" => "l",
	"¬" => "m",
	"­" => "n",
	"®" => "o",
	"Ї" => "p",
	"а" => "r",
	"б" => "s",
	"в" => "t",
	"г" => "u",
	"д" => "f",
	"е" => "h",
	"ж" => "c",
	"з" => "ch",
	"й" => "sch",
	"и" => "sh",
	"м" => "'",
	"л" => "y",
	"к" => "'",
	"н" => "e",
	"о" => "yu",
	"п" => "ya"
);

$dos_tran2russian = array_flip ($dos_tran);

?>