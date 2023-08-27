CREATE TABLE cde (
    id_centro           integer not null,
    id_cde              integer primary key autoincrement,
    cod_cde             text,
    classe              text);
INSERT INTO "cde" VALUES(1,1,'00.00.00','GENERALIDADE');
INSERT INTO "cde" VALUES(1,2,'00.05.00','REFER�NCIA');
INSERT INTO "cde" VALUES(1,3,'00.05.01','Almanaque');
INSERT INTO "cde" VALUES(1,4,'00.05.02','Atlas');
INSERT INTO "cde" VALUES(1,5,'00.05.03','Bibliografia');
INSERT INTO "cde" VALUES(1,6,'00.05.04','Cat�logo');
INSERT INTO "cde" VALUES(1,7,'00.05.05','Dicion�rio. Gloss�rio');
INSERT INTO "cde" VALUES(1,8,'00.05.06','Enciclop�dia');
INSERT INTO "cde" VALUES(1,9,'00.05.07','Guia. Manual');
INSERT INTO "cde" VALUES(1,10,'00.05.08','Repert�rio. Invent�rio. Diret�rio');
INSERT INTO "cde" VALUES(1,11,'00.05.09','�ndice. Vocabul�rio. Tesauro');
INSERT INTO "cde" VALUES(1,12,'00.06.00','COLE��O');
INSERT INTO "cde" VALUES(1,13,'00.06.01','Obras de Allan Kardec');
INSERT INTO "cde" VALUES(1,14,'00.06.02','Cole��o Andr� Luiz');
INSERT INTO "cde" VALUES(1,15,'00.06.03','S�rie Psicol�gica Joanna de �ngelis');
INSERT INTO "cde" VALUES(1,16,'10.00.00','FILOSOFIA');
INSERT INTO "cde" VALUES(1,17,'20.00.00','RELIGI�O');
INSERT INTO "cde" VALUES(1,18,'20.01.00','Vida de Jesus');
INSERT INTO "cde" VALUES(1,19,'20.02.00','Jesus e os Ap�stolos');
INSERT INTO "cde" VALUES(1,20,'20.03.00','Estudo dos Evangelhos');
INSERT INTO "cde" VALUES(1,21,'20.03.01','Par�bolas Evang�licas');
INSERT INTO "cde" VALUES(1,22,'20.04.00','Cristianismo');
INSERT INTO "cde" VALUES(1,23,'30.00.00','CI�NCIA');
INSERT INTO "cde" VALUES(1,24,'30.01.00','Sobreviv�ncia, natureza do mundo espiritual e vida ap�s a morte');
INSERT INTO "cde" VALUES(1,25,'30.02.00','Reencarna��o');
INSERT INTO "cde" VALUES(1,26,'30.03.00','Mediunidade');
INSERT INTO "cde" VALUES(1,27,'30.03.01','Fen�meno medi�nico espec�fico');
INSERT INTO "cde" VALUES(1,28,'30.03.02','Animismo');
INSERT INTO "cde" VALUES(1,29,'30.03.03','Fluidoterapia. Tratamento');
INSERT INTO "cde" VALUES(1,30,'30.03.04','Reuni�o medi�nica');
INSERT INTO "cde" VALUES(1,31,'30.04.00','Proje��o astral (experi�ncia fora do corpo)');
INSERT INTO "cde" VALUES(1,32,'30.05.00','Sonhos e mist�rios');
INSERT INTO "cde" VALUES(1,33,'30.06.00','Metaps�quica');
INSERT INTO "cde" VALUES(1,34,'30.07.00','Parapsicologia');
INSERT INTO "cde" VALUES(1,35,'30.08.00','Hipnotismo');
INSERT INTO "cde" VALUES(1,36,'40.00.00','EVENTO');
INSERT INTO "cde" VALUES(1,37,'40.01.00','Congresso');
INSERT INTO "cde" VALUES(1,38,'40.01.01','Anais');
INSERT INTO "cde" VALUES(1,39,'40.02.00','Encontro');
INSERT INTO "cde" VALUES(1,40,'40.02.01','Anais');
INSERT INTO "cde" VALUES(1,41,'40.03.00','Semin�rio');
INSERT INTO "cde" VALUES(1,42,'40.04.00','Curso');
INSERT INTO "cde" VALUES(1,43,'50.00.00','MOVIMENTO ESP�RITA');
INSERT INTO "cde" VALUES(1,44,'50.01.00','Orienta��o. Manual');
INSERT INTO "cde" VALUES(1,45,'50.01.01','Centro Esp�rita');
INSERT INTO "cde" VALUES(1,46,'50.01.02','Servi�o de Assist�ncia e Promo��o Social');
INSERT INTO "cde" VALUES(1,47,'50.01.03','Biblioteca Esp�rita');
INSERT INTO "cde" VALUES(1,48,'50.02.00','Campanha');
INSERT INTO "cde" VALUES(1,49,'50.02.01','Em Defesa da Vida');
INSERT INTO "cde" VALUES(1,50,'50.02.02','Viver em Fam�lia');
INSERT INTO "cde" VALUES(1,51,'50.02.03','Construamos a Paz, promovendo o Bem!');
INSERT INTO "cde" VALUES(1,52,'50.02.04','Paz no lar, Paz na humanidade');
INSERT INTO "cde" VALUES(1,53,'51.00.00','ATIVIDADES INSTITUCIONAIS');
INSERT INTO "cde" VALUES(1,54,'51.01.00','Estatuto');
INSERT INTO "cde" VALUES(1,55,'51.02.00','Relat�rio');
INSERT INTO "cde" VALUES(1,56,'51.03.00','Plano de A��o. Plano de Trabalho. Planejamento');
INSERT INTO "cde" VALUES(1,57,'51.04.00','Projeto');
INSERT INTO "cde" VALUES(1,58,'52.00.00','MOVIMENTO ESP�RITA NO EXTERIOR');
INSERT INTO "cde" VALUES(1,59,'60.00.00','EDUCA��O');
INSERT INTO "cde" VALUES(1,60,'60.01.00','Evangeliza��o Esp�rita Infantojuvenil');
INSERT INTO "cde" VALUES(1,61,'60.02.00','Estudo Sistematizado da Doutrina Esp�rita');
INSERT INTO "cde" VALUES(1,62,'60.03.00','Estudo e Educa��o da Mediunidade');
INSERT INTO "cde" VALUES(1,63,'60.04.00','Estudo Aprofundado do Espiritismo');
INSERT INTO "cde" VALUES(1,64,'60.05.00','Material de Apoio');
INSERT INTO "cde" VALUES(1,65,'60.06.00','Meio Ambiente. Ecologia. Sustentabilidade');
INSERT INTO "cde" VALUES(1,66,'70.00.00','ARTE. COMUNICA��O');
INSERT INTO "cde" VALUES(1,67,'70.01.00','M�sica');
INSERT INTO "cde" VALUES(1,68,'70.02.00','Teatro');
INSERT INTO "cde" VALUES(1,69,'70.03.00','Cinema');
INSERT INTO "cde" VALUES(1,70,'70.04.00','Televis�o');
INSERT INTO "cde" VALUES(1,71,'70.05.00','R�dio');
INSERT INTO "cde" VALUES(1,72,'70.06.00','Imprensa');
INSERT INTO "cde" VALUES(1,73,'70.07.00','Internet');
INSERT INTO "cde" VALUES(1,74,'80.00.00','LITERATURA');
INSERT INTO "cde" VALUES(1,75,'80.01.00','Conto. Cr�nica');
INSERT INTO "cde" VALUES(1,76,'80.02.00','Romance');
INSERT INTO "cde" VALUES(1,77,'80.03.00','Mensagem');
INSERT INTO "cde" VALUES(1,78,'80.04.00','Poema');
INSERT INTO "cde" VALUES(1,79,'81.00.00','LITERATURA INFANTIL');
INSERT INTO "cde" VALUES(1,80,'82.00.00','LITERATURA JUVENIL');
INSERT INTO "cde" VALUES(1,81,'85.00.00','LITERATURA EM OUTROS IDIOMAS');
INSERT INTO "cde" VALUES(1,82,'85.01.00','Esperanto');
INSERT INTO "cde" VALUES(1,83,'85.02.00','Espanhol');
INSERT INTO "cde" VALUES(1,84,'85.03.00','Franc�s');
INSERT INTO "cde" VALUES(1,85,'85.04.00','Ingl�s');
INSERT INTO "cde" VALUES(1,86,'85.05.00','Alem�o');
INSERT INTO "cde" VALUES(1,87,'85.06.00','Italiano');
INSERT INTO "cde" VALUES(1,88,'85.07.00','Russo');
INSERT INTO "cde" VALUES(1,89,'85.08.00','H�ngaro');
INSERT INTO "cde" VALUES(1,90,'90.00.00','HIST�RIA. BIOGRAFIA');
INSERT INTO "cde" VALUES(1,91,'90.01.00','Hist�ria');
INSERT INTO "cde" VALUES(1,92,'90.02.00','Biografia');
INSERT INTO "cde" VALUES(1,93,'91.00.00','ENTREVISTA');
INSERT INTO "cde" VALUES(1,94,'00.06.04','Reformador');
INSERT INTO "cde" VALUES(1,95,'80.05.00','Historia');
INSERT INTO "cde" VALUES(1,96,'70.08.00','Multimidia (DVD, CD...)');
INSERT INTO "cde" VALUES(1,97,'10.01.00','Espiritismo');
INSERT INTO "cde" VALUES(1,98,'30.03.05','Reuni�o medi�nica');
INSERT INTO "cde" VALUES(1,99,'51.01.01','Estatuto da Federa��o Esp�rita Brasileira');