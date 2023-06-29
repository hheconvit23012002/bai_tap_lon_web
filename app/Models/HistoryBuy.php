<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryBuy extends Model
{
    use HasFactory;
    protected $table = "history_buy";
    protected $fillable = [
        'book_id',
        'user_id',
        'number',
        'address',
        'tel',
        'price',
        'note',
        'status',
    ];

    public function getSumPriceAttribute(){
        $format = new \NumberFormatter("vi_VN", \NumberFormatter::CURRENCY);
        return $format->formatCurrency($this->price*$this->number,"VND");
    }

    public function getValiPriceAttribute(){
        $format = new \NumberFormatter("vi_VN", \NumberFormatter::CURRENCY);
        return $format->formatCurrency($this->price,"VND");
    }
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
