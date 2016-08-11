<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    const TYPE_PUBLISHED = 0;
    const TYPE_DRAFT = 1;
    const TYPE_AUTO_SAVED = 2;

    static $types = [
        self::TYPE_PUBLISHED => 'published',
        self::TYPE_DRAFT => 'draft',
        self::TYPE_AUTO_SAVED => 'autoSaved'
    ];

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = ['title', 'content', 'slug', 'type', 'published_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];


    /**
     * Returns post results based on the postType.
     *
     * @param $query
     * @param $type
     * @param bool $defaultOrder
     *
     * @return mixed
     */
    public function scopeOfType($query, $type, $defaultOrder = false)
    {
        $q = $query->where('type', self::$types[$type]);

        return (!$defaultOrder) ? $q->orderBy('published_at', 'desc') : $q;
    }

    /**
     * Returns a model containing the specified slug.
     *
     * @param $query
     * @param $slug
     *
     * @return mixed
     */
    public function scopeWithSlug($query, $slug)
    {
        return $query->where('slug', $slug)->first();
    }

    /**
     * Returns the published_at value transformed to something like "August 10, 2023"
     *
     * @param $value
     *
     * @return string
     */
    public function getPublishedAtAttribute($value)
    {
        if(empty($value)) return $value;

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $value);

        return $carbon->formatLocalized('%B %d, %Y');
    }

    /**
     * Get the content, stripped from html, in a shortened string.
     *
     * @return string
     */
    public function excerpt()
    {
        $stripped = strip_tags($this->attributes['content'], '');

        return substr(trim($stripped), 0, 200) . "...";
    }
}
