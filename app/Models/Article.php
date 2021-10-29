<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = "articles";

    protected $guarded = ['id'];

    public function author()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function like()
    {
        return $this->hasMany(ArticleLike::class, 'article_id', 'id');
    }

    public function comment()
    {
        return $this->hasMany(ArticleComment::class, 'article_id', 'id');
    }
}
