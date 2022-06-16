<?php

namespace App\Managers;

use App\Models\Article;
use App\Models\File;

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
        if ($article->files()) {
            $fileManager = app(FileManager::class);
            foreach ($article->files as $file){
                $fileManager->delete(auth()->user(), $file->filename);
            }
        }

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

    public function uploadFile($article, array $params)
    {
        $fileManager = app(FileManager::class);
        $file = $fileManager->save($params);

        if (!$article->files()->where('file_id', $file->id)->first()) {
            $article->files()->attach($file->id);
        }

        return $file->filename;
    }

    public function deleteFile($user, $article, $filename){
        $fileManager = app(FileManager::class);
        $fileEntry = File::where('filename', $filename)->first();

        $article->files()->detach($fileEntry->id);

        $fileManager->delete($user, $filename);
    }
}
