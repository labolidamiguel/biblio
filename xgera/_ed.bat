set ed="c:\program files\editplus 3\editplus.exe" 
set com="_clean.bat _ed.bat _gera_all.bat _gera_crud.bat"
@echo off
start "" %ed% "%com%"  /secondary /minimized
exit
