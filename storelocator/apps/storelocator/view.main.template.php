<?php
/**
 * storelocator - Main page template. Lists all items. 
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
if (!defined('SCHLIX_VERSION')) die('No Access');

global $HTMLHeader;
$HTMLHeader->JAVASCRIPT_SCHLIX_UI();
$this->CSS('storelocator.css');
$this->JAVASCRIPT('storelocator.js');
$str_mainpage_title =  $this->getConfig('str_mainpage_title') ? $this->getConfig('str_mainpage_title') : $this->getApplicationDescription();
$str_mainpage_text =  $this->getConfig('str_mainpage_text');

$location = array('street'=>'addressStreet','city'=>'addressLocality','province'=>'addressRegion','postal'=>'postalCode','country'=>'addressCountry');
$stores = array();
foreach ($items as $child_item){
    if ($child_item['status'] > 0) {
        $place_no_html = [];
        foreach ($location as $element => $element_type)
            if ($child_item[$element])
                $place_no_html[] = $child_item[$element];
        $place_combined = implode(', ', $place_no_html);
        array_push($stores, [$child_item["store"], $place_combined, (float) $child_item["latitude"], (float) $child_item["longitude"]]);
    }
}
$store_locations = json_encode($stores);
$HTMLHeader->CSS_EXTERNAL('https://map.schlix.website/1/leaflet.css','all');
$HTMLHeader->JAVASCRIPT_EXTERNAL('https://map.schlix.website/1/leaflet.js');
?>
<div class="app-page-main app-<?= $this->app_name; ?>" id="app-<?= $this->app_name; ?>-main">
    <h1 class="main title"><?= ___h($str_mainpage_title) ?></h1>
    
    <div class="row mt-lg-5 mb-lg-5">
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4>">
            <ul class="list-group">
                <?php foreach ($items as $child_item): ?>
                    <?php $place_no_html = [];
                        foreach ($location as $element => $element_type)
                            if ($child_item[$element])
                                $place_no_html[] = $child_item[$element];
                        $place_combined = implode(', ', $place_no_html);
                    ?>
                    <?php if ($child_item['status'] > 0): ?>      
                        <li class="list-group-item" onclick="javascript:onStoreLocationClick(<?= ___h($child_item['latitude']); ?>, <?= ___h($child_item['longitude']); ?>);"><strong><?= ___h($child_item['store']); ?></strong><br /> <?= ___h($place_combined); ?></li>
                    <?php endif ?>
                <?php endforeach ?>    
            </ul>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="stores_info_map" id="store_map_canvas" ></div>
            <meta itemprop="stores" content="<?= ___h($store_locations) ?>" id="stores" />
        </div>
    </div>

</div>