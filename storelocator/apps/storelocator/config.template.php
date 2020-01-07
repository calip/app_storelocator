<?php
/**
 * storelocator - Config
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
<!-- {top_menu} -->
<schlix-config:data-editor data-schlix-controller="SCHLIX.CMS.storelocatorAdminController" type="config">

        <x-ui:schlix-config-save-result />
        <x-ui:schlix-editor-form id="form-edit-config" method="post" data-config-action="save" action="<?= $this->createFriendlyAdminURL('action=saveconfig') ?>" autocomplete="off">

            <schlix-config:action-buttons />
            <x-ui:csrf />

            <x-ui:schlix-tab-container>
                <!-- tab -->
                <x-ui:schlix-tab id="tab_general" fonticon="far fa-file" label="<?= ___('General') ?>"> 
                    <!--content -->
                        
                        <schlix-config:app_alias />
                        <schlix-config:app_description />
                        <schlix-config:checkbox config-key='bool_disable_app' label='<?= ___('Disable application') ?>' />
                        <!--config --> 
                        <schlix-config:textbox config-key='str_meta_keywords' label='<?= ___('Meta Keywords') ?>' />
                        <schlix-config:textbox config-key='str_meta_description' label='<?=  ___('Meta Description') ?>' />
                        <!-- end config -->
                    <!-- Example begins -->
                    <h3><?= ___('Example Config Options') ?></h3>
                    <schlix-config:textbox config-key='str_example_1' label='<?= ___('Textbox Example') ?>' />
                    <schlix-config:textarea config-key='str_example_2' label="<?= ___('Textarea Example') ?>" class='wysiwyg' />             
                    <schlix-config:textarea config-key='str_example_3' label="<?= ___('Non-WYSIWYG textarea example') ?>"  />             

                    <schlix-config:integerbox config-key='int_integerbox_example' config-default-value="1" min="1" max="200"  label='<?= ___('Integer box example with default value') ?>' />

                    <schlix-config:checkbox config-key='bool_checkbox_example' label='<?= ___('Checkbox Example') ?>' />

                    <schlix-config:dropdownlist class="form-control" config-key="str_option_select" label="<?= ___('Dropdown list example') ?>" >
                        <schlix-config:option value="0"><?= ___('Please select') ?></schlix-config:option>
                        <schlix-config:option value="<?= ___h('opt1') ?>"><?= ___h('Option 1') ?></schlix-config:option>
                        <schlix-config:option value="<?= ___h('opt2') ?>"><?= ___h('Option 2') ?></schlix-config:option>
                        <schlix-config:option value="<?= ___h('opt3') ?>"><?= ___h('Option 3') ?></schlix-config:option>
                    </schlix-config:dropdownlist> 

                    <schlix-config:radiogroup config-key="int_option_radio" label="<?= ('Radio group example') ?>">
                        <schlix-config:option value="1"><?= ___h('Option 1') ?></schlix-config:option>
                        <schlix-config:option value="2"><?= ___h('Option 2') ?></schlix-config:option>
                        <schlix-config:option value="3"><?= ___h('Option 3') ?></schlix-config:option>
                    </schlix-config:radiogroup>

                    <schlix-config:checkboxgroup config-key="int_option_checkbox" label="<?= ('Checkbox group example') ?>">
                        <schlix-config:option value="1"><?= ___h('Option 1') ?></schlix-config:option>
                        <schlix-config:option value="2"><?= ___h('Option 2') ?></schlix-config:option>
                        <schlix-config:option value="3"><?= ___h('Option 3') ?></schlix-config:option>
                    </schlix-config:checkboxgroup>    
                   <!-- Example Ends -->

                       <!-- Example Ends -->
                </x-ui:schlix-tab>
            <!-- tab -->
            <x-ui:schlix-tab id="tab_main_opt" fonticon="fa fa-newspaper" label="<?= ___('Default Main page Options') ?>"> 
                <!-- main page -->
                <x-ui:row>
                    <x-ui:column md="6">
                        <schlix-config:textbox config-key='str_mainpage_title' label='<?= ___('Main page title') ?>'   />                        
                        <schlix-config:textarea config-key='str_mainpage_text' label="<?= ___('Main page introduction text') ?>" class="wysiwyg" />
                    </x-ui:column>
                    <!-- col -->
                    <x-ui:column md="6">
                        <schlix-config:integerbox config-key='int_mainpage_items_per_page' config-default-value="10" label='<?= ___('Default maximum mumber of items to be displayed per page') ?>'   />
                        <schlix-config:main-page-meta-options config-key="array_mainpage_meta_options" item-per-column="5" column-count="1" />
                    </x-ui:column>
                </x-ui:row>

            </x-ui:schlix-tab>
            <!-- tab -->
            <x-ui:schlix-tab id="tab_item_opt" fonticon="fa fa-file-alt" label="<?= ___('Default Item Options') ?>"> 


                <schlix-config:item-meta-options config-key='array_default_item_meta_options' item-per-column="1" column-count="3" />
                <schlix-config:checkbox config-key='reset_item_options' label='<?= ___('Reset all item options') ?>' />
            </x-ui:schlix-tab>
            <!-- hooks -->
            <?= \SCHLIX\cmsHooks::output('getApplicationAdminExtraEditConfigTab', $this) ?>                       

            </x-ui:schlix-tab-container>
            
        </x-ui:schlix-editor-form>
</schlix-config:data-editor>      
