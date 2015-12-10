<?php

namespace app\cmwn\Users;
use app\Http\Controllers\Api\ApiController;
use app\Repositories\SideBarItems;
use app\User;
use Illuminate\Support\Facades\Auth;

class UserSpecificRepository extends ApiController
{

    public $tag;
    protected $currentUser;

	public function __construct(SideBarItems $tag){
		$this->tag = $tag;
        $this->currentUser = Auth::user();
	}

	public function getApiSideBar(){
		return $this->tag;
	}

	public function compose($view){
		$acceptedfriends = array();
		$pendingfriends = array();
		$friendrequests = array();
		if (Auth::check()) {
			$acceptedfriends = User::find($this->currentUser->uuid)->acceptedfriends;
			$pendingfriends = User::find($this->currentUser->uuid)->pendingfriends;
			$friendrequests = User::find($this->currentUser->uuid)->friendrequests;
		}



		$view->with('tags', $this->tag->getAll())->with('acceptedfriends', $acceptedfriends)->with('pendingfriends', $pendingfriends)->with('friendrequests', $friendrequests);
	}

    public function friendsForApi(){
        $friends = array();
        if (Auth::check()) {
            $friends['acceptedfriends'] = User::find($this->currentUser->uuid)->acceptedfriends;
            $friends['pendingfriends'] = User::find($this->currentUser->uuid)->pendingfriends;
            $friends['friendrequests'] = User::find($this->currentUser->uuid)->friendrequests;
        }

        return $friends;
    }



}
