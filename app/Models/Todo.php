<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_to_do';


	public function user(){
		 return $this->belongsTo('App\Models\User', 'user_id', 'id');
	}
}
