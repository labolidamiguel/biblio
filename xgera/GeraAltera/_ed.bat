set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_comp.bat _run.bat _jar.bat GeraAltera.mf"
set lib="..\GeraLib\Parse.java ..\GeraLib\GravaIo.java"
set src="GeraAltera.java FonteAltera.java"

@echo off
start "" %ed% "%tol%" "%lib%" "%src%" /secondary /minimized
exit
