@ECHO OFF

DEL /F UrlShortener.db
sqlite3 UrlShortener.db < create.sql
