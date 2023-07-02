/** UTILIZADORES mais proximos do com id 1**/

drop function get_pedidos_proximos(id_motorista integer);
drop function get_estimativa_tempo(id_pedido int, motorista_id int, tipo varchar(30));

create or replace function get_estimativa_tempo(id_pedido int, motorista_id int, tipo varchar(30)) returns float
as
$$
declare
    velocidade_carro float;
    declare result   double precision;
BEGIN

    select cv.velocidade_media
    into velocidade_carro
    from motorista m
             inner join viatura v on m.id = v.id_motorista
             inner join categoria_viatura cv on cv.id = v.id_categoria
    where m.id = motorista_id;
--
    if tipo = 'BUSCAR' then

        select (st_distance(u.localizacao::geography, p.origem::geography) / 1000) / velocidade_carro
        into result
        from pedido p
                 inner join motorista m on m.id = motorista_id
                 inner join utilizador u on u.id = m.id
        where p.id = id_pedido;


    elsif tipo = 'LEVAR' then

        select (st_distance(p.origem::geography, p.destino::geography) / 1000) / velocidade_carro
        into result
        from pedido p
                 inner join motorista m on m.id = motorista_id
                 inner join utilizador u on u.id = m.id
        where p.id = id_pedido;


    end if;

    return result;
END ;
$$ language plpgsql;

CREATE OR REPLACE FUNCTION get_pedidos_proximos(id_motorista integer)
    RETURNS TABLE
            (
                pedido_id int,
                nome      varchar(100),
                origem    geometry,
                destino   geometry
            )
AS
$$
BEGIN

    return query SELECT p.id, u.nome, p.origem, p.destino
                 FROM pedido p
                          inner join cliente c on c.id = p.id_cliente
                          inner join utilizador u on u.id = c.id

                 WHERE p.estado = 'CRIADO'
                 ORDER BY st_distance(p.origem, (SELECT u.localizacao
                                                 FROM motorista m
                                                          inner join utilizador u on u.id = m.id
                                                 WHERE u.id = id_motorista))
                 LIMIT 5;
END;
$$ LANGUAGE plpgsql;

select *
from get_pedidos_proximos(2);


drop function iniciar_viagem(id_motorista integer, id_pedido int);
drop function aceitar_viagem(id_motorista integer, id_pedido int);

CREATE OR REPLACE procedure aceitar_viagem(id_motorista integer, id_pedido int) AS
$$
BEGIN
    update pedido set estado='ACEITE' where id = id_pedido;
    update motorista p set estado= 'OCUPADO' where id = id_motorista;
END
$$ LANGUAGE plpgsql;


CREATE OR REPLACE procedure iniciar_viagem(id_motorista integer, id_pedido int) AS
$$
BEGIN

    update pedido set estado='EM_ATENDIENTO' where id = id_pedido;

    insert into viagem(preco, id_pedido, id_motorista, data_inicio, data_fim, tempo_estimando)
    values (null, id_pedido, id_motorista, current_timestamp, null,
            get_estimativa_tempo(id_pedido, id_motorista, 'LEVAR'));

    update motorista p set estado= 'OCUPADO' where id = id_motorista;

END;
$$ LANGUAGE plpgsql;

drop function finalizar_viagem(pedido_id int);

create or replace function finalizar_viagem(pedido_id int)
    returns table
            (
                preco numeric(19, 2),
                tempo double precision
            )
AS
$$
BEGIN

    update pedido set estado='FINALIZADO' where id = pedido_id;
    update viagem p set data_fim= current_timestamp where id_pedido = pedido_id;

    update motorista p
    set estado= 'DISPONIVEL'
    where id = (select v.id_motorista
                from viagem v
                where v.id_pedido = pedido_id);

    update utilizador u
    set localizacao= (select p.destino from pedido p where p.id = pedido_id)
    where u.id = (select u.id
                  from utilizador u2
                           inner join motorista m2 on u2.id = m2.id
                           inner join viagem v on m2.id = v.id_motorista
                  where v.id_pedido = id_pedido);

    --TEMPO DECORRIDO EM HORA
    update viagem
    set data_fim=current_timestamp,
        tempo_real= ((EXTRACT(EPOCH FROM current_timestamp)::double precision / 3600) -
                     tempo_estimando) / 3600
    where id_pedido = pedido_id;

    if false then

        update viagem
        set preco = (select cast(cv.fiabilidade as double precision) * cast(v.tempo_real as double precision)
                     from viagem v
                              inner join utilizador u on u.id = v.id_motorista
                              inner join viatura v2 on v.id_motorista = v2.id_motorista
                              inner join categoria_viatura cv on cv.id = v2.id_categoria
                     where v.id_pedido = pedido_id);

    else
        update viagem
        set preco = (select cv.fiabilidade * v.tempo_estimando
                     from viagem v
                              inner join utilizador u on u.id = v.id_motorista
                              inner join viatura v2 on v.id_motorista = v2.id_motorista
                              inner join categoria_viatura cv on cv.id = v2.id_categoria
                     where v.id_pedido = pedido_id);
    end if;

    return query SELECT v.preco, v.tempo_real from viagem v where id_pedido=pedido_id;


END;
$$ LANGUAGE plpgsql;



select *
from get_estimativa_tempo(2, 4, 'LEVAR') as tempo_em_hora;
select *
from get_estimativa_tempo(4, 2, 'LEVAR') as t;


select *
from pedido;
select *
from viagem;
select *
from motorista;
select *
from utilizador;
delete
from viagem
where 0 = 0;

call aceitar_viagem(4, 2);
call iniciar_viagem(4, 2);
select * from finalizar_viagem(2);