<!-- Language Switcher (Floating) -->
<div class="language-switcher-float" id="language-switcher">
    <button class="language-toggle" id="language-toggle">
        <i class="fas fa-globe"></i>
        <span class="current-lang"><?= strtoupper(Language::current()) ?></span>
        <i class="fas fa-chevron-down"></i>
    </button>
    <div class="language-dropdown" id="language-dropdown">
        <?php 
        $languageNames = [
            'ar' => 'العربية',
            'en' => 'English', 
            'fr' => 'Français',
            'ru' => 'Русский',
            'zh' => '中文',
            'es' => 'Español'
        ];
        foreach (Config::SUPPORTED_LANGUAGES as $langCode): 
        ?>
            <a href="<?= baseUrl($langCode . (!empty($_GET['route']) ? '/' . $_GET['route'] : '')) ?>" 
               class="language-option <?= $langCode === Language::current() ? 'active' : '' ?>"
               data-lang="<?= $langCode ?>">
                <img src="<?= asset('images/flags/' . ($langCode === 'en' ? 'gb' : ($langCode === 'zh' ? 'cn' : $langCode)) . '.png') ?>" 
                     alt="<?= $languageNames[$langCode] ?>" 
                     class="flag-icon">
                <?= $languageNames[$langCode] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <div class="hero-main">
                <div class="hero-text">
                    <div class="hero-logo">
                        <img src="<?= asset('images/cemactrading-logo.jpg') ?>" alt="<?= Config::APP_NAME ?>" class="hero-logo-img">
                    </div>
                    <h1 class="hero-title"><?= __('home_title') ?></h1>
                    <p class="hero-description"><?= __('home_welcome') ?></p>
                </div>
                <div class="hero-visual">
                    <div class="hero-decorative">
                        <div class="floating-element element-1"><i class="fas fa-ship"></i></div>
                        <div class="floating-element element-2"><i class="fas fa-plane"></i></div>
                        <div class="floating-element element-3"><i class="fas fa-truck"></i></div>
                    </div>
                </div>
            </div>
            <div class="hero-buttons">
                <a href="#products" class="btn btn-primary smooth-scroll">
                    <i class="fas fa-file-alt"></i> <?= __('nav_quotation') ?>
                </a>
                <a href="#contact" class="btn btn-secondary smooth-scroll">
                    <i class="fas fa-envelope"></i> <?= __('nav_contact') ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section class="about-section" id="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2><?= __('who_we_are') ?></h2>
                <p><?= __('who_we_are_text') ?></p>
            </div>
            <div class="col-md-6">
                <div class="about-image">
                    <img src="<?= asset('images/about-placeholder.jpg') ?>" alt="<?= __('who_we_are') ?>" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
    <div class="container">
        <h2 class="section-title"><?= __('our_services') ?></h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-ship"></i>
                </div>
                <h3><?= __('service_import') ?></h3>
                <p><?= __('service_import_desc') ?></p>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-plane"></i>
                </div>
                <h3><?= __('service_export') ?></h3>
                <p><?= __('service_export_desc') ?></p>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3><?= __('service_supply') ?></h3>
                <p><?= __('service_supply_desc') ?></p>
            </div>
            
            <div class="service-card">
                <div class="service-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3><?= __('service_customs') ?></h3>
                <p><?= __('service_customs_desc') ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section" id="products">
    <div class="container">
        <div class="products-intro">
            <h2><?= __('products_title') ?></h2>
            <p><?= __('products_intro') ?></p>
        </div>
        
        <div class="products-table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th><?= __('product_image') ?></th>
                        <th><?= __('product_name') ?></th>
                        <th><?= __('product_description') ?></th>
                        <th><?= __('product_season') ?></th>
                        <th><?= __('product_packaging') ?></th>
                        <th><?= __('product_price') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr class="product-row">
                            <td class="product-image-cell">
                                <div class="product-image">
                                    <img src="<?= asset('images/' . htmlspecialchars($product['image'])) ?>" 
                                         alt="<?= htmlspecialchars($product['name']) ?>" 
                                         loading="lazy">
                                </div>
                            </td>
                            <td class="product-name">
                                <h4><?= htmlspecialchars($product['name']) ?></h4>
                            </td>
                            <td class="product-description">
                                <p><?= htmlspecialchars($product['description']) ?></p>
                            </td>
                            <td class="product-season">
                                <?= htmlspecialchars($product['season']) ?>
                            </td>
                            <td class="product-packaging">
                                <?= htmlspecialchars($product['packaging']) ?>
                            </td>
                            <td class="product-price">
                                <?php if ($product['price'] !== '-'): ?>
                                    <span class="price"><?= $product['price'] ?></span>
                                <?php else: ?>
                                    <span class="price-contact"><?= __('contact_us') ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Products Display -->
        <div class="products-mobile">
            <?php foreach ($products as $product): ?>
                <div class="product-card-mobile">
                    <div class="product-image-mobile">
                        <img src="<?= asset('images/' . htmlspecialchars($product['image'])) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             loading="lazy">
                    </div>
                    <div class="product-info-mobile">
                        <h4 class="product-name-mobile"><?= htmlspecialchars($product['name']) ?></h4>
                        <p class="product-description-mobile"><?= htmlspecialchars($product['description']) ?></p>
                        
                        <div class="product-details-mobile">
                            <div class="detail-item">
                                <strong><?= __('product_season') ?>:</strong> <?= htmlspecialchars($product['season']) ?>
                            </div>
                            <div class="detail-item">
                                <strong><?= __('product_packaging') ?>:</strong> <?= htmlspecialchars($product['packaging']) ?>
                            </div>
                            <div class="detail-item">
                                <strong><?= __('product_price') ?>:</strong> 
                                <?php if ($product['price'] !== '-'): ?>
                                    <span class="price"><?= $product['price'] ?></span>
                                <?php else: ?>
                                    <span class="price-contact"><?= __('contact_us') ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-section" id="why-us">
    <div class="container">
        <h2 class="section-title"><?= __('why_choose_us') ?></h2>
        <div class="why-grid">
            <div class="why-item">
                <div class="why-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <h4><?= __('why_reliable') ?></h4>
            </div>
            
            <div class="why-item">
                <div class="why-icon">
                    <i class="fas fa-star"></i>
                </div>
                <h4><?= __('why_quality') ?></h4>
            </div>
            
            <div class="why-item">
                <div class="why-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h4><?= __('why_location') ?></h4>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-intro">
            <h2><?= __('contact_title') ?></h2>
            <p><?= __('contact_description') ?></p>
        </div>
        
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-container">
                    <h3><?= __('contact_form_message') ?></h3>
                    
                    <!-- Display messages -->
                    <?php if (isset($_SESSION['contact_message'])): ?>
                        <div class="alert alert-<?= $_SESSION['contact_type'] ?>">
                            <?= htmlspecialchars($_SESSION['contact_message']) ?>
                        </div>
                        <?php 
                        unset($_SESSION['contact_message']);
                        unset($_SESSION['contact_type']);
                        ?>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= baseUrl('contact') ?>" class="contact-form" id="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name"><?= __('form_name') ?> *</label>
                                <input type="text" id="name" name="name" required 
                                       placeholder="Votre nom complet">
                            </div>
                            
                            <div class="form-group">
                                <label for="email"><?= __('form_email') ?> *</label>
                                <input type="email" id="email" name="email" required 
                                       placeholder="votre@email.com">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message"><?= __('form_message') ?> *</label>
                            <textarea id="message" name="message" rows="6" required 
                                      placeholder="Décrivez votre demande..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-submit">
                            <i class="fas fa-paper-plane"></i> <?= __('form_send') ?>
                        </button>
                        
                        <small class="form-note">
                            <i class="fas fa-info-circle"></i> 
                            <?= __('form_required') ?>
                        </small>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4">
                <div class="contact-info-container">
                    <h3><?= __('nav_contact') ?></h3>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h4><?= __('address') ?></h4>
                            <p><?= Config::COMPANY_INFO['address'] ?></p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-details">
                            <h4><?= __('phone') ?></h4>
                            <p>
                                <a href="tel:<?= Config::COMPANY_INFO['phone'] ?>" class="contact-link">
                                    <?= Config::COMPANY_INFO['phone'] ?>
                                </a>
                            </p>
                            <p>
                                <a href="<?= Config::SOCIAL_LINKS['whatsapp'] ?>" 
                                   target="_blank" rel="noopener" class="whatsapp-link">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="contact-info-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h4><?= __('email') ?></h4>
                            <p>
                                <a href="mailto:<?= Config::COMPANY_INFO['email'] ?>" class="contact-link">
                                    <?= Config::COMPANY_INFO['email'] ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Business Hours -->
                    <div class="business-hours">
                        <h4><i class="fas fa-clock"></i> Heures d'ouverture</h4>
                        <ul>
                            <li>Lundi - Vendredi: 8h00 - 18h00</li>
                            <li>Samedi: 8h00 - 14h00</li>
                            <li>Dimanche: Fermé</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="map-section">
    <div class="container">
        <h3>Notre Localisation</h3>
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3969.6785737845943!2d9.70195431465893!3d4.051509897139654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10610c5e8a6a8ff7%3A0x8a1c4f8b6c7c5c5c!2sAkwa%2C%20Douala%2C%20Cameroon!5e0!3m2!1sen!2s!4v1635234567890!5m2!1sen!2s"
                width="100%" 
                height="400" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="CEMAC Trading Location">
            </iframe>
        </div>
    </div>
</section>

<!-- Footer Section -->
<section class="footer-section">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section-content">
                <h3><?= Config::APP_NAME ?></h3>
                <p><?= __('home_description') ?></p>
                <div class="social-links">
                    <a href="<?= Config::SOCIAL_LINKS['whatsapp'] ?>" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="<?= Config::SOCIAL_LINKS['email'] ?>" target="_blank" rel="noopener">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            
            <div class="footer-section-content">
                <h4>Informations de Contact</h4>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> <?= Config::COMPANY_INFO['address'] ?></p>
                    <p><i class="fas fa-phone"></i> <a href="tel:<?= Config::COMPANY_INFO['phone'] ?>"><?= Config::COMPANY_INFO['phone'] ?></a></p>
                    <p><i class="fas fa-envelope"></i> <a href="mailto:<?= Config::COMPANY_INFO['email'] ?>"><?= Config::COMPANY_INFO['email'] ?></a></p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 <?= Config::APP_NAME ?>. Tous droits réservés.</p>
        </div>
    </div>
</section>