USE db_caso_01;

-- Inserción de profesiones
INSERT INTO profesiones (profesion) VALUES
('INGENIERO DE SOFTWARE'),
('ANALISTA DE SISTEMAS'),
('DESARROLLADOR WEB'),
('ADMINISTRADOR DE REDES'),
('CIENTÍFICO DE DATOS'),
('INGENIERO DE TELECOMUNICACIONES'),
('SOPORTE TÉCNICO'),
('ADMINISTRADOR DE BASE DE DATOS'),
('DISEÑADOR GRÁFICO'),
('INGENIERO DE CIBERSEGURIDAD');

-- Inserción de cargos
INSERT INTO cargos (cargo) VALUES
('GERENTE DE TI'),
('ANALISTA DE TI'),
('DESARROLLADOR FRONT-END'),
('DESARROLLADOR BACK-END'),
('ESPECIALISTA EN REDES'),
('ESPECIALISTA EN DATOS'),
('CONSULTOR DE SEGURIDAD'),
('DISEÑADOR UI/UX'),
('ADMINISTRADOR DE SISTEMAS'),
('JEFE DE PROYECTOS');

-- Inserción de empleados (asegurando que las profesiones y cargos existan en las tablas)
INSERT INTO empleados (profesion_id, cargo_id, nombres, apellido_paterno, apellido_materno) VALUES
(1, 1, 'CARLOS', 'GOMEZ', 'FERNANDEZ'),
(2, 2, 'MARÍA', 'LOPEZ', 'GUZMAN'),
(3, 3, 'JUAN', 'PEREZ', 'RODRIGUEZ'),
(4, 4, 'ANA', 'RAMIREZ', 'MARTINEZ'),
(5, 5, 'LUIS', 'HERNANDEZ', 'SANCHEZ'),
(6, 6, 'CLAUDIA', 'DIAZ', 'TORRES'),
(7, 7, 'JORGE', 'MENDOZA', 'VARGAS'),
(8, 8, 'JESSICA', 'VEGA', 'ROJAS'),
(9, 9, 'FRANCISCO', 'CASTRO', 'MEJIA'),
(10, 10, 'SOFIA', 'REYES', 'RIOS');