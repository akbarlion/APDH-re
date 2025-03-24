<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyelia extends Model
{
    use HasFactory;

    protected $table = 'penyelia'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Setting the primary key

    public $incrementing = false; // Since 'user_id' is a foreign key and not auto-incrementing

    protected $fillable = [
        'user_id',
        'rph_id',
        'nip',
        'status',
        'tgl_berlaku',
        'file_sk',
    ];

    /**
     * Relationships
     */

    // Lapak belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rph()
    {
        return $this->belongsTo(Rph::class);
    }
}
