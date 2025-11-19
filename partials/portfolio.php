<?php
require_once 'server.php';
?>

<section class="portfolio" id="portfolio">
    <div class="container">
        <h2 class="section-title">Наше портфолио</h2>
        <div class="portfolio-filters">
            <button class="filter-btn active" data-filter="all">Все работы</button>
            <?php
            // Получаем категории для фильтров
            $categories = $pdo->query("SELECT * FROM category")->fetchAll();
            foreach ($categories as $category): ?>
                <button class="filter-btn" data-filter="<?php echo htmlspecialchars($category['Name']); ?>">
                    <?php echo htmlspecialchars($category['Name']); ?>
                </button>
            <?php endforeach; ?>
        </div>
        <div class="portfolio-grid">
            <?php
            $works = getPortfolioWorks();
            foreach ($works as $work): ?>
                <div class="portfolio-item" data-category="<?php echo htmlspecialchars($work['category_name']); ?>">
                    <img src="<?php echo htmlspecialchars($work['Image_url']); ?>" 
                         alt="<?php echo htmlspecialchars($work['Title']); ?>">
                    <div class="portfolio-overlay">
                        <h3><?php echo htmlspecialchars($work['Title']); ?></h3>
                        <p><?php echo htmlspecialchars($work['Description']); ?></p>
                        <p><strong>Услуга:</strong> <?php echo htmlspecialchars($work['service_name']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>