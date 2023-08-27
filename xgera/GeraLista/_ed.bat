set ed="c:\program files\editplus 3\editplus.exe" 
set tol="_comp.bat _run.bat _jar.bat GeraLista.mf"
set lib="..\GeraLib\Parse.java ..\GeraLib\GravaIo.java"
set par="..\GeraParam\param_app_lista.txt ..\GeraParam\param_autor_lista.txt"
set src="GeraLista.java FonteLista.java"

@echo off
start "" %ed% "%tol%" "%par%" "%lib%" "%src%" /secondary /minimized
exit
