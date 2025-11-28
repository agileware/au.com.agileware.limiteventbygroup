<?php
/**
 * Implements hook_civicrm_install().
 *
 * This hook is called when the extension is installed.
 */
function limiteventbygroup_civicrm_install(): void {
  // Use the API to ensure the Custom Group exists
  $groupParams = [
    'name' => 'Limit_Event_Group_Settings',
    'title' => 'Limit Event Registration by Group',
    'extends' => 'Event',
    'is_active' => 1,
  ];
  $group = civicrm_api3('CustomGroup', 'create', $groupParams);
  
  // Get the ID of the newly created Custom Group
  $custom_group_id = $group['id'];

  // Use the API to create the Custom Field (Entity Reference to Group)
  $fieldParams = [
    'custom_group_id' => $custom_group_id,
    'label' => 'Required Contact Group for Registration',
    'data_type' => 'EntityReference',
    'html_type' => 'Select',
    // Correct parameter: Use entity_reference_contact_type for 'Group' entity
    'entity_reference_contact_type' => 'Group', 
    'column_name' => 'limit_group_id',
    'is_active' => 1,
    'note_help' => 'Select a Contact Group. Only contacts belonging to this group can register for this event.',
  ];

  civicrm_api3('CustomField', 'create', $fieldParams);
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * It is good practice to clean up custom data upon uninstall.
 */
function limiteventbygroup_civicrm_uninstall(): void {
  // Find the Custom Group and delete it and its associated fields.
  $group = civicrm_api3('CustomGroup', 'get', [
    'name' => 'Limit_Event_Group_Settings',
    'sequential' => 1,
  ]);
  
  if (!empty($group['id'])) {
    civicrm_api3('CustomGroup', 'delete', ['id' => $group['id']]);
  }
}