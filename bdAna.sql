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
	idAlum INT NOT NULL,
	idEst INT NOT NULL,
	anio INT NOT NULL,
	semestre VARCHAR(20),
	PRIMARY KEY(idAlum, idEst),
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