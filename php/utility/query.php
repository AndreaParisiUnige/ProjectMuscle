<?php
/*  La logica di controllo degli errori applicata è la seguente: se falliscono funzioni
    il cui motivo di fallimento è noto (es. tentativo di inserire un utente già esistente)
    viene stampato un messaggio di errore specifico all'utente. 
    Se invece fallisce una funzione il cui motivo di fallimento non è noto, viene memorizzato
    su un file di log l'errore e si invia all'utente un messaggio d'errore generico.
*/
require_once '../utility/utils.php';
require_once '../utility/connection.php';


define('SELECT_COOKIE', ['email', 'admin', 'rememberMeToken', 'cookie_expiration']);
define('WHERE_STMT_COOKIE', 'rememberMeToken=? AND cookie_expiration > NOW()');


// Richiede la tabella su cui fare la query, divide un array in stringhe separate da virgola e le concatena
// per comporre la select. Richiede una stringa per comporre il where e un array con i tipi di dato da inserire
// Il primo array può essere un regolare array, il secondo deve essere un array associativo
function genericSelect($table, $select_Columns, $where, $toBind, $con)
{
    $query = "SELECT " . implode(", ", $select_Columns) . " FROM " . $table;
    $query = isset($where) ? ($query . " WHERE " . $where) : $query;

    $stmt = mysqli_prepare($con, $query);
    check_mysqliFunction($stmt, $con, 'prepare', $query);

    if (!empty($toBind)) {
        $values = array_values($toBind);    // Ottengo i nomi associati ai valori sotto forma di array
        $types = getTypes($values);         // Ottengo i tipi di dato associati ai valori sotto forma di stringa
        check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);
    }

    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);
    $result = mysqli_stmt_get_result($stmt);
    check_mysqliFunction($result, $con, 'get result', $query);

    mysqli_stmt_close($stmt);
    if ($result && mysqli_num_rows($result) > 0) {
        $rows = [];
        while ($row = mysqli_fetch_array($result)) {
            $rows[] = $row;
        }
        if (count($rows) == 1)
            return $rows[0];
        else return $rows;
    }
    return null;
}

function insert_data($table, $toInsert, $con)
{;
    $columns = array_keys($toInsert);
    $values = array_values($toInsert);
    $types = getTypes($values);

    $query = "INSERT INTO " . $table . "(" . implode(", ", $columns) . ") VALUES (" . implode(", ", array_fill(0, count($columns), "?")) . ")";
    $stmt = mysqli_prepare($con, $query);
    check_mysqliFunction($stmt, $con, 'prepare', $query);

    check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);
    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);

    if (mysqli_stmt_affected_rows($stmt)) {
        mysqli_stmt_close($stmt);
        return true;
    }
    mysqli_stmt_close($stmt);
}

function delete_user($id, $con)
{
    $query = "DELETE FROM users WHERE id=?";
    check_mysqliFunction($delete_stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);
    check_mysqliFunction(mysqli_stmt_bind_param($delete_stmt, "i", $id), $con, 'bind', $query);
    check_mysqliFunction(mysqli_stmt_execute($delete_stmt), $con, 'execute', $query);
    if (mysqli_stmt_affected_rows($delete_stmt)) {
        mysqli_stmt_close($delete_stmt);
        return true;
    }
    mysqli_stmt_close($delete_stmt);
}

function generic_delete($table, $where, $whereBind, $con)
{
    $query = "DELETE FROM " . $table . " WHERE " . $where;
    $stmt = mysqli_prepare($con, $query);
    check_mysqliFunction($stmt, $con, 'prepare', $query);

    if (!empty($whereBind)) {
        $values = array_values($whereBind);
        $types = getTypes($whereBind);
    }
    check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);

    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);
    if (!mysqli_stmt_affected_rows($stmt))
        throw new Exception("error in '" . $query . "': " . mysqli_error($con));
    mysqli_stmt_close($stmt);
    return true;
}

// Si aspetta in input un array associativo con i nomi delle colonne e i valori da inserire
// Opzionalmente può ricevere una condizione da aggiungere al where, attesa nel formato "colonna=? AND colonna2=? ..."
// ed un array non associativo con i valori da inserire nella where (in ordine)
function generic_Update($table, $select_key_value, $where, $whereBind, $con)
{
    $keys = array_keys($select_key_value);
    $query = "UPDATE " . $table . " SET " . implode("=?, ", $keys) . "=?";
    $query = isset($where) ? ($query . " WHERE " . $where) : $query;
    check_mysqliFunction($stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);

    if (!empty($select_key_value)) {
        $values = array_values($select_key_value);
        $types = getTypes($values);         // Ottengo i tipi di dato associati ai valori sotto forma di stringa

        if (!empty($whereBind)) {
            $values = array_merge($values, array_values($whereBind));
            $types = $types . getTypes($whereBind);
        }
        check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);
    }
    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);
    if (!mysqli_stmt_affected_rows($stmt))
        throw new Exception("error in '" . $query . "': " . mysqli_error($con));
    mysqli_stmt_close($stmt);
    return true;
}
