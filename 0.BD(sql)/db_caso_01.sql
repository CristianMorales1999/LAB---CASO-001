CREATE DATABASE IF NOT EXISTS db_caso_01;
USE db_caso_01;

CREATE TABLE profesiones (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  profesion VARCHAR(40) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE cargos (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cargo VARCHAR(40) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE empleados (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  profesion_id INTEGER UNSIGNED NOT NULL,
  cargo_id INTEGER UNSIGNED NOT NULL,
  nombres VARCHAR(45) NOT NULL,
  apellido_paterno VARCHAR(40) NULL,
  apellido_materno VARCHAR(40) NULL,
  PRIMARY KEY(id),
  INDEX empleados_FKIndex1(profesion_id),
  INDEX empleados_FKIndex2(cargo_id),
  FOREIGN KEY(profesion_id)
    REFERENCES profesiones(id)
      ON DELETE CASCADE
      ON UPDATE CASCADE,
  FOREIGN KEY(cargo_id)
    REFERENCES cargos(id)
      ON DELETE CASCADE
      ON UPDATE CASCADE
);

