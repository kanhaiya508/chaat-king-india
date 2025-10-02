# 🍴 Chaat King India - Restaurant Management System

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat&logo=laravel)](https://laravel.com)
[![PWA Ready](https://img.shields.io/badge/PWA-Ready-4285F4?style=flat&logo=pwa)](https://web.dev/progressive-web-apps/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

A complete restaurant management system built with Laravel 11, featuring order management, KOT printing, billing, and **Progressive Web App (PWA)** support for installation on any device.

## ✨ Key Features

- 📱 **Progressive Web App** - Install on mobile, tablet, or desktop
- 🍽️ Order Management (Dine-in, Takeaway, Delivery)
- 🖨️ Kitchen Order Ticket (KOT) Printing
- 💰 Payment Processing (Cash, Card, UPI, WriteOff)
- 📊 Real-time Reports & Analytics
- 👥 Staff & Branch Management
- 🎟️ Event Hall Booking System
- 🔔 Push Notifications Support
- 📴 Offline Mode Support
- 🔒 Secure Authentication

## 📱 PWA Features

This application is a **fully functional Progressive Web App**:

- ✅ **Install on Any Device** - Works like a native app
- ✅ **Offline Support** - Access cached data without internet
- ✅ **Push Notifications** - Real-time order updates
- ✅ **Fast Performance** - Service worker caching
- ✅ **Responsive Design** - Optimized for all screen sizes
- ✅ **Auto Updates** - Always get the latest version

### 🚀 Quick PWA Setup

1. **Generate Icons:**
   ```bash
   # Visit this page to generate PWA icons:
   http://your-domain.com/icons/icon-generator.html
   ```

2. **Test Installation:**
   ```bash
   # Check PWA status:
   http://your-domain.com/pwa-test.html
   ```

3. **Complete Guide:**
   See [PWA_SETUP_GUIDE.md](PWA_SETUP_GUIDE.md) for detailed instructions.

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- MySQL 8.0 or higher
- Node.js & NPM
- Web server (Apache/Nginx)
- **HTTPS** (required for PWA in production)

## 🛠️ Installation

1. **Clone Repository:**
   ```bash
   git clone <repository-url>
   cd chaat-king-india
   ```

2. **Install Dependencies:**
   ```bash
   composer install
   npm install && npm run build
   ```

3. **Environment Setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=chaat_king
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Run Migrations:**
   ```bash
   php artisan migrate --seed
   ```

6. **Generate PWA Icons:**
   - Visit `/icons/icon-generator.html`
   - Save all generated icons to `public/icons/`

7. **Start Server:**
   ```bash
   php artisan serve
   ```

8. **Access Application:**
   ```
   http://localhost:8000
   ```

## 📱 Installing as PWA

### Desktop (Chrome/Edge):
1. Visit the application
2. Click **"Install App"** button (bottom-right)
3. Confirm installation
4. App opens in standalone window

### Android:
1. Open in Chrome
2. Menu (⋮) → **"Install app"**
3. Tap **"Install"**
4. App icon appears on home screen

### iOS (iPhone/iPad):
1. Open in Safari
2. Share button (□↑)
3. **"Add to Home Screen"**
4. Tap **"Add"**

## 🔧 Configuration

### PWA Configuration

Edit `public/manifest.json` to customize:
```json
{
    "name": "Your Restaurant Name",
    "short_name": "YourApp",
    "theme_color": "#800020",
    "background_color": "#800020"
}
```

### Service Worker

Customize caching in `public/service-worker.js`:
```javascript
const STATIC_ASSETS = [
    '/',
    '/css/app.css',
    // Add more assets to cache
];
```

## 📚 Documentation

- [API Documentation](API_DOCUMENTATION.md)
- [PWA Setup Guide](PWA_SETUP_GUIDE.md)
- [Testing Guide](/pwa-test.html)

## 🎨 Theme

Current theme uses **Burgundy (#800020)** color scheme. To change:

1. Update `public/manifest.json`
2. Update `resources/views/app/layouts/app.blade.php` meta tags
3. Update `public/css/auth.css`

## 🧪 Testing

### PWA Testing:
```bash
# Visit PWA test page:
http://your-domain.com/pwa-test.html
```

### Run Lighthouse Audit:
1. Open DevTools (F12)
2. Go to "Lighthouse" tab
3. Select "Progressive Web App"
4. Click "Generate report"
5. Aim for 90+ score

## 📊 Features Breakdown

### Order Management
- Create/Edit orders (Dine-in, Takeaway, Delivery)
- Multiple payment methods
- Order filtering and search
- Real-time order status

### KOT System
- Print kitchen orders by group
- Track printed/unprinted items
- Support for addons and remarks
- Automatic group assignment

### Billing
- Multiple payment methods
- Split payments
- Discount management
- Print receipts

### Reports
- Daily/Monthly sales
- Top selling items
- Payment summaries
- Order type analysis

### Event Management
- Hall booking system
- Slot management
- Booking calendar
- Customer management

## 🔒 Security

- Password-protected order deletion
- User authentication required
- Secure payment processing
- CSRF protection
- XSS protection

## 🤝 Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Open pull request

## 📄 License

This project is licensed under the MIT License.

## 👨‍💻 Support

For issues or questions:
- Check [PWA Setup Guide](PWA_SETUP_GUIDE.md)
- Visit [PWA Test Page](/pwa-test.html)
- Open an issue on GitHub

---

## 🎉 What's Next?

After installation:
1. ✅ Generate PWA icons ([Guide](/icons/icon-generator.html))
2. ✅ Test PWA installation ([Test Page](/pwa-test.html))
3. ✅ Configure your brand colors
4. ✅ Set up HTTPS for production
5. ✅ Run Lighthouse audit
6. ✅ Deploy and enjoy!

---

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
