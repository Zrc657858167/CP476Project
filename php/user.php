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

    // if (isset($_POST['supp_updated'])) {
    //     $str = "UPDATE supplier";
    //     $substr = "";
    //     if ($_POST['supp_id']) {
    //         $substr .= ''
    //     }
    // }

    if (isset($_POST['supp_deleted'])) {
        $substr = '';
        if ($_POST['supp_id']) {
            $substr .= 'supp_id = :supp_id, ';
        }
        if ($_POST['supp_name']) {
            $substr .= 'supp_name = :supp_name';
        }
        if ($_POST['address']) {
            $substr .= 'address = :address, ';
        }
        if ($_POST['phone']) {
            $substr .= 'phone = :phone, ';
        }
        if ($_POST['email']) {
            $substr .= 'email = :email, ';
        }

        if ($substr) {
            $str = 'DELETE FROM supplier WHERE ' . $substr;
            $stmt = $conn->prepare(substr($str, 0, -2));
            if ($_POST['supp_id']) {
                $stmt->bindValue('supp_id', $_POST['supp_id']);
            }
            if ($_POST['supp_name']) {
                $stmt->bindValue('supp_name', $_POST['supp_name']);
            }
            if ($_POST['address']) {
                $stmt->bindValue('address', $_POST['address']);
            }
            if ($_POST['phone']) {
                $stmt->bindValue('phone', $_POST['phone']);
            }
            if ($_POST['email']) {
                $stmt->bindValue('email', $_POST['email']);
            }
            try {
                $stmt->execute();
            } catch (PDOException) {
                echo "Cannot delete these rows while their values of the primary key Supplier ID are the values of the foreign key Supplier ID of some rows in the Product table.";
            }
        } 
    }

    if (isset($_POST['prod_deleted'])) {
        $substr = '';
        if ($_POST['prod_id']) {
            $substr .= 'prod_id = :prod_id, ';
        }
        if ($_POST['prod_name']) {
            $substr .= 'prod_name = :prod_name';
        }
        if ($_POST['description']) {
            $substr .= 'description = :description, ';
        }
        if ($_POST['price']) {
            $substr .= 'price = :price, ';
        }
        if ($_POST['quantity']) {
            $substr .= 'quantity = :quantity, ';
        }
        if ($_POST['status']) {
            $substr .= 'status = :status, ';
        }
        if ($_POST['supp_id']) {
            $substr .= 'supp_id = :supp_id, ';
        }

        if ($substr) {
            $str = 'DELETE FROM product WHERE ' . $substr;
            $stmt = $conn->prepare(substr($str, 0, -2));
            if ($_POST['prod_id']) {
                $stmt->bindValue('prod_id', $_POST['prod_id']);
            }
            if ($_POST['prod_name']) {
                $stmt->bindValue('prod_name', $_POST['prod_name']);
            }
            if ($_POST['description']) {
                $stmt->bindValue('description', $_POST['description']);
            }
            if ($_POST['price']) {
                $stmt->bindValue('price', $_POST['price']);
            }
            if ($_POST['quantity']) {
                $stmt->bindValue('quantity', $_POST['quantity']);
            }
            if ($_POST['status']) {
                $stmt->bindValue('status', $_POST['status']);
            }
            if ($_POST['supp_id']) {
                $stmt->bindValue('supp_id', $_POST['supp_id']);
            }
            $stmt->execute();
        } 
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
