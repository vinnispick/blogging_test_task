{extends file="layouts/main.tpl"}

{block name=content}
    <div class="category-hero">
        <h2>{$pagination->categoryName}</h2>
        {if $pagination->categoryDescription}
            <p class="category-description">{$pagination->categoryDescription}</p>
        {else}
            <p class="subtitle">Discover articles in <strong>{$pagination->categoryName}</strong>.</p>
        {/if}
        
        <div class="sort-container">
            <div class="sort-label">Sort Priority</div>
            <div class="sort-grid">
                {assign var="fields" value=[
                    'published_at' => 'Date Published',
                    'view_count' => 'Most Popular',
                    'title' => 'Name (A-Z)'
                ]}

                {foreach $fields as $field => $label}
                    {assign var="isActive" value=false}
                    {assign var="priority" value=0}
                    {assign var="direction" value=''}
                    
                    {foreach $sortCriteria as $idx => $criteria}
                        {if $criteria.column == $field}
                            {assign var="isActive" value=true}
                            {assign var="priority" value=$idx + 1}
                            {assign var="direction" value=$criteria.direction}
                        {/if}
                    {/foreach}

                    <div class="sort-item {if $isActive}is-active{/if}" data-priority="{$priority}">
                        {if $isActive}
                            {* Toggle Direction URL *}
                            {assign var="newSort" value=""}
                            {foreach $sortCriteria as $idx => $criteria}
                                {if $idx > 0}{assign var="newSort" value="`$newSort`,"}{/if}
                                {if $criteria.column == $field}
                                    {assign var="nextDir" value="asc"}
                                    {if $criteria.direction == 'asc'}{assign var="nextDir" value="desc"}{/if}
                                    {assign var="newSort" value="`$newSort``$criteria.column`:`$nextDir`"}
                                {else}
                                    {assign var="newSort" value="`$newSort``$criteria.column`:`$criteria.direction`"}
                                {/if}
                            {/foreach}
                            <a href="?id={$pagination->categoryId}&sort={$newSort}" class="sort-btn-main" data-ajax-link="true">
                                <span class="priority-badge">{$priority}</span>
                                <span class="label">{$label}</span>
                                <span class="dir-icon">{if $direction == 'desc'}&darr;{else}&uarr;{/if}</span>
                            </a>

                            {* Remove URL *}
                            {assign var="remSort" value=""}
                            {assign var="remCount" value=0}
                            {foreach $sortCriteria as $idx => $criteria}
                                {if $criteria.column != $field}
                                    {if $remCount > 0}{assign var="remSort" value="`$remSort`,"}{/if}
                                    {assign var="remSort" value="`$remSort``$criteria.column`:`$criteria.direction`"}
                                    {assign var="remCount" value=$remCount + 1}
                                {/if}
                            {/foreach}
                            <a href="?id={$pagination->categoryId}&sort={$remSort}" class="sort-remove" title="Remove from chain" data-ajax-link="true">&times;</a>
                        {else}
                            {* Add to Chain URL *}
                            {assign var="addSortParam" value="`$field`:desc"}
                            {if $field == 'title'}{assign var="addSortParam" value="`$field`:asc"}{/if}
                            
                            {assign var="addSort" value=$addSortParam}
                            {if $currentSort != ""}
                                {assign var="addSort" value="`$currentSort`,`$addSortParam`"}
                            {/if}
                            <a href="?id={$pagination->categoryId}&sort={$addSort}" class="sort-btn-main inactive" data-ajax-link="true">
                                <span class="label">{$label}</span>
                            </a>
                        {/if}
                    </div>
                {/foreach}

                <div class="sort-actions">
                    <a href="?id={$pagination->categoryId}" class="reset-btn" title="Reset to default" data-ajax-link="true">
                        <i class="icon-refresh"></i> Reset All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Article Container with AJAX Loading State -->
    <div id="articles-wrapper">
        <div id="loading-overlay" class="hidden">
            <div class="spinner"></div>
        </div>
        <div id="partial-container">
            {include file="partials/category_articles.tpl"}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.getElementById('articles-wrapper');
            const partialContainer = document.getElementById('partial-container');
            const loadingOverlay = document.getElementById('loading-overlay');
            const sortContainer = document.querySelector('.sort-container');

            // Handle AJAX links
            document.addEventListener('click', async (e) => {
                const link = e.target.closest('[data-ajax-link="true"]');
                if (!link) return;

                e.preventDefault();
                const url = new URL(link.href);
                url.searchParams.set('ajax', '1');

                try {
                    // Show loading
                    loadingOverlay.classList.remove('hidden');
                    partialContainer.style.opacity = '0.4';

                    const response = await fetch(url);
                    if (!response.ok) throw new Error('Network response was not ok');
                    
                    const html = await response.text();
                    
                    // Update Content
                    // Note: We need to update both the articles and the sort UI if the sort changed
                    // Since the sort UI is outside the partial, we'll fetch the whole page and extract parts 
                    // OR we can just reload the whole page via AJAX and replace sections.
                    // Let's optimize: Fetch with ajax=1 returns only partial. If we need to update Sort UI, 
                    // we might need another approach or include Sort UI in the partial.
                    // For now, let's just reload the page content if sorting changes, OR update Sort UI manually.
                    
                    // Better approach: Let Action return both if needed. 
                    // But to keep it simple and high-performance, let's just reload the page part.
                    // If the sort UI needs updating, we can either:
                    // 1. Move Sort UI into the partial.
                    // 2. Refresh the whole page content via a different mechanism.
                    
                    // Let's go with 1: Move Sort UI into the partial for true "one-stop" update.
                    
                    // Wait, I already wrote the Sort UI above the partial-container. 
                    // Let's re-evaluate. I'll move the sort-container INSIDE the partial too?
                    // No, let's just replace the whole #main-content if it's easier, 
                    // but the user wants "no jump to top".
                    
                    // Re-try logic: fetch(url without ajax=1), parse DOM, replace sections.
                    // This is cleaner and guarantees consistency.
                    
                    const fullUrl = new URL(link.href);
                    const fullResponse = await fetch(fullUrl);
                    const fullHtml = await fullResponse.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(fullHtml, 'text/html');
                    
                    // Update the sections
                    document.getElementById('partial-container').innerHTML = doc.getElementById('partial-container').innerHTML;
                    document.querySelector('.sort-container').innerHTML = doc.querySelector('.sort-container').innerHTML;
                    
                    // Update URL
                    window.history.pushState({}, '', link.href);
                    
                    // Scroll to top of window if pagination was clicked
                    if (link.classList.contains('page-link')) {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    
                    // Scroll to top of grid if needed, but the requirement is "not throw user to upper of page"
                    // meaning keep scroll where it is for sorting.
                    
                } catch (err) {
                    console.error('Fetch error:', err);
                    window.location.href = link.href; // Fallback
                } finally {
                    loadingOverlay.classList.add('hidden');
                    partialContainer.style.opacity = '1';
                }
            });

            // Handle browser back button
            window.addEventListener('popstate', () => {
                window.location.reload();
            });
        });
    </script>
    
    <style>
        .category-hero { text-align: center; padding: 4rem 1rem; background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(168, 85, 247, 0.05) 100%); border-radius: 1.5rem; margin-bottom: 3rem; position: relative; }
        .subtitle { color: #94a3b8; font-size: 1.1rem; }
        
        /* Sort Grid UI (Phase 11) */
        .sort-container { 
            margin-top: 2.5rem; 
            padding: 1.5rem; 
            background: rgba(30, 41, 59, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem;
            display: flex; 
            flex-direction: column; 
            gap: 1.25rem; 
            align-items: center; 
        }
        .sort-label { font-weight: 700; color: #64748b; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.15em; }
        
        .sort-grid { display: flex; flex-wrap: wrap; gap: 1rem; justify-content: center; align-items: center; }
        
        .sort-item { 
            display: flex; 
            align-items: center; 
            background: rgba(15, 23, 42, 0.3); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 0.85rem; 
            overflow: hidden; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            position: relative;
        }
        
        .sort-item.is-active {
            background: rgba(99, 102, 241, 0.1);
            border-color: rgba(99, 102, 241, 0.4);
            box-shadow: 0 8px 20px -5px rgba(0, 0, 0, 0.3);
        }

        .sort-item:hover {
            transform: translateY(-2px);
            border-color: rgba(99, 102, 241, 0.5);
            background: rgba(30, 41, 59, 0.6);
        }
        
        .sort-btn-main { 
            padding: 0.65rem 1rem; 
            color: #94a3b8; 
            text-decoration: none; 
            font-size: 0.9rem; 
            font-weight: 600; 
            display: flex; 
            align-items: center; 
            gap: 0.75rem; 
        }
        
        .sort-item.is-active .sort-btn-main { color: #fff; }

        .priority-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 900;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.5);
        }

        .dir-icon { font-size: 1.1rem; opacity: 0.8; }
        
        .sort-remove { 
            padding: 0.65rem 0.75rem; 
            color: #64748b; 
            text-decoration: none; 
            font-size: 1.2rem; 
            border-left: 1px solid rgba(255, 255, 255, 0.05); 
            transition: all 0.2s; 
            background: rgba(15, 23, 42, 0.2); 
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sort-remove:hover { background: rgba(239, 68, 68, 0.2); color: #f87171; }

        .sort-actions {
            margin-left: 0.5rem;
            padding-left: 1.25rem;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .reset-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.1rem;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 0.85rem;
            color: #f87171;
            font-size: 0.85rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .reset-btn:hover {
            background: #ef4444;
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);
        }
        
        /* AJAX Loading States */
        #articles-wrapper { position: relative; min-height: 400px; }
        #partial-container { transition: opacity 0.3s ease; }
        
        #loading-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; justify-content: center; align-items: flex-start; padding-top: 100px; z-index: 5; pointer-events: none; }
        #loading-overlay.hidden { display: none; }
        
        .spinner { width: 40px; height: 40px; border: 3px solid rgba(99, 102, 241, 0.1); border-top-color: #6366f1; border-radius: 50%; animation: spin 0.8s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }

        .dir-icon { font-size: 1rem; line-height: 1; }

        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 4rem; }
        .page-link { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 0.75rem; background: rgba(15, 23, 42, 0.3); color: #94a3b8; text-decoration: none; transition: all 0.2s; border: 1px solid rgba(255, 255, 255, 0.05); }
        .page-link:hover { border-color: #6366f1; color: #fff; }
        .page-link.active { background: #6366f1; color: #fff; border-color: #6366f1; box-shadow: 0 0 15px rgba(99, 102, 241, 0.2); }
    </style>
{/block}
