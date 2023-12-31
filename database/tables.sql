drop database my_taxi_db;

CREATE EXTENSION IF NOT EXISTS postgis;

create database my_taxi_db;

drop table if exists viatura;
drop table if exists categoria_viatura;
drop table if exists viagem;
drop table if exists cliente;
drop table if exists pedido_reserva;
drop table if exists pedido;
drop table if exists motorista;
drop table if exists utilizador;

drop type if exists status_pedido;
drop type if exists status_motorista;
drop type if exists tipo_utilizador;

create type status_pedido as ENUM ('FINALIZADO','EM_ATENDIENTO','ACEITE','CRIADO');
create type status_motorista as ENUM ('DISPONIVEL','OCUPADO');
create type tipo_utilizador as ENUM ('CLIENTE','MOTORISTA');

create table utilizador
(
    id              serial primary key,
    nome            varchar(100)    not null,
    email           varchar(100)    not null,
    password        varchar(100)    not null,
    data_nascimento date            not null,
    tipo            tipo_utilizador not null,
    morada			varchar(100)	not null,
    localizacao     geometry(Point, 4326)
);

select u.nome ,u.localizacao, p.id  from pedido p inner join viagem v on p.id = v.id_pedido
           inner join utilizador u on  u.id =p.id_cliente where v.id_motorista=2 order by v.data_inicio asc limit 1;

          select * from utilizador;

         select *from pedido;
        
        delete from pedido where 0=0;
         
create table cliente
(
    id int references utilizador (id) primary key
);

create table motorista
(
    id int references utilizador (id) primary key ,
    estado        status_motorista default 'DISPONIVEL'
);

create table categoria_viatura
(
    id               serial primary key,
    velocidade_media float,
    fiabilidade      float,
    descricao        varchar(30)
);

create table viatura
(
    id           serial primary key,
    id_categoria int references categoria_viatura (id),
    id_motorista int references motorista (id)
);

create table pedido
(
    id         serial primary key,
    destino    geometry(Point, 4326),
    origem     geometry(Point, 4326),
    id_cliente int not null,
    estado     status_pedido default 'CRIADO'
);

create table pedido_reserva
(
    id           serial primary key,
    id_pedido    int references pedido (id),
    id_motorista int null references motorista (id)
);

create table viagem
(
    id              serial primary key,
    preco           numeric(19, 2),
    id_pedido       int references pedido (id),
    id_motorista    int references motorista (id),
    data_inicio     timestamp,
    data_fim        timestamp,
    tempo_estimando float,
    tempo_real      float
);