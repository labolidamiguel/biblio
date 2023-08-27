path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraCria.jar
javac -cp GeraCria.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
