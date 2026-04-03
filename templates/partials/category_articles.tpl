<!-- Article Grid -->
<div id="article-list-container">
    <div class="article-grid">
        {foreach $pagination->articles as $article}
            {include file="components/article_card.tpl" article=$article}
        {/foreach}
    </div>

    <!-- Pagination -->
    {if $pagination->totalPages > 1}
        <div class="pagination">
            {assign var="sortQuery" value=""}
            {if $currentSort != ""}{assign var="sortQuery" value="&sort=`$currentSort`"}{/if}

            {if $pagination->currentPage > 1}
                <a href="?id={$pagination->categoryId}&page={$pagination->currentPage - 1}{$sortQuery}" class="page-link" data-ajax-link="true">&laquo;</a>
            {/if}

            {for $p=1 to $pagination->totalPages}
                {if $p == $pagination->currentPage}
                    <span class="page-link active">{$p}</span>
                {else}
                    <a href="?id={$pagination->categoryId}&page={$p}{$sortQuery}" class="page-link" data-ajax-link="true">{$p}</a>
                {/if}
            {/for}

            {if $pagination->currentPage < $pagination->totalPages}
                <a href="?id={$pagination->categoryId}&page={$pagination->currentPage + 1}{$sortQuery}" class="page-link" data-ajax-link="true">&raquo;</a>
            {/if}
        </div>
    {/if}
</div>
