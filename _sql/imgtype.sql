use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_imgtype;
CREATE TABLE shli_imgtype (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content			TEXT,
	imglimit		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	merge_seed		INTEGER UNSIGNED NOT NULL DEFAULT 0,

	resize_default_qlty			VARCHAR(250) NOT NULL DEFAULT 85,
	resize_default_width		VARCHAR(250) NOT NULL DEFAULT '',
	resize_default_height		VARCHAR(250) NOT NULL DEFAULT '',
	resize_published			TINYINT UNSIGNED NOT NULL DEFAULT 1,
	resize_default_checked		TINYINT UNSIGNED NOT NULL DEFAULT 0,

	big_resize_default_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	big_resize_default_width	VARCHAR(250) NOT NULL DEFAULT '',
	big_resize_default_height	VARCHAR(250) NOT NULL DEFAULT '',
	big_resize_published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	big_resize_default_checked	TINYINT UNSIGNED NOT NULL DEFAULT 0,

	first_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first_autoresize_height		VARCHAR(250) NOT NULL DEFAULT '',
#	first_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	first_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first_autoresize_tpl_ex		TEXT,
	first_autoresize_tpl_nex	TEXT,

	first_merge_img				VARCHAR(250) NOT NULL DEFAULT '',
	first_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	first_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	every_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every_autoresize_height		VARCHAR(250) NOT NULL DEFAULT '',
#	every_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	every_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every_autoresize_tpl_ex		TEXT,
	every_autoresize_tpl_nex	TEXT,

	every_merge_img				VARCHAR(250) NOT NULL DEFAULT '',
	every_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	every_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	first2_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first2_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first2_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first2_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	first2_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first2_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first2_autoresize_tpl_ex	TEXT,
	first2_autoresize_tpl_nex	TEXT,

	first2_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first2_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first2_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	first2_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first2_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	every2_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every2_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every2_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every2_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	every2_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every2_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every2_autoresize_tpl_ex	TEXT,
	every2_autoresize_tpl_nex	TEXT,


	every2_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every2_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every2_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	every2_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every2_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,






	first3_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first3_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first3_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first3_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	first3_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first3_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first3_autoresize_tpl_ex	TEXT,
	first3_autoresize_tpl_nex	TEXT,

	first3_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first3_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first3_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	first3_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first3_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	every3_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every3_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every3_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every3_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	every3_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every3_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every3_autoresize_tpl_ex	TEXT,
	every3_autoresize_tpl_nex	TEXT,

	every3_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every3_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every3_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	every3_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every3_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,



	first4_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first4_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first4_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first4_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	first4_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first4_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first4_autoresize_tpl_ex	TEXT,
	first4_autoresize_tpl_nex	TEXT,

	first4_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first4_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first4_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	first4_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	first4_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	every4_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every4_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every4_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every4_autoresize_firstonly	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	every4_autoresize_apply		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every4_autoresize_debug		TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every4_autoresize_tpl_ex	TEXT,
	every4_autoresize_tpl_nex	TEXT,

	every4_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every4_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every4_merge_alfa			TINYINT UNSIGNED NOT NULL DEFAULT 30,
	every4_merge_type			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	every4_merge_apply			TINYINT UNSIGNED NOT NULL DEFAULT 1,


	img_present				TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_newqnty				TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_txt_present			TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_txt_eq_fname		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_url_present			TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_zip_present			TINYINT UNSIGNED NOT NULL DEFAULT 1,

	img_big_present			TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_big_newqnty			TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_big_txt_present		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_big_txt_eq_fname	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_big_url_present		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_big_zip_present		TINYINT UNSIGNED NOT NULL DEFAULT 1,


	img_thumb_present		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	img_thumb_qlty			VARCHAR(250) NOT NULL DEFAULT 85,
	img_thumb_width			VARCHAR(250) NOT NULL DEFAULT '',
	img_thumb_height		VARCHAR(250) NOT NULL DEFAULT '80',


	msg_ident			VARCHAR(250) NOT NULL DEFAULT 'Картинка',
	msg_change			VARCHAR(250) NOT NULL DEFAULT 'изменить картинку',
	msg_add				VARCHAR(250) NOT NULL DEFAULT 'Новая картинка',
	msg_img				VARCHAR(250) NOT NULL DEFAULT 'маленькая',
	msg_img_big			VARCHAR(250) NOT NULL DEFAULT 'большая',

	img_table			VARCHAR(250) NOT NULL DEFAULT '',

	PRIMARY KEY(id)
);

#desc shli_imgtype;
insert into shli_imgtype (id, manorder, deleted, ident, hashkey, first_autoresize_width, first_autoresize_apply, every_autoresize_width, every_autoresize_apply) values
	(1, 1, 0, "Картинки в контент", "IMG_CONTENT", 100, 1, '', 0);
	
#select * from shli_imgtype;