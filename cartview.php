<?php
session_start(); 

include 'functions.php';
include 'productslist.php';
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])){
	$product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
	$product = new Product;
	$product_details = $product->getProductByProdId($product_id);
	if ($product_details && $quantity > 0) {echo "in";
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
			echo "hi";
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
	echo "<pre>";
	print_r($_SESSION['cart']);
    // Prevent form resubmission...
    header('location: cartview.php');	
    exit;
}
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
   
	$values = array_keys($products_in_cart);
	$id='';
	 foreach($values as $value){
				  if($id){
				  $id.=','.$value;
			  }else{
				  $id = $value;
			  }
			  //echo $value;
			  
			  } 
			  
			  //echo $id;
    $where = 'product_id IN ('.$id.')';
	
	$product = new Product;
	$products = $product->getCartProducts($where);
	 foreach ($products as $product) {
        $subtotal += (float)$product['product_price'] * (int)$products_in_cart[$product['product_id']];
    }
	//echo "<pre>";
	//print_r($products);
	
	
}
?> 
<?=template_header('Cart')?>

<div class="cart content-wrapper">
    <h1>Shopping Cart</h1>
    <form action="placeorder.php" method="post">
        <table>
            <thead>
                <tr>
                    <td colspan="2">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
                <?php else: ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td class="img">
                        <a href="product.php?id=<?=$product['id']?>">
                            <img src="images/<?=$product['product_image']?>" width="50" height="50" alt="<?=$product['product_name']?>">
                        </a>
                    </td>
                    <td>
                        <a href="product.php?id=<?=$product['product_id']?>"><?=$product['product_name']?></a>
                        <br>
                        
                    </td>
                    <td class="price">&dollar;<?=$product['product_price']?></td>
                    <td class="quantity">
                        <input type="number" name="quantity-<?=$product['product_id']?>" value="<?=$products_in_cart[$product['product_id']]?>" min="1" max="<?=$product['quantity']?>" placeholder="Quantity" required>
                    </td>
                    <td class="price">&dollar;<?=$product['product_price'] * $products_in_cart[$product['product_id']]?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
			
			<input type="hidden" name="productsid" value="<?=$id?>">
			<input type="hidden" name="subtotal" value="<?=$subtotal?>">
            <span class="price">&dollar;<?=$subtotal?></span>
        </div>
        <div class="buttons">
            
            <input type="submit" value="Place Order" name="placeorder">
        </div>
    </form>
</div>

<?=template_footer()?>
