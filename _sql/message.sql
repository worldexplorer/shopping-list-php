--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_message;
CREATE TABLE shli_message (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	room			INTEGER NOT NULL DEFAULT 0,
	person			INTEGER NOT NULL DEFAULT 0,

	content			TEXT,
	purchase		INTEGER NOT NULL DEFAULT 0,
	
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

CREATE TRIGGER trg_shli_message_update_date_updated
	BEFORE UPDATE ON shli_message FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_message;

insert into shli_message(id, room, person, purchase, content) values
	(1, 1, 2, 0, 'Привет, вот список'),
	(2, 1, 2, 1, ''),
	(3, 1, 1, 0, 'Готово, купил')
;

--select * from shli_message;