{extends file="layouts/main.tpl"}

{block name=content}
    <div class="hero">
        <h1>Latest Insights per Category</h1>
        <p>Curated high-quality articles from our experts across multiple domains.</p>
    </div>

    {foreach $categoryGroups as $group}
        <section class="category-block">
            <div class="category-header">
                <h2>{$group->category->name}</h2>
                <p>{$group->category->description}</p>
                <a href="/category/{$group->category->id}" class="view-all">View All Category Posts &rarr;</a>
            </div>

            <div class="article-grid">
                {foreach $group->articles as $article}
                    {include file="components/article_card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
        
        <style>
            .category-block { margin-bottom: 4rem; position: relative; }
            .category-header { margin-bottom: 2rem; border-left: 5px solid #a855f7; padding-left: 1.5rem; }
            .view-all { 
                display: inline-block; margin-top: 1rem; color: #a855f7; font-weight: bold; font-size: 0.9rem;
            }
            .hero { text-align: center; margin-bottom: 6rem; padding: 4rem 0; background: rgba(99, 102, 241, 0.05); border-radius: 2rem; }
        </style>
    {/foreach}
{/block}
