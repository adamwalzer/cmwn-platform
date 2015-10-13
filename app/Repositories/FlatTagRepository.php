<?php

namespace cmwn\Repositories;
use Illuminate\Support\Facades\Auth;

class FlatTagRepository
{
    protected $role = null;
	public function __construct(){
		if ($role = Auth::user()->role) {
			foreach ($role as $rol) {
				$this->role[] = $rol->title;
			}
		}
	}

	public function getAll()
    {
	    $tags['admin'] = array(
		    'Members' => '/users/members',
		    'Roles' => '/users/members',
		    'Ditricts' => '/districts',
		    'Organizations' => '/organizations',
		    'Groups' => '/groups',
        );

	    $tags['principal'] = array(
		    'Members' => '/users/members',
		    'Roles' => '/users/members',
		    'Ditricts' => '/districts',
		    'Organizations' => '/organizations',
		    'Groups' => '/groups',
	    );

	    $tags['teacher'] = array(
		    'Teacher' => '/users/teachers',
	    );

	    $tags['guardian'] = array(
		    'guardian' => '/guardian',
	    );

	    $tags['student'] = array(
		    'Student' => '/student',
	    );

		$combinedTags = array();
	    if ($this->role) {
		    foreach ($this->role as $role) {
			    foreach ($tags[ $role ] as $title => $link) {
				    $combinedTags[ $title ] = $link;
			    }
		    }
	    }
	    return $combinedTags;
	}

}
