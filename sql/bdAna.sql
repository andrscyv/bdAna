CREATE TABLE alumnos (
    idAlum INT NOT NULL AUTO_INCREMENT,
    cu INT NOT NULL,
    beca INT NOT NULL,
    nombre VARCHAR(20) NOT NULL,
    apellidoP VARCHAR(20) NOT NULL,
    apellidoM VARCHAR(20) NOT NULL,
    programa VARCHAR(60) NOT NULL,
    email VARCHAR(50) NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    estado VARCHAR(30),
    calle VARCHAR(50) NOT NULL,
    colonia VARCHAR(50) NOT NULL,
    delegacion VARCHAR(50) NOT NULL,
    cp INT NOT NULL,
    numExt INT,
    numInt INT,
    comentarios TEXT,
    PRIMARY KEY (idAlum)
);

CREATE TABLE empresas(
	idEmp INT NOT NULL AUTO_INCREMENT,
	rfc VARCHAR(20) NOT NULL,
	telefono VARCHAR(20) NOT NULL,
	estado VARCHAR(30),
	nombre VARCHAR(50) NOT NULL,
	calle VARCHAR(50) NOT NULL,
	colonia VARCHAR(50) NOT NULL,
	delegacion VARCHAR(50) NOT NULL,
	cp INT NOT NULL,
	numExt INT,
	numInt INT,
	giro TEXT,
	PRIMARY KEY(idEmp));

CREATE TABLE estancias(
	idEst INT NOT NULL AUTO_INCREMENT,
	universidad VARCHAR(30) NOT NULL,
	pais VARCHAR(20) NOT NULL,
	PRIMARY KEY (idEst));

CREATE TABLE escuelasAlternas(
	idEsc INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(30),
	PRIMARY KEY( idEsc )
	);

CREATE TABLE sanciones(
	idSancion INT NOT NULL AUTO_INCREMENT,
	idAlum INT NOT NULL,
	descripcion TEXT,
	area VARCHAR(30),
	problemasReglamento TEXT,
	PRIMARY KEY( idSancion),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE
	);


CREATE TABLE materias( 
	idMat INT NOT NULL AUTO_INCREMENT,
	cMateria INT,
	folio INT,
	numCreditos INT NOT NULL,
	nombre VARCHAR(20) NOT NULL,
	semestre INT NOT NULL,
	PRIMARY KEY(idMat)
	);

CREATE TABLE actividadesExtra( 
	idAct INT NOT NULL AUTO_INCREMENT,
	idAlum INT NOT NULL,
	nombre VARCHAR(30),
	tipo VARCHAR(10),
	PRIMARY KEY(idAct),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE
	);


CREATE TABLE alumnos_escuelas(
	idAlum INT NOT NULL,
	idEsc INT NOT NULL,
	carrera VARCHAR(30),
	PRIMARY KEY(idAlum, idEsc),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE,
	FOREIGN KEY(idEsc) REFERENCES escuelasAlternas(idEsc) ON DELETE CASCADE
	);

CREATE TABLE alumnos_empresas(
	idAlum INT NOT NULL,
	idEmp INT NOT NULL,
	puesto VARCHAR(30),
	fechaIni DATE,
	PRIMARY KEY(idAlum, idEmp),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE,
	FOREIGN KEY(idEmp) REFERENCES empresas(idEmp) ON DELETE CASCADE
	);


CREATE TABLE alumnos_estancias(
	idInter INT NOT NULL AUTO_INCREMENT,
	idAlum INT NOT NULL,
	idEst INT NOT NULL,
	anio INT NOT NULL,
	semestre VARCHAR(20),
	PRIMARY KEY(idInter),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE,
	FOREIGN KEY(idEst) REFERENCES estancias(idEst) ON DELETE CASCADE
	);


CREATE TABLE alumnos_materias(
	idAlum INT NOT NULL,
	idMat INT NOT NULL,
	estatusFin VARCHAR(30),
	calificacion INT,
	PRIMARY KEY(idAlum, idMat),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE,
	FOREIGN KEY(idMat) REFERENCES materias(idMat) ON DELETE CASCADE
	);

CREATE TABLE usuarios(
idUsu INT NOT NULL AUTO_INCREMENT,
usuario VARCHAR(30) NOT NULL,
password VARCHAR(255) NOT NULL,
rol VARCHAR(20) NOT NULL,
PRIMARY KEY(idUsu)
);

ALTER TABLE alumnos DROP COLUMN comentarios;

CREATE TABLE comentarios(
	idComentario INT NOT NULL AUTO_INCREMENT,
	comentario TEXT NOT NULL,
	idAlum INT NOT NULL,
	PRIMARY KEY(idComentario),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE

);

ALTER TABLE alumnos MODIFY beca INT;
ALTER TABLE alumnos MODIFY nombre VARCHAR(20);
ALTER TABLE alumnos MODIFY apellidoP VARCHAR(20);
ALTER TABLE alumnos MODIFY apellidoM VARCHAR(20);
ALTER TABLE alumnos MODIFY programa VARCHAR(60);
ALTER TABLE alumnos MODIFY email VARCHAR(50);
ALTER TABLE alumnos MODIFY telefono VARCHAR(15);
ALTER TABLE alumnos MODIFY estado VARCHAR(30);
ALTER TABLE alumnos MODIFY calle VARCHAR(50);
ALTER TABLE alumnos MODIFY colonia VARCHAR(50);
ALTER TABLE alumnos MODIFY delegacion VARCHAR(50);
ALTER TABLE alumnos MODIFY cp INT;

CREATE TABLE preparatorias(
	idPrep INT NOT NULL AUTO_INCREMENT,
	nombrePrep VARCHAR(30) NOT NULL,
	promedio DOUBLE NOT NULL,
	habloConAna INT NOT NULL,
	idAlum INT NOT NULL,
	PRIMARY KEY (idPrep, idAlum),
	FOREIGN KEY(idAlum) REFERENCES alumnos(idAlum) ON DELETE CASCADE

);


	
CREATE TABLE materiasRevalidadas(
	materiaRev VARCHAR(40) NOT NULL,
	materiaItam VARCHAR(40),
	calificacion DOUBLE,
	idInter INT NOT NULL,
	PRIMARY KEY(materiaRev, idInter),
	FOREIGN KEY (idInter) REFERENCES alumnos_estancias(idInter) ON DELETE CASCADE	
);
