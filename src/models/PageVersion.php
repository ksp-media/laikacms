<?php

namespace KSPM\LCMS\Model;

use Illuminate\Database\Eloquent\Model;

class PageVersion extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'laikacms_page_version';
    protected $primaryKey = 'id';
    protected $guarded = array();
    
   public function page(){
       return $this->hasOne('KSPM\LCMS\Model\Page', 'origin_id', 'id');
   }
}
