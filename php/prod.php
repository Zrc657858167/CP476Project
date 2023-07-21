<!DOCTYPE html>
<html>
    <body>
        <!-- Display product table -->
        <h3>Product</h3>
        <table>
            <tr>
                <th>Product ID</th>
                <th>Product name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Supplier ID</th>
            </tr>
            <?php
            // phpcs:disable PEAR.Commenting
            require_once "init.php";
            $stmt = $conn->prepare(appendWHERE("SELECT * FROM product", $_POST));
            bindCols($stmt, $_POST);
            $stmt->execute();
            formatRows($stmt);
            ?>
        </table>
    </body>
</html>