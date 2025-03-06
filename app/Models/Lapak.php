<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lapak extends Model
{
    use HasFactory;

    protected $table = 'lapak'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Setting the primary key

    public $incrementing = false; // Since 'user_id' is a foreign key and not auto-incrementing

    protected $fillable = [
        'user_id',
        'no_lapak',
        'pasar_id',
        'telp',
    ];

    /**
     * Relationships
     */

    // Lapak belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Lapak belongs to a market (pasar)
    public function pasar()
    {
        return $this->belongsTo(Pasar::class, 'pasar_id');
    }
}
