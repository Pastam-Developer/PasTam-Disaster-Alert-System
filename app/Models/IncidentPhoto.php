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

        // Use a relative URL to avoid mixed-content issues when behind a proxy
        // and to avoid relying on APP_URL for correct scheme/host.
        return '/storage/' . ltrim($this->photo_path, '/');
    }

    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path) {
            return '/storage/' . ltrim($this->thumbnail_path, '/');
        }

        return $this->photo_url;
    }
}
