<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity', 'description', 'image', 'video', 'category_id'];

    /**
     * علاقة متعدد-إلى-واحد مع الفئات
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}


