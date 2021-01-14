<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'introduction',
        'location',
        'cost',
    ];

    /**
     * @inheritdoc
     */
    protected $casts = [
        'cost' => 'float',
    ];

}
