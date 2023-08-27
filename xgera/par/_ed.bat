set ed="c:\program files\editplus 3\editplus.exe" 
set com="_clean.bat _ed.bat"
@echo off
start "" %ed% "%com%"  /secondary /minimized
exit
