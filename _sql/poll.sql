--\connect shli
\encoding utf8;
--SET CHARACTER SET utf8;

DROP TABLE IF EXISTS shli_poll;
CREATE TABLE shli_poll (
	id				SERIAL,
	date_updated	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_created	TIMESTAMP WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
	date_published	TIMESTAMP WITHOUT TIME ZONE,
	published		BOOLEAN NOT NULL DEFAULT true,
	deleted			BOOLEAN NOT NULL DEFAULT false,
	manorder		SERIAL, -- INTEGER NOT NULL DEFAULT 0 CHECK (manorder >= 0),

	ident			VARCHAR(250) NOT NULL DEFAULT '',

	tooltip				TEXT,
	comment_above		TEXT,
	comment_below		TEXT,
	save_button_label	TEXT,
	
	icwhose			INTEGER NOT NULL DEFAULT 0,

	admins_csv					VARCHAR(250) NOT NULL DEFAULT '',
	admins_notify_after_votes	INTEGER NOT NULL DEFAULT 0,

	gender_explicit	BOOLEAN NOT NULL DEFAULT false,

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

CREATE TRIGGER trg_shli_poll_update_date_updated
	BEFORE UPDATE ON shli_poll FOR EACH ROW
	EXECUTE PROCEDURE fn_sync_date_updated();


--\d shli_poll;
--select * from shli_poll;
