
/** UTILIZADORES mais proximos do com id 1**/
SELECT *
FROM utilizador
WHERE id <> 1
ORDER BY ST_Distance(localizacao, (SELECT localizacao FROM utilizador WHERE id = 1))
LIMIT 2 ;
