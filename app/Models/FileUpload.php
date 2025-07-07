<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FileUpload extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['file_path', 'disk', 'status'];

    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }

  public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
{
    $this->addMediaConversion('thumb')
         ->width(200)
         ->height(200)
         ->sharpen(10);
}
}