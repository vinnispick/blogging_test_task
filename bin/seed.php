<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Container;

$container = new Container();
$pdo = $container->get(PDO::class);

echo "Starting database seeding...\n";

// Clear existing data
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
$pdo->exec("TRUNCATE TABLE article_category;");
$pdo->exec("TRUNCATE TABLE articles;");
$pdo->exec("TRUNCATE TABLE categories;");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

// Seed Categories
$categories = [
    ['Technology', 'Latest trends in software, hardware, and AI.'],
    ['Gastronomy', 'Exploring the world through taste and culinary techniques.'],
    ['Finance', 'Managing wealth, understanding markets, and economic stability.'],
    ['Lifestyle', 'Ideas for better living, travel, and personal growth.'],
    ['Health', 'Modern medicine, mental wellness, and biological longevity.'],
    ['Science', 'Deep dives into quantum physics, space, and discovery.'],
    ['Nature', 'Preserving our planet and exploring the wild.'],
    ['Productivity', 'Mastering focus, habits, and peak performance.']
];

$categoryIds = [];
$catStmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
foreach ($categories as $cat) {
    $catStmt->execute($cat);
    $categoryIds[] = $pdo->lastInsertId();
    echo "Added category: {$cat[0]}\n";
}

// Seed Articles
$articles = [
    [
        'Quantum Supremacy: Beyond the Horizon',
        'Computing as we know it is about to change forever with qubits.',
        'Quantum computers exploit the unique properties of quantum mechanics to solve problems that are intractable for classical computers.',
        'https://loremflickr.com/800/600/quantum,technology'
    ],
    [
        'The Secret Life of Microbes',
        'Exploring the invisible world that keeps our planet alive.',
        'Every teaspoon of soil contains millions of microorganisms, each playing a vital role in the cycle of life.',
        'https://loremflickr.com/800/600/bacteria,microbiology'
    ],
    [
        'Deep Work: The Superpower of 2026',
        'Mastering focus in a world designed to distract you.',
        'As automation takes over routine tasks, the ability to focus on complex, creative work becomes the ultimate competitive advantage.',
        'https://loremflickr.com/800/600/work,focus'
    ],
    [
        'James Webb Telescope: First Light',
        'Stunning new images that redefine our understanding of the universe.',
        'By peering back 13.5 billion years, the JWST is showing us the birth of the first stars and galaxies.',
        'https://loremflickr.com/800/600/space,galaxy'
    ],
    [
        'Artisanal Coffee: From Farm to Cup',
        'A journey through the volcanic soils where the best beans grow.',
        'The complexity of a single-origin roast depends on soil chemistry, altitude, and processing method.',
        'https://loremflickr.com/800/600/coffee'
    ],
    [
        'Crypto Regulation and Stability',
        'How central banks and new laws are shaping the future of finance.',
        'The Wild West of digital assets is maturing as regulatory frameworks clear the path for institutional adoption.',
        'https://loremflickr.com/800/600/cryptocurrency,finance'
    ],
    [
        'Hyper-Local Gastronomy: The 10-Mile Diet',
        'Why restaurants are sourcing everything from their own backyards.',
        'True freshness of ingredients can only be achieved when those ingredients haven\'t spent days in transport.',
        'https://loremflickr.com/800/600/food,restaurant'
    ],
    [
        'The Resilience of the Arctic Tundra',
        'Wildlife adapts as global temperatures continue to rise.',
        'Polar bears and arctic foxes are showing remarkable adaptability, but for how much longer?',
        'https://loremflickr.com/800/600/arctic,nature'
    ],
    [
        'Atomic Habits: Redux',
        'Small changes that yield massive results in personal health.',
        'Success isn\'t about radical shifts, but the compounding power of tiny, consistent improvements.',
        'https://loremflickr.com/800/600/fitness,habits'
    ],
    [
        'The Ethics of Synthetic Biology',
        'Programming DNA like we program software: Potential and pitfalls.',
        'CRISPR and gene editing offer the promise of curing diseases, but raise profound ethical questions about our biological future.',
        'https://loremflickr.com/800/600/biology,science'
    ],
    [
        'Sustainable Architecture for Megacities',
        'Designing buildings that breathe and produce their own energy.',
        'Vertical forests and self-shading facades are transforming the concrete jungles of the future.',
        'https://loremflickr.com/800/600/architecture,modern'
    ],
    [
        'Regenerative Agriculture 101',
        'Healing the soil to ensure food security for the next century.',
        'Cover crops, no-till methods, and rotation can restore degraded land into productive ecosystems.',
        'https://loremflickr.com/800/600/farming,nature'
    ],
    [
        'The Psychology of Decision Fatigue',
        'How to simplify your life and save your willpower for what matters.',
        'Each choice we make depletes our mental energy. Learn to automate the mundane to excel in the complex.',
        'https://loremflickr.com/800/600/psychology,brain'
    ],
    [
        'Urban Nature: Rewilding the City',
        'Bringing back biodiversity to the streets and rooftops.',
        'Green corridors and pollinator paths are allowing wildlife to thrive amidst urban sprawl.',
        'https://loremflickr.com/800/600/urban,nature'
    ],
    [
        'Interstellar Travel: A Centennial Goal',
        'The propulsion systems being designed to reach the nearest stars.',
        'From light sails to ion thrusters, we are taking the first theoretical steps toward Proxima Centauri.',
        'https://loremflickr.com/800/600/spacecraft,mars'
    ],
    [
        'Gut Microbiome: The Second Brain',
        'The powerful link between your digestion and mental state.',
        'Research increasingly shows that the health of our gut bacteria affects our mood and overall well-being.',
        'https://loremflickr.com/800/600/science,medical'
    ],
    [
        'FinTech Revolution in 2026',
        'How AI is making financial advice accessible to everyone.',
        'Robo-advisors are evolving from simple algorithm-based tools to sophisticated emotional AI partners.',
        'https://loremflickr.com/800/600/fintech,data'
    ],
    [
        'Morning Routines for High Performance',
        'What the world\'s most productive people do in their first hour.',
        'The first 60 minutes of your day set the tone for the remaining 15 hours. Optimize accordingly.',
        'https://loremflickr.com/800/600/morning,sunrise'
    ],
    [
        'Wildlife Photography Ethics',
        'Getting the shot without disturbing the subject or the habitat.',
        'True conservation photography puts the welfare of the animal and its environment above the final image.',
        'https://loremflickr.com/800/600/wildlife,photography'
    ],
    [
        'The Stoic Approach to Modern Stress',
        'Ancient wisdom for emotional stability in a chaotic world.',
        'Marcus Aurelius and Seneca provide timeless protocols for focusing on what is within our control.',
        'https://loremflickr.com/800/600/stoic,history'
    ],
    [
        'Exploring the Mariana Trench',
        'What we found in the deepest, darkest part of the ocean.',
        'Strange life forms and plastic waste illustrate both the resilience of nature and the reach of humanity.',
        'https://loremflickr.com/800/600/underwater,ocean'
    ]
];

