#!/bin/sh

[ "$1" = "test"] && BD="_test"
psql -h localhost -U libraryii -d libraryii$BD
