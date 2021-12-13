--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_img;
CREATE TABLE shli_img (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 0,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	img				VARCHAR(255) NOT NULL DEFAULT '',
	img_w			INTEGER NOT NULL DEFAULT 0,
	img_h			INTEGER NOT NULL DEFAULT 0,
	img_txt			VARCHAR(255) NOT NULL DEFAULT '',

	img_big			VARCHAR(255) NOT NULL DEFAULT '',
	img_big_w		INTEGER NOT NULL DEFAULT 0,
	img_big_h		INTEGER NOT NULL DEFAULT 0,
	img_big_txt		VARCHAR(255) NOT NULL DEFAULT '',

	owner_entity	VARCHAR(250) NOT NULL DEFAULT '',
	owner_entity_id	INTEGER NOT NULL DEFAULT 1,
	imgtype			INTEGER NOT NULL DEFAULT 1,

	img_src			VARCHAR(250) NOT NULL DEFAULT '',
	img_big_src		VARCHAR(250) NOT NULL DEFAULT '',

	img_main		SMALLINT NOT NULL DEFAULT 0,

	crc32			INTEGER NOT NULL DEFAULT 0,

	date_faceted	TIMESTAMP,
	faceted			SMALLINT NOT NULL DEFAULT 0,
	faceting		SMALLINT NOT NULL DEFAULT 0,

	PRIMARY KEY(id)
----		, key (owner_entity, owner_entity_id),
----		, key (imgtype),
----		, key (published, deleted),
----		, key (img_txt),
----		, key (img_big_txt),
----		, key (faceted),
----		, key (faceting),
);



-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_img_update_date_updated
	BEFORE UPDATE ON shli_img FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_img;
--select * from shli_img;