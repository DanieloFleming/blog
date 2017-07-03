<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    /**
     * Post types
     */
    const TYPE_PUBLISHED = 0;
    const TYPE_DRAFT = 1;
    const TYPE_AUTO_SAVED = 2;

    /**
     * Array containing post types.
     *
     * @var array
     */
    private static $types = [
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
     * Array for storing the previous and next post.
     *
     * @var array
     */
    public $pagePosts = [];
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
     * Returns the published_at value transformed to something like "August 10, 2023".
     *
     * @return string
     */
    public function published()
    {
        if(!isset($this->attributes['published_at'])) {
            $rawPublishedAt = date('y-m-d H:i:s');
        } else {
            $rawPublishedAt = $this->attributes['published_at'];
        }

        $carbon = Carbon::createFromFormat('Y-m-d H:i:s', $rawPublishedAt);

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

    /**
     * Get a post newer current post.
     *
     * @return mixed
     */
    public function previous()
    {
        if(!isset($this->pagePosts['previous'])) {
            $result = static::where('published_at', '<', $this->published_at)
                ->orderBy('desc')
                ->first();

            $this->pagePosts['previous'] = $result;
        }

        return $this->pagePosts['previous'];
    }

    /**
     * Get a post older than current post
     *
     * @return mixed
     */
    public function next()
    {
        if(!isset($this->pagePosts['next'])) {
            $result = static::where('published_at', '>', $this->published_at)
                ->orderBy('asc')
                ->first();

            $this->pagePosts['next'] = $result;
        }

        return $this->pagePosts['next'];
    }
}
