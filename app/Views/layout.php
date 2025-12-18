<!DOCTYPE html>
<html lang="<?= Language::current() ?>" dir="<?= Language::direction() ?>" class="<?= Language::cssClass() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- SEO Meta Tags -->
    <title><?= isset($title) ? htmlspecialchars($title) . ' - ' . Config::APP_NAME : Config::APP_NAME ?></title>
    <meta name="description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : Config::META_DESCRIPTION ?>">
    <meta name="keywords" content="<?= Config::META_KEYWORDS ?>">
    <meta name="author" content="CEMAC Trading">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= baseUrl($_SERVER['REQUEST_URI']) ?>">
    
    <!-- Open Graph Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= isset($title) ? htmlspecialchars($title) . ' - ' . Config::APP_NAME : Config::APP_NAME ?>">
    <meta property="og:description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : Config::META_DESCRIPTION ?>">
    <meta property="og:url" content="<?= baseUrl($_SERVER['REQUEST_URI']) ?>">
    <meta property="og:site_name" content="<?= Config::APP_NAME ?>">
    <meta property="og:locale" content="<?= Language::current() ?>">
    
    <!-- Twitter Card Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= isset($title) ? htmlspecialchars($title) . ' - ' . Config::APP_NAME : Config::APP_NAME ?>">
    <meta name="twitter:description" content="<?= isset($meta_description) ? htmlspecialchars($meta_description) : Config::META_DESCRIPTION ?>">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= Config::APP_NAME ?>",
        "url": "<?= Config::APP_URL ?>",
        "logo": "<?= asset('images/cemactrading-logo.jpg') ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Villa N°125 Avenue Prince de Galle - Akwa",
            "addressLocality": "Douala",
            "addressCountry": "CM"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+237678121232",
            "contactType": "customer service",
            "email": "contact@cemactrading.com"
        },
        "sameAs": [
            "https://wa.me/237678121232"
        ]
    }
    </script>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= asset('images/favicon.ico') ?>">
</head>
<body class="<?= Language::cssClass() ?>">

    <!-- Single Page Content -->
    <main class="single-page-content" id="main-content">
        <?= $content ?>
    </main>

    <!-- Scripts -->
    <script>
        const BASE_PATH = '<?= Config::APP_URL . Config::BASE_PATH ?>';
    </script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="<?= asset('js/app.js') ?>"></script>
    
    <!-- Google Analytics (Optional) -->
    <!-- Add your Google Analytics code here -->
</body>
</html>