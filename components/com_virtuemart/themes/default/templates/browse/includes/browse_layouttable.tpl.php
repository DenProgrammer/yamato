<?php
if (!defined('_VALID_MOS') && !defined('_JEXEC'))
    die('Direct Access to ' . basename(__FILE__) . ' is not allowed.');
mm_showMyFileName(__FILE__);
?>
<div class="brdcrambs" >
    <a href="index.php">Каталог</a> / 
    <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=<?php echo JRequest::getInt('Itemid'); ?>"><?php echo $category_name; ?></a>
    <?php if ($category_id == 17 && (isset($_GET['marka']))) { ?>
        / <a href="index.php?option=com_virtuemart&page=shop.browse&category_id=<?php echo $category_id; ?>&Itemid=<?php echo JRequest::getInt('Itemid'); ?>&marka=<?php echo $_GET['marka']; ?>"><?php echo $_GET['marka']; ?></a>
    <?php } ?>
    <?php
    if (isset($referer['model']) && isset($referer['cm']) && isset($referer['rul'])) {
        echo "<a style='float:right;' href='$ref'>Вернутся к результатам поиска</a>";
    }
    ?>
</div>

<?php echo $buttons_header // The PDF, Email and Print buttons ?>
<?php echo $browsepage_header // The heading, the category description ?>
<?php echo $parameter_form // The Parameter search form  ?>
<?php echo $orderby_form // The sort-by, order-byF form PLUS top page navigation  ?>

<?php
$data    = array(); // Holds the rows of products
$i       = 1;
$row     = 0; // Counters
$percent = 100;
if (JRequest::getVar('Itemid') == 29) {
    jimport('joomla.application.module.helper');
    $mods = JModuleHelper::getModule('calctyres');

    echo JModuleHelper::renderModule($mods);
    $percent = 74;
}
if (JRequest::getVar('Itemid') == 27) {
    jimport('joomla.application.module.helper');
    $mods = JModuleHelper::getModule('calcaccumulators');

    echo JModuleHelper::renderModule($mods);
    $percent = 74;
}

foreach ($products as $product) {

    foreach ($product as $attr => $val) {
        // Using this we make all the variables available in the template
        // translated example: $this->set( 'product_name', $product_name );
        $this->set($attr, $val);
    }

    // Parse the product template (usually 'browse_x') for each product
    // and store it in our $data array 
    $data[$row][] = $this->fetch('browse/' . $templatefile . '.php');

    // Start a new row ?
    if (($i % $products_per_row) == 0) {
        $row++;
    }
    $i++;
}

if (count($products) == 0) {
    echo JText::_('PRODUCTS_NOT_FOUND');
}
// Creates a new HTML_Table object that will help us
// to build a table holding all the products
$table = new HTML_Table('width="' . $percent . '%"');

// Loop through each row and build the table
foreach ($data as $key => $value) {
    $table->addRow($data[$key]);
}
// Display the table
echo $table->toHtml();
?>
<br class="clr" />
<?php echo $browsepage_footer ?>
<?php
// Show Featured Products
if ($this->get_cfg('showFeatured', 1)) {
    /* featuredproducts(random, no_of_products,category_based) no_of_products 0 = all else numeric amount
      edit featuredproduct.tpl.php to edit layout */
    echo $ps_product->featuredProducts(true, 10, true);
}
?>
<?php echo $recent_products ?>
