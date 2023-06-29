<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;
    protected $table = 'book';
    protected $fillable = [
        'title',
        'author',
        'des',
        'release_date',
        'number_page',
        'category_id',
        'avatar',
        'price'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getPriceNowAttribute(){
        $format = new \NumberFormatter("vi_VN", \NumberFormatter::CURRENCY);
        return $format->formatCurrency($this->price,"VND");
    }

}
