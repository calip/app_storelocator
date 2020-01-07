<?php
/**
 * storelocator - Main admin view template
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
if (!defined('SCHLIX_VERSION')) die();
?>
<!-- {top_menu} -->
<x-ui:schlix-data-explorer-list data-schlix-controller="SCHLIX.CMS.storelocatorAdminController" data-enable-preview-link="true" data-default-item-icon="fa fa-map-marker fa-2x">
    <!-- Toolbar -->
    <x-ui:schlix-explorer-toolbar>
        <x-ui:schlix-explorer-toolbar-menu data-position="left">    
            <x-ui:schlix-explorer-menu-command data-schlix-command="new-item" data-schlix-app-action="newitem"   fonticon="fa fa-map-marker" label="<?= ___('New Store') ?>" />
            <x-ui:schlix-explorer-menu-command data-schlix-command="copy" require-selected-items="1" fonticon="fa fa-copy" label="<?= ___('Copy') ?>" />
            <x-ui:schlix-explorer-menu-command data-schlix-command="paste" require-clipboard-items="1" fonticon="far fa-clipboard" label="<?= ___('Paste') ?>" />
            <x-ui:schlix-explorer-menu-command data-schlix-command="delete" require-selected-items="1" fonticon="far fa-trash-alt" label="<?= ___('Delete') ?>" />
            <x-ui:schlix-explorer-menu-command data-schlix-command="refresh"  fonticon="fas fa-sync" label="<?= ___('Refresh') ?>" />
            <!-- {config} -->
            <?php /* optional 
            <x-ui:schlix-explorer-menu-folder fonticon="fa fa-gears" label="<?= ___('Configuration') ?>">
                <x-ui:schlix-explorer-menu-command data-schlix-command="config" data-schlix-app-action="editconfig"  fonticon="fas fa-cog" label="<?= ___('Default Settings') ?>" />
                <x-ui:schlix-explorer-menu-command data-schlix-command="custom-table-config" data-custom-table="app_storelocator_items" fonticon="fas fa-terminal" label="<?= ___('Custom table fields: Item') ?>" />
                <x-ui:schlix-explorer-menu-command data-schlix-command="custom-table-config" data-custom-table="app_storelocator_categories"  fonticon="fas fa-terminal" label="<?= ___('Custom table fields: Category') ?>" />
            </x-ui:schlix-explorer-menu-folder> */ ?>            
            <!-- {end config -->
            <?= \SCHLIX\cmsHooks::output('getApplicationAdminExtraToolbarMenuItem', $this) ?>
        </x-ui:schlix-explorer-toolbar-menu>
        <x-ui:schlix-explorer-toolbar-search />
        <!-- {help-about} -->
        <x-ui:schlix-explorer-toolbar-menu data-position="right">
            <x-ui:schlix-explorer-menu-folder fonticon="fa fa-question-circle" label="<?= ___('Help') ?>">
                <x-ui:schlix-explorer-menu-command data-schlix-command="help-about" data-schlix-app-action="help-about" fonticon="fas fas-cog" label="<?= ___('About') ?>" />
            </x-ui:schlix-explorer-menu-folder>
        </x-ui:schlix-explorer-toolbar-menu>
        <!-- {end help-about} -->

    </x-ui:schlix-explorer-toolbar>
    <!-- breadcrumb -->
    <x-ui:schlix-explorer-breadcrumb />        
    <!-- data viewer -->        
    <x-ui:schlix-explorer-row>
        <!-- Right Column -->
        <x-ui:schlix-explorer-right-column>
            <!-- datatable -->
            <x-ui:schlix-data-table schlix-id="datanav-datatable" data-default-sort-by="id" data-default-sort-direction="desc">
                <x-ui:schlix-data-table-columns>
                    <x-ui:schlix-data-table-column key="check" label="this.getSelectAllCheckboxTableHeader()" formatter="SCHLIX.CMS.storelocatorAdminController.formatDataTableCell_CheckBox" sortable="false" />
                    <x-ui:schlix-data-table-column key="this.field_item_title" sortable="true" label="<?= ___('Title') ?>" formatter="this.formatDataTableCell_DefaultTitleColumn" />
                    <x-ui:schlix-data-table-column key="this.field_id" hidden="true" sortable="false" formatter="number" />
                    <x-ui:schlix-data-table-column key="status" label="<?= ___('Status') ?>" sortable="true" formatter="this.formatDataTableCell_Status" editor="new SCHLIX.UI.DropdownCellEditor({dropdownOptions:[{value:0, label: 'Inactive'}, {value:1, label: 'Active'} ],disableBtns:false})" />

                    <x-ui:schlix-data-table-column key="sort_order" label="<?= ___('Sort Order') ?>" sortable="true" formatter="number" editor="new SCHLIX.UI.TextboxCellEditor({validator:SCHLIX.UI.DataTable.validateNumber,disableBtns:false})" />

                    <x-ui:schlix-data-table-column key="date_created" label='<?= ___('Date Created') ?>' sortable="true" formatter="this.formatDataTableCell_Date" editor="new SCHLIX.CMS.DateCellEditor({disableBtns:false})" />
                    <x-ui:schlix-data-table-column key="date_modified" label='<?= ___('Date Modified') ?>' sortable="true" formatter="this.formatDataTableCell_Date" editor= "new SCHLIX.CMS.DateCellEditor({disableBtns:false})" />
                </x-ui:schlix-data-table-columns>
            </x-ui:schlix-data-table>
            <!-- pagination -->
            <x-ui:schlix-explorer-pagination />
            <!-- end column -->
        </x-ui:schlix-explorer-right-column>
    </x-ui:schlix-explorer-row>
    <!-- End Data Viewer -->
</x-ui:schlix-data-explorer-list>