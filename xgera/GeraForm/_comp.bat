path="C:\Program Files\Java\jdk1.8.0_281\bin"
del GeraForm.jar
javac -cp GeraForm.java ..\GeraLib\*.java *.java
@echo off
copy ..\GeraLib\*.class .
