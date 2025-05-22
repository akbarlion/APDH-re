<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    /* *
     *
     * Lapak belongs to a user
     *
     * @return BelongsTo
     *
     * */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
     * Relasi m2m ke RPH
     * @return BelongsToMany
     */
    public function rph() : BelongsToMany
    {
        return $this->belongsToMany(Rph::class, 'juleha_rph');
    }
}
