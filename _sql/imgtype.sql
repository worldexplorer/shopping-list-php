--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_imgtype;
CREATE TABLE shli_imgtype (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content			TEXT,
	imglimit		INTEGER NOT NULL DEFAULT 0,
	merge_seed		INTEGER NOT NULL DEFAULT 0,

	resize_default_qlty			VARCHAR(250) NOT NULL DEFAULT 85,
	resize_default_width		VARCHAR(250) NOT NULL DEFAULT '',
	resize_default_height		VARCHAR(250) NOT NULL DEFAULT '',
	resize_published			BOOLEAN NOT NULL DEFAULT true,
	resize_default_checked		BOOLEAN NOT NULL DEFAULT false,

	big_resize_default_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	big_resize_default_width	VARCHAR(250) NOT NULL DEFAULT '',
	big_resize_default_height	VARCHAR(250) NOT NULL DEFAULT '',
	big_resize_published		BOOLEAN NOT NULL DEFAULT true,
	big_resize_default_checked	BOOLEAN NOT NULL DEFAULT false,

	first_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first_autoresize_height		VARCHAR(250) NOT NULL DEFAULT '',
--	first_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	first_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	first_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	first_autoresize_tpl_ex		TEXT,
	first_autoresize_tpl_nex	TEXT,

	first_merge_img				VARCHAR(250) NOT NULL DEFAULT '',
	first_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	first_merge_type			BOOLEAN NOT NULL DEFAULT false,
	first_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	every_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every_autoresize_height		VARCHAR(250) NOT NULL DEFAULT '',
--	every_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	every_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	every_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	every_autoresize_tpl_ex		TEXT,
	every_autoresize_tpl_nex	TEXT,

	every_merge_img				VARCHAR(250) NOT NULL DEFAULT '',
	every_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	every_merge_type			BOOLEAN NOT NULL DEFAULT false,
	every_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	first2_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first2_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first2_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first2_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	first2_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	first2_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	first2_autoresize_tpl_ex	TEXT,
	first2_autoresize_tpl_nex	TEXT,

	first2_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first2_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first2_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	first2_merge_type			BOOLEAN NOT NULL DEFAULT false,
	first2_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	every2_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every2_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every2_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every2_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	every2_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	every2_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	every2_autoresize_tpl_ex	TEXT,
	every2_autoresize_tpl_nex	TEXT,


	every2_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every2_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every2_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	every2_merge_type			BOOLEAN NOT NULL DEFAULT false,
	every2_merge_apply			BOOLEAN NOT NULL DEFAULT true,






	first3_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first3_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first3_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first3_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	first3_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	first3_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	first3_autoresize_tpl_ex	TEXT,
	first3_autoresize_tpl_nex	TEXT,

	first3_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first3_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first3_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	first3_merge_type			BOOLEAN NOT NULL DEFAULT false,
	first3_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	every3_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every3_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every3_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every3_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	every3_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	every3_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	every3_autoresize_tpl_ex	TEXT,
	every3_autoresize_tpl_nex	TEXT,

	every3_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every3_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every3_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	every3_merge_type			BOOLEAN NOT NULL DEFAULT false,
	every3_merge_apply			BOOLEAN NOT NULL DEFAULT true,



	first4_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	first4_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	first4_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	first4_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	first4_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	first4_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	first4_autoresize_tpl_ex	TEXT,
	first4_autoresize_tpl_nex	TEXT,

	first4_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	first4_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	first4_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	first4_merge_type			BOOLEAN NOT NULL DEFAULT false,
	first4_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	every4_autoresize_qlty		VARCHAR(250) NOT NULL DEFAULT 85,
	every4_autoresize_width		VARCHAR(250) NOT NULL DEFAULT '',
	every4_autoresize_height	VARCHAR(250) NOT NULL DEFAULT '',
	every4_autoresize_firstonly	BOOLEAN NOT NULL DEFAULT true,
	every4_autoresize_apply		BOOLEAN NOT NULL DEFAULT false,
	every4_autoresize_debug		BOOLEAN NOT NULL DEFAULT false,
	every4_autoresize_tpl_ex	TEXT,
	every4_autoresize_tpl_nex	TEXT,

	every4_merge_img			VARCHAR(250) NOT NULL DEFAULT '',
	every4_merge_dstfname		VARCHAR(250) NOT NULL DEFAULT '',
	every4_merge_alfa			SMALLINT NOT NULL DEFAULT 30,
	every4_merge_type			BOOLEAN NOT NULL DEFAULT false,
	every4_merge_apply			BOOLEAN NOT NULL DEFAULT true,


	img_present				BOOLEAN NOT NULL DEFAULT true,
	img_newqnty				BOOLEAN NOT NULL DEFAULT true,
	img_txt_present			BOOLEAN NOT NULL DEFAULT true,
	img_txt_eq_fname		BOOLEAN NOT NULL DEFAULT true,
	img_url_present			BOOLEAN NOT NULL DEFAULT true,
	img_zip_present			BOOLEAN NOT NULL DEFAULT true,

	img_big_present			BOOLEAN NOT NULL DEFAULT true,
	img_big_newqnty			BOOLEAN NOT NULL DEFAULT true,
	img_big_txt_present		BOOLEAN NOT NULL DEFAULT true,
	img_big_txt_eq_fname	BOOLEAN NOT NULL DEFAULT true,
	img_big_url_present		BOOLEAN NOT NULL DEFAULT true,
	img_big_zip_present		BOOLEAN NOT NULL DEFAULT true,


	img_thumb_present		BOOLEAN NOT NULL DEFAULT true,
	img_thumb_qlty			VARCHAR(250) NOT NULL DEFAULT 85,
	img_thumb_width			VARCHAR(250) NOT NULL DEFAULT '',
	img_thumb_height		VARCHAR(250) NOT NULL DEFAULT '80',


	msg_ident			VARCHAR(250) NOT NULL DEFAULT '????????????????',
	msg_change			VARCHAR(250) NOT NULL DEFAULT '???????????????? ????????????????',
	msg_add				VARCHAR(250) NOT NULL DEFAULT '?????????? ????????????????',
	msg_img				VARCHAR(250) NOT NULL DEFAULT '??????????????????',
	msg_img_big			VARCHAR(250) NOT NULL DEFAULT '??????????????',

	img_table			VARCHAR(250) NOT NULL DEFAULT '',

	PRIMARY KEY(id)
);



-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_imgtype_update_date_updated
	BEFORE UPDATE ON shli_imgtype FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_imgtype;

insert into shli_imgtype
	(id, ident, hashkey,
		 first_autoresize_width, first_autoresize_apply,
		 every_autoresize_width, every_autoresize_apply) values
	(1, '???????????????? ?? ??????????????', 'IMG_CONTENT', 100, true, '', true),
	(2, '???????? ??????????????????????????', 'IMG_PERSON', 100, true, '', true),
	(3, '???????????? ????????', 'IMG_ROOM', 100, true, '', true),
	(4, '???????? ????????????????', 'IMG_PRODUCT', 100, true, '', true);

ALTER SEQUENCE shli_imgtype_id_seq RESTART WITH 5;

--select * from shli_imgtype;
