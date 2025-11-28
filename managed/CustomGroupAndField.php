<?php
// managed/CustomGroupAndField.php
declare(strict_types = 1); 

use CRM_Core_DAO_CustomGroup as CustomGroup;
use CRM_Core_DAO_CustomField as CustomField;

return [
  // 1. CUSTOM GROUP DEFINITION
  [
    'name' => 'limit_event_by_group_custom_group',
    'entity' => 'CustomGroup',
    'params' => [
      'name' => 'Limit_Event_Group_Settings',
      'title' => 'Limit Event Registration by Group', 
      'extends' => 'Event', 
      'is_active' => 1,
      'version' => 3, 
      // --- ADDED MATCH ---
      'match' => ['name'], 
    ],
  ],

  // 2. CUSTOM FIELD DEFINITION
  [
    'name' => 'limit_event_by_group_custom_field',
    'entity' => 'CustomField',
    'params' => [
      'custom_group_id' => 'Limit_Event_Group_Settings', 
      'label' => 'Required Contact Group for Registration', 
      'data_type' => 'EntityReference', 
      'html_type' => 'Select', 
      'is_active' => 1,
      'is_searchable' => 0,
      'is_view' => 0,
      'weight' => 1,
      'column_name' => 'limit_group_id', 
      'entity_reference_to' => 'Group', 
      'version' => 3,
      // --- ADDED MATCH ---
      'match' => ['name', 'custom_group_id'], 
    ],
  ],
];