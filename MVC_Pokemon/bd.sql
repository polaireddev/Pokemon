drop database  if exists pokemons;

CREATE DATABASE pokemons;

USE pokemons;

CREATE TABLE usuario(
id int auto_increment,
nick VARCHAR(50) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
partidas_ganadas int DEFAULT 0,
partidas_jugadas int DEFAULT 0,
partidas_perdidas int DEFAULT 0,
digievoluciones_disponibles int DEFAULT 0,
imagen VARCHAR (255),
created_at 	DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(id)
);

CREATE TABLE pokemon(
id int auto_increment,
nombre VARCHAR(50) UNIQUE NOT NULL,
ataque int NOT NULL,
defensa int NOT NULL,
tipo VARCHAR(50) NOT NULL,
nivel TINYINT NOT NULL,
id_evolucion int,
imagen VARCHAR (255),
PRIMARY KEY(id),
CONSTRAINT pokemon_evolucion_id FOREIGN KEY (`id_evolucion`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);

CREATE TABLE pokemon_usuario(
usuario_id 	INT, 
pokemon_id 	INT,
created_at 	DATETIME DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY(usuario_id, pokemon_id),
CONSTRAINT usuario_id FOREIGN KEY (`usuario_id`) REFERENCES usuario (`id`) ON UPDATE CASCADE,
CONSTRAINT pokemon_id FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);

CREATE TABLE equipo_usuario(
usuario_id INT,
pokemon_id INT,
PRIMARY KEY (usuario_id, pokemon_id),
CONSTRAINT usuario_id_equipo FOREIGN KEY (`usuario_id`) REFERENCES usuario (`id`) ON UPDATE CASCADE,
CONSTRAINT pokemon_id_equipo FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);

INSERT INTO pokemon (nombre, ataque, defensa, tipo, nivel, id_evolucion, imagen) VALUES 
("Venusaur", 21, 18, "Planta", 3, NULL, "ivysaur.gif"),
("Ivysaur", 17, 13, "Planta", 2, 1, "ivysaur.gif"),
("Bulbasaur", 12, 10, "Planta", 1, 2, "bulbasaur.gif"),
("Charizard", 25, 15, "Fuego", 3, NULL, "charizard.gif"),
("Charmeleon", 18, 13, "Fuego", 2, 4, "charmaleon.gif"),
("Charmander", 14, 8, "Fuego", 1, 5, "charmander.gif"),
("Blastoise", 19, 23, "Agua", 3, NULL, "blastoise.gif"),
("Wartortle", 14, 17, "Agua", 2, 7, "wartortle.gif"),
("Squirtle", 10, 11, "Agua", 1, 8, "squirtel.gif"),
("Raichu", 16, 17, "Electrico", 2, NULL, "raichu.gif"),
("Pikachu", 16, 17, "Electrico", 2, 10, "pikachu.gif"),
("Pichu", 9, 9, "Electrico", 1, 11, "pichu.gif");



