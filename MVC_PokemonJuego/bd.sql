-- SQLBook: Code
drop database  if exists pokemons;

CREATE DATABASE pokemons;

USE pokemons;

CREATE TABLE users(
id int auto_increment,
usuario VARCHAR(50) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
partidas_ganadas int DEFAULT 0,
partidas_jugadas int DEFAULT 0,
partidas_perdidas int DEFAULT 0,
evoluciones_disponibles int DEFAULT 0,
imagen VARCHAR (255),
administrador bool NOT NULL DEFAULT FALSE,
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
CONSTRAINT usuario_id FOREIGN KEY (`usuario_id`) REFERENCES users (`id`) ON UPDATE CASCADE,
CONSTRAINT pokemon_id FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE equipo_usuario(
usuario_id INT,
pokemon_id INT,
numeroPokemon VARCHAR(50),
PRIMARY KEY (usuario_id, pokemon_id),
CONSTRAINT usuario_id_equipo FOREIGN KEY (`usuario_id`) REFERENCES users (`id`) ON UPDATE CASCADE,
CONSTRAINT pokemon_id_equipo FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);



INSERT INTO pokemon (nombre, ataque, defensa, tipo, nivel, id_evolucion, imagen) VALUES 
("venusaur", 21, 18, "Planta", 3, NULL, "assets/pokemons/venusaur"), 	#1
("ivysaur", 17, 13, "Planta", 2, 1, "assets/pokemons/ivysaur"),			#2
("bulbasaur", 12, 10, "Planta", 1, 2, "assets/pokemons/bulbasaur"),		#3

("charizard", 25, 15, "Fuego", 3, NULL, "assets/pokemons/charizard"),	#4
("charmeleon", 18, 13, "Fuego", 2, 4, "assets/pokemons/charmeleon"),	#5
("charmander", 14, 8, "Fuego", 1, 5, "assets/pokemons/charmander"),		#6

("blastoise", 19, 23, "Agua", 3, NULL, "assets/pokemons/blastoise"),	#7
("wartortle", 14, 17, "Agua", 2, 7, "assets/pokemons/wartortle"),		#8
("squirtle", 10, 11, "Agua", 1, 8, "assets/pokemons/squirtle"),			#9

("raichu", 16, 17, "Electrico", 3, NULL, "assets/pokemons/raichu"),		#10
("pikachu", 16, 17, "Electrico", 2, 10, "assets/pokemons/pikachu"),		#11
("pichu", 9, 9, "Electrico", 1, 11, "assets/pokemons/pichu"),			#12

("infernape", 16, 17, "Fuego", 3, NULL, "assets/pokemons/infernape"),	#13
("monferno", 16, 17, "Fuego", 2, 13, "assets/pokemons/monferno"),		#14
("chimchar", 16, 17, "Fuego", 1, 14, "assets/pokemons/chimchar"),		#15

("empoleon", 16, 17, "Agua", 3, NULL, "assets/pokemons/empoleon"),		#16
("prinplup", 16, 17, "Agua", 2, 16, "assets/pokemons/prinplup"),		#17
("piplup", 16, 17, "Agua", 1, 17, "assets/pokemons/piplup"),			#18

("torterra", 16, 17, "Planta", 3, NULL, "assets/pokemons/torterra"),	#19
("grotle", 16, 17, "Planta", 2, 19, "assets/pokemons/grotle"),			#20
("turtwig", 16, 17, "Planta", 1, 20, "assets/pokemons/turtwig"),		#21

("luxray", 16, 17, "Electrico", 3, NULL, "assets/pokemons/luxray"),		#22
("luxio", 16, 17, "Electrico", 2, 22, "assets/pokemons/luxio"),			#23
("shinx", 16, 17, "Electrico", 1, 23, "assets/pokemons/shinx"),			#24

("golem", 16, 17, "Tierra", 3, NULL, "assets/pokemons/golem"),			#25
("graveler", 16, 17, "Tierra", 2, 25, "assets/pokemons/graveler"),		#26
("geodude", 16, 17, "Tierra", 1, 26, "assets/pokemons/geodude"),		#27

("krookodile", 16, 17, "Tierra", 3, NULL, "assets/pokemons/krookodile"),#28
("krokorok", 16, 17, "Tierra", 2, 28, "assets/pokemons/krokorok"),		#29
("sandile", 16, 17, "Tierra", 1, 29, "assets/pokemons/sandile"),		#30
("ratata", 16, 17, "Normal", 1, NULL, "assets/pokemons/ratata");  #31



INSERT INTO users (usuario, password, partidas_ganadas, partidas_jugadas, partidas_perdidas, evoluciones_disponibles, imagen, administrador)
VALUES
('Patri', 'patri', 10, 20, 10, 5, 'imagen1.png', FALSE),
('Marco', 'marco', 15, 30, 15, 3, 'imagen2.png', FALSE),
('Jesus', 'jesus', 8, 15, 7, 2, 'imagen3.png', FALSE),
('JuanCarlos', 'juancarlos', 20, 25, 5, 7, 'imagen4.png', FALSE),
('Manu', 'manu', 0, 5, 5, 1, 'imagen5.png', FALSE),
('Dani', 'dani', 12, 18, 6, 4, 'imagen6.png', FALSE);
INSERT INTO users (usuario, password, administrador) VALUES ("admin", 12345678, true);

-- Usuario 1: Patri
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (1, 3); -- Bulbasaur
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (1, 6); -- Charmander
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (1, 9); -- Squirtle

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (1, 3, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (1, 6, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (1, 9, "pokemon3");


-- Usuario 2: Marco
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 12); -- Pichu
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 15); -- Chimchar
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 18); -- Piplup
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 6); -- Charmander
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 9); -- Squirtle
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (2, 3); -- Bulbasur

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (2, 15, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (2, 18, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (2, 9, "pokemon3");


-- Usuario 3: Jesus
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (3, 21); -- Turtwig
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (3, 24); -- Shinx
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (3, 27); -- Geodude

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (3, 21, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (3, 24, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (3, 27, "pokemon3");


-- Usuario 4: Juan Carlos
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (4, 29); -- Sandile
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (4, 3);  -- Bulbasaur
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (4, 6);  -- Charmander

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (4, 6, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (4, 29, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (4, 3, "pokemon3");


-- Usuario 5: Manu
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (5, 24); -- Shinx
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (5, 27); -- Geodude
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (5, 30); -- Sandile

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (5, 24, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (5, 27, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (5, 30, "pokemon3");


-- Usuario 6: Dani
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (6, 3);  -- Bulbasaur
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (6, 6);  -- Charmander
INSERT INTO pokemon_usuario (usuario_id, pokemon_id) VALUES (6, 9);  -- Squirtle

INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (6, 3, "pokemon1");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (6, 6, "pokemon2");
INSERT INTO equipo_usuario (usuario_id, pokemon_id, numeroPokemon) VALUES (6, 9, "pokemon3");






