delete
from utilizador
where 0 = 0;

insert into utilizador(nome, email, password, data_nascimento, tipo, morada, localizacao)
values ('Jorge Filas', 'filas@gmail.com', '123', '2001-12-12', 'CLIENTE', '',
        ST_SetSRID(st_makepoint(123.122, 123.452), 4326)),
       ('Nuria santos', 'nuria@gmail.com', '1233', '2003-12-12', 'CLIENTE', '',
        ST_SetSRID(st_makepoint(923.122, 123.452), 4326)),
       ('De cabrito', 'cabrito@gmail.com', '123', '2005-02-12', 'CLIENTE', '',
        ST_SetSRID(st_makepoint(423.122, 423.452), 4326)),
       ('Mateus zip', 'mateus@gmail.com', '123', '1995-12-23', 'MOTORISTA', '',
        ST_SetSRID(st_makepoint(123.122, 323.452), 4326)),
       ('Andre Lucamba', 'andre@gmail.com', '123', '2001-12-12', 'MOTORISTA', '',
        ST_SetSRID(st_makepoint(223.122, 123.452), 4326));


insert into pedido(origem, destino, id_cliente)

VALUES (st_setsrid(st_makepoint(1223.34, 1122), 4326), st_setsrid(st_makepoint(2221.34, 1122), 4326), 1),
       (st_setsrid(st_makepoint(2223.34, 1122), 4326), st_setsrid(st_makepoint(2232.34, 1122), 4326), 2),
       (st_setsrid(st_makepoint(1323.34, 1122), 4326), st_setsrid(st_makepoint(232.34, 1122), 4326), 3);

insert into categoria_viatura(velocidade_media, fiabilidade, descricao)
values (51.7, 8, 'JIP'),
       (21.7, 4, 'Médio porte'),
       (60, 7, 'Veloz');
insert into viatura(id_categoria, id_motorista)
VALUES (1, 1),
       (2, 2),
       (3, 3);

select *
from pedido;

select *
from utilizador;
select *
from cliente;

select *
from motorista;