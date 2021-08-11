<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $table = 'attachments';

    protected $primaryKey = 'id';

    protected $fillable =[
        'user_id',
        'file_original_name',
        'file_name',
        'file_size',
        'extension',
        'url',
    ];

    protected $appends = ['image_path'];

    public function getImagePathAttribute(): string
    {
        return $this->url
            ? asset('storage/'.$this->url)
            : $this->_defaultImagePath();
    }

    public function getFileSizeAttribute(): string
    {
        if (!empty($this->attributes['file_size'])){
            return number_format($this->attributes['file_size'] / 1024, 2);
        }
        return '0.00';

    }

    private function _defaultImagePath(): string
    {
        return asset('images/no-image-available.jpg');
    }

    /**
     * Get the owning attachmentable model.
     */
    public function attachmentable()
    {
        return $this->morphTo();
    }
}
