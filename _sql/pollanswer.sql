--\connect shli;
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_pollanswer;
CREATE TABLE shli_pollanswer (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),
	ident			VARCHAR(250) NOT NULL DEFAULT '',

	tooltip			TEXT,
	comment_above	TEXT,
	comment_below	TEXT,
	
	
	poll			INTEGER NOT NULL DEFAULT 0,
	pollquestion	INTEGER NOT NULL DEFAULT 0,

	
--Ты придёшь на урок в "пнд 13е, группа Л"?
-- - да:
--	-- приду на сальсу,
--	-- приду на бачату,
-- - не приду
	parent_id		INTEGER NOT NULL DEFAULT 0,
	multicb			SMALLINT NOT NULL DEFAULT 0,
	
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

CREATE TRIGGER trg_shli_pollanswer_update_date_updated
	BEFORE UPDATE ON shli_pollanswer FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();

-- \d shli_pollanswer;

-- select * from shli_pollanswer;
