path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraExclui.jar
javac -cp GeraExclui.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
