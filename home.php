<?php
session_start();
// Include functions and connect to the database using PDO MySQL
include 'functions.php';
// Page is set to home (home.php) by default, so when the visitor visits that will be the page they see.
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
// Include and show the requested page
//include $page . '.php';
include 'categorylist.php';
$catObj = new Category;
$categories = $catObj->getCategories();
//echo "<pre>";
//print_r($categories);
?>

<?=template_header('Categories')?>
<div class="featured">
    <h2>Categories</h2>
</div>
<div class="recentlyadded content-wrapper">
    <h2>Categories</h2>
    <div class="products">
        <?php foreach ($categories as $category): ?>
        <a href="products.php?catid=<?=$category['category_id']?>" class="product">
            
            <span class="name"><?=$category['category_name']?></span>
            
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?=template_footer()?>