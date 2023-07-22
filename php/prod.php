<!DOCTYPE html>
<html>
    <body>
        <!-- Display product table -->
        <h3>Product</h3>
        <table>
            <form action=user.php method="POST">
                Return to home <input type="submit" value="Home">
                <input type="hidden" name="prod_home" value="yes">
            </form>
            <form action=user.php method="POST">
                Delete current selection <input type="submit" value="Delete">
                <input type="hidden" name="prod_deleted" value="yes">
                <?php
                // phpcs:disable PEAR.Commenting         
                echo '<input type="hidden" name="prod_id" value="' . $_POST['prod_id'] . '">';
                echo '<input type="hidden" name="prod_name" value="' . $_POST['prod_name'] . '">';
                echo '<input type="hidden" name="description" value="' . $_POST['description'] . '">';
                echo '<input type="hidden" name="price" value="' . $_POST['price'] . '">';
                echo '<input type="hidden" name="quantity" value="' . $_POST['quantity'] . '">';
                echo '<input type="hidden" name="status" value="' . $_POST['status'] . '">';
                echo '<input type="hidden" name="supp_id" value="' . $_POST['supp_id'] . '">';
                ?>
            </form>
            <form action=user.php method="POST">
                <tr>
                    <td><input type="text" name="u_prod_id" placeholder="Product ID" maxlength=4></td>
                    <td><input type="text" name="u_prod_name" placeholder="Product name" maxlength=20></td>
                    <td><input type="text" name="u_description" placeholder="Description" maxlength=35></td>
                    <td><input type="number" name="u_price" placeholder="Price" step=0.01 max=9999.99 min=-9999.99></td>
                    <td><input type="number" name="u_quantity" placeholder="Quantity" max=65535 min=0></td>
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
                <input type="hidden" name="prod_updated" value="supplier">
            </form>
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
            $a = array();
            $keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
            assocAppend($a, $_POST, $keys);
            $stmt = $conn->prepare(appendWHERE("SELECT * FROM product", $a));
            bindCols($stmt, $a);
            $stmt->execute();
            // echo '<input type="hidden" name="prod_rows" value="' . $stmt->rowCount() . '">';
            formatRows($stmt);
            ?>
        </table>
    </body>
</html>