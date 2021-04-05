<?php
include 'functions.php';
include 'productslist.php';
$product = new Product;
$prodid = isset($_GET['prodid']) ? $_GET['prodid'] : '';
$product_details = $product->getProductByProdId($prodid);
//echo "<pre>";
//print_r($product_details);
?>
<?=template_header('Product')?>

<div class="product content-wrapper">
    <img src="images/<?=$product_details['product_image']?>" width="500" height="500" alt="<?=$product_details['product_name']?>">
    <div>
        <h1 class="name"><?=$product_details['product_name']?></h1>
        <span class="price">
            &dollar;<?=$product_details['product_price']?>
            
        </span>
        <form action="cartview.php" method="post">
            <input type="number" name="quantity" value="1" min="1" max="<?=$product_details['quantity']?>" placeholder="Quantity" required>
            <input type="hidden" name="product_id" value="<?=$product_details['product_id']?>">
            <input type="submit" value="Add To Cart">
        </form>
        <div class="description">
            <?=$product_details['product_desc']?>
			<?php=$product_details['product_code'];?>
        </div>
    </div>
</div>

<?=template_footer()?>