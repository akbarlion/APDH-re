<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rph extends Model
{
    use HasFactory;

    protected $table = 'rph'; // Explicitly defining the table name

    protected $primaryKey = 'id'; // Setting the primary key

    protected $fillable = [
        'name',
        'alamat',
        'phone',
        'status_sertifikasi',
        'file_sertifikasi',
        'penyelia_id'
    ];

    /**
     * Relationships
     * 
     * @return row
     */
    public function penyelia()
    {
        return $this->belongsTo(Penyelia::class);
    }
}
