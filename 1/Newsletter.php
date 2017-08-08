<?php

namespace App\Cms\Models;

use Carbon\Carbon;
use ChrisWillerton\Searchable\Searchable;
use Engage\CmsCore\Models\Base;
use Engage\CmsCore\Traits\ActivityLogger;
use Engage\CmsCore\Traits\Scheduling;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Base
{
    use SoftDeletes;
    use ActivityLogger;
    use Scheduling;
    use Searchable;

    protected $dates = ['deleted_at', 'date'];

    protected $full_text_index = 'name, pdf';
    protected $resource_name = 'newsletters';

    protected $file_fields = [
        'pdf',
    ];

    protected $fillable = [
        'name',
        'pdf',
        'date',
        'publish_from_date',
        'publish_from_time',
        'publish_from',
        'publish_until_date',
        'publish_until_time',
        'publish_until',
        'position',
        'published',
    ];

    public function getPdfUrlAttribute()
    {
        return $this->getFileFieldUrl('pdf');
    }

    public function getFormattedDateAttribute()
    {
        return ($this->date) ? $this->date->format('dS F, Y') : false;
    }

    public function getCmsFormattedDateAttribute()
    {
        return ($this->date) ? $this->date->format('Y-m-d') : false;
    }
    
}