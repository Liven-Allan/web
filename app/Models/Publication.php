<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'url',
        'priority',  
        'patron_id'
    ];
  


    // Define the relationship to the Patron model (if exists)
    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }
}
