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

        th,
        td {
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
    <h3>Product</h3>
    <table>
        <!-- Return home form -->
        <form action="index.php" method="POST">
            Return to home <input type="submit" value="Home">
            <input type="hidden" name="action" value="prod_home">
        </form>

        <!-- Delete current selection form -->
        <form action="index.php" method="POST">
            Delete current selection <input type="submit" value="Delete">
            <input type="hidden" name="action" value="prod_deleted">
            <?php
            // phpcs:disable PEAR.Commenting    
            // just a way of sending data back to user.php with POST     
            echo '<input type="hidden" name="prod_id" value="' . $_POST['prod_id'] . '">';
            echo '<input type="hidden" name="prod_name" value="' . $_POST['prod_name'] . '">';
            echo '<input type="hidden" name="description" value="' . $_POST['description'] . '">';
            echo '<input type="hidden" name="price" value="' . $_POST['price'] . '">';
            echo '<input type="hidden" name="quantity" value="' . $_POST['quantity'] . '">';
            echo '<input type="hidden" name="status" value="' . $_POST['status'] . '">';
            echo '<input type="hidden" name="supp_id" value="' . $_POST['supp_id'] . '">';
            ?>
        </form>

        <!-- Update current selection form -->
        <form action="index.php" method="POST">
            <tr>
                <td><input type="text" name="u_prod_id" placeholder="Product ID" maxlength=4></td>
                <td><input type="text" name="u_prod_name" placeholder="Product name" maxlength=20></td>
                <td><input type="text" name="u_description" placeholder="Description" maxlength=35></td>
                <td style="text-align: right; padding-right: 50px; width: 150px;"><input type="number" name="u_price" placeholder="Price" step=0.01 max=9999.99 min=-9999.99></td>
                <td style="text-align: right; padding-right: 30px; width: 80px;"><input type="number" name="u_quantity" placeholder="Quantity" max=65535 min=0></td>
                <td><input type="text" name="u_status" placeholder="Status" maxlength=1></td>
                <td><input type="text" name="u_supp_id" placeholder="Supplier ID" maxlength=4></td>
                <td><input type="submit" value="Update"></td>
            </tr>
            <?php
            echo '<input type="hidden" name="prod_id" value="' . $_POST['prod_id'] . '">';
            echo '<input type="hidden" name="prod_name" value="' . $_POST['prod_name'] . '">';
            echo '<input type="hidden" name="description" value="' . $_POST['description'] . '">';
            echo '<input type="hidden" name="price" value="' . $_POST['price'] . '">';
            echo '<input type="hidden" name="quantity" value="' . $_POST['quantity'] . '">';
            echo '<input type="hidden" name="status" value="' . $_POST['status'] . '">';
            echo '<input type="hidden" name="supp_id" value="' . $_POST['supp_id'] . '">';
            ?>
            <input type="hidden" name="action" value="prod_updated">
        </form>
        <tr>
            <th>Product ID</th>
            <th>Product name</th>
            <th>Description</th>
            <th style="text-align: right; padding-right: 50px; width: 150px;">Price</th>
            <th style="text-align: right; padding-right: 30px; width: 80px;">Quantity</th>
            <th>Status</th>
            <th>Supplier ID</th>
        </tr>
        
        <!-- Display current selection -->
        <?php
        // $stmt comes index.php, which is the file that includes this one
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['prod_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['prod_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td style=\"text-align: right; padding-right: 50px; width: 150px;\">" . htmlspecialchars($row['price']) . "</td>";
            echo "<td style=\"text-align: right; padding-right: 30px; width: 80px;\">" . htmlspecialchars($row['quantity']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "<td>" . htmlspecialchars($row['supp_id']) . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>