<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name=title}{$pageTitle|default:"Blog Engine"}{/block}</title>
    
    <!-- Premium Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Outfit:wght@700;900&display=swap" rel="stylesheet">
    
    <!-- Main Styled CSS (Compiled from SCSS) -->
    <link rel="stylesheet" href="/static/css/main.css">
    
    {block name=head}{/block}
</head>
<body>
    <div class="container">
        <header class="site-header">
            <div class="logo">BLOGGER</div>
        </header>

        <nav>
            <a href="/" class="{if ($activePage|default:"") == 'home'}active{/if}">Home</a>
            {* Logic for dynamic categories can be added here *}
            <a href="/category/1">Technology</a>
            <a href="/category/2">Gastronomy</a>
            <a href="/category/3">Finance</a>
            <a href="/category/4">Lifestyle</a>
            <a href="/category/5">Health</a>
        </nav>

        <main>
            {block name=content}{/block}
        </main>

        <footer>
            <p>&copy; 2026 Blogger Engine. Built with PHP 8.1+ & Smarty.</p>
            <p>High-Performance ADR Architecture.</p>
        </footer>
    </div>
</body>
</html>
