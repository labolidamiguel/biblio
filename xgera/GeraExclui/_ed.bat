set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_comp.bat _run.bat _jar.bat GeraExclui.mf"
set lib="..\GeraLib\Parse.java ..\GeraLib\GravaIo.java"
set par="param_autor.txt param_leitor.txt"
set src="GeraExclui.java FonteExclui.java"

@echo off
start "" %ed% "%tol%" "%par%" "%lib%" "%src%" /secondary /minimized
exit
