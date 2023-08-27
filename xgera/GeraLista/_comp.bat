path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraLista.jar
javac -cp GeraLista.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
