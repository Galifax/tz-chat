<?php

namespace App\Models;

use betterapp\LaravelDbEncrypter\Traits\EncryptableDbAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory, EncryptableDbAttribute;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
    ];

    protected $casts = [
        'created_at' => "datetime:y-m-d H:i",
        'updated_at' => "datetime:y-m-d H:i",
    ];

    protected array $encryptable = [
        'message',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
