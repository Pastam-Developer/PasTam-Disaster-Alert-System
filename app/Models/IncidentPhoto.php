<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class IncidentPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'incident_report_id',
        'photo_path',
        'thumbnail_path',
        'caption',
        'sort_order'
    ];

    public function incident()
    {
        return $this->belongsTo(IncidentReport::class);
    }

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo_path) {
            return null;
        }

        return Storage::disk('public')->url($this->photo_path);
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }

        return $this->photo_url;
    }
}
