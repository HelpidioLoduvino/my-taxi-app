delete from utilizador where 0=0;

insert into utilizador(nome, email, password, data_nascimento, tipo, x, y)
values ('Jorge Filas', 'filas@gmail.com', '123', '2001-12-12', 'CLIENTE', 123.12, 123.45),
       ('Nuria santos', 'nuria@gmail.com', '123', '2003-12-12', 'CLIENTE', 923.12, 123.45),
       ('De cabrito', 'cabrito@gmail.com', '123', '2005-02-12', 'CLIENTE', 423.12, 423.45),
       ('Mateus zip', 'mateus@gmail.com', '123', '1995-12-23', 'MOTORISTA', 123.12, 323.45),
       ('Andre Lucamba', 'andre@gmail.com', '123', '2001-12-12', 'MOTORISTA', 223.12, 123.45);


select * from motorista;