set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_comp.bat _run.bat _jar.bat GeraForm.mf"
set lib="..\GeraLib\Parse.java ..\GeraLib\Parse.java ..\GeraLib\GravaIo.java"
set par="param_autor.txt param_leitor.txt"
set src="GeraForm.java FonteForm.java"

@echo off
start "" %ed% "%tol%" "%par%" "%lib%" "%src%" /secondary /minimized
exit
