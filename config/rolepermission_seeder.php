<?php

return [
  /**
  * Control if the seeder should create a user per role while seeding the data.
  */
  'create_users' => env('LARATRUST_CREATE_USERS', false),

  /**
  * Control if all the laratrust tables should be truncated before running the seeder.
  */
  'truncate_tables' => env('LARATRUST_TRUNCATE_TABLES', false),

  /**
  * Control if all the laratrust pivot tables should be truncated before running the seeder.
  */
  'truncate_pivot_tables' => env('LARATRUST_TRUNCATE_PIVOT_TABLES', false),

  /**
  * Control if default roles other than Admin should be created after seeding.
  */
  'seed_default_roles' => env('LARATRUST_SEED_DEFAULT_ROLES', false),

  'roles_structure' => [
    'Admin' => [
      'User Management' => [
        'access_user_management',

        'create_user',
        'view_user',
        'update_user',
        'delete_user',

        'create_role',
        'view_role',
        'update_role',
        'delete_role',
        'view_permission',
        'update_permission',
        'assign_role',
        'assign_permission',

        'view_login_activity',
        'view_activity_trail',
        'generate_user_management_reports',
      ],

      'Result Management' => [
        'access_results',
        'review_results',
        'retain_results',
        'release_results',
        'recall_results',
        'revoke_results',
        'export_results_csv',
      ],

      'Sample Management' => [
        'access_samples',
        'receive_samples',
        'reject_samples',
        'accession_samples',
        'archive_samples',
        'export_samples_csv',
      ],

      'BioRepository' => [
        'access_biorepository',
        'export_bio_repository_csv',
        ],

        'Manage Utilities' => [
        'access_utilities',
        'export_utilities_csv',
      ],

      'Dashboard & Reports' => [
        'access_general_dashboard',
        'generate_genral_reports',
        ],
      ],
    //
    //   'Results QC' => [
    //
    //     'Manage Results' => [
    //     'access_results',
    //     'review_results',
    //     'retain_results',
    //     'release_results',
    //     'recall_results',
    //     'revoke_results',
    //   ],
    //   'Dashboard & Reports' => [
    //     'access_general_dashboard',
    //     'generate_genral_reports',
    //   ],
    // ],
    //
    //   'Sample Reception' => [
    //
    //   'Manage Samples' => [
    //     'access_samples',
    //     'receive_samples',
    //     'reject_samples',
    //     'accession_samples',
    //     'archive_samples',
    //   ],
    //
    //   'Manage Bio Repository' => [
    //     'access_biorepository',
    //   ],
    // ],
    //
    //   'Bio Repository' => [
    //
    //   'Manage Bio Repository' => [
    //     'access_biorepository',
    //   ],
    // ],

      ],

        //Configure Default Roles and Permissions
        'default_roles' => [
        'Default User' => [
        'access_samples'
      ],
    ],
  ];
