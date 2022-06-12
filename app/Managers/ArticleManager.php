<?php

namespace App\Managers;

use App\Models\Article;

class ArticleManager
{
    private Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public function create(array $params): void
    {
        $this->article = app(Article::class);
        $this->article->fill($params);
        $this->article->user_id = $params['user_id'];
        $this->article->save();
    }

    public function update(Article $article, array $params): void
    {
        $article->slug = null;
        $article->fill($params);
        $article->save();
    }

    public function delete(Article $article): void
    {
        $article->delete();
    }
}
