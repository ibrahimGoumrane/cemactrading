<!-- 404 Error Page -->
<section class="error-section">
    <div class="container">
        <div class="error-content">
            <div class="error-image">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1>404</h1>
            <h2>Page Not Found</h2>
            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
            
            <div class="error-actions">
                <a href="/<?= Language::current() ?>" class="btn btn-primary">
                    <i class="fas fa-home"></i> Go Home
                </a>
                <a href="/<?= Language::current() ?>/contact" class="btn btn-secondary">
                    <i class="fas fa-envelope"></i> Contact Us
                </a>
            </div>
        </div>
    </div>
</section>