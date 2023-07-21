<?php
// phpcs:disable PEAR.Commenting
$dsn= "mysql:host=localhost;dbname=cp476project;charset=utf8mb4";
$options = [
    PDO::ATTR_EMULATE_PREPARES => false, 
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $conn = new PDO($dsn, "root", "GcTQqD2V9tsCi8Vlz55D", $options);
}   catch(PDOException $e) {
}

function appendWHERE(string $str, &$a)
{
    $str .= " WHERE ";
    foreach ($a as $key=>$value) {
        if ($value) {
            $str .= "$key = :$key and ";
        }
    }
    return substr($str, 0, -5);
}

function bindCols(PDOStatement $stmt, &$a)
{
    foreach ($a as $key=>$value) {
        if ($value) {
            $stmt->bindValue($key, $value);
        }
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
?>