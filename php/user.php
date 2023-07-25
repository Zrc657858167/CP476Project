<!DOCTYPE html>
<html>
<body>
    <?php
    // phpcs:disable PEAR.Commenting
    require_once "init.php";

    if (!isset($_POST['action'])) {
        include 'view/login.php';
    } else if ($_POST['action'] == 'supp_searched') {
        $a = array();
        $keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
        assocAppend($a, $_POST, $keys);
        $stmt = $conn->prepare(appendWHERE("SELECT * FROM supplier", $a));
        bindCols($stmt, $a);
        $stmt->execute();

        include 'view/supp.php';
    } else if ($_POST['action'] == 'prod_searched') {
        $a = array();
        $keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
        assocAppend($a, $_POST, $keys);
        $stmt = $conn->prepare(appendWHERE("SELECT * FROM product", $a));
        bindCols($stmt, $a);
        $stmt->execute();

        include 'view/prod.php';
    } else {
        if ($_POST['action'] == 'supp_deleted') {
            $a = array();
            $keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
            assocAppend($a, $_POST, $keys);
            $stmt = $conn->prepare(appendWHERE("DELETE FROM supplier", $a));
            bindCols($stmt, $a);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                $msg;
                $errorInfo = $e->errorInfo;
                if ($errorInfo[0] == '23000' && $errorInfo[1] == '1451') {
                    $msg = "Cannot delete a parent row: doing so will leave product.supp_id unmatched for some rows in the product table. product.supp_id is a foreign key that must match the value of supplier.supp_id for some row in the supplier table to maintain referential integrity.";
                } else {
                    $msg = $e->getMessage();
                }
                echo '<script type="text/javascript">';
                echo 'alert("' . $msg . '");';
                echo '</script>';
            }
        } else if ($_POST['action'] == 'prod_deleted') {
            $a = array();
            $keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
            assocAppend($a, $_POST, $keys);
            $stmt = $conn->prepare(appendWHERE("DELETE FROM product", $a));
            bindCols($stmt, $a);
            try {
                $stmt->execute();
            } catch (PDOException $e) {
                echo '<script type="text/javascript">';
                echo 'alert("' . $e->getMessage() . '");';
                echo '</script>';
            }
        } else if ($_POST['action'] == 'supp_updated') {
            $old = array();
            $old_keys = array('supp_id', 'supp_name', 'address', 'phone', 'email');
            assocAppend($old, $_POST, $old_keys);
            $updated = array();
            $updated_keys = array('u_supp_id', 'u_supp_name', 'u_address', 'u_phone', 'u_email');
            assocAppend($updated, $_POST, $updated_keys);
    
            if ($updated) {
                $str = "UPDATE supplier SET ";
                foreach ($updated as $key => $value) {
                    // during the bind step later on: need to bind key to value from $updated
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
                    $msg;
                    $errorInfo = $e->errorInfo;
                    if ($errorInfo[0] == '23000' && $errorInfo[1] == '1451') {
                        $msg = "Cannot update a parent row: updating supplier.supp_id will leave product.supp_id unmatched for some rows in the product table. product.supp_id is a foreign key that must match the value of supplier.supp_id for some row in the supplier table to maintain referential integrity.";
                    } else if ($errorInfo[0] == '23000' && $errorInfo[1] == '1062') {
                        $msg = $errorInfo[2] . ". Primary key Supplier ID must be unique.";
                    } else {
                        $msg = $e->getMessage();
                    }
                    echo '<script type="text/javascript">';
                    echo 'alert("' . $msg . '");';
                    echo '</script>';
                }
            }
        } else if ($_POST['action'] == 'prod_updated') {
            $old = array();
            $old_keys = array('prod_id', 'prod_name', 'description', 'price', 'quantity', 'status', 'supp_id');
            assocAppend($old, $_POST, $old_keys);
            $updated = array();
            $updated_keys = array('u_prod_id', 'u_prod_name', 'u_description', 'u_price', 'u_quantity', 'u_status', 'u_supp_id');
            assocAppend($updated, $_POST, $updated_keys);
    
            if ($updated) {
                $str = "UPDATE product SET ";
                foreach ($updated as $key => $value) {
                    $str .= substr($key, 2) . " = :$key, ";
                }
                $str = substr($str, 0, -2);
                $stmt = $conn->prepare(appendWHERE($str, $old));
                bindCols($stmt, $updated);
                bindCols($stmt, $old);
                try {
                    $stmt->execute();
                } catch (PDOException $e) {
                    $msg;
                    $errorInfo = $e->errorInfo;
                    if ($errorInfo[0] == '23000' && $errorInfo[1] == '1452') {
                        $msg = "Cannot update a child row: there is no parent row with a value of supplier.supp_id that matches this new value of product.supp_id. product.supp_id is a foreign key that must match the value of supplier.supp_id for some row in the supplier table to maintain referential integrity.";
                    } else if ($errorInfo[0] == '23000' && $errorInfo[1] == '1062') {
                        $msg = $errorInfo[2] . ". Primary key (Product ID, Supplier ID) must be unique.";
                    } else {
                        $msg = $e->getMessage();
                    }
                    echo '<script type="text/javascript">';
                    echo 'alert("' . $msg . '");';
                    echo '</script>';
                }
            }
        }

        $stmt = $conn->query(
            "SELECT prod_id, prod_name, quantity, price, status, supp_name 
            FROM product JOIN supplier ON product.supp_id = supplier.supp_id"
        );
        include 'view/search.php';
    }
    ?>
</body>
</html>