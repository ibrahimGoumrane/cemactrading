# CEMAC Trading - Modern MVC Web Application

A professional, multilingual trading company website built with PHP MVC architecture, featuring beautiful responsive design and SEO optimization.

## 🌟 Features

### Multilingual Support

- **6 Languages**: Arabic (RTL), English, French, Russian, Chinese, Spanish
- Automatic language detection from browser settings
- SEO-friendly language routing (`/en/`, `/ar/`, etc.)
- Full RTL support for Arabic language

### Modern Architecture

- **MVC Pattern**: Clean separation of concerns
- **Responsive Design**: Mobile-first approach with CSS Grid and Flexbox
- **SEO Optimized**: Structured data, meta tags, sitemap generation
- **Accessibility**: WCAG 2.1 compliant with keyboard navigation
- **Performance**: Lazy loading, preloading, optimized assets

### Business Features

- Company profile and services showcase
- Product catalog with detailed specifications
- Contact form with validation and email integration
- Quotation request system
- Automatic sitemap generation
- Social media integration

## 🚀 Quick Start

### Requirements

- PHP 7.4 or higher
- Web server (Apache/Nginx)
- mod_rewrite enabled for clean URLs

### Installation

1. **Clone/Download** the application to your web server:

   ```
   /your-web-root/new/
   ```

2. **Configure Web Server** - The `.htaccess` file is already configured for Apache

3. **Set Permissions** (if on Linux/Mac):

   ```bash
   chmod -R 755 /path/to/application
   chmod -R 777 /path/to/application/data/ (if using file cache)
   ```

4. **Configure Application** - Edit `app/Config/Config.php`:

   ```php
   // Update company information
   const COMPANY_NAME = 'Your Company Name';
   const COMPANY_EMAIL = 'your-email@domain.com';
   // ... other settings
   ```

5. **Test Installation** - Visit your domain:
   ```
   http://yourdomain.com/new/
   ```

## 📁 Project Structure

```
new/
├── index.php                 # Application entry point
├── .htaccess                 # URL rewriting and security
├── app/
│   ├── Config/
│   │   ├── Config.php        # Application configuration
│   │   └── Language.php      # Translation system
│   ├── Controllers/
│   │   └── HomeController.php # Main application controller
│   ├── Views/
│   │   ├── layout.php        # Main layout template
│   │   ├── home.php          # Homepage
│   │   ├── quotation.php     # Quotation form
│   │   ├── contact.php       # Contact form
│   │   ├── 404.php           # Error page
│   │   └── sitemap.php       # Sitemap XML
│   └── Languages/
│       ├── ar.php            # Arabic translations
│       ├── en.php            # English translations
│       ├── fr.php            # French translations
│       ├── ru.php            # Russian translations
│       ├── zh.php            # Chinese translations
│       └── es.php            # Spanish translations
└── public/
    ├── css/
    │   └── style.css         # Main stylesheet
    ├── js/
    │   └── app.js            # JavaScript functionality
    └── images/
        └── README.md         # Image requirements guide
```

## 🎨 Customization

### Styling

- Edit `public/css/style.css` for design changes
- CSS custom properties make theming easy:
  ```css
  :root {
    --primary-color: #007bff; /* Change brand color */
    --secondary-color: #6c757d;
    --font-family: "Poppins", sans-serif;
  }
  ```

### Content

- Update translations in `app/Languages/*.php`
- Modify company info in `app/Config/Config.php`
- Edit page content in `app/Views/*.php`

### Adding New Languages

1. Create new language file: `app/Languages/xx.php`
2. Add language to config: `app/Config/Config.php`
3. Add routes in `.htaccess`

### Adding New Pages

1. Add method to `HomeController.php`
2. Create view file in `app/Views/`
3. Add navigation links
4. Update translations

## 🔧 Configuration

### Email Setup

Edit `app/Controllers/HomeController.php` to configure email:

```php
private function sendEmail($formData) {
    // Configure your email settings here
    // Options: PHP mail(), SMTP, or email service API
}
```

### SEO Configuration

Update meta tags and structured data in:

- `app/Config/Config.php` - Global SEO settings
- `app/Views/layout.php` - Meta tags template
- Individual view files for page-specific SEO

