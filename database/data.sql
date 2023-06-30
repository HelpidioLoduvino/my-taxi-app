delete from utilizador where 0=0;

insert into utilizador(nome, email, password, data_nascimento, tipo, localizacao)
values ('Jorge Filas', 'filas@gmail.com', '123', '2001-12-12', 'CLIENTE',ST_SetSRID(st_makepoint( 123.122, 123.452),4326)),
       ('Nuria santos', 'nuria@gmail.com', '123', '2003-12-12', 'CLIENTE',ST_SetSRID(st_makepoint( 923.122, 123.452),4326)),
       ('De cabrito', 'cabrito@gmail.com', '123', '2005-02-12', 'CLIENTE',ST_SetSRID(st_makepoint( 423.122, 423.452),4326)),
       ('Mateus zip', 'mateus@gmail.com', '123', '1995-12-23', 'MOTORISTA',ST_SetSRID(st_makepoint( 123.122, 323.452),4326)),
       ('Andre Lucamba', 'andre@gmail.com', '123', '2001-12-12', 'MOTORISTA',ST_SetSRID(st_makepoint( 223.122, 123.452),4326));


select * from motorista;