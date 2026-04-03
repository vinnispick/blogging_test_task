{extends file="layouts/main.tpl"}

{block name=content}
    <div style="text-align: center; padding: 6rem 0;">
        <h1 style="font-size: 6rem; background: linear-gradient(135deg, #f43f5e 0%, #a855f7 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">{$statusCode}</h1>
        <h2 style="font-size: 2.5rem; margin-top: -1rem;">Something went wrong</h2>
        <p style="color: #94a3b8; max-width: 500px; margin: 2rem auto; font-size: 1.1rem;">
            {$message|default:"The page you are looking for might have been removed, had its name changed, or is temporarily unavailable."}
        </p>
        <a href="/" style="display: inline-block; padding: 1rem 2.5rem; background: #6366f1; border-radius: 1rem; font-weight: bold; margin-top: 2rem;">Back to Home</a>
    </div>
{/block}
