<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPAddress extends Model
{
    use HasFactory;
    protected $table = 'ip_address';
    protected $fillable = [
        'ip',
        'type',
        'data'
    ];
    protected $casts = [
        'data' => 'array'
    ];
}
