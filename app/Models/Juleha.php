<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juleha extends Model
{
    use HasFactory;

    protected $table = 'juleha'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Setting the primary key

    public $incrementing = false; // Since 'user_id' is a foreign key and not auto-incrementing

    protected $fillable = [
        'user_id',
        'nomor_sertifikat',
        'masa_sertifikat',
        'upload_sertifikat',
    ];

    /**
     * Relationships
     */

    // Lapak belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
