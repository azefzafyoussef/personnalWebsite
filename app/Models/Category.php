<?php
// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'color', 'icon', 'is_active'
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}