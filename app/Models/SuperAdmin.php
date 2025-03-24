<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{
    use HasFactory;

    protected $table = 'super_admin'; // Explicitly defining the table name

    protected $primaryKey = 'user_id'; // Setting the primary key

    public $incrementing = false; // Since 'user_id' is a foreign key and not auto-incrementing

    protected $fillable = [
        'user_id',
        'access_level',
        'notes',
    ];

    /**
     *
     * Relationships
     *
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    //
}
