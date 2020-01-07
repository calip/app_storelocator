<?php
/**
 * storelocator - Edit Item Template (Admin)
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

global $HTMLHeader, $CurrentUser;
if ($id == 'new') {
    $item['permission_read'] = serialize('everyone');
    $header_title = ___('New Item');
 } else {
    $id = (int) $id;
    $preview_link = $this->app->createFriendlyURL("action=viewitem&id={$id}");
    $header_title = ___('Edit Item').' #'.___h($id);
}

$HTMLHeader->CSS_EXTERNAL('https://map.schlix.website/1/leaflet.css','all');
$HTMLHeader->CSS_EXTERNAL('https://map.schlix.website/1/Control.Geocoder.css','all');
$HTMLHeader->JAVASCRIPT_EXTERNAL('https://map.schlix.website/1/leaflet.js');
$HTMLHeader->JAVASCRIPT_EXTERNAL('https://map.schlix.website/1/Control.Geocoder.js');
/** quick fix **/
if ((int) $item['map_zoom'] == 0)
    $item['map_zoom'] = 17;

?>
<!-- {top_menu} -->
<x-ui:schlix-item-editor  data-type-desc="<?= ___('item') ?>" data-schlix-controller="SCHLIX.CMS.storelocatorAdminController">    
        
        <x-ui:schlix-editor-form id="form-edit-item" method="post" admin-action="saveitem">
            <x-ui:csrf id="_csrftoken" />
            <x-ui:hidden id="id" name="id" data-field="id" />
            <x-ui:hidden id="category_id" data-field="category_id" name="category_id" />
            <x-ui:hidden id="guid" data-field="guid" name="guid" />
            <x-ui:schlix-editor-top-row>    
                <x-ui:schlix-editor-top-left>
                    <!-- Page Title -->
                     <x-ui:schlix-document-title id="title" maxlength="255"  required="required"  data-field="title" table-type="item" />
                    <!-- Virtual Filename -->
                    <x-ui:schlix-document-virtual-filename id="virtual_filename" data-field="virtual_filename" />
                    
                </x-ui:schlix-editor-top-left>
                <x-ui:schlix-editor-top-right>
                    <x-ui:schlix-editor-action-buttons />
                </x-ui:schlix-editor-top-right>            
            </x-ui:schlix-editor-top-row>

            <!-- main -->
            <x-ui:clearboth />
            
            <x-ui:schlix-document-save-result />
            <!-- end main section -->
            <!-- begin tabs -->
            <x-ui:schlix-tab-container>
                <!-- tab -->
                <x-ui:schlix-tab id="tab_content" fonticon="far fa-address-card" label="<?= ___('Content') ?>">                     
                    <x-ui:row>
                        <x-ui:column md="6">
                            <!-- content -->
                                <x-ui:textbox label="<?= ___('Store Name'); ?>" id="store" name="store" data-field="store" />                            
                                <x-ui:textbox label="<?= ___('PO Box'); ?>"  id="pobox" name="pobox"  data-field="pobox" />
                                <x-ui:textbox label="<?= ___('Street Address'); ?>"  name="street" id="street"  data-field="street" />
                                <x-ui:textbox label="<?= ___('City'); ?>"  id="city" name="city" data-field="city" />
                                <x-ui:textbox label="<?= ___('Province/State'); ?>"  name="province" id="province" data-field="province" />
                                <x-ui:textbox label="<?= ___('Postal/Zip Code'); ?>"  name="postal" id="postal" data-field="postal" />
                                <x-ui:textbox label="<?= ___('Country'); ?>"  id="country" name="country" data-field="country" />
                            
                            <!-- end content -->
                        </x-ui:column>
                        <x-ui:column md="6">
                            <!-- content -->
                                <x-ui:textbox label="<?= ___('Phone'); ?>"  id="phone" name="phone" data-field="phone" />
                                <x-ui:textbox label="<?= ___('Fax'); ?>"  id="fax" name="fax" data-field="fax" />
                                <x-ui:textbox label="<?= ___('Mobile'); ?>"  id="mobile" name="mobile"  data-field="mobile"  />
                            <!-- end content -->
                        </x-ui:column>
                    </x-ui:row> 
                </x-ui:schlix-tab>
                <!-- tab -->
                <x-ui:schlix-tab id="tab_map" fonticon="fas fa-map-marker-alt" label="<?= ___('Map') ?>">
                    <!-- map -->
                    <x-ui:row>
                        <x-ui:column sm="4" md="2">
                            
                            <x-ui:textbox type="number" id="map_zoom"  name="map_zoom" data-field="map_zoom" label="<?= ___('Zoom Level'); ?>" />
                            <x-ui:textbox id="latitude"  name="latitude" data-field="latitude" label="<?= ___('Latitude'); ?>" />
                            <x-ui:textbox id="longitude"  name="longitude" data-field="longitude" label="<?= ___('Longitude'); ?>" />                            
                            <!-- field -->
                            <?php /*<p><?= ___('Display map in the contact form'); ?>
                                <x-ui:radio name="display_map" data-field="display_map" id="display_map_yes" value="1" required="required" label="<?= ___('Yes') ?>" />
                                <x-ui:radio name="display_map" data-field="display_map" id="display_map_no" value="0" required="required" label="<?= ___('No') ?>"  />                                    
                            </p>*/ ?>
                            <x-ui:checkbox name="display_map" data-field="display_map" value="1" label="<?= ___('Display map in the contact form') ?>" />
                            <hr />
                            <a id="btn_update_map" class="btn btn-info" href="javascript:void(0)"><i class="fas fa-sync"></i> <?= ___('Update') ?></a> 
                            <hr />
                            
                        </x-ui:column>
                        <!-- column -->
                        <x-ui:column sm="8" md="10">
                            
                            <div id="map_canvas" style="width:100%;height:400px" >

                            </div>                    
                            <p><?= ___('Click the Update Location button above to get the latitude and longitude of the place by *street address*. You can move and drag or double click the marker around to reflect a more accurate location.'); ?></p>
                    <p><?= ___('Note: Width and Height of the map display on the frontend must be set from your own template CSS!') ?></p>

                        </x-ui:column>
                    </x-ui:row>

                    <!-- end map -->
                </x-ui:schlix-tab>
                <x-ui:schlix-tab id="tab_meta" fonticon="fa fa-hashtag" label="<?= ___('Meta') ?>">    
                    <x-ui:textbox id="meta_description" name="meta_description"  data-field="meta_description" label="<?= ___('Meta Description') ?>" />
                    <x-ui:tagbox id="meta_key" name="meta_key" data-field="meta_key" label="<?= ___('Meta Keywords') ?>" />
                    <x-ui:tagbox id="tags" name="tags" data-field="tags" label="<?= ___('Tags') ?>" />
                </x-ui:schlix-tab>
                <!-- tab -->
                <x-ui:schlix-tab id="tab_dates" fonticon="far fa-calendar" label="<?= ___('Dates') ?>"> 
                    
                    <x-ui:schlix-datetime-picker id="date_created" data-field="date_created" label="<?= ___('Created') ?>" />
                    <x-ui:schlix-datetime-picker id="date_modified" data-field="date_modified" label="<?= ___('Modified') ?>" />
                    <x-ui:schlix-datetime-picker id="date_available" name="date_available" data-field="date_available" label="<?= ___('Available on') ?>" />
                    <x-ui:schlix-datetime-picker id="date_expiry" name="date_expiry" data-field="date_expiry" label="<?= ___('Expiry') ?>" />
                    
                </x-ui:schlix-tab>
                <!-- tab -->
                <x-ui:schlix-tab id="tab_options" fonticon="fa fa-sliders-h" label="<?= ___('Options') ?>">
                    <x-ui:schlix-editor-item-meta-options name="options" data-field="options" max-item-per-column="1" column="3" />
                </x-ui:schlix-tab>
                <!-- hooks -->
                <?= \SCHLIX\cmsHooks::output('getApplicationAdminExtraEditItemTab', $this, $item) ?>
            </x-ui:schlix-tab-container>            
            <!-- end tabs -->
        </x-ui:schlix-editor-form>
</x-ui:schlix-item-editor> 