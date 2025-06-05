USE db_caso_01;

-- Inserción de profesiones
INSERT INTO profesiones (profesion) VALUES
('SECUNDARIA COMPLETA'),
('CONTADOR'),
('SECRETARIA'),
('MARKETING');

-- Inserción de cargos
INSERT INTO cargos (cargo) VALUES
('CAJERO'),
('VENDEDOR'),
('AUXILIAR CONTABLE'),
('ALMACENERO');

-- Inserción de empleados (asegurando que las profesiones y cargos existan en las tablas)
INSERT INTO empleados (profesion_id, cargo_id, nombres, apellido_paterno, apellido_materno) VALUES
(4, 2, 'YOSIP', 'URQUIZO', 'GOMEZ'),
(2, 1, 'ENRIQUE', 'MARCOS', 'VAZQUEZ'),
(1, 1, 'MARIA', 'RUIZ', 'DIAZ'),
(1, 1, 'JUAN', 'ARIAS', 'VALVERDE'),
(1, 2, 'LUIS', 'MIRANDA', 'PARDO'),
(2, 3, 'LULU', 'QUEBEDO', 'CHAVEZ'),
(2, 3, 'ANDREA', 'ALVAREZ', 'PRIETO'),
(3, 2, 'ANA', 'RIVAS', 'TELLO'),
(4, 2, 'EVITA', 'PERON', 'ARIAS'),
(4, 2, 'MIGUEL', 'CERVANTES', 'SAAVEDRA'),
(3, 1, 'CALUDIA', 'ROJAS', 'AVILA'),
(4, 2, 'RITA', 'ARIAS', 'ALVARES');