# reCAPTCHA Setup Guide

Your contact form now includes reCAPTCHA protection to prevent spam submissions. To complete the setup, you need to obtain reCAPTCHA keys from Google.

## Step 1: Get reCAPTCHA Keys

1. Visit [Google reCAPTCHA Admin Console](https://www.google.com/recaptcha/admin/create)
2. Sign in with your Google account
3. Click on "+" to create a new site
4. Fill out the form:
   - **Label**: CEMAC Trading Contact Form
   - **reCAPTCHA type**: reCAPTCHA v2 → "I'm not a robot" Checkbox
   - **Domains**: Add your domain(s)
     - For local testing: `localhost`
     - For production: `your-domain.com` (replace with your actual domain)
5. Accept the reCAPTCHA Terms of Service
6. Click "Submit"

## Step 2: Configure Your Application

1. Copy the **Site Key** and **Secret Key** from the reCAPTCHA admin console
2. Open `app/Config/Config.php`
3. Replace the placeholder values:

```php
// reCAPTCHA Configuration
const RECAPTCHA_SITE_KEY = 'YOUR_ACTUAL_SITE_KEY_HERE';
const RECAPTCHA_SECRET_KEY = 'YOUR_ACTUAL_SECRET_KEY_HERE';
```

## Step 3: Test the Implementation

1. Navigate to your contact form
2. Try submitting without completing the reCAPTCHA - you should see an error
3. Complete the reCAPTCHA and submit - the form should work normally
4. Check that spam submissions are now blocked

## Security Notes

- Keep your **Secret Key** private - never expose it in client-side code
- The **Site Key** is public and used in the frontend
- Test thoroughly in both development and production environments
- Monitor your reCAPTCHA admin console for abuse reports

## Troubleshooting

### reCAPTCHA not showing

- Check that your domain is correctly configured in reCAPTCHA admin
- Ensure the Site Key is correct in Config.php
- Check browser console for JavaScript errors

### "Invalid site key" error

- Verify the Site Key in Config.php matches the admin console
- Ensure the domain matches what's configured in reCAPTCHA admin

### Form submission fails

- Check that the Secret Key is correct
- Verify your server can make HTTPS requests to Google's servers
- Check PHP error logs for detailed error messages

## Features Implemented

✅ reCAPTCHA v2 widget integrated into contact form  
✅ Server-side verification in PHP  
✅ Client-side validation with JavaScript  
✅ Multi-language error messages  
✅ Responsive design and styling  
✅ Proper error handling and user feedback

Your contact form is now protected against spam bots while maintaining a good user experience for legitimate visitors.
