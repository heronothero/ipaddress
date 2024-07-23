<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPAddress extends Model
{
    use HasFactory;

    /**
     * Table
     * @var string
     */
    protected $table = 'ip_address';

    /**
     * Fillable filds
     * @var array
     */
    protected $fillable = [
        'ip',
        'type',
        'data'
    ];

    /**
     * Casts
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];
}
