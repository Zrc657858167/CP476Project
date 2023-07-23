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
                <td><input type="text" name="u_supp_id" placeholder="Supplier ID" maxlength=4></td>
                <td><input type="text" name="u_supp_name" placeholder="Supplier name" maxlength=35></td>
                <td><input type="text" name="u_address" placeholder="Address" maxlength=35></td>
                <td><input type="tel" name="u_phone" placeholder="Phone" maxlength=20></td>
                <td><input type="email" name="u_email" placeholder="Email" maxlength=254></td>
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
        $a = array();
        $keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
        assocAppend($a, $_POST, $keys);
        $stmt = $conn->prepare(appendWHERE("SELECT * FROM supplier", $a));
        bindCols($stmt, $a);
        $stmt->execute();
        formatRows($stmt);
        ?>
    </table>
</body>

</html>