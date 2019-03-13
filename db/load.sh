#!/bin/sh

BASE_DIR=$(dirname "$(readlink -f "$0")")
if [ "$1" != "test" ]; then
    psql -h localhost -U libraryii -d libraryii < $BASE_DIR/libraryii.sql
fi
psql -h localhost -U libraryii -d libraryii_test < $BASE_DIR/libraryii.sql
