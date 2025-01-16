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
CONSTRAINT pokemon_id FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);

CREATE TABLE equipo_usuario(
usuario_id INT,
pokemon_id INT,
PRIMARY KEY (usuario_id, pokemon_id),
CONSTRAINT usuario_id_equipo FOREIGN KEY (`usuario_id`) REFERENCES users (`id`) ON UPDATE CASCADE,
CONSTRAINT pokemon_id_equipo FOREIGN KEY (`pokemon_id`) REFERENCES pokemon (`id`) ON UPDATE CASCADE
);

INSERT INTO users (usuario, password, administrador) VALUES ("admin", 12345678, true);

INSERT INTO pokemon (nombre, ataque, defensa, tipo, nivel, id_evolucion, imagen) VALUES 
("Venusaur", 21, 18, "Planta", 3, NULL, "ivysaur.gif"), 	#1
("Ivysaur", 17, 13, "Planta", 2, 1, "ivysaur.gif"),			#2
("Bulbasaur", 12, 10, "Planta", 1, 2, "bulbasaur.gif"),		#3

("Charizard", 25, 15, "Fuego", 3, NULL, "charizard.gif"),	#4
("Charmeleon", 18, 13, "Fuego", 2, 4, "charmaleon.gif"),	#5
("Charmander", 14, 8, "Fuego", 1, 5, "charmander.gif"),		#6

("Blastoise", 19, 23, "Agua", 3, NULL, "blastoise.gif"),	#7
("Wartortle", 14, 17, "Agua", 2, 7, "wartortle.gif"),		#8
("Squirtle", 10, 11, "Agua", 1, 8, "squirtel.gif"),			#9

("Raichu", 16, 17, "Electrico", 3, NULL, "raichu.gif"),		#10
("Pikachu", 16, 17, "Electrico", 2, 10, "pikachu.gif"),		#11
("Pichu", 9, 9, "Electrico", 1, 11, "pichu.gif"),			#12

("Infernape", 16, 17, "Fuego", 3, NULL, "infernape.gif"),	#13
("Monferno", 16, 17, "Fuego", 2, 13, "monferno.gif"),		#14
("Chimchar", 16, 17, "Fuego", 1, 14, "chimchar.gif"),		#15

("Empoleon", 16, 17, "Agua", 3, NULL, "empoleon.gif"),		#16
("Prinplup", 16, 17, "Agua", 2, 16, "prinplup.gif"),		#17
("Piplup", 16, 17, "Agua", 1, 17, "piplup.gif"),			#18

("Torterra", 16, 17, "Planta", 3, NULL, "torterra.gif"),	#19
("Grotle", 16, 17, "Planta", 2, 19, "grotle.gif"),			#20
("Turtwig", 16, 17, "Planta", 1, 20, "turtwig.gif"),		#21

("Luxray", 16, 17, "Electrico", 3, NULL, "luxray.gif"),		#22
("Luxio", 16, 17, "Electrico", 2, 22, "luxio.gif"),			#23
("Shinx", 16, 17, "Electrico", 1, 23, "shinx.gif"),			#24

("Golem", 16, 17, "Tierra", 3, NULL, "golem.gif"),			#25
("Graveler", 16, 17, "Tierra", 2, 25, "graveler.gif"),		#26
("Geodude", 16, 17, "Tierra", 1, 26, "geodude.gif"),		#27

("Krookodile", 16, 17, "Tierra", 3, NULL, "krookodile.gif"),#28
("Krokorok", 16, 17, "Tierra", 2, 28, "krokorok.gif"),		#29
("Sandile", 16, 17, "Tierra", 1, 29, "sandile.gif");		#30


INSERT INTO users (usuario, password, partidas_ganadas, partidas_jugadas, partidas_perdidas, evoluciones_disponibles, imagen, administrador)
VALUES
('Usuario1', 'password1', 10, 20, 10, 5, 'imagen1.png', FALSE),
('Usuario2', 'password2', 15, 30, 15, 3, 'imagen2.png', TRUE),
('Usuario3', 'password3', 8, 15, 7, 2, 'imagen3.png', FALSE),
('Usuario4', 'password4', 20, 25, 5, 7, 'imagen4.png', FALSE),
('Usuario5', 'password5', 0, 5, 5, 1, 'imagen5.png', FALSE),
('Usuario6', 'password6', 12, 18, 6, 4, 'imagen6.png', FALSE),
('Usuario7', 'password7', 9, 12, 3, 6, 'imagen7.png', TRUE),
('Usuario8', 'password8', 5, 10, 5, 0, 'imagen8.png', FALSE),
('Usuario9', 'password9', 7, 15, 8, 3, 'imagen9.png', FALSE),
('Usuario10', 'password10', 18, 22, 4, 8, 'imagen10.png', FALSE),
('Usuario11', 'password11', 14, 28, 14, 3, 'imagen11.png', TRUE),
('Usuario12', 'password12', 6, 11, 5, 2, 'imagen12.png', FALSE),
('Usuario13', 'password13', 11, 20, 9, 5, 'imagen13.png', FALSE),
('Usuario14', 'password14', 2, 6, 4, 1, 'imagen14.png', FALSE),
('Usuario15', 'password15', 16, 23, 7, 9, 'imagen15.png', FALSE),
('Usuario16', 'password16', 3, 9, 6, 0, 'imagen16.png', TRUE),
('Usuario17', 'password17', 19, 21, 2, 8, 'imagen17.png', FALSE),
('Usuario18', 'password18', 1, 8, 7, 2, 'imagen18.png', FALSE),
('Usuario19', 'password19', 13, 19, 6, 4, 'imagen19.png', FALSE),
('Usuario20', 'password20', 4, 10, 6, 3, 'imagen20.png', FALSE);

