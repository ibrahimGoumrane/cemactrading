<?php
/**
 * Application Configuration
 */

class Config
{
    // Application settings
    const APP_NAME = 'CEMAC Trading';
    const APP_URL = 'http://localhost/cemactrading/';
    const BASE_PATH = '';
    const DEFAULT_LANGUAGE = 'en';
    
    // Supported languages
    const SUPPORTED_LANGUAGES = ['ar', 'en', 'fr', 'ru', 'zh', 'es'];
    
    // Language names
    const LANGUAGE_NAMES = [
        'ar' => 'العربية',
        'en' => 'English',
        'fr' => 'Français',
        'ru' => 'Русский',
        'zh' => '中文',
        'es' => 'Español'
    ];
    
    // Contact settings
    const CONTACT_EMAIL = 'contact@cemactrading.com';
    const ADMIN_EMAILS = ['contact@cemactrading.com'];
    
    // SMTP Email Configuration (Formafast with TLS)
    const SMTP_HOST = 'mail.formafast.com';
    const SMTP_PORT = 587;
    const SMTP_USERNAME = 'mail@formafast.com';
    const SMTP_PASSWORD = 'Mail.Formafast.216';
    const SMTP_FROM_EMAIL = 'mail@formafast.com';
    const SMTP_FROM_NAME = 'CEMAC Trading';
    
    // SEO settings
    const META_DESCRIPTION = 'CEMAC Trading - Import & Export Specialists based in Douala, Cameroon. High-quality food products, supply chain management, and customs assistance.';
    const META_KEYWORDS = 'CEMAC Trading, import, export, food products, Douala, Cameroon, supply chain, customs, agriculture';
    
    // Social media
    const SOCIAL_LINKS = [
        'whatsapp' => 'https://wa.me/237678121232',
        'email' => 'mailto:contact@cemactrading.com'
    ];
    
    // Company information
    const COMPANY_INFO = [
        'name' => 'CEMAC Trading',
        'address' => 'Villa N°125 Avenue Prince de Galle - Akwa - Douala - Cameroun',
        'phone' => '+237 678 12 12 32',
        'email' => 'contact@cemactrading.com'
    ];
}