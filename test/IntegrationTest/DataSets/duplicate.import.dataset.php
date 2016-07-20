<?php

return [
    'flips'         => [],
    'organizations' => [
        0 => [
            'org_id'      => 'district',
            'title'       => 'Gina\'s District',
            'description' => null,
            'meta'        => null,
            'created'     => '2016-04-27 10:48:44',
            'updated'     => '2016-04-27 10:48:46',
            'deleted'     => null,
            'type'        => 'district',
        ],
        1 => [
            'org_id'      => 'm-o-m',
            'title'       => 'Ministry of Magic',
            'description' => null,
            'meta'        => null,
            'created'     => '2016-04-27 10:48:44',
            'updated'     => '2016-04-27 10:48:46',
            'deleted'     => null,
            'type'        => 'district',
        ],
    ],
    'games'         => [],
    'groups'        => [
        [
            'group_id'        => 'school',
            'organization_id' => 'district',
            'title'           => 'Gina\'s School',
            'description'     => null,
            'meta'            => null,
            'head'            => '1',
            'tail'            => '6',
            'created'         => '2016-04-15 15:46:07',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'school',
            'external_id'     => null,
            'parent_id'       => null,
            'depth'           => '0',
        ],
        [
            'group_id'        => 'hogwarts',
            'organization_id' => 'm-o-m',
            'title'           => 'Hogwarts',
            'description'     => null,
            'meta'            => null,
            'head'            => '1',
            'tail'            => '2',
            'created'         => '2016-04-15 15:46:07',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'school',
            'external_id'     => null,
            'parent_id'       => null,
            'depth'           => '0',
        ],
        [
            'group_id'        => 'english',
            'organization_id' => 'district',
            'title'           => 'English Class',
            'description'     => null,
            'meta'            => null,
            'head'            => '4',
            'tail'            => '5',
            'created'         => '2016-04-15 15:47:02',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'class',
            'external_id'     => null,
            'parent_id'       => 'school',
            'depth'           => '123',
        ],
        [
            'group_id'        => 'math',
            'organization_id' => 'district',
            'title'           => 'Math Class',
            'description'     => null,
            'meta'            => null,
            'head'            => '2',
            'tail'            => '3',
            'created'         => '2016-04-15 15:46:03',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'class',
            'external_id'     => null,
            'parent_id'       => 'school',
            'depth'           => '456',
        ],
    ],
    'images'        => [],
    'names'         => [],
    'user_flips'    => [],
    'users'         => [
        [
            'user_id'      => 'english_student',
            'username'     => 'english_student',
            'email'        => 'english_student@ginasink.com',
            'code'         => null,
            'type'         => 'CHILD',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'John',
            'middle_name'  => 'D',
            'last_name'    => 'Yoder',
            'gender'       => 'M',
            'meta'         => null,
            'birthdate'    => '2016-04-15 11:58:15',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => '0001',
        ],
        [
            'user_id'      => 'english_teacher',
            'username'     => 'english_teacher',
            'email'        => 'english_teacher@ginasink.com',
            'code'         => null,
            'type'         => 'ADULT',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'Angelot',
            'middle_name'  => 'M',
            'last_name'    => 'Fredickson',
            'gender'       => 'M',
            'meta'         => '[]',
            'birthdate'    => '2016-04-15 00:00:00',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => null,
        ],
        [
            'user_id'      => 'math_student',
            'username'     => 'math_student',
            'email'        => 'math_student@ginasink.com',
            'code'         => null,
            'type'         => 'CHILD',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'WILLIS',
            'middle_name'  => 'C',
            'last_name'    => 'KELSEY',
            'gender'       => 'M',
            'meta'         => null,
            'birthdate'    => '2016-04-15 11:50:47',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => '0002',
        ],
        [
            'user_id'      => 'math_teacher',
            'username'     => 'math_teacher',
            'email'        => 'math_teacher@ginasink.com',
            'code'         => null,
            'type'         => 'ADULT',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'William',
            'middle_name'  => 'T',
            'last_name'    => 'West',
            'gender'       => 'M',
            'meta'         => null,
            'birthdate'    => '2016-04-15 11:50:05',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => null,
        ],
        [
            'user_id'      => 'other_principal',
            'username'     => 'other_principal',
            'email'        => 'other_principal@manchuck.com',
            'code'         => null,
            'type'         => 'ADULT', // questionable ;)
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'Max',
            'middle_name'  => 'C',
            'last_name'    => 'Rafferty',
            'gender'       => 'M',
            'meta'         => null,
            'birthdate'    => '2016-04-15 11:51:42',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => null,
        ],
        [
            'user_id'      => 'principal',
            'username'     => 'principal',
            'email'        => 'principal@ginasink.com',
            'code'         => null,
            'type'         => 'ADULT',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'Kirk',
            'middle_name'  => 'S',
            'last_name'    => 'West',
            'gender'       => 'M',
            'meta'         => null,
            'birthdate'    => '2016-04-15 11:49:08',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'code_expires' => null,
            'super'        => '0',
            'external_id'  => null,
        ],
    ],
    'user_friends'  => [],
    'user_groups'   => [
        [
            'user_id'  => 'english_student',
            'group_id' => 'english',
            'role'     => 'student',
        ],
        [
            'user_id'  => 'english_teacher',
            'group_id' => 'english',
            'role'     => 'teacher',
        ],
        [
            'user_id'  => 'math_student',
            'group_id' => 'math',
            'role'     => 'student',
        ],
        [
            'user_id'  => 'math_teacher',
            'group_id' => 'math',
            'role'     => 'teacher',
        ],
        [
            'user_id'  => 'principal',
            'group_id' => 'school',
            'role'     => 'principal',
        ],
    ],
    'user_images'   => [],
];
