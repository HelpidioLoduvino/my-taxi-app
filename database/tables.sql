create database my_taxi_db;

drop table if exists categoria_viatura;
drop table if exists motorista;

drop type if exists status_pedido;
drop type if exists status_motorista;

create type status_pedido as ENUM ('FINALIZADO','EM_ATENDIENTO','DISPONIVEL');
create type status_motorista as ENUM ('DISPONIVEL','OCUPADO');

create table motorista(
    id serial primary key ,
    nome varchar(100),
    x float,
    y float,
    estado status_motorista

);

create table categoria_viatura (
    id serial primary key ,
    velocidade_media float,
    fiabilidade float,
    descricao varchar(30)
);

create table viatura(
    id serial primary key ,
    id_categoria int references categoria_viatura(id),
    id_motorista int references motorista(id)
);

create table cliente(
    id serial primary key ,
    nome varchar(100),
    x float,
    y float
);

create table pedido(
    id serial primary key ,
    x_origem float,
    y_origem float,
    x_destino float,
    y_destino float,
    id_cliente int not null,
    estado status_pedido
);

create table pedido_reserva(
   id serial primary key ,
   id_pedido int references pedido(id),
   id_motorista int null references motorista(id)
);

create table viagem(
   id serial primary key ,
   preco numeric(19,2),
   id_pedido int references pedido(id),
   id_motorista int references motorista(id),
   data_inicio timestamp,
   data_fim timestamp
);