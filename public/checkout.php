<?php require_once("../resources/config.php")?>
<?php include(TEMPLATE_FRONT .DS. "header.php")?> 



<?php

if(isset( $_SESSION['product_1'])){
    echo $_SESSION['product_1'];
};
 

?>

<h4><?php echo display_message();?></h4>



    <!-- Page Content -->
 <div class="container">


<!-- /.row --> 

<div class="row">

      <h1>Checkout</h1>


<form  action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_cart">
  <input type="hidden" name="business" value="jaydasb@gmail.com">
  <input type="hidden" name="upload" value="1">
  <!-- <input type="hidden" name="business" value="dasjay084@gmail.com"> -->
  <!-- <in put type="hidden" name="at" value="YourIdentityToken"> -->
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
           <?php cart()?>
        </tbody> 
    </table>
    <?Php if(isset($_SESSION['item_quantity'])){
        $value = $_SESSION['item_quantity'];
        if($value>0){
          echo "<input type='submit' value='Buy Now' name='PayPal'>";
        }
        
      }?>
    
</form>




<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity']: $_SESSION['item_quantity']= "0" ?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">&#36;<?php echo isset($_SESSION['item_total']) ? $_SESSION['item_total']: $_SESSION['item_total']= "0" ?></span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->

 <?php include(TEMPLATE_FRONT .DS. "footer.php")?>