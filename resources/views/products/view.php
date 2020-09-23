<?php $this->extends('layouts/products'); ?>
<h1>Product</h1>
<p>
    This is the product page for <?php print $parameters['product']; ?>.
    <?php print $this->escape($scary); ?>
</p>
