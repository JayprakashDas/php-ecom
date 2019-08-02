<?php

if($connection){
    echo "connected";
}

function redirect($location){
    header("Location: $location");
}

function query($sql){
    global $connection;

    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED". mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}


//get products
function getproducts(){
    $query = query("SELECT * FROM products");

    confirm($query);

    while($row = fetch_array($query)){
        //HERADOC this below name is
       $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}"><img src="http://placehold.it/320x150" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                            <h4><a href="product.html">{$row['product_title']}</a>
                            </h4>
                            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            <a class="btn btn-primary" href="cart.php?add={$row['product_id']}">Add to cart</a>
                        </div>
                </div>
        </div>  

DELIMETER;

       echo $product;
    }
}

// get categories

function get_categories(){
    $query = query("SELECT * FROM categories");

    confirm($query);

    while($row = fetch_array($query)){
        //HERADOC this below name is
       $categories = <<<DELIMETER
       <a href="category.php?id={$row['cat_id']}" class='list-group-item'>{$row['cat_title']}</a> 

DELIMETER;

       echo $categories;
    }

}

//get products in ctegory page
function getproducts_in_cate_page(){
    $query = query("SELECT * FROM products WHERE product_category_id = ".escape_string($_GET['id']) ." ");

    confirm($query);

    while($row = fetch_array($query)){
        //HERADOC this below name is
       $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4"> 
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}"><img src="http://placehold.it/320x150" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                            <h4><a href="product.html">{$row['product_title']}</a>
                            </h4>
                            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            <a class="btn btn-primary" href="item.php">Add to cart</a>
                        </div>
                </div>
        </div>  

DELIMETER;

       echo $product;
    }
}

function shop_page(){
    $query = query("SELECT * FROM products");

    confirm($query);

    while($row = fetch_array($query)){
        //HERADOC this below name is
       $product = <<<DELIMETER
        <div class="col-sm-4 col-lg-4 col-md-4">
                <div class="thumbnail">
                    <a href="item.php?id={$row['product_id']}"><img src="http://placehold.it/320x150" alt=""></a>
                        <div class="caption">
                            <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                            <h4><a href="product.html">{$row['product_title']}</a>
                            </h4>
                            <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                            <a class="btn btn-primary" href="item.php">Add to cart</a>
                        </div>
                </div>
        </div>  

DELIMETER;

       echo $product;
    }
}

function login_user(){

    if(isset($_POST['submit'])){
       $username =  escape_string($_POST['username']);
       $password =  escape_string($_POST['password']);

       $query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");
        confirm($query);


        if(mysqli_num_rows($query) == 0){
            redirect('login.php');
            set_message("something wen wrong");
        } else {
            set_message("welcome {$username}");
            redirect("admin");
        }
    }  

}

function set_message($msg){

    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else{
        $msg = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function send_message(){
    if(isset($_POST['submit'])){
       $from_name =  $_POST['name'];
       $email =  $_POST['email'];
       $phone =  $_POST['phone'];
       $text =  $_POST['text'];
       $to = "dasjay084@gmail.com";

       $headers = "FROM : {$from_name} {$email} ";

       mail($to, $phone, $text, $headers );
    }
}