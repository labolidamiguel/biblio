set ed="c:\program files\editplus 3\editplus.exe" 
set com="_lista_entidades.bat _describe.bat _cria_all.bat"
@echo off
start "" %ed% "%com%"  /secondary /minimized
exit
