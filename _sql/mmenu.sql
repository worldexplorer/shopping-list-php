use shli;
set names cp1251;
SET CHARACTER SET cp1251;

DROP TABLE IF EXISTS shli_mmenu;
CREATE TABLE shli_mmenu (
	id				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
	date_updated	TIMESTAMP,
	date_created	TIMESTAMP,
	date_published	TIMESTAMP,
	published		TINYINT UNSIGNED NOT NULL DEFAULT 1,
	deleted			TINYINT UNSIGNED NOT NULL DEFAULT 0,
	manorder		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	ident			VARCHAR(250) NOT NULL DEFAULT '',
	
	parent_id		INTEGER UNSIGNED NOT NULL DEFAULT 1,
	
	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	is_heredoc		TINYINT NOT NULL DEFAULT 1,
	is_drone		TINYINT NOT NULL DEFAULT 0,

	#annotation				TEXT,
	content					TEXT,
	content_no_freetext		TINYINT UNSIGNED NOT NULL DEFAULT 0,

	img_free		VARCHAR(250) NOT NULL DEFAULT '',
	img_mover		VARCHAR(250) NOT NULL DEFAULT '',

	img_small_free		VARCHAR(250) NOT NULL DEFAULT '',
	img_small_mover		VARCHAR(250) NOT NULL DEFAULT '',
	img_small_current	VARCHAR(250) NOT NULL DEFAULT '',

	img_ctx_left	VARCHAR(250) NOT NULL DEFAULT '',
	img_ctx_right	VARCHAR(250) NOT NULL DEFAULT '',
	img_ctx_top		VARCHAR(250) NOT NULL DEFAULT '',

	banner_top		INTEGER UNSIGNED NOT NULL DEFAULT 0,
	banner_sky		INTEGER UNSIGNED NOT NULL DEFAULT 0,


	pagetitle			TEXT,
	title				TEXT,
	meta_keywords		TEXT,
	meta_description	TEXT,

	tpl_list_item		TEXT,
	tpl_list_wrapper	TEXT,

	published_legend 	TINYINT UNSIGNED NOT NULL DEFAULT 1,
	manorder_legend		INTEGER UNSIGNED NOT NULL DEFAULT 0,

	published_sitemap 	TINYINT UNSIGNED NOT NULL DEFAULT 1,

	PRIMARY KEY(id),
	INDEX (parent_id)
);

#desc shli_shli_mmenu;


insert into shli_mmenu(id, manorder, parent_id, ident, published) values(1, 1, 0, 'root', 0);

insert into shli_mmenu(id, manorder, parent_id, ident, hashkey, published, deleted) values
	(2, 2, 1, 'Top menu', 'MMENU_TOP', 0, 0)
	;

insert into shli_mmenu(id, manorder, parent_id, ident, hashkey, is_heredoc) values
	(10, 10, 2, 'ABOUT', 'index', 0)
	;

#select * from shli_shli_mmenu;
