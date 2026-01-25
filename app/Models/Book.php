<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'author',
        'isbn',
        'price',
        'condition',
        'listing_type',
        'category',
        'publication_year',
        'language',
        'image',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'publication_year' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exchangeRequests(): HasMany
    {
        return $this->hasMany(BookExchange::class, 'owner_book_id');
    }

    public function exchangeOffers(): HasMany
    {
        return $this->hasMany(BookExchange::class, 'requester_book_id');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeForSale($query)
    {
        return $query->whereIn('listing_type', ['sell', 'both']);
    }

    public function scopeForExchange($query)
    {
        return $query->whereIn('listing_type', ['exchange', 'both']);
    }
}
