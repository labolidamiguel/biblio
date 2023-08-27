set sql3=C:\Z_INSTAL\C\sqlite3.exe
set biblio=c:\source\biblio\database\biblio.db
set entid=%1

echo %entid% > %entid%.txt
%sql3% %biblio% "PRAGMA table_info(%entid%);" >> %entid%.txt
java -jar C:\Z_INSTAL\C\TableInfo2h.jar %entid%.txt %entid%.h
