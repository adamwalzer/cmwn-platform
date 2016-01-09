<?php

namespace app;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;
use app\cmwn\Traits\RoleTrait;
use app\cmwn\Traits\EntityTrait;

class District extends Model
{
    use RoleTrait, EntityTrait, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'districts';

    protected $fillable = [
        'code',
    ];

    public static $districtUpdateRules = array(
        'title' => 'string',
        //'role[]'=>'required',
        //'role[]'=>'required|regex:/^[0-9]?$/',
    );

    public function organizations()
    {
        return $this->belongsToMany('app\Organization');
    }

    public function groups()
    {
        $organization = $this->organizations->lists('id')->toArray();

        return Group::whereIn('organization_id', $organization)->get();
    }

    public function images()
    {
        return $this->morphMany('app\Image', 'imageable');
    }

    public function updateParameters($parameters)
    {
        if (isset($parameters['title'])) {
            $this->title = $parameters['title'];
        }

        if (isset($parameters['description'])) {
            $this->description = $parameters['description'];
        }

        return $this->save();
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, $val)
    {
        return $query->where('title', $val);
    }
}
