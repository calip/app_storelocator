<?php
namespace App;

/**
 * storelocator - Admin class
 * 
 * Store Locator is a powerful and easy to use location management system. You can customize the appearance of the map, and provide custom labels for entry fields.
 *
 * @copyright 2019 calip
 *
 * @license MIT
 *
 * @version 1.0
 * @package storelocator
 * @author  Alip <asalip.putra@gmail.com>
 * @link    https://github.com/calip/app_storelocator
 */
class storelocator_Admin extends \SCHLIX\cmsAdmin_List {

    /**
     * Constructor
     * @global \SCHLIX\cmsDatabase $SystemDB
     */    
    public function __construct() {
        global $SystemDB;
        
        // Data: Item
        parent::__construct(true, array());
        // You can enable more items here                
        $this->setItemFieldNamesForAjaxListing('id', 'virtual_filename', 'title',  'date_created', 'date_modified','status','sort_order');
    }
    
    /**
     * Modify data before save item
     * @global \App\Users $CurrentUser
     * @param array $datavalues
     * @return array
     */
    public function onModifyDataBeforeSaveItem($datavalues) {
        global $CurrentUser;
        
        $datavalues = parent::onModifyDataBeforeSaveItem($datavalues);
        
        $current_admin_id = $CurrentUser->getCurrentUserID();
        $field_admin_id = ($datavalues['id'] == 'new') ? 'created_by_id' : 'modified_by_id';
        $datavalues[$field_admin_id] = intval($datavalues[$field_admin_id]);
        if (!($datavalues[$field_admin_id] > 0 && $datavalues[$field_admin_id] != $current_admin_id))
            $datavalues[$field_admin_id] = $current_admin_id;
        $datavalues['virtual_filename'] = convert_into_sef_friendly_title($datavalues['virtual_filename'], true);
        if (empty($datavalues['meta_description']))
            $datavalues['meta_description'] = $datavalues['title'];
        if (empty($datavalues['virtual_filename']) || ($datavalues['virtual_filename'] == 'index'))
            $datavalues['virtual_filename'] = 'item' . $datavalues[$this->field_id];

        $datavalues['options'] = serialize($datavalues['options']);
        $datavalues['featured'] = intval($datavalues['featured']);

        
        return $datavalues;
    }
    
}
