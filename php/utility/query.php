<?php
require_once '../utility/utils.php';
require_once '../utility/connection.php';


// Si aspetta in input un array associativo con i nomi delle colonne e i valori da inserire
// Opzionalmente può ricevere una condizione da aggiungere al where, attesa nel formato "colonna=? AND colonna2=? ..."
// ed un array non associativo con i valori con cui fare il bind (in ordine)
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

// Si aspetta in input un array associativo con i nomi delle colonne e i valori da inserire
function generic_Insert($table, $toInsert, $con)
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

// Si aspetta in input una stringa corrispondente al where della query,
// attesa nel formato "colonna=? AND colonna2=? ..."
// ed un array non associativo con i valori con cui fare il bind (in ordine)
function generic_Delete($table, $where, $whereBind, $con)
{
    $query = "DELETE FROM " . $table . " WHERE " . $where;
    $stmt = mysqli_prepare($con, $query);
    check_mysqliFunction($stmt, $con, 'prepare', $query);

    $values = array_values($whereBind);
    $types = getTypes($whereBind);
    check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);

    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);
    if (!mysqli_stmt_affected_rows($stmt))
        throw new Exception("error in '" . $query . "': " . mysqli_error($con));
    mysqli_stmt_close($stmt);
    return true;
}

// Si aspetta in input un array associativo con i nomi delle colonne e i valori da inserire
// Opzionalmente può ricevere una condizione da aggiungere al where, attesa nel formato "colonna=? AND colonna2=? ..."
// ed un array non associativo con i valori con cui fare il bind (in ordine)
function generic_Update($table, $select_key_value, $where, $whereBind, $con)
{
    $keys = array_keys($select_key_value);
    $query = "UPDATE " . $table . " SET " . implode("=?, ", $keys) . "=?";
    $query = isset($where) ? ($query . " WHERE " . $where) : $query;
    check_mysqliFunction($stmt = mysqli_prepare($con, $query), $con, 'prepare', $query);

    $values = array_values($select_key_value);
    $types = getTypes($values);         
        if (!empty($whereBind)) {
            $values = array_merge($values, array_values($whereBind));
            $types = $types . getTypes($whereBind);
        }
    check_mysqliFunction(mysqli_stmt_bind_param($stmt, $types, ...$values), $con, 'bind', $query);
    
    check_mysqliFunction(mysqli_stmt_execute($stmt), $con, 'execute', $query);
    if (!mysqli_stmt_affected_rows($stmt))
        throw new Exception("error in '" . $query . "': " . mysqli_error($con));
    mysqli_stmt_close($stmt);
    return true;
}
