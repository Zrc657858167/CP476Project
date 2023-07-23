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
<h1>CP476 Group Project</h1>

<!-- Search supplier form -->
<form action="index.php" method="POST">
    <input type="text" name="supp_id" placeholder="Supplier ID" maxlength=4>
    <input type="text" name="supp_name" placeholder="Supplier name" maxlength=35>
    <input type="text" name="address" placeholder="Address" maxlength=35>
    <input type="tel" name="phone" placeholder="Phone" maxlength=20>
    <input type="email" name="email" placeholder="Email" maxlength=254>
    <input type="submit" value="Search supplier table">
    <input type="hidden" name="action" value="supp_searched">
</form>

<!--Search product form -->
<form action="index.php" method="POST">
    <input type="text" name="prod_id" placeholder="Product ID" maxlength=4>
    <input type="text" name="prod_name" placeholder="Product name" maxlength=20>
    <input type="text" name="description" placeholder="Description" maxlength=35>
    <input type="number" name="price" placeholder="Price" step=0.01 max=9999.99 min=-9999.99>
    <input type="number" name="quantity" placeholder="Quantity" max=65535 min=0>
    <input type="text" name="status" placeholder="Status" maxlength=1>
    <input type="text" name="supp_id" placeholder="Supplier ID" maxlength=4>
    <input type="submit" value="Search product table">
    <input type="hidden" name="action" value="prod_searched">
</form>

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
    // $stmt comes index.php, which is the file that includes this one
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