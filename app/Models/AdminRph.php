<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRph extends Model
{
    use HasFactory;

    protected $table = 'admin_rph'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Setting the primary key

    public $incrementing = false; // Since 'user_id' is a foreign key and not auto-incrementing

    protected $fillable = [
        'user_id',
        'rph_id',
    ];

    /**
     * Relationships
     *
     * Admin RPH belongsTo RPH
     */

    public function rph()
    {
        return $this->belongsTo(Rph::class);
    }
}
