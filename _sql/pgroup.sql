--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_pgroup CASCADE;
CREATE TABLE shli_pgroup (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	parent_id		INTEGER NOT NULL,

	room			INTEGER NOT NULL,

	purchase_origin	INTEGER NOT NULL, -- purchase in the room that first used this product group

	PRIMARY KEY(id)
--	,FOREIGN KEY ("parent_id") REFERENCES "shli_pgroup"(id)
	,FOREIGN KEY ("room") REFERENCES "shli_room"(id)
	,FOREIGN KEY ("purchase_origin") REFERENCES "shli_purchase"(id)
);


-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_pgroup_update_date_updated
	BEFORE UPDATE ON shli_pgroup FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_pgroup;

insert into shli_pgroup
	(id, parent_id, room, purchase_origin, ident) values
	(1, 0, 1, 1, 'root'),
	(2, 1, 1, 1, 'Бакалея'),
	(3, 1, 1, 1, 'Выпечка'),
	(4, 1, 1, 1, 'Молочка')
;

ALTER SEQUENCE shli_pgroup_id_seq RESTART WITH 5;

--select * from shli_pgroup;
