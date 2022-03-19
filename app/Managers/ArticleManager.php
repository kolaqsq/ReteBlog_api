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

    public function create(array $data): Article
    {
        if (!isset($data['slug'])) {
            $data['slug'] = Article::getSlugFromTitle($data['title']);
        }

        $this->article = app(Article::class);
        $this->article->fill($data);

    }
}