### Security Settings

The `.htaccess` file includes:

- Security headers (HSTS, CSP, X-Frame-Options)
- File access restrictions
- HTTPS redirection (uncomment if needed)

## 📱 Responsive Design

### Breakpoints

- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

### Features

- Mobile-first CSS approach
- Hamburger navigation for mobile
- Responsive tables with card view fallback
- Touch-friendly interface elements

## 🌍 Internationalization

### Supported Languages

| Code | Language | Direction |
| ---- | -------- | --------- |
| ar   | Arabic   | RTL       |
| en   | English  | LTR       |
| fr   | French   | LTR       |
| ru   | Russian  | LTR       |
| zh   | Chinese  | LTR       |
| es   | Spanish  | LTR       |

### Translation Helper

```php
<?= t('translation_key') ?>
// Outputs translated text based on current language
```

## ⚡ Performance

### Optimization Features

- CSS and JS minification ready
- Image lazy loading
- Critical resource preloading
- Efficient caching headers
- Gzip compression enabled

### Page Speed Tips

1. Optimize images (use WebP format)
2. Enable CDN for static assets
3. Use PHP OPcache in production
4. Implement Redis/Memcached for sessions

## 🔒 Security

### Security Features

- Input validation and sanitization
- CSRF protection ready
- XSS prevention
- SQL injection protection (when using database)
- Security headers configured

### Production Checklist

- [ ] Remove development comments
- [ ] Enable error logging, disable display_errors
- [ ] Configure secure session settings
- [ ] Set up HTTPS with proper certificates
- [ ] Regular security updates

## 🚀 Deployment

### Development

- Use PHP built-in server: `php -S localhost:8000`
- Access: `http://localhost:8000/new/`

### Production

1. Upload files to web server
2. Configure domain to point to `/new/` directory
3. Set up SSL certificate
4. Configure email delivery
5. Set production environment settings

### Performance Monitoring

- Enable error logging
- Monitor page load times
- Track user interactions
- Set up uptime monitoring

## 🆘 Troubleshooting

### Common Issues

**Clean URLs not working**

- Ensure mod_rewrite is enabled
- Check `.htaccess` file permissions
- Verify AllowOverride is set in Apache config

**Language switching not working**

- Check that all language files exist
- Verify language codes in Config.php
- Ensure routes are properly configured

**Contact form not sending emails**

- Configure SMTP settings or use mail service API
- Check server mail() function availability
- Verify email addresses and DNS settings

**Mobile navigation not working**

- Check that JavaScript file is loaded
- Verify hamburger button HTML structure
- Check browser console for errors

## 📈 Analytics Integration

### Google Analytics 4

Add tracking code to `app/Views/layout.php`:

```html
<!-- Google Analytics -->
<script
  async
  src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"
></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag("js", new Date());
  gtag("config", "GA_MEASUREMENT_ID");
</script>
```

### Facebook Pixel

```html
<!-- Facebook Pixel -->
<script>
  !(function (f, b, e, v, n, t, s) {
    if (f.fbq) return;
    n = f.fbq = function () {
      n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
    };
    if (!f._fbq) f._fbq = n;
    n.push = n;
    n.loaded = !0;
    n.version = "2.0";
    n.queue = [];
    t = b.createElement(e);
    t.async = !0;
    t.src = v;
    s = b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t, s);
  })(
    window,
    document,
    "script",
    "https://connect.facebook.net/en_US/fbevents.js"
  );
  fbq("init", "PIXEL_ID");
  fbq("track", "PageView");
</script>
```

## 📞 Support

### Resources

- **Documentation**: This README file
- **Configuration**: `app/Config/Config.php`
- **Language Files**: `app/Languages/`
- **Styling Guide**: `public/css/style.css` comments

### Need Help?

1. Check browser console for JavaScript errors
2. Review server error logs
3. Verify file permissions
4. Test with different browsers/devices

## 📄 License

This project is built for CEMAC Trading and customized for their specific business needs. All rights reserved.

---

**Built with ❤️ for CEMAC Trading**

_Professional trading solutions with modern web technology_
