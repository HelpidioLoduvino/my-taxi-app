/** UTILIZADORES mais proximos do com id 1**/

drop function get_pedidos_proximos(id_motorista integer);

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
                          inner join utilizador u on u.id = c.id_utilizador

                 WHERE p.estado = 'CRIADO'
                 ORDER BY st_distance(p.origem, (SELECT u.localizacao
                                                 FROM motorista m
                                                          inner join utilizador u on u.id = m.id_utilizador
                                                 WHERE u.id = id_motorista))
                 LIMIT 5;
END;
$$ LANGUAGE plpgsql;

select *
from get_pedidos_proximos(2);


drop function iniciar_viagem(id_motorista integer, id_pedido int);

CREATE OR REPLACE procedure iniciar_viagem(id_motorista integer, id_pedido int) AS
$$
BEGIN

    update pedido set estado='EM_ATENDIENTO' where id = id_pedido;

    insert into viagem(preco, id_pedido, id_motorista, data_inicio, data_fim)
    values (null, id_pedido, id_motorista, current_timestamp, null);

    update motorista p set estado= 'OCUPADO' where id = id_motorista;

END;
$$ LANGUAGE plpgsql;

drop function finalizar_viagem(pedido_id int);

create or replace procedure finalizar_viagem(pedido_id int)
     AS
$$
BEGIN

    update pedido set estado='FINALIZADO' where id=pedido_id;
    update viagem p set data_fim= current_timestamp where id_pedido=pedido_id;

    update motorista p set estado= 'DISPONIVEL' where id = (
        select v.id_motorista from viagem v where v.id_pedido=pedido_id
        );

    update utilizador u  set localizacao= (select p.destino from pedido p where p.id=pedido_id)
                         where u.id = (select u.id from utilizador u2
                                        inner join motorista m2 on u2.id = m2.id_utilizador
                                        inner join viagem v on m2.id = v.id_motorista
                                        where v.id_pedido=id_pedido);


END;
$$ LANGUAGE plpgsql;


call iniciar_viagem(2, 1);
select *from pedido;

select *from viagem;

select *from motorista;

call finalizar_viagem(1);