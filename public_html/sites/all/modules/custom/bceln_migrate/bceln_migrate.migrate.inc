<?php

/**
 * Implements hook_migrate_api().
 */
function bceln_migrate_migrate_api() {
  return [
    'api' => 2,
    'groups' => [
      'initial_csv' => [
        'title' => t('Initial import from CSV'),
        'default_format' => 'plain_text', // Default text format for all content migrations
      ],
    ],
    'migrations' => [
      'vendor_import' => [
        'class_name' => 'Bceln_Migrate_Node_Vendor',
        'description' => t('Import vendors'),
        'destination_type' => 'vendor',
        'default_uid' => Bceln_Migrate_Config::getDefaultUid(),
        'dependencies' => [],
        'group_name' => 'initial_csv',
      ],

      'organization_import' => [
        'class_name' => 'Bceln_Migrate_Node_Organization',
        'description' => t('Import organizations'),
        'destination_type' => 'organization',
        'default_uid' => Bceln_Migrate_Config::getDefaultUid(),
        'dependencies' => [],
        'group_name' => 'initial_csv',
      ],

      'resource_import' => [
        'class_name' => 'Bceln_Migrate_Node_Resource',
        'description' => t('Import resources'),
        'destination_type' => 'resource',
        'default_uid' => Bceln_Migrate_Config::getDefaultUid(),
        'dependencies' => [
          'vendor_import',
          'organization_import', // for field_organization_ref (via subscriptions.csv)
        ],
        'group_name' => 'initial_csv',
      ],

      'license_import' => [
        'class_name' => 'Bceln_Migrate_Node_License',
        'description' => t('Import licenses'),
        'destination_type' => 'license',
        'default_uid' => Bceln_Migrate_Config::getDefaultUid(),
        'dependencies' => [
          'resource_import',
        ],
        'group_name' => 'initial_csv',
      ],

      'user_import' => [
        'class_name' => 'Bceln_Migrate_User',
        'description' => t('Import users'),
        'dependencies' => [],
        'group_name' => 'initial_csv',
      ],

      'profile_import' => [
        'class_name' => 'Bceln_Migrate_Profile',
        'description' => t('Import user profiles'),
        'dependencies' => [
          'user_import',
          'organization_import',
        ],
        'group_name' => 'initial_csv',
      ],
    ],
  ];
}
