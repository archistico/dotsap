CREATE TABLE "bilancio" (
	"id"	INTEGER NOT NULL UNIQUE,
	"entratauscita"	TEXT NOT NULL,
	"lavoroprivato"	TEXT NOT NULL,
	"tipologia"	TEXT NOT NULL,
	"totale"	NUMERIC NOT NULL DEFAULT 0,
	"tasse"	NUMERIC DEFAULT 0,
	"commissioni"	NUMERIC DEFAULT 0,
	"data"	TEXT NOT NULL,
	"chi"	TEXT NOT NULL,
	"note"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
)

CREATE TABLE "bilancio_tipo" (
	"idbilanciotipo"	INTEGER NOT NULL UNIQUE,
	"categoria"	TEXT NOT NULL,
	"dettaglio"	TEXT NOT NULL,
	PRIMARY KEY("idbilanciotipo" AUTOINCREMENT)
)