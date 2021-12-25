--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_icdictcontent;
CREATE TABLE shli_icdictcontent (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content			TEXT,

	label_style		VARCHAR(250) NOT NULL DEFAULT '',
	tf1_width		INTEGER NOT NULL DEFAULT 0,
	tf1_incolumn 	SMALLINT NOT NULL DEFAULT 0,

	tf1_addtodict 		SMALLINT NOT NULL DEFAULT 0,
	tf1_addedpublished 	SMALLINT NOT NULL DEFAULT 0,

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

insert into shli_icdictcontent(id, manorder, icdict, ident) values(1, 1, 1, 'Бумага');
insert into shli_icdictcontent(id, manorder, icdict, ident) values(2, 2, 1, 'Картон');
insert into shli_icdictcontent(id, manorder, icdict, ident) values(3, 3, 1, 'Пластик');
insert into shli_icdictcontent(id, manorder, icdict, ident) values(4, 4, 1, 'Подарочная');

--select * from shli_icdictcontent;
