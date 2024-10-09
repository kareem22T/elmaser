<?php

namespace App\Observers;

use App\Models\Article;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     *
     * @param  \App\Models\Article  $article
     * @return void
     */
    public function created(Article $article)
    {
        $this->generateSitemap();
    }

    /**
     * Generate the sitemap when a new article is created.
     */
    protected function generateSitemap()
    {
        $sitemap = Sitemap::create();

        // Retrieve all articles to generate the sitemap
        $articles = Article::all();

        foreach ($articles as $article) {
            $sitemap->add(
                Url::create(route('article.show', $article->id))  // Use the article route
                    ->setLastModificationDate($article->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.8)
            );
        }

        // Save sitemap to the public directory
        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