// --- High-Quality Article Seed Expansion (Phase 11) ---
$articleThemes = [
    'Technology' => [
        'titles' => ['Future of AI', 'Quantum Computing', 'Web 4.0 Ecosystems', 'Cybersecurity in 2026', 'Neural Interfaces', 'Sustainable Tech Stack'],
        'short' => ['How AI is reshaping our world.', 'The qubits are coming for your encryption.', 'A decentralized future without borders.'],
        'content' => ['Deep dive into the latest algorithmic breakthroughs.', 'A technical analysis of distributed ledger technology.']
    ],
    'Gastronomy' => [
        'titles' => ['The Molecular Kitchen', 'Ancient Grains Rediscovered', 'Hyper-Local Sourcing', 'Plant-Based Fine Dining', 'The Science of Fermentation'],
        'short' => ['Redefining the dining experience with chemistry.', 'Sustainable eats from your backyard.', 'Micro-seasonal menus represent the future.'],
        'content' => ['Exploring the chemical composition of flavor profiles.', 'A journey through traditional sourdough techniques.']
    ],
    'Finance' => [
        'titles' => ['DeFi Regulations', 'The CBDC Revolution', 'Algorithmic Trading Strategies', 'Wealth Management in Volatility', 'Tokenized Real Estate'],
        'short' => ['Central banks are going digital.', 'Managing risk in an unpredictable market.', 'Programmable money is changing the world.'],
        'content' => ['An economic analysis of inflationary pressures.', 'Strategies for long-term compound interest growth.']
    ],
    'Lifestyle' => [
        'titles' => ['Minimalism in 2026', 'Digital Nomad Paradises', 'Slow Living Movement', 'Curating Your Environment', 'The Art of Essentialism'],
        'short' => ['Living with less to achieve more.', 'Finding balance in a hyper-connected age.', 'How to design a life you don\'t need a vacation from.'],
        'content' => ['Practical steps to reduce digital clutter.', 'A guide to intentional habit formation.']
    ],
    'Health' => [
        'titles' => ['Biohacking Your Sleep', 'Precision Medicine', 'The Microbiome Mind Link', 'Longevity Protocols', 'Personalized Nutrition'],
        'short' => ['Optimizing your biology for peak performance.', 'Why your gut is your second brain.', 'The future of anti-aging science.'],
        'content' => ['Scientific review of circadian rhythm optimization.', 'Investigating the cellular mechanisms of autophagy.']
    ],
    'Science' => [
        'titles' => ['Dark Matter Mysteries', 'The Multi-Planetary Goal', 'Synthetic Biology Ethics', 'Fusion Energy Breakthroughs', 'Neutrino Detection'],
        'short' => ['Understanding the missing mass of the universe.', 'The engineering challenges of a Mars colony.', 'Clean energy is closer than ever.'],
        'content' => ['Astrophysical observations from the James Webb telescope.', 'Breaking down the physics of nuclear fusion.']
    ],
    'Nature' => [
        'titles' => ['Rewilding the Tundra', 'Oceanic Biodiversity', 'Regenerative Agriculture', 'The Intelligence of Mycelium', 'Vertical Forests'],
        'short' => ['Saving ecosystems one acre at a time.', 'How fungi help trees talk to each other.', 'Architecting nature into the city.'],
        'content' => ['Case study on reforestation and carbon sequestration.', 'Analysis of marine ecosystem resilience.']
    ],
    'Productivity' => [
        'titles' => ['Deep Work Mastery', 'The Flow State Protocol', 'Atomic Habit Compounding', 'Time Blocking 2.0', 'The Pareto Power'],
        'short' => ['Focus is the superpower of the 21st century.', 'Eliminating distractions to achieve more in less time.', 'How small wins lead to massive success.'],
        'content' => ['Applying neurobiology to professional performance.', 'A technical breakdown of cognitive load management.']
    ]
];

