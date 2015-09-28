<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_user';
    protected $primaryKey = 'id';
    protected $guarded = array();
    
    
    public function role(){
        return $this->hasOne('\KSPM\LCMS\Model\UserRole', 'id', 'laikacms_user_role_id');
    }

    

}
