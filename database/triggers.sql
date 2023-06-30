
CREATE FUNCTION insert_motorista_utilizador()
    RETURNS TRIGGER AS $$
BEGIN
    IF NEW.tipo = 'MOTORISTA' THEN
        INSERT INTO motorista (id_utilizador) VALUES (NEW.id);
    ELSIF NEW.tipo = 'CLIENTE' THEN
        INSERT INTO cliente (id_utilizador) VALUES (NEW.id);
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

create trigger autulizar_motorista_utilizador After insert on utilizador
    for EACH ROW execute FUNCTION insert_motorista_utilizador();

 /* TODO: fazer para update e delete*/