<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use \DateTimeInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Folder extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public $table = 'folders';

    protected $appends = [
        'files',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'project_id',
        'parent_id',
        'thumbnail_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null) : void
    {
        $this->addMediaConversion('thumb')->fit('crop', 100, 100);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function getFilesAttribute()
    {
        $files = $this->getMedia('files');

        $files->map(function ($file) {
            $file->thumbnail = substr($file->mime_type, 0, 5) == 'image' ? $file->getUrl('thumb') : null;
        });

        return $files;
    }

    public function getImagesAttribute()
    {
        return $this->files->filter(function ($file) {
            return substr($file->mime_type, 0, 5) == 'image';
        });
    }

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'parent_id');
    }
}
