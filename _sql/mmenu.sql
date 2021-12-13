--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_mmenu;
CREATE TABLE shli_mmenu (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',
	
	parent_id		INTEGER NOT NULL DEFAULT 1,
	
	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	is_heredoc		SMALLINT NOT NULL DEFAULT 1,
	is_drone		SMALLINT NOT NULL DEFAULT 0,

	--annotation				TEXT,
	content					TEXT,
	content_no_freetext		SMALLINT NOT NULL DEFAULT 0,

	img_free		VARCHAR(250) NOT NULL DEFAULT '',
	img_mover		VARCHAR(250) NOT NULL DEFAULT '',

	img_small_free		VARCHAR(250) NOT NULL DEFAULT '',
	img_small_mover		VARCHAR(250) NOT NULL DEFAULT '',
	img_small_current	VARCHAR(250) NOT NULL DEFAULT '',

	img_ctx_left	VARCHAR(250) NOT NULL DEFAULT '',
	img_ctx_right	VARCHAR(250) NOT NULL DEFAULT '',
	img_ctx_top		VARCHAR(250) NOT NULL DEFAULT '',

	banner_top		INTEGER NOT NULL DEFAULT 0,
	banner_sky		INTEGER NOT NULL DEFAULT 0,


	pagetitle			TEXT,
	title				TEXT,
	meta_keywords		TEXT,
	meta_description	TEXT,

	tpl_list_item		TEXT,
	tpl_list_wrapper	TEXT,

	published_legend 	SMALLINT NOT NULL DEFAULT 1,
	manorder_legend		INTEGER NOT NULL DEFAULT 0,

	published_sitemap 	SMALLINT NOT NULL DEFAULT 1,

	PRIMARY KEY(id)
--	INDEX (parent_id),
);



-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_mmenu_update_date_updated
	BEFORE UPDATE ON shli_mmenu FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_mmenu;


insert into shli_mmenu(id, manorder, parent_id, ident, published) values(1, 1, 0, 'root', 0);

insert into shli_mmenu(id, manorder, parent_id, ident, hashkey, published) values
	(2, 2, 1, 'Top menu', 'MMENU_TOP', 0)
	;

insert into shli_mmenu(id, manorder, parent_id, ident, hashkey, is_heredoc) values
	(10, 10, 2, 'ABOUT', 'index', 0)
	;

--select * from shli_mmenu;
