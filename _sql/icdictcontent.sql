--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_icdictcontent;
CREATE TABLE shli_icdictcontent (
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

	label_style		VARCHAR(250) NOT NULL DEFAULT '',
	tf1_width		INTEGER NOT NULL DEFAULT 0,
	tf1_incolumn 	BOOLEAN NOT NULL DEFAULT false,

	tf1_addtodict 		BOOLEAN NOT NULL DEFAULT false,
	tf1_addedpublished 	BOOLEAN NOT NULL DEFAULT false,

	icdict			INTEGER NOT NULL DEFAULT 0,

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

CREATE TRIGGER trg_shli_icdictcontent_update_date_updated
	BEFORE UPDATE ON shli_icdictcontent FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_icdictcontent;

insert into shli_icdictcontent
	(id, manorder, icdict, ident) values
	(1, 1, 1, 'Бумага'),
	(2, 2, 1, 'Картон'),
	(3, 3, 1, 'Пластик'),
	(4, 4, 1, 'Подарочная')
;

ALTER SEQUENCE shli_icdictcontent_id_seq RESTART WITH 5;

--select * from shli_icdictcontent;
