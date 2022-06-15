<?php

namespace App\Managers;

use App\Models\Article;
use App\Models\User;
use phpDocumentor\Reflection\Types\Boolean;

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

    public function react($user, Article $article, bool $like, bool $dislike)
    {
        if (!$user->reactions()->where('article_id', $article->id)->first()) {
            $user->reactions()->attach($article->id);
        }

        $entry = $user->reactions()->where('article_id', $article->id)->first()->pivot;
        $likeState = $entry->like;
        $dislikeState = $entry->dislike;

//        echo 'a '. $likeState . ', b ' . $like . ' asa ' . $article->likes + 1;

        if ($like) {
            if ($likeState) {
                $article->likes--;
            } else {
                $article->likes++;
                if ($dislikeState) {
                    $article->dislikes--;
                }
            }
        } else {
            if ($dislikeState) {
                $article->dislikes--;
            } else {
                $article->dislikes++;
                if ($likeState) {
                    $article->likes--;
                }
            }
        }

        $entry->like = !($entry->like) && $like;
        $entry->dislike = !($entry->dislike) && $dislike;

        $entry->save();
        $article->save();
    }

    public function viewCount($session, Article $article)
    {
        $viewed = session()->get('viewed_article', []);
        if (!in_array($article->id, $viewed)) {
            $article->increment('views');
            session()->push('viewed_article', $article->id);
        }
    }
}
