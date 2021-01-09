<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/731265dcbb.js"></script>
    <title>Shop</title>
</head>

<body>
    
    <nav class="navbar navbar-expand navbar-darkgray bg-darkgreen sticky-top">
        <a class="navbar-brand" href="index.php" title="Dakota's Store">
            <span class="d-none d-sm-inline">Dakota's Store</span>
        </a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php" title="Home">
                    <span class="d-inline d-sm-none"><i class="fas fa-home h4"></i></span>
                    <span class="d-none d-sm-inline">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="shop.php" title="Shop">
                    <span class="d-inline d-sm-none"><i class="fas fa-shopping-cart h4"></i></span>
                    <span class="d-none d-sm-inline">Shop</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="sell.php" title="Sell">
                    <span class="d-inline d-sm-none"><i class="fas fa-dollar-sign h4"></i></span>
                    <span class="d-none d-sm-inline">Sell</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="update.php" title="Update">
                    <span class="d-inline d-sm-none"><i class="fas fa-edit h4"></i></span>
                    <span class="d-none d-sm-inline">Update</span>
                </a>
            </li>
        </ul>
    </nav>

    <article>
        <div class="container text-lightgray">

            <h1>Shop</h1>
            <hr>
            <p>
                Here you can view everything that has been listed for sale.
            </p>
            <hr>

            <?php
                $pw = base64_decode('Vmlld1NvbmljMzg0');
                $db = new mysqli("localhost", "300083663", $pw, "db300083663");
                unset($pw);

                if (isset($_POST['Name'])) {
                    $name = $_POST['Name'];
                    $query = $db->prepare('SELECT QtyInStock, QtySold FROM CIS245_ProductList WHERE Name=?');
                    $query->bind_param("s", $name);
                    $query->execute();
                    $result = $query->get_result();
                    $arr = $result->fetch_all(MYSQL_ASSOC);
                    $stock = $arr[0]['QtyInStock'];
                    $sold = $arr[0]['QtySold'];
                    $query->close();
                    if ($stock > 0) {
                        $stock -= 1;
                        $sold += 1;
                        $query = $db->prepare('UPDATE CIS245_ProductList SET QtyInStock=?, QtySold=? WHERE Name=?');
                        $query->bind_param("iis", $stock, $sold, $name);
                        $query->execute();
                        $query->close();
                    }
                }

                $query = 'SELECT * FROM CIS245_ProductList';
                $result = $db->query($query);
                $db->close();

                if ($result === false) {
                    echo '<p class="dberror">';
                    echo 'Internal server error. Please try again later.';
                    echo '</p>';
                } else {
                    $arr = $result->fetch_all(MYSQL_ASSOC);
                    echo '<div class="row">';
                    foreach ($arr as $item) {
                        echo '<div class="col-sm-6 col-md-4 col-lg-3 p-0">';
                        echo '<div class="card card-darkgray">';
                        echo '<div class="card-body">';
                        echo '<h3 class="card-title">';
                        echo $item['Name'];
                        echo '</h3>';
                        echo '<div class="text-center">';
                        echo '<img src="'.$item['URL'].'">';
                        echo '</div>';
                        echo '<br>';
                        echo '<p class="card-text">';
                        echo $item['Description'];
                        echo '</p>';
                        echo '<hr>';
                        echo '<p class="card-text">';
                        echo 'Price: $' . $item['Price'] / 100.0;
                        echo '<br>';
                        echo 'Stock: ' . $item['QtyInStock'];
                        echo '<br>';
                        echo 'Number Sold: ' . $item['QtySold'];
                        echo '</p>';
                        echo '<form action="shop.php" method="POST">';
                        echo '<input type="hidden" name="Name" value="'.$item['Name'].'">';
                        $disabled = $item['QtyInStock'] > 0 ? "" : "disabled";
                        echo '<input type="submit" value="Buy" '.$disabled.'>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                }
            ?>

        </div>
    </article>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>