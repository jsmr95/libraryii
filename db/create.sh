#!/bin/sh

if [ "$1" = "travis" ]; then
    psql -U postgres -c "CREATE DATABASE libraryii_test;"
    psql -U postgres -c "CREATE USER libraryii PASSWORD 'libraryii' SUPERUSER;"
else
    sudo -u postgres dropdb --if-exists libraryii
    sudo -u postgres dropdb --if-exists libraryii_test
    sudo -u postgres dropuser --if-exists libraryii
    sudo -u postgres psql -c "CREATE USER libraryii PASSWORD 'libraryii' SUPERUSER;"
    sudo -u postgres createdb -O libraryii libraryii
    sudo -u postgres psql -d libraryii -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    sudo -u postgres createdb -O libraryii libraryii_test
    sudo -u postgres psql -d libraryii_test -c "CREATE EXTENSION pgcrypto;" 2>/dev/null
    LINE="localhost:5432:*:libraryii:libraryii"
    FILE=~/.pgpass
    if [ ! -f $FILE ]; then
        touch $FILE
        chmod 600 $FILE
    fi
    if ! grep -qsF "$LINE" $FILE; then
        echo "$LINE" >> $FILE
    fi
fi
