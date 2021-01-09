<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/icon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/731265dcbb.js"></script>
    <title>Update</title>
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
                <a class="nav-link" href="shop.php" title="Shop">
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
                <a class="nav-link active" href="update.php" title="Update">
                    <span class="d-inline d-sm-none"><i class="fas fa-edit h4"></i></span>
                    <span class="d-none d-sm-inline">Update</span>
                </a>
            </li>
        </ul>
    </nav>

    <article>
        <div class="container text-lightgray">
            <h1>Update</h1>
            <hr>
            <p>
                Need to correct a description or simply update stock? Fill out the form here.
                If you're not changing any information, simply leave those fields blank.
            </p>
            <hr>
            <div class="container">
                <form class="form-darkgray" action="update.php" method="POST" id="form">
                    <div class="form-group row">
                        <label class="form-control col-sm-5 col-md-4 col-lg-3" for="NameOld">Current Product Name: </label>
                        <div class="col">
                            <input class="form-control" type="text" name="NameOld" maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-control col-sm-5 col-md-4 col-lg-3" for="Name">New Product Name: </label>
                        <div class="col">
                            <input class="form-control" type="text" name="Name" maxlength="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-control col-sm-5 col-md-4 col-lg-3" for="URL">New Image URL: </label>
                        <div class="col">
                            <input class="form-control" type="text" name="URL" maxlength="256">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-control col-12" for="Description">New Product Description: </label>
                        <textarea class="form-control col-12" name="Description" maxlength="1024"></textarea>
                    </div>
                    <div class="form-group row">
                        <label class="form-control col-sm-5 col-md-4 col-lg-3" for="Price">New Selling Price: </label>
                        <div class="col">
                            <input class="form-control" type="number" name="Price" min="0.01" max="10000" step="0.01">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="form-control col-sm-5 col-md-4 col-lg-3" for="Stock">Updated Stock: </label>
                        <div class="col">
                            <input class="form-control" type="number" name="Stock" min="0" max="1000">
                        </div>
                    </div>
                    <div class="form-group row">
                        <input class="form-control col-4 col-sm-2" type="button" value="Preview" onClick="preview()">
                        <input class="form-control col-4 col-sm-2" type="submit" value="Submit">
                    </div>
                </form>
            </div>

            <?php
                if (isset($_POST['NameOld']) && strlen($_POST['NameOld']) != 0) {
                    $pw = base64_decode('Vmlld1NvbmljMzg0');
                    $db = new mysqli("localhost", "300083663", $pw, "db300083663");
                    unset($pw);
                    
                    $nameOld = $_POST['NameOld'];
                    $query = $db->prepare('SELECT URL, Description, Price, QtyInStock FROM CIS245_ProductList WHERE Name=?');
                    $query->bind_param("s", $nameOld);
                    $query->execute();
                    $result = $query->get_result();
                    $query->close();
                    if ($result->num_rows == 1) {
                        $oldVars = $result->fetch_all(MYSQL_ASSOC);
                        $name = $_POST['Name'];
                        $url = $_POST['URL'];
                        $desc = $_POST['Description'];
                        $price = $_POST['Price'];
                        $stock = $_POST['Stock'];

                        if (strlen($name) == 0) {
                            $name = $nameOld;
                        }
                        if (strlen($url) == 0) {
                            $url = $oldVars[0]['URL'];
                        }
                        if (strlen($desc) == 0) {
                            $desc = $oldVars[0]['Description'];
                        }
                        if (strlen($price) == 0) {
                            $price = $oldVars[0]['Price'];
                        } else {
                            $price *= 100;
                        }
                        if (strlen($stock) == 0) {
                            $stock = $oldVars[0]['QtyInStock'];
                        }
                        $time = date("Y-m-d H:i:s");
                        $query = $db->prepare('UPDATE CIS245_ProductList SET Name=?, URL=?, Description=?, Price=?, QtyInStock=?, Updated=? WHERE Name=?');
                        if ($query === false) {
                            echo var_dump($query);
                        }
                        $query->bind_param("sssiiss", $name, $url, $desc, $price, $stock, $time, $nameOld);
                        $query->execute();
                        $query->close();
                        $query = $db->prepare('SELECT Name FROM CIS245_ProductList WHERE Name=?');
                        $query->bind_param("s", $name);
                        $query->execute();
                        $result = $query->get_result();
                        $query->close();
                        if ($result === false) {
                            echo '<p class="dberror">';
                            echo 'Internal server error. Please try again later.';
                            echo '</p>';
                        } else {
                            echo '<p>';
                            echo 'Submission successful.';
                            echo '</p>';
                        }
                    } else {
                        echo '<p class="dberror">';
                        echo 'That name does not exist in the database!';
                        echo '</p>';
                    }
                    $db->close();
                }
            ?>

            <script src="js/preview.js"></script>
            <div id="previewCard" style="display: none">
                <hr>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-lg-3 p-0">
                        <div class="card card-darkgray">
                            <div class="card-body">
                                <h3 class="card-title" id="previewName"></h3>
                                <div class="text-center">
                                    <img src="" id="previewURL">
                                </div>
                                <br>
                                <p class="card-text" id="previewDesc"></p>
                                <hr>
                                <p class="card-text" id="previewOther"></p>
                                <input type="submit" value="Buy" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </article>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>