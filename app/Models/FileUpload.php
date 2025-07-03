<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    protected $fillable = ['file_path', 'status'];

    /**
     * Get the file's status.
     *
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }

    /**
     * Set the file's status.
     *
     * @param  string  $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = strtolower($value);
    }
}
