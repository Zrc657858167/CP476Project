<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <style>
        /* Add your CSS here */
    </style>
</head>
<body>

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
        echo "Connection failed: " . $e->getMessage(); // is this helpful???
    }

    if (isset($_POST['supp_updated'])) {
        // $_POST has the form u_s1, . . . , u_sn, s1, . . . , sn, supp_updated
        // unset supp_updated. then the stuff with count() works
        $str = "UPDATE " . $_POST['supp_updated'] . " SET ";
        unset($_POST['supp_updated']);
        foreach (array_slice($_POST, 0, count($_POST) / 2) as $key=>$value) {
            if ($value) {
                $str .= substr($key, 2) . " = :$key, ";
            }
        }

        $str = substr($str, 0, -2);
        $str .= " WHERE ";
        foreach (array_slice($_POST, count($_POST) / 2) as $key=>$value) {
            if ($value) {
                $str .= "$key = :$key and ";
            }
        }
        $str = substr($str, 0, -5);

        echo $str;
        $stmt = $conn->prepare($str);
        $stmt->debugDumpParams();
        foreach ($_POST as $key=>$value) {
            if ($value) {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->debugDumpParams();
        $stmt->execute();
    }
    ?>

    <h1>CP476 Group Project</h1>

    <!-- Search supplier form -->
    <form action="supp.php" method="POST">
        <input type="text" name="supp_id" placeholder="Supplier ID">
        <input type="text" name="supp_name" placeholder="Supplier name">
        <input type="text" name="address" placeholder="Address">
        <input type="text" name="phone" placeholder="Phone">
        <input type="text" name="email" placeholder="Email">
        <input type="submit" value="Search supplier table">
    </form>

    <!--Search product form -->
    <form action="prod.php" method="POST">
        <input type="text" name="prod_id" placeholder="Product ID">
        <input type="text" name="prod_name" placeholder="Product name">
        <input type="text" name="description" placeholder="Description">
        <input type="text" name="quantity" placeholder="Quantity">
        <input type="text" name="price" placeholder="Price">
        <input type="text" name="status" placeholder="Status">
        <input type="text" name="supp_id" placeholder="Supplier ID">
        <input type="submit" value="Search product table">
    </form>

    <!-- Search results -->
    <?php
        // if (isset($_POST['searched_supp'])) {

        // }
    ?>

    <!-- Display inventory table -->
    <h3>Inventory</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Product name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Status</th>
            <th>Supplier name</th>
        </tr>
        
        <?php
        // phpcs:disable PEAR.Commenting
        $stmt = $conn->query(
            "SELECT prod_id, prod_name, quantity, price, status, supp_name 
            FROM product JOIN supplier ON product.supp_id = supplier.supp_id"
        );
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['prod_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prod_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['supp_name']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
