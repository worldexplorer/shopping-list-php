#!/bin/bash

# https://stackoverflow.com/questions/8594717/shell-script-to-execute-pgsql-commands-in-files
# https://stackoverflow.com/questions/6523019/postgresql-scripting-psql-execution-with-password

#export PGPASSWORD=shli

PGPASSFILE=/tmp/pgpasswd$$
touch $PGPASSFILE
chmod 600 $PGPASSFILE
#echo "myserver:5432:mydb:jdoe:password" > $PGPASSFILE
echo "localhost:5432:shli:shli:shli" > $PGPASSFILE
export PGPASSFILE
#psql mydb
#rm $PGPASSFILE


URL=postgresql://shli:shli@localhost:5433/shli?sslmode=require

for sqlFile in *.sql; do
	echo "***** $sqlFile *****"
#	psql shli -U shli -W -f "$sqlFile"
#	psql shli -f "$sqlFile"
	psql $URL -f "$sqlFile"
done


rm $PGPASSFILE
