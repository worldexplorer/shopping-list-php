--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_room;
CREATE TABLE shli_room (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	person_created	INTEGER NOT NULL DEFAULT 0,

	message_pinned			INTEGER NOT NULL DEFAULT 0,
	message_pinned_text		TEXT, -- deduplication
	
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

CREATE TRIGGER trg_shli_room_update_date_updated
	BEFORE UPDATE ON shli_room FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_room;

insert into shli_room
	(id, person_created, ident) values
	(1, 1, 'Наш чат')
;

--select * from shli_room;
