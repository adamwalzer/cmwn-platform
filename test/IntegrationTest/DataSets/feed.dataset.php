<?php

return [

    'organizations'    => [
        [
            'org_id'      => 'district',
            'title'       => 'Gina\'s District',
            'description' => null,
            'meta'        => null,
            'created'     => '2016-04-27 10:48:44',
            'updated'     => '2016-04-27 10:48:46',
            'deleted'     => null,
            'type'        => 'district',
        ],
        [
            'org_id'      => 'manchuck',
            'title'       => 'MANCHUCK\'S district',
            'description' => null,
            'meta'        => null,
            'created'     => '2016-04-27 10:48:44',
            'updated'     => '2016-04-27 10:48:46',
            'deleted'     => null,
            'type'        => 'district',
        ],
    ],
    'games'            => [
        [
            'game_id'     => 'animal-id',
            'created'     => '2016-04-13 00:00:00',
            'updated'     => '2016-04-13 00:00:00',
            'title'       => 'Animal ID',
            'description' => 'Can you ID the different kinds of animals? Do you know what plants and animals
                    belong together? Prove it and learn it right here!
                ',
            'deleted'     => null,
            'meta'        => '{"desktop" : false, "unity" : false}',
            'coming_soon' => '0',
        ],
        [
            'game_id'     => 'be-bright',
            'created'     => '2016-04-13 00:00:00',
            'updated'     => '2016-04-13 00:00:00',
            'title'       => 'Be Bright',
            'description' => 'Become a Light Saver agent of change! This music video will kick your inner
                    superhero into high gear!
                ',
            'deleted'     => null,
            'meta'        => '{"desktop" : false, "unity" : false}',
            'coming_soon' => '0',
        ],
        [
            'game_id'     => 'Monarch',
            'created'     => '2016-04-13 00:00:00',
            'updated'     => '2016-04-13 00:00:00',
            'title'       => 'Monarch',
            'description' => 'Monarch Butterflies are crucial for the environment' .
                ' yet they are endangered! This is your spot!',
            'meta'        => '{"desktop" : false, "unity" : false}',
            'deleted'     => null,
            'coming_soon' => '0',
        ],
    ],
    'groups'           => [
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
            'network_id'      => 'school',
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
            'depth'           => '1',
            'network_id'      => 'school',
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
            'depth'           => '1',
            'network_id'      => 'school',
        ],
        [
            'group_id'        => 'other_school',
            'organization_id' => 'manchuck',
            'title'           => 'MC School',
            'description'     => null,
            'meta'            => null,
            'head'            => '1',
            'tail'            => '4',
            'created'         => '2016-04-15 15:52:36',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'school',
            'external_id'     => null,
            'parent_id'       => null,
            'depth'           => '0',
            'network_id'      => 'other_school',
        ],
        [
            'group_id'        => 'other_math',
            'organization_id' => 'manchuck',
            'title'           => 'MC Math',
            'description'     => null,
            'meta'            => null,
            'head'            => '2',
            'tail'            => '3',
            'created'         => '2016-04-15 15:53:06',
            'updated'         => '0000-00-00 00:00:00',
            'deleted'         => null,
            'type'            => 'class',
            'external_id'     => null,
            'parent_id'       => 'other_school',
            'depth'           => '1',
            'network_id'      => 'other_school',
        ],
    ],


    'users'            => [
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
            'super'        => '0',
            'external_id'  => '8675309',
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
            'super'        => '0',
            'external_id'  => null,
        ],
        [
            'user_id'      => 'super_user',
            'username'     => 'super_user',
            'email'        => 'super@ginasink.com',
            'code'         => null,
            'type'         => 'ADULT',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'Joni',
            'middle_name'  => null,
            'last_name'    => 'Albers',
            'gender'       => 'F',
            'meta'         => null,
            'birthdate'    => '2016-04-27 10:48:42',
            'created'      => '2016-04-27 10:48:44',
            'updated'      => '2016-04-27 10:48:46',
            'deleted'      => null,
            'super'        => '1',
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
            'external_id'  => null,
        ],
        [
            'user_id'      => 'other_student',
            'username'     => 'other_student',
            'email'        => 'other_student@manchuck.com',
            'code'         => null,
            'type'         => 'CHILD',
            'password'     => '$2y$10$b53JWhhPjSyHvbvaL0aaD.9G3RKTd4pZn6JCkop6pkqFYDrEPJTC.',
            'first_name'   => 'Chuck',
            'middle_name'  => 'C',
            'last_name'    => 'Reeves',
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
    ],


    'user_groups'      => [
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
            'user_id'  => 'principal',
            'group_id' => 'school',
            'role'     => 'principal',
        ],
        [
            'user_id'  => 'math_student',
            'group_id' => 'math',
            'role'     => 'student',
        ],
        [
            'user_id'  => 'other_student',
            'group_id' => 'other_math',
            'role'     => 'student',
        ],
    ],



    'user_suggestions' => [],
    'feed'             => [
        [
            'feed_id'      => 'es_friend_feed',
            'sender'       => 'math_student',
            'title'        => 'Friendship Made',
            'message'      => 'became friends with',
            'priority'     => 5,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'FRIEND',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'es_game_feed',
            'sender'       => null,
            'title'        => 'New Game Added',
            'message'      => 'new game to play',
            'priority'     => 4,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'GAME',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'es_flip_feed',
            'sender'       => 'english_student',
            'title'        => 'Flip Earned',
            'message'      => 'you earned a new flip',
            'priority'     => 3,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'FLIP',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'ms_friend_feed',
            'sender'       => 'english_student',
            'title'        => 'Friendship Made',
            'message'      => 'became friends with',
            'priority'     => 5,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'FRIEND',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'ms_game_feed',
            'sender'       => null,
            'title'        => 'New Game Added',
            'message'      => 'new game to play',
            'priority'     => 4,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'GAME',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'ms_flip_feed',
            'sender'       => 'math_student',
            'title'        => 'Flip Earned',
            'message'      => 'you earned a new flip',
            'priority'     => 3,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'FLIP',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'os_game_feed',
            'sender'       => null,
            'title'        => 'New Game Added',
            'message'      => 'new game to play',
            'priority'     => 4,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'GAME',
            'type_version' => 1,
        ],
        [
            'feed_id'      => 'os_flip_feed',
            'sender'       => 'other_student',
            'title'        => 'Flip Earned',
            'message'      => 'you earned a new flip',
            'priority'     => 3,
            'posted'       => '2016-04-15 11:49:08',
            'visibility'   => 2,
            'type'         => 'FLIP',
            'type_version' => 1,
        ],
    ],
    'user_feed'        => [
        [
            'feed_id'      => 'es_friend_feed',
            'user_id'      => 'english_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'es_flip_feed',
            'user_id'      => 'english_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'es_game_feed',
            'user_id'      => 'english_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'ms_friend_feed',
            'user_id'      => 'math_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'ms_flip_feed',
            'user_id'      => 'math_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'ms_game_feed',
            'user_id'      => 'math_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'os_flip_feed',
            'user_id'      => 'other_student',
            'read_flag'    => '0'
        ],
        [
            'feed_id'      => 'os_game_feed',
            'user_id'      => 'other_student',
            'read_flag'    => '0'
        ],
    ],
];
