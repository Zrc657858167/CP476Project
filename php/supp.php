<!DOCTYPE html>
<html>
    <body>
        <!-- Display supplier table -->
        <h3>Supplier</h3>
        <table>
            <form action=user.php method="POST">
                Return to home <input type="submit" value="Home">
                <input type="hidden" name="supp_home" value="yes">
            </form>
            <form action=user.php method="POST">
                Delete current selection <input type="submit" value="Delete">
                <input type="hidden" name="supp_deleted" value="yes">
                <?php
                // phpcs:disable PEAR.Commenting         
                echo '<input type="hidden" name="supp_id" value="' . $_POST['supp_id'] . '">';
                echo '<input type="hidden" name="supp_name" value="' . $_POST['supp_name'] . '">';
                echo '<input type="hidden" name="address" value="' . $_POST['address'] . '">';
                echo '<input type="hidden" name="phone" value="' . $_POST['phone'] . '">';
                echo '<input type="hidden" name="email" value="' . $_POST['email'] . '">';
                ?>
            </form>
            <form action=user.php method="POST">
                <tr>
                    <td><input type="text" name="u_supp_id" placeholder="Supplier ID"></td>
                    <td><input type="text" name="u_supp_name" placeholder="Supplier name"></td>
                    <td><input type="text" name="u_address" placeholder="Address"></td>
                    <td><input type="text" name="u_phone" placeholder="Phone"></td>
                    <td><input type="text" name="u_email" placeholder="Email"></td>
                    <td><input type="submit" value="Update"></td>
                </tr>
                <?php  
                echo '<input type="hidden" name="supp_id" value="' . $_POST['supp_id'] . '">';
                echo '<input type="hidden" name="supp_name" value="' . $_POST['supp_name'] . '">';
                echo '<input type="hidden" name="address" value="' . $_POST['address'] . '">';
                echo '<input type="hidden" name="phone" value="' . $_POST['phone'] . '">';
                echo '<input type="hidden" name="email" value="' . $_POST['email'] . '">';
                ?>
                <input type="hidden" name="supp_updated" value="supplier">
            </form>
            <tr>
                <th>Supplier ID</th>
                <th>Supplier name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
            </tr>
            <?php
            require_once "init.php";
            $stmt = $conn->prepare(appendWHERE("SELECT * FROM supplier", $_POST));
            bindCols($stmt, $_POST);
            $stmt->execute();
            formatRows($stmt);
            ?>
        </table>
    </body>
</html>