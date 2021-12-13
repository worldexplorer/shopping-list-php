--\connect dbname=shli user=shli password=shli host=localhost
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_constant;
CREATE TABLE shli_constant (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		SMALLINT NOT NULL DEFAULT 1,
	deleted			SMALLINT NOT NULL DEFAULT 0,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	hashkey			VARCHAR(250) NOT NULL DEFAULT '',
	content			TEXT,

	PRIMARY KEY(id)
--	, UNIQUE (hashkey),
);

-- https://stackoverflow.com/questions/2362871/postgresql-current-timestamp-on-update
CREATE OR REPLACE FUNCTION fn_sync_date_updated() RETURNS TRIGGER 
LANGUAGE plpgsql AS $$
BEGIN
    NEW.date_updated = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;

CREATE TRIGGER trg_shli_constant_update_date_updated
	BEFORE UPDATE ON shli_constant FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();

--\d shli_constant;

--insert into shli_constant (id, manorder, ident, hashkey, content) VALUES
--	(1,1,'Счётчики в начале страниц','COUNTER_TOP','')
--	(2,2,'Счётчики в конце страниц','COUNTER_BOTTOM','')
--	(3,3,'Контент в шапке','CONTENT_TOP','Шапка сайта')
--	(4,4,'Контент в подвале','CONTENT_BOTTOM','Подвал сайта');

--select * from shli_constant;
