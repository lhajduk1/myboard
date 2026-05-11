<?php

namespace App\Models;

use App\Enums\PageStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Override;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'published_at',
        'page_id',
        'user_id',
    ];

    #[Override]
    public function casts()
    {
        return [
            'published_at' => 'datetime',
            'status' => PageStatus::class,
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'page_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    #[Override]
    protected static function booted(): void
    {
        static::saving(function (Page $page) {
            if ($page->status === PageStatus::PUBLISHED && !$page->published_at) {
                $page->published_at = now();
            }
        });
    }
}
