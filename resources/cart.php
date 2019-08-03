<?php require_once("config.php")?>

<?php 

if(isset($_GET['add'])){
    $id = $_GET['add'];
    $query = query("SELECT * FROM products WHERE product_id =  '$id' ");
    confirm($query);

    while($row = fetch_array($query)){


        if($row['product_quantity'] != $_SESSION['product_'.$_GET['add']]){
            $_SESSION['product_'.$_GET['add']] +=1; 
                redirect('../public/checkout.php');
        }else{
            redirect('../public/checkout.php');
            set_message("we only have". $row['product_quantity']);

        }

    }
    // $_SESSION['product_'.$_GET['add']] +=1;

    // redirect('index.php');

}

if(isset($_GET['remove'])){
    $_SESSION['product_'.$_GET['remove']]--;
    if($_SESSION['product_'.$_GET['remove']]<1){
        unset($_SESSION['item_total']);
        unset($_SESSION['item_quantity']);
        redirect("../public/checkout.php");
    }else{
       
        redirect("../public/checkout.php");
    }
}

if(isset($_GET['delete'])){
    $_SESSION['product_'.$_GET['delete']]='0';

    unset($_SESSION['item_total']);
    unset($_SESSION['item_quantity']);

    redirect("../public/checkout.php");
}


function cart(){
    $total = 0;
    $item_quantity = 0;
    $item_name = 1;
    $item_number =1;
    $amount = 1;
    $quantity =1;
    foreach($_SESSION as $name => $value){

        if($value>0) {

            if(substr($name, 0 , 8 ) == "product_"){

                $length = strlen((int)$name - 8);
                // $length = (int)$length;
                $id = substr($name, 8 , $length);

                $query = query("SELECT * FROM products WHERE product_id = $id ");
                confirm($query);
    
            while($row = fetch_array($query)){

                $sub= $row['product_price']*$value;
                $item_quantity +=$value;
                $product = <<<DELIMETER
                <tr>
                <td>{$row['product_title']}</td>
                <td>{$row['product_price']}</td>
                <td>{$value}</td>
                <td>&#36;{$sub}</td>
                <td>
                    <a class='btn btn-warning' href="../resources/cart.php?remove={$row['product_id']}"><span class='glyphicon glyphicon-minus'></span></a>
                    <a class='btn btn-success' href="../resources/cart.php?add={$row['product_id']}"><span class='glyphicon glyphicon-plus'></span></a>
                    
                    <a class='btn btn-danger' href="../resources/cart.php?delete={$row['product_id']}"><span class='glyphicon glyphicon-remove'></span></a>
                </td>
                
                </tr>
                <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                <input type="hidden" name="amount_{$amount}" value="{$row['product_price']}">
                <input type="hidden" name="quantity_{$quantity}" value="{$value}">
DELIMETER;
    
         echo $product;

         $item_name++;
        $item_number++;
        $amount++;
        $quantity++;
            }
        $_SESSION['item_total']=$total +=$sub;
        $_SESSION['item_quantity']=$item_quantity;
            }
        }

       
    }

    
}

function report(){


    if(isset($_GET['tx'])){
        $amount =  $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];

        



        $total = 0;
        $item_quantity = 0;

        foreach($_SESSION as $name => $value){

            if($value>0) {

                if(substr($name, 0 , 8 ) == "product_"){

                    $length = strlen((int)$name - 8);
                    // $length = (int)$length;
                    $id = substr($name, 8 , $length);

                    $order_query = query("INSERT INTO orders (order_amount, order_transaction,order_status, order_currency)
                    VALUES('{$amount}','{$transaction}','{$status}','{$currency}')");

                    $last_id = last_id();
                    echo $last_id;
                    
                    confirm($order_query);


                    $query = query("SELECT * FROM products WHERE product_id = $id ");
                    confirm($query);
        
                    while($row = fetch_array($query)){

                    $sub= $row['product_price']*$value;
                    $item_quantity +=$value;
                    $product_price = $row['product_price'];
                    $product_title = $row['product_title'];

                    $report_query = query("INSERT INTO report (product_id, product_price, product_quantity, order_id,product_title)
                    VALUES('{$id}','{$product_price}','{$value}','{$last_id}','{$product_title}')");
                }
                    $total +=$sub;
                    echo $item_quantity;
            }
        }
    }
       session_destroy();
    }
    else{
            redirect('index.php');
        }

    
}


?> 