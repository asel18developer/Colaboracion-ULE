# CONECTARSE A LA BASE DE DATOS ---> mysql -u root -p
#No funciona con la '' en las dos primeras lineas es sin ellas
drop database if exists residencia;

create database residencia;
GRANT ALL ON *.* TO 'cesar'@localhost IDENTIFIED BY '1002';