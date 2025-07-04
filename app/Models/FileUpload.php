<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FileUpload extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['disk', 'status'];

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        if ($media && str_starts_with($media->mime_type, 'image/')) {
            $this->addMediaConversion('thumb')
                ->width(200)
                ->height(200)
                ->sharpen(10)
                ->nonQueued();
        }
    }
}
