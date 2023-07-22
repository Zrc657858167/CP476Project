<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
    <style>
        /* css */
        form {
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            border-right: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <?php
    // phpcs:disable PEAR.Commenting
    require_once "init.php";

    // process $_POST to DELETE FROM supplier
    if (isset($_POST['supp_deleted'])) {
        $a = array();
        $keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
        assocAppend($a, $_POST, $keys);
        $stmt = $conn->prepare(appendWHERE("DELETE FROM supplier", $a));
        bindCols($stmt, $a);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            // echo "Can't delete rows with this value of supp_id while it exists as the value of the foreign key of some row in the product table";
        }
    }

    // process $_POST to UPDATE supplier
    if (isset($_POST['supp_updated'])) {
        $old = array();
        $old_keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
        assocAppend($old, $_POST, $old_keys);
        $updated = array();
        $updated_keys = array('u_supp_id', 'u_supp_name', 'u_address', 'u_phone', 'u_email');
        assocAppend($updated, $_POST, $updated_keys);

        if ($updated) {
            // // if supp_id is being updated and it's not just being changed to its current value
            // // isset($updated['u_supp_id']) && !(isset($old['supp_id']) && $old['supp_id'] == $updated['u_supp_id'])
            // if (isset($updated['u_supp_id']) && $_POST['supp_rows'] == 1) {
            //     // if supp_id is being updated, and there are multiple rows, then it will make duplicates, which isn't allowed for supp_id
            //     // if no rows were selected, then there's nothing to update
            //     if () {
                
            //     }
            //     $sql = $conn->prepare("SELECT* FROM supplier WHERE supp_id = ?");
            //     $sql->bindValue(1, $updated['u_supp_id']);
            // }

            $str = "UPDATE supplier SET ";
            foreach ($updated as $key=>$value) {
                // during the bind phase step later on: need to bind key to value from $updated
                // Example: bind :u_supp_id to $updated['u_supp_id']
                // just need to turn the string to supp_id = :u_supp_id
                // use substr rather than using $old. the keys of $old likely won't match the keys of $updated
                $str .= substr($key, 2) . " = :$key, ";
            }
            $str = substr($str, 0, -2);
            $stmt = $conn->prepare(appendWHERE($str, $old));
            bindCols($stmt, $updated);
            bindCols($stmt, $old);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                // echo "Can't modify the value of supp_id while it exists as the value of the foreign key of some row in the product table.";
                echo $e->getMessage();
            }
        }
    }

    // process $_POST to DELETE FROM product
    if (isset($_POST['prod_deleted'])) {
        $a = array();
        $keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
        assocAppend($a, $_POST, $keys);
        $stmt = $conn->prepare(appendWHERE("DELETE FROM product", $a));
        bindCols($stmt, $a);
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // process $_POST to UPDATE product
    if (isset($_POST['prod_updated'])) {
        $old = array();
        $old_keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
        assocAppend($old, $_POST, $old_keys);
        $updated = array();
        $updated_keys = array('u_prod_id', 'u_prod_name', 'u_description', 'u_price', 'u_quantity', 'u_status', 'u_supp_id');
        assocAppend($updated, $_POST, $updated_keys);
        
        if ($updated) {
            $str = "UPDATE product SET ";
            foreach ($updated as $key=>$value) {
                $str .= substr($key, 2) . " = :$key, ";
            }
            $str = substr($str, 0, -2);
            echo $str;
            $stmt = $conn->prepare(appendWHERE($str, $old));
            bindCols($stmt, $updated);
            bindCols($stmt, $old);
            // try {
            //     $stmt->execute();
            // } catch (PDOException) {
            //     echo "Can't modify the value of the foreign key supp_id while it exists as the value of supp_id in the supplier table.";
            // }
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>

    <h1>CP476 Group Project</h1>

    <!-- Search supplier form -->
    <form action="supp.php" method="POST">
        <input type="text" name="supp_id" placeholder="Supplier ID" maxlength=4>
        <input type="text" name="supp_name" placeholder="Supplier name" maxlength=35>
        <input type="text" name="address" placeholder="Address" maxlength=35>
        <input type="tel" name="phone" placeholder="Phone" maxlength=20>
        <input type="email" name="email" placeholder="Email" maxlength=254>
        <input type="submit" value="Search supplier table">
    </form>

    <!--Search product form -->
    <form action="prod.php" method="POST">
        <input type="text" name="prod_id" placeholder="Product ID" maxlength=4>
        <input type="text" name="prod_name" placeholder="Product name" maxlength=20>
        <input type="text" name="description" placeholder="Description" maxlength=35>
        <input type="number" name="price" placeholder="Price" step=0.01 max=9999.99 min=-9999.99> 
        <input type="number" name="quantity" placeholder="Quantity" max=65535 min=0>
        <input type="text" name="status" placeholder="Status" maxlength=1>
        <input type="text" name="supp_id" placeholder="Supplier ID" maxlength=4>
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
            <th style="text-align: right; padding-right: 30px; width: 80px;">Quantity</th>
            <th style="text-align: right; padding-right: 50px; width: 150px;">Price</th>
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
            echo "<td style=\"text-align: right; padding-right: 30px; width: 80px;\">" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td style=\"text-align: right; padding-right: 50px; width: 150px;\">" . htmlspecialchars($row['price']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['supp_name']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
