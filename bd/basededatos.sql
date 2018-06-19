-- CONECTARSE A LA BASE DE DATOS ---> mysql -u root -p
use residencia;

--# Eliminacion de las tablas nombradas si ya existen

drop table if exists ImgTag;
drop table if exists Tags;
drop table if exists Imagenes;
drop table if exists Usuarios;


--# Una vez eliminadas pasamos a la creacion de estas

--# Creacion de la tabla usuario.
CREATE TABLE Usuarios(

 nombre_usuario VARCHAR(30) NOT NULL,
 pass VARCHAR(100) NOT NULL,
 nombre VARCHAR(20) NOT NULL,
 apellidos VARCHAR(30) NOT NULL,
 tipo INT NOT NULL,
 CONSTRAINT PRIMARY KEY(nombre_usuario)

);

--# Creacion de la tabla Imagenes.
CREATE TABLE Imagenes(

 id_imagen INT NOT NULL AUTO_INCREMENT,
 nombre_imagen VARCHAR(100) NOT NULL,
 ruta VARCHAR(300) NOT NULL,
 CONSTRAINT PRIMARY KEY(id_imagen)

);

--# Creacion de la tabla Tags.
CREATE TABLE Tags(
 nombre VARCHAR(100) NOT NULL,
 CONSTRAINT PRIMARY KEY(nombre)
);

--# Creacion de la tabla ImgTag.
CREATE TABLE ImgTag(

 tag VARCHAR(100) NOT NULL,
 id_imagen INT NOT NULL,
 CONSTRAINT FOREIGN KEY (tag) REFERENCES Tags(nombre) on delete cascade on update cascade,
 --#ON DELETE RESTRICT ON UPDATE CASCADE,
 CONSTRAINT FOREIGN KEY (id_imagen) REFERENCES Imagenes(id_imagen)
 ON DELETE RESTRICT ON UPDATE CASCADE,
 CONSTRAINT PRIMARY KEY(tag, id_imagen)

);

--# Creacion de la tabla ImgTag.
CREATE TABLE RepPersonal(

 usuario VARCHAR(100) NOT NULL,
 imagen INT NOT NULL,
 CONSTRAINT FOREIGN KEY (usuario) REFERENCES Usuarios(nombre_usuario) on delete cascade on update cascade,
 --#ON DELETE RESTRICT ON UPDATE CASCADE,
 CONSTRAINT FOREIGN KEY (imagen) REFERENCES Imagenes(id_imagen)
 ON DELETE RESTRICT ON UPDATE CASCADE,
 CONSTRAINT PRIMARY KEY(usuario, imagen)

);

INSERT INTO Usuarios(
    nombre_usuario,
    pass,
    nombre,
    apellidos,
    tipo
    )
VALUES(
    'admin00',
    md5('4ut15m0'),
    'Administrador',
    'admin',
    0
);


INSERT INTO Usuarios(
    nombre_usuario,
    pass,
    nombre,
    apellidos,
    tipo
    )
VALUES(
    'user00',
    md5('4ut15m0'),
    'Usuario',
    'user',
    1
);
