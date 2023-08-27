path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraAltera.jar 
javac -cp GeraAltera.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
