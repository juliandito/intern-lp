<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    use HasFactory;

    protected $table = "article_comments";

    protected $guarded = ["id"];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
