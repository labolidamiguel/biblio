path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraDominio.jar
javac -cp GeraDominio.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
