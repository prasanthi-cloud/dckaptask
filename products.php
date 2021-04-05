<?php
include 'functions.php';
include 'productslist.php';
$productlist = new Product;
$catid = isset($_GET['catid']) ? $_GET['catid'] : '';
if($catid){
	$products = $productlist->getProductsByCatId($catid);
}
else{
	$products = $productlist->getProducts();
}
 $total_products = count($products);
//echo "<pre>";
//print_r($productsByCatId);
?>
<?=template_header('Products')?>

<div class="products content-wrapper">
    <h1>Products</h1>
    <p><?=$total_products?> Products</p>
    <div class="products-wrapper">
        <?php foreach ($products as $product): ?>
        <a href="product.php?prodid=<?=$product['product_id']?>" class="product">
            <img src="images/<?=$product['product_image']?>" width="200" height="200" alt="<?=$product['product_name']?>">
            <span class="name"><?=$product['product_name']?></span>
            <span class="price">
                &dollar;<?=$product['product_price']?>
                
            </span>
        </a>
        <?php endforeach; ?>
    </div>
    
</div>

<?=template_footer()?>