# IKO KAZI - Localized Job Marketplace

## Overview

IKO KAZI is a web-based job marketplace designed to connect local job seekers with employers within their geographical locations. It targets informal sector workers, small businesses, and SMEs, providing a verified and trustworthy platform for employment opportunities.

## Features

### For Job Seekers
- Create and manage profiles with skills and experience
- Upload CV/Resume in PDF format
- Browse jobs filtered by location
- Apply for jobs and track application status
- Save jobs for later review
- Receive interview notifications

### For Employers
- Register business profiles with verification
- Post and manage job listings
- View and review applications
- Update application status (pending, interviewing, rejected, accepted)
- Manage job postings (active, closed, archived)

## Technology Stack

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Architecture:** MVC-style with procedural PHP

## Project Structure

```
ikokazi/
├── config/              # Configuration files
│   ├── database.php     # Database connection
│   ├── constants.php    # Application constants
│   └── functions.php    # Helper functions
├── database/
│   └── schema.sql       # Database schema
├── public/
│   ├── index.php        # Application entry point
│   ├── css/             # Stylesheets
│   │   ├── styles.css
│   │   └── responsive.css
│   ├── js/              # JavaScript files
│   │   └── main.js
│   ├── api/             # API endpoints
│   │   ├── auth/
│   │   ├── jobs/
│   │   ├── applications/
│   │   └── profile/
│   └── pages/           # Frontend pages
│       ├── home.php
│       ├── login.php
│       ├── register.php
│       ├── dashboard.php
│       ├── jobs/
│       └── applications/
├── uploads/             # File uploads (CVs, documents)
├── .gitignore
└── README.md
```

## Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/Cruise1601/ikokazi.git
   cd ikokazi
   ```

2. **Configure database**
   ```bash
   cp config/.env.example config/.env
   # Edit config/.env with your database credentials
   ```

3. **Create database**
   ```bash
   mysql -u root -p < database/schema.sql
   ```

4. **Set up web server**
   - Point your web server document root to the `public/` directory
   - Or use PHP's built-in server: `php -S localhost:8000 -t public/`

5. **Access the application**
   - Open `http://localhost/ikokazi` in your browser

## Usage

### For Job Seekers
1. Register with email, phone, and create a password
2. Upload your CV
3. Complete your profile with skills and experience
4. Browse available jobs by location
5. Apply for jobs that match your skills
6. Track application status through your dashboard

### For Employers
1. Register with company information
2. Verify your account
3. Post new job listings
4. Review applications from job seekers
5. Update application status and interview dates
6. Manage your job postings

## Database Schema

Key tables:
- **users** - User accounts (seekers, employers, admins)
- **seeker_profiles** - Job seeker information
- **employer_profiles** - Company/employer information
- **jobs** - Job listings
- **applications** - Job applications
- **saved_jobs** - Bookmarked jobs
- **messages** - Communication between users
- **activity_log** - System activity tracking

## Security

- Password hashing using bcrypt
- PDO prepared statements to prevent SQL injection
- CSRF token protection on forms
- Session-based authentication
- Input sanitization and validation

## Future Enhancements

- Geo-location services (GPS-based job discovery)
- SMS notifications for interviews and updates
- AI-powered job recommendations
- Video interview capabilities
- Payment integration for premium features
- Admin dashboard for moderation
- Mobile app (iOS/Android)

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is open source and available under the MIT License.

## Support

For support, email support@ikokazi.com or open an issue on GitHub.

## Authors

- Cruise1601 - Initial development

## Acknowledgments

- Built to serve local communities and support SMEs
- Inspired by the need for verified employment opportunities
