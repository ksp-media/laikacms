<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_content';
    protected $primaryKey = 'id';
    protected $guarded = array();

    

}
