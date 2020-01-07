<?php
namespace App;
/**
 * storelocator - Main Class
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
class storelocator extends \SCHLIX\cmsApplication_List {

    /**
     * Constructor
     * @global \SCHLIX\cmsDatabase $SystemDB
     */
    public function __construct() {
        global $SystemDB;
        
        parent::__construct("storelocator", 'app_storelocator_items');
        /* You can modify this  */
        $this->has_versioning = true; // set to false if you don't need versioning capability if this app wants versioning enabled
        $this->disable_frontend_runtime = false; //  set this to true if this is a backend only app         
        
    }

    /**
     * View Main Page
     * @param int $pg
     * @return boolean
     */
    //_______________________________________________________________________________________________________________//
    public function viewMainPage($pg = 1) {

        // Set Page Title
        $str_page_title = $this->getConfig('str_mainpage_title', true);
        $pg = intval($pg);
        if ($pg > 1)
            $str_page_title.=' - '.___('Page').' '.$pg;
        $this->setPageTitle($str_page_title);
        // Set Max Posts per page
        $max_posts_perpage = $this->getConfig('int_mainpage_items_per_page', 10);
        $main_meta_options =  $this->translateMetaOptions($this->getConfig('array_mainpage_meta_options'));
        
        if ($max_posts_perpage == 0)
            $max_posts_perpage = 10;
        // Set total item count
        $total_item_count = $this->getTotalItemCount('status > 0');
        if ($max_posts_perpage * $pg > $total_item_count + $max_posts_perpage) {
            display_http_error(404);
            return false;
        }
        // Set Pagination
        $pagination = $this->getStartAndEndForItemPagination($pg, $max_posts_perpage, $total_item_count);
        $sort_by = $main_meta_options['items_sortby'] ?  $main_meta_options['items_sortby'] : 'date_created';
        $sort_dir = $main_meta_options['items_sortdirection'] ?  $main_meta_options['items_sortdirection'] : 'DESC';

        // Get Items to display
        $items = $this->getAllItems('*', 'status > 0', $pagination['start'], $pagination['end'], $sort_by, $sort_dir);
        $this->declarePageLastModified($this->getMaxDateFromArray($items));
        // Get main page meta options
        
        $local_variables = compact(array_keys(get_defined_vars()));
        $this->loadTemplateFile('view.main', $local_variables);
    }
    

    //_______________________________________________________________________________________________________________//
    public function getMainPageMetaOptionKeys() {
        return array(
          array('value' => 'display_error_no_access', 'label' => ___('Display errors for inaccesible item')),
          array('value' => 'display_items', 'label' => ___('Display list of items')),
          array('value' => 'display_item_summary', 'label' => ___('Display item\'s summary')),
          array('value' => 'display_item_created_by', 'label' => ___('Display item\'s created by')),
          array('value' => 'display_item_date_created', 'label' => ___('Display item\'s date created')),
          array('value' => 'display_item_date_modified', 'label' => ___('Display item\'s date modified')),
          array('value' => 'display_item_read_more_link', 'label' => ___('Display item\'s "Read More" link')),
          array('value' => 'display_item_view_count', 'label' => ___('Display item\'s view count')) 
        );
    }
       
    
    /**
     * Validates save item. If there's an error, it will return an array
     * with one or more error string, otherwise it will return a boolean true
     * @global \App\Users $CurrentUser
     * @param array $datavalues
     * @return bool|array String array
     */
    public function getValidationErrorListBeforeSaveItem($datavalues)
    {
        $parent_error_list = parent::getValidationErrorListBeforeSaveItem($datavalues);
        $error_list = array();
        // You can put custom item save validation here
        // e.g. 
        // if (str_contains($datavalues['title'],'a'))
        // $error_list[] = ___('Title may not contain letter a');
        return array_merge($parent_error_list, $error_list);
    }

    /**
     * Before save item
     * @param array $datavalues
     * @return array
     */
    protected function modifyDataValuesBeforeSaveItem($datavalues) {
        $datavalues = parent::modifyDataValuesBeforeSaveItem($datavalues);
        // You can customize the data values before it's saved here
        // e.g.
        // $datavalues['title'] = real_strip_tags($datavalues['title']);
        //
        return $datavalues;
    }
    
    /**
     * Do something after save item
     * @param array $datavalues
     * @param array $original_datavalues
     * @param array $previous_item
     * @param array $retval
     */
    protected function onAfterSaveItem($datavalues, $original_datavalues, $previous_item, $retval)
    {
        parent::onAfterSaveItem($datavalues, $original_datavalues, $previous_item, $retval);
    }



    /**
     * Run Command
     * @param array $command
     * @return boolean
     */
    public function Run($command) {
        //$this->insertTest();
        switch ($command['action']) {
            case 'main': $this->viewMainPage($command['pg']);
                return true;
                break;
            default: return parent::Run($command);
        }
    }



}
