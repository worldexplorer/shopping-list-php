--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_user;
CREATE TABLE shli_user (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP, --  ON UPDATE CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	phone			VARCHAR(250) NOT NULL DEFAULT '',
	email			VARCHAR(250) NOT NULL DEFAULT '',

	password		VARCHAR(250) NOT NULL DEFAULT '',
	auth			VARCHAR(250) NOT NULL DEFAULT '',
	
	date_lastclick	TIMESTAMP,
	lastip			VARCHAR(250) NOT NULL DEFAULT '',
	lastsid			VARCHAR(250) NOT NULL DEFAULT '',
	
	PRIMARY KEY(id)
----		, key (published), key (deleted)
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

CREATE TRIGGER trg_shli_user_update_date_updated
	BEFORE UPDATE ON shli_user FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


-- http://sqlines.com/postgresql/datatypes/serial
-- https://www.postgresqltutorial.com/creating-first-trigger-postgresql/
--CREATE OR REPLACE FUNCTION fn_manorder_equals_id() RETURNS TRIGGER 
--LANGUAGE plpgsql AS $$
--BEGIN
--    NEW.manorder = OLD.id;
--	update shli_user set manorder=id where id=OLD.id;
--    RETURN NEW;
--END;
--$$;

--CREATE TRIGGER trg_shli_user_on_insert_manorder_equals_id
--  AFTER INSERT ON shli_user FOR EACH ROW
--  EXECUTE PROCEDURE fn_manorder_equals_id();


-- \d shli_user;


insert into shli_user(ident) values
	('Вася'),
	('Маша'),
	('Даша'),
	('Коля'),
	('Маруся'),
	('Петрович');

-- select * from shli_user;



-- CREATE OR REPLACE FUNCTION update_date_updated_column()
-- RETURNS TRIGGER AS $$
-- BEGIN
--    NEW.date_updated = now(); 
--    RETURN NEW;
-- END;
-- $$ language 'plpgsql';

-- CREATE TRIGGER trg_shli_user_update_date_updated
-- 	BEFORE UPDATE ON shli_user FOR EACH ROW
-- 	EXECUTE PROCEDURE update_date_updated_column();