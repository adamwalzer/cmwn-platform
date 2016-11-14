<?php
use \Security\Authorization\Rbac;

return [
    'cmwn-roles' => [
        'permission_labels' => [
            // super
            'view.all.users'       => 'View all users',

            // user
            'create.user'          => 'Create a user',
            'view.user.adult'      => 'View an Adults Information',
            'view.user.child'      => 'View a child\'s Information',
            'edit.user.adult'      => 'Edit an Adult',
            'edit.user.child'      => 'Edit a Child',
            'pick.username'        => 'Pick a new User Name',
            'update.password'      => 'Update profile password',
            'remove.user.adult'    => 'Delete an Adult user',
            'remove.user.child'    => 'Delete a Child user',
            'can.friend'           => 'Can friend users',
            'view.feed'            => 'Can view feed',

            // Flip
            'create.user.flip'     => 'Earn a flip',
            'view.flip'            => 'View flip information',
            'view.user.flip'       => 'View Flips for a user',

            // group
            'create.child.group'   => 'Create a sub group',
            'create.group'         => 'Create a group',
            'view.group'           => 'View Group',
            'view.child.groups'    => 'View all the child groups from a parent',
            'view.user.groups'     => 'View Groups the user belongs too',
            'view.all.groups'      => 'View all Groups',
            'edit.group'           => 'Edit a Group',
            'import'               => 'Import Data file',
            'remove.child.group'   => 'Remove a child group',
            'remove.group'         => 'Remove a group',

            // user group
            'add.group.user'       => 'Add user to group',
            'remove.group.user'    => 'Remove user from group',
            'view.group.users'     => 'View Group users',

            // organizations
            'create.org'           => 'Create an Organization',
            'view.all.orgs'        => 'View all Organizations',
            'view.org'             => 'View an Organization',
            'view.user.orgs'       => 'View all Organizations the user belongs too',
            'view.org.users'       => 'View all users in an organization',
            'edit.org'             => 'Edit an Organization',
            'remove.org'           => 'Remove an Organization',

            // game
            'view.game-data'       => 'View Save Game Data of a game',
            'view.games'           => 'View all Games',
            'save.game'            => 'Save Game progress',

            // misc
            'adult.code'           => 'Send adult reset code',
            'child.code'           => 'Send child reset code',
            'attach.profile.image' => 'Upload a profile image',
            'view.profile.image'   => 'View a users profile image',
            'flag.image'           => 'Can flag images',
            'view.all.flagged.images'  => 'Can view all flagged images',
            'edit.flag'            => 'Edit flag',
            'delete.flag'          => 'delete flag',
            'view.flagged.image'   => 'view a flagged image using flag_id',


            // skribble
            'view.skribble'        => 'Read Skribbles',
            'create.skribble'      => 'Create Skribbles',
            'delete.skribble'      => 'Delete Skribbles',
            'update.skribble'      => 'Update Skribbles',
            'skribble.notice'      => 'Notify Skribble status',
        ],
        'roles'             => [
            'super' => [
                'entity_bits' => [
                    'group.district'        => -1,
                    'group.school'          => -1,
                    'group.class'           => -1,
                    'organization.district' => -1,
                    'organization.school'   => -1,
                    'organization.class'    => -1,
                    'adult'                 => -1,
                    'child'                 => -1,
                    'me'                    => -1,
                ],
                'permissions' => [
                    'add.group.user',
                    'adult.code',
                    'attach.profile.image',
                    'child.code',
                    'create.child.group',
                    'create.group',
                    'create.org',
                    'create.user',
                    'delete.flag',
                    'edit.group',
                    'edit.org',
                    'edit.user.adult',
                    'edit.user.child',
                    'flag.image',
                    'import',
                    'pick.username',
                    'remove.child.group',
                    'remove.group',
                    'remove.group.user',
                    'remove.org',
                    'remove.user.adult',
                    'remove.user.child',
                    'skribble.notice',
                    'update.password',
                    'view.all.flagged.images',
                    'view.all.groups',
                    'view.all.orgs',
                    'view.all.users',
                    'view.child.groups',
                    'view.flagged.image',
                    'view.flip',
                    'view.game-data',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.org.users',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                ],
            ],

            'admin.adult'       => [
                'entity_bits' => [
                    'group.school' => Rbac::SCOPE_UPDATE | Rbac::SCOPE_CREATE,
                    'group.class'  => Rbac::SCOPE_UPDATE | Rbac::SCOPE_CREATE,
                    'me'           => Rbac::SCOPE_UPDATE,
                    'child'        => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'adult'        => Rbac::SCOPE_REMOVE,
                ],
                'permissions' => [
                    'add.group.user',
                    'adult.code',
                    'child.code',
                    'create.child.group',
                    'create.group',
                    'edit.group',
                    'edit.user.adult',
                    'edit.user.child',
                    'import',
                    'remove.group.user',
                    'remove.user.adult',
                    'remove.user.child',
                    'view.child.groups',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.org.users',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                ],
            ],

            'principal.adult' => [
                'entity_bits' => [
                    'group.school' => Rbac::SCOPE_UPDATE,
                    'group.class'  => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'adult'        => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'child'        => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'me'           => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'add.group.user',
                    'adult.code',
                    'child.code',
                    'create.child.group',
                    'create.group',
                    'edit.group',
                    'edit.user.adult',
                    'edit.user.child',
                    'import',
                    'remove.group.user',
                    'remove.user.adult',
                    'remove.user.child',
                    'view.child.groups',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                ],
            ],

            'asst_principal.adult' => [
                'entity_bits' => [
                    'group.school' => Rbac::SCOPE_UPDATE,
                    'group.class'  => Rbac::SCOPE_UPDATE,
                    'adult'        => Rbac::SCOPE_REMOVE,
                    'child'        => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'me'           => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'add.group.user',
                    'adult.code',
                    'child.code',
                    'create.child.group',
                    'create.group',
                    'edit.group',
                    'edit.user.adult',
                    'edit.user.child',
                    'import',
                    'remove.group.user',
                    'remove.user.adult',
                    'remove.user.child',
                    'view.child.groups',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                ],
            ],

            'teacher.adult' => [
                'entity_bits' => [
                    'group.class' => Rbac::SCOPE_UPDATE,
                    'child'       => Rbac::SCOPE_UPDATE | Rbac::SCOPE_REMOVE,
                    'me'          => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'add.group.user',
                    'child.code',
                    'edit.group',
                    'edit.user.child',
                    'remove.group.user',
                    'remove.user.child',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                ],
            ],

            'neighbor.adult' => [
                'entity_bits' => [],
                'permissions' => [
                    'view.flip',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.flip',
                ],
            ],

            'me.child' => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'attach.profile.image',
                    'can.friend',
                    'create.skribble',
                    'create.user.flip',
                    'delete.skribble',
                    'edit.user.child',
                    'flag.image',
                    'pick.username',
                    'save.game',
                    'update.password',
                    'update.skribble',
                    'view.flip',
                    'view.games',
                    'view.profile.image',
                    'view.skribble',
                    'view.user.child',
                    'view.user.flip',
                    'view.user.groups',
                    'view.feed',
                ],
            ],

            'me.adult' => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'attach.profile.image',
                    'edit.user.adult',
                    'flag.image',
                    'save.game',
                    'update.password',
                    'view.flip',
                    'view.games',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.flip',
                    'view.user.groups',
                    'view.user.orgs',
                    'view.feed',
                ],
            ],

            'neighbor.child'    => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'can.friend',
                    'child.code',
                    'create.user.flip',
                    'pick.username',
                    'update.password',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.group.users',
                    'view.org',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                ],
            ],

            'student.child' => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'can.friend',
                    'view.flip',
                    'view.games',
                    'view.group',
                    'view.user.groups',
                    'view.group.users',
                    'view.profile.image',
                    'view.user.adult',
                    'view.user.child',
                    'view.user.flip',
                ],
            ],

            'logged_in.child' => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'view.games',
                    'view.flip',
                ],
            ],

            'logged_in.adult' => [
                'entity_bits' => [
                    'me' => Rbac::SCOPE_UPDATE,
                ],
                'permissions' => [
                    'view.games',
                    'view.flip',
                ],
            ],

            'guest' => [
            ],
        ],
    ],
];
