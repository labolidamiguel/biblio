set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_comp.bat _run.bat _jar.bat GeraDominio.mf"
set lib="..\GeraLib\Parse.java ..\GeraLib\GravaIo.java"
set par="param_autor.txt param_leitor.txt"
set src="GeraDominio.java FonteDominio.java"

@echo off
start "" %ed% "%tol%" "%par%" "%lib%" "%src%" /secondary /minimized
exit
