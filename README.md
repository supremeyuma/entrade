# Entrade - Crypto Copy-Trading Platform

A full-stack cryptocurrency trading platform that enables users to discover, evaluate, and automatically copy trades from professional traders. Built with modern web technologies and designed for scale, security, and real-time performance.

## 🎯 Project Overview

Entrade is a sophisticated social copy-trading platform where retail investors can:
- Browse and compare professional traders by performance metrics (ROI, win rate, etc.)
- Subscribe to traders and automatically replicate their trades in real-time
- Track trading history and portfolio performance with detailed analytics
- Access market data and backtesting capabilities for informed decisions
- Execute secure deposits and withdrawals with multi-currency support
- Participate in referral programs to earn rewards

## ✨ Key Features

### Trading & Portfolio Management
- **Live Trader Leaderboard** - Real-time ranking of traders by ROI with multi-timeframe analytics (1W, 1M, 12M)
- **Trader Comparison** - Side-by-side analysis of trader performance, strategies, and statistics
- **Trader Subscriptions** - Follow and auto-copy trades from top-performing traders
- **Trade History Tracking** - Detailed transaction logs with entry/exit points and ROI calculations
- **Balance Management** - Real-time balance updates and portfolio valuation
- **Automated Trade Replication** - Background job processing for instant trade execution

### User Management & Security
- **Email Verification** - Secure user registration with verified email addresses
- **KYC Compliance** - Multi-document document verification with ID and passport support
- **User Account Settings** - Customizable user preferences and security options
- **Role-Based Access Control** (RBAC) - Spatie permissions for granular access management
- **Referral Program** - Multi-tier referral system with bonus calculations

### Financial Operations
- **Crypto Payments** - Plisio SDK integration for stablecoin deposits
- **Withdrawal Management** - Customizable withdrawal settings and processing
- **Deposit Tracking** - Complete transaction history with timestamps and amounts
- **User Wallets** - Multi-wallet support for different assets

### Data & Analytics
- **Market Data Integration** - Automated OHLCV data downloads for crypto symbols (BTC/USDT, etc.)
- **Backtesting Engine** - Historical trade simulation for strategy validation
- **Performance Analytics** - ROI calculations, win rate analysis, and trend visualization
- **Real-Time Charts** - Interactive Chart.js visualizations of trading data

## 💻 Technology Stack

### Backend
- **Framework**: Laravel 10.10 (PHP 8.1+) - Enterprise-grade web framework
- **Authentication**: Laravel Sanctum + Jetstream - Token-based API auth, multi-factor options
- **Real-Time Communication**: Pusher + Laravel Echo - Real-time updates and WebSocket support
- **Permissions**: Spatie Laravel Permission - Fine-grained access control
- **Payment Processing**: Plisio SDK - Native GuzzleHTTP client for crypto transactions
- **Job Queuing**: Laravel Queues - Background task processing for trade replication & data downloads
- **Database ORM**: Eloquent - Type-safe model relationships and query builder
- **PDF Generation**: Laravel DomPDF - Invoice and document generation
- **QR Codes**: Endroid QR Code Library - Dynamic QR generation for wallet addresses

### Frontend
- **UI Framework**: Livewire 3.6 - Dynamic, reactive components without leaving PHP
- **Styling**: Tailwind CSS 3.4.17 + Bootstrap 5.2 - Responsive utility-first design
- **Interactivity**: Alpine.js 3.4.2 - Lightweight reactive data binding
- **Build Tool**: Vite 6.3.4 - Lightning-fast bundling and HMR
- **Charts**: Chart.js 4.5.0 - Interactive financial data visualization
- **CSS Preprocessing**: SASS 1.56 + PostCSS - Advanced stylesheet features

### DevOps & Testing
- **Testing Framework**: PHPUnit 10.1 + Mockery - Unit and feature test suites
- **Code Quality**: Laravel Pint - PSR-12 coding standards enforcement
- **Environment**: Laravel Sail - Docker-based local development environment
- **Version Control**: Git with comprehensive .gitignore

## 🏗️ Architecture Highlights

### Clean Code Principles
- **Separation of Concerns**: Distinct layers for Controllers, Services, Models, and Jobs
- **Service-Oriented Architecture**: Reusable business logic in dedicated service classes
  - `MarketDataService` - Centralized API calls and data processing
  - `TradeHistoryService` - Trade analytics and calculations
  - `SiteSettingsService` - Configuration management
  - `BacktestSimulator` - Trade simulation engine
- **Repository Pattern**: Eloquent models as repositories for data access
- **Dependency Injection**: Full Laravel IoC container utilization

### Scalability & Performance
- **Job Queue System** - Asynchronous processing with configurable retry logic
  - `DownloadDailyOhlcvDataJob` - Market data synchronization
  - `GenerateTradesJob` - Real-time trade generation
  - `GenerateSimulatedTradesJob` - Backtesting trades
  - `GenerateHistoricalTradesJob` - Historical data processing
- **Caching Strategy** - Redis support (Predis) for high-frequency data access
- **Broadcasting** - Real-time leaderboard and balance updates via WebSockets
- **Lazy Loading & Eager Loading** - Optimized database queries with Eloquent relationships

### Security Implementation
- **API Token Authentication** - Sanctum JWT tokens for stateless API authentication
- **CORS Configuration** - Cross-origin request filtering for SPA support
- **Form Validation** - Dedicated Request classes with validation rules
- **File Upload Security** - Restricted MIME types (JPG, PNG, PDF) and storage isolation
- **Database Transactions** - Atomic operations for financial transactions
- **Permission Middleware** - Role-based route protection

## 📁 Project Structure

```
entrade/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Request handlers with business logic routing
│   │   ├── Requests/       # Form validation rules
│   │   ├── Middleware/     # Auth and request processing
│   │   └── Livewire/       # Real-time component controllers
│   ├── Models/             # Eloquent models with relationships
│   ├── Services/           # Core business logic (data, trade processing)
│   ├── Jobs/               # Queued async tasks
│   ├── Helpers/            # Utility functions
│   └── Actions/            # Fortify & Jetstream auth actions
├── resources/
│   ├── views/              # Blade templates & Livewire components
│   ├── js/                 # TypeScript/JavaScript frontend code
│   └── css/                # Tailwind CSS
├── database/
│   ├── migrations/         # Schema definitions
│   └── seeders/            # Test data generation
├── routes/
│   ├── web.php             # Website routes
│   ├── api.php             # REST API routes
│   └── auth.php            # Authentication flows
├── tests/                  # PHPUnit test suites
└── config/                 # Application configuration files
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.1 or higher
- Composer
- Node.js & npm
- Docker (optional, for Laravel Sail)
- MySQL or PostgreSQL

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd entrade
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   php artisan jwt:secret  # Generate JWT secret
   ```

5. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   npm run dev  # In another terminal for Vite
   ```

## 🔧 Development Commands

```bash
# Run tests
composer test

# Format code with Pint
composer format

# Run database migrations
php artisan migrate

# Clear application cache
php artisan cache:clear

# Process queue jobs
php artisan queue:work
```

## 📊 Future Roadmap

- Advanced portfolio analytics dashboard
- Machine learning trader performance prediction
- Multi-exchange integration (Binance, Kraken, etc.)
- Mobile app (React Native)
- Advanced risk management tools
- Automated strategy backtesting UI
- Trader review and rating system

## 🤝 Contributing

Contributions are welcome! Please follow PSR-12 coding standards and include tests for new features.

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.

---

**Built for traders, by traders. Democratizing access to professional trading strategies.**