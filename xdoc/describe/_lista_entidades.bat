set sql3=C:\Z_INSTAL\C\sqlite3.exe
set biblio=c:\source\biblio\database\biblio.db

%sql3% %biblio% "SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY 1;" > tables.txt

pause
