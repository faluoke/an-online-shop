<?php
session_start();
include 'header.php';
require 'dblogin.php';
$product_ids = array();
if (isset($_SESSION['signed_in']) == true) {

    if (filter_input(INPUT_POST, 'submit')) {
        if (isset($_SESSION['cart'])) {
            $count = count($_SESSION['cart']);

            $product_ids = array_column($_SESSION['cart'], 'id');

            if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)) {
                $_SESSION['cart'][$count] = array(
                    'id' => filter_input(INPUT_GET, 'id'),
                    'name' => filter_input(INPUT_POST, 'item'),
                    'cost' => filter_input(INPUT_POST, 'cost'),
                    'quantity' => filter_input(INPUT_POST, 'quantity')
                );
            } else {
                for ($i = 0; $i < count($product_ids); $i++) {
                    if ($product_ids[$i] == filter_input(INPUT_GET, 'id')) {
                        $_SESSION['cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                    }
                }
            }
        } else { // if cart doesn't exist, create first product with array 0
            //create array using submtted form data
            $_SESSION['cart'][0] = array(
                'id' => filter_input(INPUT_GET, 'id'),
                'name' => filter_input(INPUT_POST, 'item'),
                'cost' => filter_input(INPUT_POST, 'cost'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );
        }
    }

    if (filter_input(INPUT_GET, 'action') == 'delete') {
        // loop through shopping cart
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['id'] == filter_input(INPUT_GET, 'id')) {
                unset($_SESSION['cart'][$key]);
            }
        }
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
} else {
    header('Location: ../index.php?status=notsignedin');
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="../css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Rajdhani" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="cart_container">
            <div clothes_container>
                <?php
                $sql = 'SELECT * FROM cart ORDER by id ASC';
                $result = mysqli_query($db_server, $sql);

                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="clothes">'
                            . '<form action="shop.php?action=add&id=' . $row['id'] . '" method="POST">'
                            . '<img src="' . $row['itemImage'] . '">'
                            . '<p>' . $row['item'] . '</p>'
                            . '<input type="hidden" name="item" value="' . $row['item'] . '">'
                            . '<p>$ ' . $row['cost'] . '</p>'
                            . '<input type="hidden" name="cost" value="' . $row['cost'] . '">'
                            . '<input type="number" name="quantity" value="0" placeholder="Quantity">'
                            . '<input type="submit" name="submit" value="ADD TO BAG">'
                            . '<p>' . $row['itemDesc'] . '</p>'
                            . '</form>'
                            . '</div>';
                        }
                    }
                }
                ?>
            </div>
            <table class="table">
                <tr><td><h3>Order Details</h3></td></tr>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <?php
                if (!empty($_SESSION['cart'])) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $key => $product) {
                        echo '<tr>'
                        . '<td>' . $product['name'] . '</td>'
                        . '<td>' . $product['quantity'] . '</td>'
                        . '<td>$ ' . $product['cost'] . '</td>'
                        . '<td>$ ' . number_format($product['quantity'] * $product['cost'], 2) . '</td>'
                        . '<td><a href="shop.php?action=delete&id=' . $product['id'] . '">Remove</a></td>'
                        . '</tr>';
                        $total = $total + ($product['quantity'] * $product['cost']);
                    }
                    echo '<tr>'
                    . '<td colspan="4" align="right">Total: </td>'
                    . '<td align="right">' . number_format($total, 2) . '</td></tr>';
                }
                if (isset($_SESSION['cart'])) {
                    if (count($_SESSION['cart']) > 0) {
                        echo '<tr>'
                        . '<td colspan="5"><button class="button">Checkout</button></td>'
                        . '</tr>';
                    }
                }
                ?>
            </table>
        </div>
    </body>
</html>
