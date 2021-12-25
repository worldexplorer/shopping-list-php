--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_purchase CASCADE;
CREATE TABLE shli_purchase (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE, -- date_purchased
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	comment_above	TEXT,
	comment_below	TEXT,

	room			INTEGER NOT NULL,
	message			INTEGER NOT NULL,

	show_pgroup		SMALLINT NOT NULL DEFAULT 0,
	show_price		SMALLINT NOT NULL DEFAULT 0,
	show_qnty		SMALLINT NOT NULL DEFAULT 0,
	show_weight		SMALLINT NOT NULL DEFAULT 0,


	person_created		INTEGER NOT NULL,
	person_purchased	INTEGER,

	price_total			NUMERIC(7,2),
	weight_total		NUMERIC(7,2),


	PRIMARY KEY(id)
	,FOREIGN KEY ("person_created") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("person_purchased") REFERENCES "shli_person"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("message") REFERENCES "shli_room"(id)
);



-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_purchase_update_date_updated
	BEFORE UPDATE ON shli_purchase FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_purchase;

insert into shli_purchase
	(id, room, message, show_pgroup, show_price, person_created, ident) values
	(1, 1, 1, 1, 1, 1, 'Фуд Сити')
;

ALTER SEQUENCE shli_purchase_id_seq RESTART WITH 2;

--select * from shli_purchase;
