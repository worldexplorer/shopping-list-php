--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_message CASCADE;
CREATE TABLE shli_message (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	room			INTEGER NOT NULL,
	person			INTEGER NOT NULL,

	content			TEXT,
	purchase		INTEGER,
	
	PRIMARY KEY(id)
	,FOREIGN KEY ("person") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("purchase") REFERENCES "shli_purchase"(id)
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
	(1, 1, 2, NULL, 'Привет, вот список'),
	(2, 1, 2, 1, ''),
	(3, 1, 1, NULL, 'Готово, купил')
;

--select * from shli_message;
