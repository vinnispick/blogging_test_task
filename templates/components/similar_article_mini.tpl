<a href="/article/{$article->id}" class="mini-card">
    <div class="mini-thumb" style="background-image: url('{$article->imageUrl|default:"https://images.unsplash.com/photo-1542831371-29b0f74f9713?auto=format&fit=crop&q=80&w=800"}');"></div>
    <div class="mini-content">
        <h4 class="mini-title">{$article->title}</h4>
        <div class="mini-meta">
            <span><i class="icon-clock"></i> {$article->publishedAt|date_format:"%b %d"}</span>
        </div>
    </div>
</a>

<style>
    .mini-card { display: flex; gap: 1rem; text-decoration: none; transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); padding: 0.5rem; border-radius: 0.75rem; border: 1px solid transparent; }
    .mini-card:hover { background: rgba(99, 102, 241, 0.05); border-color: rgba(99, 102, 241, 0.1); transform: translateX(5px); }
    
    .mini-thumb { width: 80px; height: 60px; border-radius: 0.5rem; background-size: cover; background-position: center; flex-shrink: 0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
    
    .mini-content { flex-grow: 1; min-width: 0; }
    .mini-title { font-size: 0.95rem; font-weight: 600; color: #1e293b; margin: 0 0 0.25rem 0; line-height: 1.3; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .mini-meta { font-size: 0.8rem; color: #64748b; display: flex; align-items: center; gap: 0.5rem; }
    
    .mini-card:hover .mini-title { color: #6366f1; }
</style>
