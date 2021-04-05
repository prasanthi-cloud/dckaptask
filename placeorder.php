<?php
session_start(); 

include 'functions.php';
include 'Order.php';
if(isset($_POST['placeorder'])){
	$_SESSION['products'] = $_POST['productsid'];
	$_SESSION['paid_amount'] = $_POST['subtotal'];
}
if(isset($_POST['submit'])&& $_POST['submit']!=''){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$addr = $_POST['addr'];
	$pay_mod = $_POST['pay_mod'];
	$rows = 'name,email,phone,address,payment_mode,products,paid_amount';
	$cust_details = array($name,$email,$phone,$addr,$pay_mod,$_SESSION['products'],$_SESSION['paid_amount']);
	
	echo "<pre>";
	print_r($cust_details);
	$order = new Orders;
	$order->insertOrder('orders',$cust_details,$rows);
	
	header('location: success.php');
exit;	
}

?>
<?=template_header('Cart')?>
<div class="cust content-wrapper">
 <h1>Customer Details</h1>
 <table>
 <tbody>
 <form action="placeorder.php" method="post">
 <tr>
 <td>Name:</td>
 <td align="left"><input type="text" name="name"></td>
 </tr>
 <tr>
 <td>Email:</td>
 <td><input type="text" name="email"></td>
 </tr>
 <tr>
 <td>Phone:</td>
 <td><input type="number" name="phone"></td>
 </tr>
 <tr>
 <td>Address:</td>
 <td><input type="text" name="addr"></td>
 </tr>
 <tr>
 <td>Payment mode:</td>
 <td><input type="text" name="pay_mod">
 <input type="hidden" name="products" value="<?=$_SESSION['products']?>">
 <input type="hidden" name="paid_amount" value="<?=$_SESSION['paid_amount']?>">
 </td>
 </tr>
 </tbody>
 </table>
 <div class="buttons">
            <input type="submit" value="Submit" name="submit">
        </div>
 
  </form>
 
</div>
<?=template_footer()?>