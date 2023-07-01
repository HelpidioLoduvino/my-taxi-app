/** UTILIZADORES mais proximos do com id 1**/

drop function get_pedidos_proximos(id_motorista integer);

CREATE OR REPLACE FUNCTION get_pedidos_proximos(id_motorista integer)
    RETURNS TABLE (
                      nome varchar(100),
                      origem geometry,
                      destino geometry
                  )
AS $$
BEGIN

    return query SELECT u.nome, p.origem, p.destino
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

select * from get_pedidos_proximos(2);
