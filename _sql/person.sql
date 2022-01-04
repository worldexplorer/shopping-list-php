--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_person CASCADE;
CREATE TABLE shli_person (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP, --  ON UPDATE CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	phone			VARCHAR(250) NOT NULL DEFAULT '',
	email			VARCHAR(250) NOT NULL DEFAULT '',

	username		VARCHAR(250) NOT NULL DEFAULT '',
	color			VARCHAR(16) NOT NULL DEFAULT '',

	password		VARCHAR(250) NOT NULL DEFAULT '',
	auth			VARCHAR(250) NOT NULL DEFAULT '',
	
	date_lastclick	TIMESTAMP,
	lastip			VARCHAR(250) NOT NULL DEFAULT '',
	lastsid			VARCHAR(250) NOT NULL DEFAULT '',
	
	PRIMARY KEY(id)
----		, key (published), key (deleted)эта анкета не определен
----		, key(ident)
);

-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_person_update_date_updated
	BEFORE UPDATE ON shli_person FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


-- http://sqlines.com/postgresql/datatypes/serial
-- https://www.postgresqltutorial.com/creating-first-trigger-postgresql/
--CREATE OR REPLACE FUNCTION fn_manorder_eqэта анкета не определенuals_id() RETURNS TRIGGER 
--LANGUAGE plpgsql AS $$
--BEGIN
--    NEW.manorder = OLD.id;
--	update shli_person set manorder=id where id=OLD.id;
--    RETURN NEW;
--END;
--$$;

--CREATE TRIGGER trg_shli_person_on_insert_manorder_equals_id
--  AFTER INSERT ON shli_person FOR EACH ROW
--  EXECUTE PROCEDURE fn_manorder_equals_id();


-- \d shli_person;


insert into shli_person
	(id, ident, phone) values
	(1, 'Петрович', '+1-555-555-55-55'),
	(2, 'Дуся', '+1-555-555-55-56');

ALTER SEQUENCE shli_person_id_seq RESTART WITH 3;

-- select * from shli_person;



-- CREATE OR REPLACE FUNCTION update_date_updated_column()
-- RETURNS TRIGGER AS $$
-- BEGIN
--    NEW.date_updated = now(); 
--    RETURN NEW;
-- END;
-- $$ language 'plpgsql';

-- CREATE TRIGGER trg_shli_person_update_date_updated
-- 	BEFORE UPDATE ON shli_person FOR EACH ROW
-- 	EXECUTE PROCEDURE update_date_updated_column();