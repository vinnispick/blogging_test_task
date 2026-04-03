{extends file="layouts/main.tpl"}

{block name=content}
    <div class="article-detail-view" id="article-view">
        <div class="article-hero" style="background-image: url('{$article->imageUrl|default:"https://images.unsplash.com/photo-1618005198919-d3d4b5a92ead?auto=format&fit=crop&q=80&w=1200"}');">
            <div class="hero-overlay">
                <div class="container hero-content-inner">
                    <div class="meta-stack animate-up">
                        <div class="badge-row">
                            {foreach $article->categories as $category}
                                <a href="/category/{$category->id}" class="cat-pill">{$category->name}</a>
                            {/foreach}
                        </div>
                        <h1 class="main-title">{$article->title}</h1>
                        <div class="meta-details">
                            <span class="meta-item"><i class="icon-calendar"></i> {$article->publishedAt|date_format:"%B %e, %Y"}</span>
                            <span class="meta-item"><i class="icon-clock"></i> ~{$readingTime} min read</span>
                            <span class="meta-item"><i class="icon-eye"></i> {$article->viewCount|number_format} views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="article-content-wrapper container">
            <main class="article-body animate-fade">
                <div class="article-lead">
                    {$article->shortDescription}
                </div>
                <div class="article-text">
                    {$article->content}
                </div>
                
                <div class="article-footer">
                    <div class="tag-list">
                        <span class="tag-label">Category:</span>
                        {foreach $article->categories as $category}
                            <a href="/category/{$category->id}" class="footer-tag">#{$category->name}</a>
                        {/foreach}
                    </div>
                </div>
            </main>

            <aside class="article-sidebar animate-side">
                <div class="sidebar-segment sticky-top">
                    <h3 class="section-title">Similar Perspectives</h3>
                    <div class="mini-grid">
                        {foreach $similarArticles as $similar}
                            {include file="components/similar_article_mini.tpl" article=$similar}
                        {foreachelse}
                            <div class="empty-state">
                                <p>Finding more insights for you...</p>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </aside>
        </div>
    </div>
{/block}
