<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasar'; // Explicitly defining the table name

    protected $fillable = [
        'name',
        'alamat',
    ];

    /**
     * Relationships
     */

    // Lapak belongs to a market (pasar)
    public function lapaks()
    {
        return $this->hasMany(Lapak::class, 'pasar_id');
    }
}
