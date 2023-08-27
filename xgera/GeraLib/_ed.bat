set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_notes.txt _comp.bat _run.bat param.txt"
set src="Parse.java GravaIo.java

@echo off
start "" %ed% "%tol%" "%src%" /secondary /minimized
exit
