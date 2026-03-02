<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookExchange extends Model
{
    protected $fillable = [
        'requester_id',
        'requester_book_id',
        'owner_id',
        'owner_book_id',
        'status',
        'message',
    ];

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function requesterBook(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'requester_book_id');
    }

    public function ownerBook(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'owner_book_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}
