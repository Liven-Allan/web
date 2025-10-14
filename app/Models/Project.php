<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $patron_id
 * @property int $priority
 * @property string $title
 * @property string|null $description
 * @property string|null $url
 * @property string|null $image
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'image',
        'patron_id'
    ];

    public function patron()
    {
        return $this->belongsTo(User::class, 'patron_id');
    }
}
