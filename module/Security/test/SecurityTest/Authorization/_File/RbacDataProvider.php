<?php

return [
    'Super Admin' => [
        'role'    => 'super',
        'allowed' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.user',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
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
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
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

        'denied' => [
            'can.friend',
            'create.skribble',
            'create.user.flip',
            'delete.skribble',
            'save.game',
            'update.skribble',
            'view.feed',
            'view.skribble',
        ],
    ],

    'Admin'       => [
        'role'    => 'admin.adult',
        'allowed' => [
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

        'denied' => [
            'attach.profile.image',
            'can.friend',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.org',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.org',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.skribble',
        ],
    ],

    // deprecated role
    'Group Admin' => [
        'role'    => 'group_admin.adult',
        'allowed' => [
            'add.group.user',
            'child.code',
            'edit.group',
            'edit.user.child',
            'remove.group.user',
            'remove.user.adult',
            'remove.user.child',
            'view.group',
            'view.group.users',
            'view.org.users',
            'view.profile.image',
            'view.user.adult',
            'view.user.child',
            'view.user.groups',
            'view.user.orgs',
        ],

        'denied' => [
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.org',
            'edit.user.adult',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.org',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.flip',
            'view.games',
            'view.org',
            'view.skribble',
            'view.user.flip',
        ],
    ],

    'Principal' => [
        'role'    => 'principal.adult',
        'allowed' => [
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

        'denied' => [
            'attach.profile.image',
            'can.friend',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.org',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.org',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.org.users',
            'view.skribble',
        ],
    ],

    'Assistant Principal' => [
        'role'    => 'asst_principal.adult',
        'allowed' => [
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

        'denied' => [
            'attach.profile.image',
            'can.friend',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.org',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.org',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.org.users',
            'view.skribble',
        ],
    ],

    'Teacher' => [
        'role'    => 'teacher.adult',
        'allowed' => [
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
            'view.org.users',
            'view.profile.image',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
            'view.user.groups',
            'view.user.orgs',
        ],

        'denied' => [
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.org',
            'edit.user.adult',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.org',
            'remove.user.adult',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.skribble',
        ],
    ],

    'Neighbor' => [
        'role'    => 'neighbor.adult',
        'allowed' => [
            'view.flip',
            'view.profile.image',
            'view.user.adult',
            'view.user.flip',
        ],

        'denied' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.games',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.skribble',
            'view.user.child',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],

    'Me (Child)' => [
        'role'    => 'me.child',
        'allowed' => [
            'attach.profile.image',
            'can.friend',
            'create.skribble',
            'create.user.flip',
            'delete.skribble',
            'edit.user.child',
            'pick.username',
            'save.game',
            'update.password',
            'update.skribble',
            'view.feed',
            'view.flip',
            'view.games',
            'view.profile.image',
            'view.skribble',
            'view.user.child',
            'view.user.flip',
            'view.user.groups',
        ],
        'denied'  => [
            'add.group.user',
            'adult.code',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.user',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'import',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'skribble.notice',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.child.groups',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.user.adult',
            'view.user.orgs',
        ],
    ],

    'Me (Adult)' => [
        'role'    => 'me.adult',
        'allowed' => [
            'attach.profile.image',
            'edit.user.adult',
            'save.game',
            'update.password',
            'view.feed',
            'view.flip',
            'view.games',
            'view.profile.image',
            'view.user.adult',
            'view.user.flip',
            'view.user.groups',
            'view.user.orgs',
        ],
        'denied'  => [
            'add.group.user',
            'adult.code',
            'can.friend',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'skribble.notice',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.child.groups',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.skribble',
            'view.user.child',
        ],
    ],

    'Child' => [
        'role'    => 'child',
        'allowed' => [
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
            'view.org.users',
            'view.profile.image',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
        ],

        'denied' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.skribble',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],

    'Student' => [
        'role'    => 'student.child',
        'allowed' => [
            'can.friend',
            'view.flip',
            'view.games',
            'view.group',
            'view.group.users',
            'view.profile.image',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
        ],

        'denied' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.org',
            'view.org.users',
            'view.skribble',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],

    'Logged In child' => [
        'role'    => 'logged_in.child',
        'allowed' => [
            'view.flip',
            'view.games',
        ],

        'denied' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.profile.image',
            'view.skribble',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],

    'Logged In Adult' => [
        'role'    => 'logged_in.adult',
        'allowed' => [
            'view.flip',
            'view.games',
        ],
        'denied'  => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.profile.image',
            'view.skribble',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],

    'Guest' => [
        'role'    => 'guest',
        'allowed' => [

        ],

        'denied' => [
            'add.group.user',
            'adult.code',
            'attach.profile.image',
            'can.friend',
            'child.code',
            'create.child.group',
            'create.group',
            'create.org',
            'create.skribble',
            'create.user',
            'create.user.flip',
            'delete.skribble',
            'edit.group',
            'edit.org',
            'edit.user.adult',
            'edit.user.child',
            'import',
            'pick.username',
            'remove.child.group',
            'remove.group',
            'remove.group.user',
            'remove.org',
            'remove.user.adult',
            'remove.user.child',
            'save.game',
            'skribble.notice',
            'update.password',
            'update.skribble',
            'view.all.groups',
            'view.all.orgs',
            'view.all.users',
            'view.feed',
            'view.child.groups',
            'view.flip',
            'view.games',
            'view.group',
            'view.group.users',
            'view.org',
            'view.org.users',
            'view.profile.image',
            'view.skribble',
            'view.user.adult',
            'view.user.child',
            'view.user.flip',
            'view.user.groups',
            'view.user.orgs',
        ],
    ],
];
