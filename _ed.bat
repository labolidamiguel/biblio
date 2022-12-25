set ed="c:\program files\editplus 3\editplus.exe" 

set app=".\classes\class.app.php .\app\app.altera.php .\app\app.cria.php .\app\app.exclui.php .\app\app.lista.php"
set aud=".\classes\class.auditoria.php .\app\auditoria.detalhe.php .\app\auditoria.exclui.php .\app\auditoria.lista.php"
set aut=".\classes\class.autor.php .\app\autor.altera.php .\app\autor.cria.php .\app\autor.exclui.php .\app\autor.lista.php"
set cde=".\classes\class.cde.php .\app\cde.altera.php .\app\cde.cria.php .\app\cde.dominio.inicial.php .\app\cde.dominio.final.php  .\app\cde.exclui.php .\app\cde.lista.php"
set cen=".\classes\class.centro.php .\app\centro.altera.php .\app\centro.cria.php .\app\centro.exclui.php .\app\centro.lista.php"
set com="_notes.txt _ed.bat"
set emp=".\classes\class.emprestimo.php .\app\emprestimo.lista.php .\app\emprestimo.altera.php .\app\emprestimo.cria.php"
set est=".\classes\class.estante.php .\app\estante.altera.php .\app\estante.cria.php .\app\estante.exclui.php .\app\estante.form.php .\app\estante.lista.php"
set exe=".\classes\class.exemplar.php .\app\exemplar.altera.php .\app\exemplar.cria.php .\app\exemplar.dominio.php .\app\exemplar.exclui.php .\app\exemplar.lista.php"
set imp=".\app\imprime.lista.php .\app\imprime.lista.php .\app\auditoria.rel.php .\app\autor.rel.php .\app\cde.rel.php .\app\editora.rel.php .\app\emprestimo.rel.php .\app\espirito.rel.php .\app\estante.rel.php .\app\exemplar.rel.cde.php .\app\exemplar.rel.etiq.php .\app\leitor.rel.php .\app\tradutor.rel.php .\app\usuario.rel.php
set inc=".\layout\inc.relatorio.epilogo.php .\layout\inc.relatorio.prologo.php 
set ini="C:\PHP\php.ini-development C:\PHP\php.ini-production"
set lay=".\layout\css.css"
set lei=".\classes\class.leitor.php .\app\leitor.altera.php .\app\leitor.cria.php .\app\leitor.dominio.php .\app\leitor.exclui.php .\app\leitor.form.php .\app\leitor.lista.php"
set login=".\common\arch.php .\app\logged.settings.chsess.php .\app\logged.settings.php .\app\login.web.php .\app\logoff.web.php .\classes\class.usuario.php .\app\main.web.php"
set pub=".\classes\class.publicado.php .\app\publicado.altera.php .\app\publicado.cria.php .\app\publicado.exclui.php .\app\publicado.lista.php"
set relexe=".\app\imprime.lista.php .\app\exemplar.rel.cde.php .\app\exemplar.rel.etiq.php"
set tit=".\classes\class.titulo.php .\app\titulo.altera.php .\app\titulo.cria.php .\app\titulo.detalhe.php .\app\titulo.dominio.php .\app\titulo.exclui.php .\app\titulo.form.php .\app\titulo.lista.php .\app\titulo.pesquisa.php"
set usu=".\classes\class.usuario.php .\app\perfil.dominio.php .\app\usuario.altera.php .\app\usuario.cria.php .\app\usuario.exclui.php .\app\usuario.lista.php"

@echo off
start "" %ed% "%com%" ".\app\leitor.lista.php" .\classes\class.titulo.php "%exe%" /secondary /minimized
exit

