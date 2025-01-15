drop database  if exists digimons;

CREATE DATABASE digimons;

USE digimons;

CREATE TABLE usuario(
id int auto_increment,
nick VARCHAR(50) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
partidas_ganadas int DEFAULT 0,
partidas_jugadas int DEFAULT 0,
partidas_perdidas int DEFAULT 0,
digievoluciones_disponibles int DEFAULT 0,
created_at 	DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

CREATE TABLE digimon(
id int auto_increment,
nombre VARCHAR(50) UNIQUE NOT NULL,
ataque int NOT NULL,
defensa int NOT NULL,
tipo VARCHAR(50) NOT NULL,
nivel TINYINT NOT NULL,
imagen VARCHAR (255)
);

CREATE TABLE digimon_usuario(
usuario_id 	INT, 
digimon_id 	INT,
created_at 	DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(usuario_id, digimon_id),
CONSTRAINT usuario_id FOREIGN KEY (`usuario_id`) REFERENCES usuario (`id`) ON UPDATE CASCADE,
CONSTRAINT digimon_id FOREIGN KEY (`digimon_id`) REFERENCES digimon (`id`) ON UPDATE CASCADE
);


