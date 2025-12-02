<?php
use CRM_Limiteventbygroup_ExtensionUtil as E;


return [
  [
    'name' => 'CustomGroup_Limit_Event',
    'entity' => 'CustomGroup',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'Limit_Event',
        'title' => E::ts('Limit Event'), 
        'extends' => 'Event',
        'weight' => 4,
        'collapse_adv_display' => TRUE,
        'is_active' => TRUE,
      ],
            'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'CustomGroup_Limit_Event_CustomField_Limit_Event_Group',
    'entity' => 'CustomField',
    'cleanup' => 'never',
    'update' => 'always',
    'params' => [
      'version' => 4,
      'values' => [
        'custom_group_id.name' => 'Limit_Event',
        'name' => 'Limit_Event_Group',
        'label' => E::ts('Limit Event Group'),
        'data_type' => 'EntityReference',
        'html_type' => 'Autocomplete-Select',
        'is_searchable' => TRUE,
        'text_length' => 255,
        'note_columns' => 60,
        'note_rows' => 4,
        'column_name' => 'Limit_Event_Group_3',
        'fk_entity' => 'Group',
        'is_active' => TRUE,
      ],
      'match' => [
        'name',
        'custom_group_id',
      ],
    ],
  ],
];