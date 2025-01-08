<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    protected $fillable = ['bio'];
    protected $hidden = ['media'];
    protected $collection = 'profile';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection($this->collection)
            ->singleFile();
    }

    public function getImageUrl()
    {
        $profileMedia = $this->getFirstMedia($this->collection);
        return $profileMedia ? $profileMedia->getUrl() : asset('/images/profile.png');
    }
}
