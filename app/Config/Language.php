<?php
/**
 * Language Management System
 */

class Language
{
    private static $translations = [];
    private static $currentLanguage = 'en';
    
    /**
     * Load language file
     */
    public static function load($language)
    {
        self::$currentLanguage = $language;
        $languageFile = PUBLIC_PATH . "/lang/{$language}.php";
        
        if (file_exists($languageFile)) {
            self::$translations = include $languageFile;
        } else {
            // Fallback to English
            $fallbackFile = PUBLIC_PATH . "/lang/en.php";
            if (file_exists($fallbackFile)) {
                self::$translations = include $fallbackFile;
            }
        }
    }
    
    /**
     * Get translation for a key
     */
    public static function get($key, $default = null)
    {
        return self::$translations[$key] ?? $default ?? $key;
    }
    
    /**
     * Get current language
     */
    public static function current()
    {
        return self::$currentLanguage;
    }
    
    /**
     * Get language direction (RTL for Arabic)
     */
    public static function direction()
    {
        return self::$currentLanguage === 'ar' ? 'rtl' : 'ltr';
    }
    
    /**
     * Get language class for CSS
     */
    public static function cssClass()
    {
        return 'lang-' . self::$currentLanguage;
    }
}

/**
 * Helper function for translations
 */
function __($key, $default = null)
{
    return Language::get($key, $default);
}