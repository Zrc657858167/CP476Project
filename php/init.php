<?php
// phpcs:disable PEAR.Commenting

// open database connection for other files to use
$dsn = "mysql:host=localhost;dbname=cp476project;charset=utf8mb4";
$options = [
    PDO::ATTR_EMULATE_PREPARES => false, 
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, "root", "GcTQqD2V9tsCi8Vlz55D", $options);
}   catch(PDOException $e) {
    echo "Connection failed";
}

/**
 * count($target_keys) == count($source_keys)
 */
// function assocAppend(&$target, &$source, &$target_keys, &$source_keys)
// {
//     $n = count($target_keys);
//     for ($i = 0; $i < $n; ++$i) {
//         $target[$target_keys[$i]] = $source[$source_keys[$i]];
//     }
// }

/**
 * Appends non false/non empty entries from $source to $target. 
 * IDEA: change $keys to $target_keys and make a new parameter
 * called $source_keys=$target_keys (if this is allowed in php).
 * 
 * @param array $target
 * @param array $source
 * @param array $keys An array of keys used to access source and name the keys of the new entries of $target
 */
function assocAppend(array &$target, array &$source, array &$keys): void
{
    foreach ($keys as $k) {
        if ($source[$k]) {
            $target[$k] = $source[$k];
        }
    }
}

// function appendSET(string $str, &$a)
// {
//     $str .= " SET ";
//     foreach ($a as $key=>$value) {
//         if ($value) {
//             $str .= "$key = :$key, ";
//         }
//     }
//     return substr($str, 0, -2);
// }

/**
 * count(&$cols) = count(&$param_names)
 */

// function appendSET(string $str, &$cols, &$param_names)
// {
//     $str .= " SET ";
//     $n = count($cols);
//     for ($i = 0; $i < $n; ++$i) {
//         $str .= $cols[$i] . " = :" . $param_names[$i] . ", ";
//     }
//     return substr($str, 0, -2);
// }

// function appendWHERE(string $str, &$a)
// {
//     if ($a) {
//         $str .= " WHERE ";
//         foreach ($a as $key=>$value) {
//             if ($value) {
//                 $str .= "$key = :$key and ";
//             }
//         }
//         $str = substr($str, 0, -5);
//     }
//     return $str;
// }

/**
 * Appends the WHERE clause if $a is non empty.
 * The statement parameters are named after the column, producing terms like $key = :$key.
 * Intended for bindCols() to be used after to bind values to the statement parameters.
 */
function appendWHERE(string $str, array &$a): string
{
    if ($a) {
        $str .= " WHERE ";
        foreach ($a as $key=>$value) {
            $str .= "$key = :$key and ";
        }
        $str = substr($str, 0, -5);
    }
    return $str;
}

// function bindCols(PDOStatement $stmt, &$a)
// {
//     foreach ($a as $key=>$value) {
//         if ($value) {
//             $stmt->bindValue($key, $value);
//         }
//     }
// }

/**
 * Binds values of $a to $stmt.
 * Expects parameters to be named the way appendWHERE() names them.
 * Expects $key = :$key so that bindValue($key, $value) can be used.
 */
function bindCols(PDOStatement $stmt, array &$a): void
{
    foreach ($a as $key=>$value) {
        $stmt->bindValue($key, $value);
    }
}

/**
 * Echoes rows of a table within table tags in html
 * 
 * @param $stmt should have been executed before calling this function
 */
function formatRows(PDOStatement $stmt): void
{
    // are prepared statements enough? seems like html injections can get through. maybe even htmlspecialchars isn't enough?
    while ($row = $stmt->fetch($mode=PDO::FETCH_BOTH)) {
        $n = count($row) / 2;
        echo "<tr>";
        for ($i = 0; $i < $n; ++$i) {
            echo "<td>" . htmlspecialchars($row[$i]) . "</td>";
        }
        echo "</tr>";
    }
}

// function build_update_stmt(&$old_key_names, &$updated_key_names, $table_name) {
//     global $conn;
//     $old = array();
//     assocAppend($old, $_POST, $old_keys_names);
//     $updated = array();
//     assocAppend($updated, $_POST, $updated_key_names);

//     $stmt;
//     if ($updated) {
//         $str = "UPDATE supplier SET ";
//         foreach ($updated as $key => $value) {
//             // during the bind step later on: need to bind key to value from $updated
//             // Example: bind :u_supp_id to $updated['u_supp_id']
//             // just need to turn the string to supp_id = :u_supp_id
//             // use substr rather than using $old. the keys of $old likely won't match the keys of $updated
//             $str .= substr($key, 2) . " = :$key, ";
//         }
//         $str = substr($str, 0, -2);
//         $stmt = $conn->prepare(appendWHERE($str, $old));
//         bindCols($stmt, $updated);
//         bindCols($stmt, $old);
//     } else {
//         $stmt = null;
//     }
//     return $stmt;
// }

?>