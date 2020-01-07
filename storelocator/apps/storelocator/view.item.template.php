<?php
/**
 * storelocator - View Item template
 * 
 * Store Locator is a powerful and easy to use location management system. You can customize the appearance of the map, and provide custom labels for entry fields.
 * 
 * @copyright 2019 calip
 *
 * @license MIT
 *
 * @package storelocator
 * @version 1.0
 * @author  Alip <asalip.putra@gmail.com>
 * @link    https://github.com/calip/app_storelocator
 */
if (!defined('SCHLIX_VERSION'))
    die('No Access');
?>
<div class="app-page-item app-<?= $this->app_name; ?>" >
    <h1><span itemprop="name"><?= ___h($item['title']); ?></span></h1>
</div>