$articleStmt = $pdo->prepare("
    INSERT INTO articles (title, short_description, content, image_url, view_count, published_at) 
    VALUES (?, ?, ?, ?, ?, ?)
");

$pivotStmt = $pdo->prepare("INSERT INTO article_category (article_id, category_id) VALUES (?, ?)");

echo "Expanding articles to 20 per category...\n";

foreach ($categoryIds as $catIndex => $categoryId) {
    // Get the name/theme for this category
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$categoryId]);
    $catName = $stmt->fetchColumn();
    $theme = $articleThemes[$catName] ?? $articleThemes['Technology']; // Fallback
    
    echo "Seed for Category: {$catName}...\n";
    
    for ($i = 1; $i <= 20; $i++) {
        $titlePrefix = $theme['titles'][array_rand($theme['titles'])];
        $titleSuffix = ($i % 2 === 0) ? " Part $i" : " (Analysis $i)";
        $title = $titlePrefix . $titleSuffix;
        
        $short = $theme['short'][array_rand($theme['short'])] . " " . $i;
        $content = $theme['content'][array_rand($theme['content'])] . " [Batch Iteration $i] Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at porttitor sem. Aliquam ex ante, luctus vitae magna iaculis, egestas convallis.";
        
        $viewCount = rand(500, 10000);
        $publishedAt = date('Y-m-d H:i:s', strtotime("-" . rand(0, 365) . " days"));
        
        // Randomize image to avoid too much duplication
        $imgKeyword = strtolower(str_replace(' ', ',', $catName));
        $imageUrl = "https://loremflickr.com/800/600/{$imgKeyword}?lock=" . ($catIndex * 100 + $i);
        
        $articleStmt->execute([
            $title, 
            $short, 
            $content, 
            $imageUrl, 
            $viewCount, 
            $publishedAt
        ]);
        
        $articleId = (int)$pdo->lastInsertId();
        $pivotStmt->execute([$articleId, $categoryId]);
    }
}

echo "Seeding completed successfully! (Total articles created: " . (count($categoryIds) * 20) . ")\n";
