# BigData Research Management System

A comprehensive web-based platform for managing research projects, tasks, and collaboration between patrons, research assistants, and administrators.

## 🚀 Features

### Multi-Role System
- **Admin**: Complete system management, user oversight, and task coordination
- **Patron**: Project creation, task assignment, and research assistant management
- **Research Assistant**: Task execution, progress tracking, and collaboration

### Core Functionality
- **Project Management**: Create, edit, and manage research projects with priorities
- **Task Management**: Assign tasks, track progress, and manage completion status
- **User Management**: Register users, manage roles, and handle permissions
- **Dashboard Analytics**: Real-time statistics and progress tracking
- **News & Publications**: Content management for research updates
- **Password Reset**: Secure password recovery system

## 🛠️ Technology Stack

- **Framework**: Laravel 10.x
- **Frontend**: Blade Templates, Bootstrap 5, FontAwesome
- **Database**: MySQL/MariaDB
- **Authentication**: Laravel Breeze
- **Styling**: Custom CSS with consistent theming
- **Icons**: FontAwesome 6.x

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.1
- **Composer** >= 2.0
- **Node.js** >= 16.x
- **NPM** or **Yarn**
- **MySQL** >= 8.0 or **MariaDB** >= 10.3
- **Git**

## 🔧 Installation

### 1. Clone the Repository
```bash
git clone https://github.com/Liven-Allan/web.git
cd bigdata-research-system
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
# or
yarn install
```

### 4. Environment Configuration
```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Setup
Edit your `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=big_data_lab
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run Migrations
```bash
# Create database tables
php artisan migrate

# (Optional) Seed with sample data
php artisan db:seed
```

### 7. Build Assets
```bash
# Compile CSS and JS assets
npm run build
# or for development
npm run dev
```

### 8. Storage Link
```bash
# Create symbolic link for file storage
php artisan storage:link
```

### 9. Start the Application
```bash
# Start the development server
php artisan serve
```

Visit `http://localhost:8000` to access the application.

## 👥 User Roles & Permissions

### Admin
- **Dashboard**: System-wide statistics and management
- **User Management**: Create, edit, disable/enable users
- **Task Oversight**: View and manage all tasks across the system
- **Content Management**: Manage news articles and site content

### Patron
- **Project Management**: Create and manage research projects
- **Task Assignment**: Create and assign tasks to research assistants
- **Team Management**: Register and manage research assistants
- **Progress Monitoring**: Track task completion and add comments

### Research Assistant
- **Task Management**: View assigned tasks and activate them
- **Progress Tracking**: Update task progress and completion status
- **Dashboard**: Personal statistics and recent task overview

## 🗂️ Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── AdminController.php
│   │   ├── PatronController.php
│   │   ├── ResearchAssistantController.php
│   │   ├── TemplateController.php
│   │   └── NewsArticleController.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Project.php
│   │   ├── Task.php
│   │   ├── ActiveTask.php
│   │   └── CompletedTask.php
│   └── Middleware/
│       └── Role.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── patron/
│   │   ├── research_assistant/
│   │   └── layouts/
│   └── css/
├── public/
│   └── css/
│       └── auth-theme.css
├── routes/
│   └── web.php
└── database/
    └── migrations/
```

## 🎨 Theming & Customization

The application uses a custom theme system with consistent colors and styling:

- **Primary Color**: Green (#28a745)
- **Theme File**: `public/css/auth-theme.css`
- **Components**: Reusable Blade components in `resources/views/components/`

### Customizing Colors
Edit the CSS variables in `public/css/auth-theme.css`:
```css
:root {
    --bdal-primary: #your-color;
    --bdal-primary-dark: #your-dark-color;
    /* ... other variables */
}
```

## 📊 Database Schema

### Key Tables
- **users**: User accounts with role-based access
- **projects**: Research projects with priorities and metadata
- **tasks**: Task assignments with status tracking
- **active_tasks**: Currently active tasks with progress
- **completed_tasks**: Finished tasks archive

## 🔐 Authentication & Security

- **Role-based Access Control**: Middleware-protected routes
- **Password Security**: Hashed passwords with reset functionality
- **CSRF Protection**: Built-in Laravel CSRF protection
- **Email Verification**: Optional email verification system

## 🚀 Deployment

### Production Setup
1. **Server Requirements**: Apache/Nginx with PHP 8.1+
2. **Environment**: Set `APP_ENV=production` in `.env`
3. **Optimization**: Run `php artisan optimize`
4. **Assets**: Build with `npm run build`
5. **Permissions**: Set proper file permissions for storage and cache

### Environment Variables
```env
APP_NAME="BigData Research System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## 🧪 Testing

```bash
# Run PHP tests
php artisan test

# Run with coverage
php artisan test --coverage
```

## 📝 API Documentation

The system includes RESTful routes for:
- User management (`/admin/users`, `/patron/users`)
- Task management (`/admin/tasks`, `/patron/tasks`)
- Project management (`/projects`)
- News management (`/news`)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📞 Support

For support and questions:
- Create an issue in the GitHub repository
- Check the documentation in the `/docs` folder
- Review the code comments for implementation details

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- Laravel Framework for the robust foundation
- Bootstrap for responsive UI components
- FontAwesome for comprehensive iconography
- The open-source community for inspiration and tools

---

**Happy Researching! 🔬📊**
