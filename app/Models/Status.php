<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Status
 * @package App\Models
 * @property int $id
 * @property string $content
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class Status extends Model
{
    protected $fillable = ['content'];

    /**
     * 一条微博属于一个用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
