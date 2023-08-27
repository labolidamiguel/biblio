set entid=%1
java -jar .\GeraAltera\GeraAltera.jar   .\par\%entid%.par
java -jar .\GeraCria\GeraCria.jar       .\par\%entid%.par
java -jar .\GeraDominio\GeraDominio.jar .\par\%entid%_lista.par
java -jar .\GeraExclui\GeraExclui.jar   .\par\%entid%.par
java -jar .\GeraForm\GeraForm.jar       .\par\%entid%.par
java -jar .\GeraLista\GeraLista.jar     .\par\%entid%_lista.par
