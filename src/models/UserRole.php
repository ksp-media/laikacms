<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_user_role';
    protected $primaryKey = 'id';
    protected $guarded = array();

    

}
