<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class todo extends Model
{
    /** @use \Database\Factories\TodoFactory */
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $guarded = ['id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
