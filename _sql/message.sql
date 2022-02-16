--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_message CASCADE;
CREATE TABLE shli_message (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',
	replyto_id		INTEGER,
	forwardfrom_id	INTEGER,

	room			INTEGER NOT NULL,
	person			INTEGER NOT NULL,

	persons_sent	INTEGER[],
	persons_read	INTEGER[],

	content			TEXT,
	archived		BOOLEAN NOT NULL DEFAULT false,
	edited			BOOLEAN NOT NULL DEFAULT false,

	purchase		INTEGER,
	
	PRIMARY KEY(id)
	,FOREIGN KEY ("person") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("purchase") REFERENCES "shli_purchase"(id)
	,FOREIGN KEY ("replyto_id") REFERENCES "shli_message"(id)
	,FOREIGN KEY ("forwardfrom_id") REFERENCES "shli_message"(id)
--	,FOREIGN KEY ("persons_sent") REFERENCES "shli_person"(id)
--	,FOREIGN KEY ("persons_read") REFERENCES "shli_person"(id)
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

insert into shli_message
	(id, room, person, purchase, ident, 			content, 			edited) values
	(1, 	1, 2, 		NULL, 		'Привет, вот список', 'Привет, вот список',	 true),
	(2, 	1, 2, 		1, 		'', 				'', 				false),
	(3, 	1, 1, 		NULL, 	'Готово, купил', 	  'Готово, купил', 		false)
;


ALTER SEQUENCE shli_message_id_seq RESTART WITH 4;

--select * from shli_message;
