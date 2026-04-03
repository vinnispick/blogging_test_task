<div class="article-card">
    <div class="card-image" style="background-image: url('{$article->imageUrl|default:"https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&q=80&w=800"}');"></div>
    <div class="card-body">
        <div class="meta">
            <span>By <strong>Admin</strong></span>
            <span>{$article->publishedAt|date_format:"%b %d, %Y"}</span>
        </div>
        <h3>{$article->title}</h3>
        <p>{$article->shortDescription|truncate:120:"..."}</p>
        <div class="meta">
            <span>{$article->viewCount} views</span>
        </div>
        <a href="/article/{$article->id}" class="btn-read">READ MORE</a>
    </div>
</div>
