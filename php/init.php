<?php
// phpcs:disable PEAR.Commenting
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
 * only appends non false entries. IDEA: change $keys to $target_keys
 * and make a new parameter called $source_keys=$target_keys (if this is allowed in php)
 */
function assocAppend(&$target, &$source, &$keys)
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

function appendWHERE(string $str, &$a)
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

function bindCols(PDOStatement $stmt, &$a)
{
    foreach ($a as $key=>$value) {
        $stmt->bindValue($key, $value);
    }
}

/**
 *  Echoes rows of a table within table tags in html
 * 
 * @param $stmt should have been executed before calling this function
 */
function formatRows(PDOStatement $stmt)
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
