--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_m2m_room_person;
CREATE TABLE shli_m2m_room_person (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) DEFAULT '',

	room			INTEGER NOT NULL DEFAULT 0,
	person			INTEGER NOT NULL DEFAULT 0,
	
	PRIMARY KEY(id)
--	unique key(person, poll),
);


-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_m2m_room_person_update_date_updated
	BEFORE UPDATE ON shli_m2m_room_person FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();



--\d shli_m2m_room_person;

insert into shli_m2m_room_person
	(id, room, person, ident) values
	(1, 1, 1, 'НашЧат - Петрович'),
	(2, 1, 2, 'НашЧат - Дуся')
;

--select * from shli_m2m_room_person;
