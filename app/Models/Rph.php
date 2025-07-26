<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * @return BelongsTo
     */
    public function penyelia() : BelongsTo
    {
        return $this->belongsTo(Penyelia::class);
    }

    /**
     * Relationships    
     *
     * @return BelongsToMany
     */
    public function julehas() : BelongsToMany
    {
        return $this->belongsToMany(
            Juleha ::class,
            'juleha_rph',
            'rph_id',
            'juleha_id',
            'user_id',
            'id'
        );
    }
}
