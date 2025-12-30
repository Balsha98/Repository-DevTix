# DevTix - Ticketing System Web Application

A gamified ticketing system for software development and programming support. Earn points, climb leagues, and help developers solve their coding challenges in this engaging support platform.

## Features

- **Gamified Support System** - Earn points and compete on leaderboards.
- **League System** - Four competitive leagues (Rookie, Junior, Senior, Legendary).
- **Ticket Management** - Post questions with up to 5 images for clarity.
- **First-Come-First-Served** - Fair ticket claiming system for assistants.
- **Real-Time Notifications** - Stay updated on ticket actions and system events.
- **Activity Logging** - Comprehensive system logging for all user actions.
- **User Statistics** - Comprehensive analytics dashboard for admins.
- **In-App Chat** - Direct messaging between all users.
- **Role-Based Access** - Three distinct user roles with specific permissions.
- **Image Upload Support** - Attach visual context to tickets.
- **Profile Pictures** - Custom profile images with optimized file storage.
- **Admin View Switching** - Admins can view the app as any user.

## User Roles & Permissions

### Administrator

- **Full System Control** - Complete access to all features and data.
- **User Management** - Add, edit, and delete all user accounts.
- **View Switching** - Access the application as any Assistant or Patron.
- **Statistics Dashboard** - View comprehensive app analytics:
  - User distribution by role.
  - Age demographics.
  - Gender statistics.
  - Assistant professions.
- **System Monitoring** - Oversee all activities and performance.

### Assistant

- **Ticket Resolution** - Respond to and resolve tickets.
- **Ticket Claiming** - Claim available tickets on first-come-first-served basis.
- **Point Earning** - Gain points for each resolved ticket.
- **League Progression** - Advance through leagues based on tickets resolved:
  - **Rookie League**: 1+ tickets resolved.
  - **Junior League**: 100+ tickets resolved.
  - **Senior League**: 250+ tickets resolved.
  - **Legendary League**: 500+ tickets resolved.
- **Leaderboard Rankings** - Compete within your league.
- **Profile Management** - Update profession and personal details.
- **Chat Access** - Communicate with all users.

### Patron

- **Ticket Creation** - Post programming questions and issues.
- **Image Attachments** - Add up to 5 images per ticket for clarity.
- **Ticket Tracking** - Monitor status of submitted tickets.
- **Assistant Communication** - Chat with assigned assistants.
- **Profile Management** - Update personal information.
- **Chat Access** - Communicate with all users.

## Gamification System

### League Structure

Assistants progress through four competitive leagues based on tickets resolved:

| League           | Tickets Required  | Status       |
| ---------------- | ----------------- | ------------ |
| 🥉 **Rookie**    | 1 - 99 tickets    | Entry level  |
| 🥈 **Junior**    | 100 - 249 tickets | Intermediate |
| 🥇 **Senior**    | 250 - 499 tickets | Advanced     |
| 👑 **Legendary** | 500+ tickets      | Elite        |

### Leaderboards

- Each league has its own leaderboard.
- Assistants are ranked by tickets resolved within their league.
- Competitive environment encourages quality support.
- Real-time ranking updates.

## Notification System

Users receive in-app notifications for:

- **Welcome Message** - Upon first signup.
- **Ticket Actions**:
  - New ticket posted (Assistants).
  - Ticket claimed by Assistant (Patrons).
  - Ticket response received (Patrons).
  - Ticket resolved (Assistants & Patrons).
- **League Progression** - When advancing to new league (Assistants).

## Activity Logging System

The application maintains comprehensive logs of all user activities:

### Authentication Events

- User login attempts.
- New user registration.

### Ticket-Related Actions

- Ticket creation.
- Ticket claiming by Assistants.
- Ticket responses added.
- Ticket resolution.
- Ticket status changes.

### Profile Changes

- User information updates.
- Profile picture uploads/updates.
- Role modifications (by admins).
- Assistant profession changes.

All logs include:

- Timestamp of action.
- User who performed the action.
- Action type and details.
- Success/failure status.

## Tech Stack

- **PHP** - Server-Side Logic & Backend
- **MySQL** - Database Management
- **HTML5** - Structure & Content
- **CSS3** - Styling & Layout
- **JavaScript** - Client-Side Interactivity
- **jQuery** - DOM Manipulation & AJAX Requests

## Installation

### Prerequisites

- PHP 7.4 or higher.
- MySQL 5.7 or higher.
- Apache web server.
- MySQL server.

### Setup Instructions

1. Clone the repository:

```bash
git clone https://github.com/Balsha98/Repository-DevTix.git
```

2. Navigate to the project directory:

```bash
cd Repository-DevTix
```

3. Import the database:

```bash
# Import the SQL file into your MySQL database.
mysql -u root -p dev_tix < source/database/database.sql
```

4. Configure your web server to point to the project directory.

5. Access the application:

```
http://localhost/local-repository-directory
```

## Project Structure

```
Repository-DevTix/
│
├── dev-tix/            # Main application directory.
│   │
│   ├── public/         # Public-facing files.
│   │   │
│   │   ├── api/        # API layer.
│   │   │   │
│   │   │   ├── classes/        # Abstract classes and interfaces.
│   │   │   │
│   │   │   ├── controllers/    # API controllers.
│   │   │   │   ├── data/       # Input validation rules.
│   │   │   │   ├── partials/   # Modal and component APIs.
│   │   │   │   └── views/      # View-specific controllers.
│   │   │   │
│   │   │   ├── helpers/        # Helper PHP classes.
│   │   │   │
│   │   │   └── index.php       # API entry point.
│   │   │
│   │   ├── core/       # Core application files.
│   │   │   │
│   │   │   ├── assets/ # Static assets.
│   │   │   │   │
│   │   │   │   ├── css/
│   │   │   │   │   ├── partials/       # CSS components.
│   │   │   │   │   ├── views/          # View-specific styles.
│   │   │   │   │   ├── general.css     # General styling.
│   │   │   │   │   ├── reusable.css    # Reusable classes.
│   │   │   │   │   └── variables.css   # CSS variables.
│   │   │   │   │
│   │   │   │   ├── javascript/
│   │   │   │   │   ├── controllers/    # JS controllers.
│   │   │   │   │   ├── helpers/        # Helper functions.
│   │   │   │   │   ├── libraries/      # Third-party libraries (jQuery).
│   │   │   │   │   ├── models/         # Data models.
│   │   │   │   │   └── views/          # View-specific scripts.
│   │   │   │   │
│   │   │   │   ├── json/       # JSON data files
│   │   │   │   │
│   │   │   │   └── media/      # Site visuals.
│   │   │   │       ├── icons/          # Icon files.
│   │   │   │       └── images/         # Image files.
│   │   │   │
│   │   │   └── views/  # Application views.
│   │   │       ├── partials/           # Reusable view components.
│   │   │       └── ...                 # Main view scripts.
│   │   │
│   │   ├── .htaccess           # Custom routing configuration.
│   │   └── index.php           # Application entry point.
│   │
│   └── source/         # Source code.
│       │
│       ├── classes/    # Core PHP classes.
│       │   │
│       │   ├── handlers/       # Application handlers.
│       │   │
│       │   ├── helpers/        # Helper classes.
│       │   │
│       │   ├── models/         # Database models.
│       │   │
│       │   ├── Router.php      # Routing class.
│       │   └── Routes.php      # Route definitions.
│       │
│       ├── database/   # Database files.
│       │
│       ├── docs/       # Additional documentation.
│       │
│       └── configuration.php   # Application configuration.
│
└── README.md           # Project documentation.
```

## Database Schema

The application uses a relational database with the following main tables:

- **users** - User accounts and authentication.
- **user_details** - Extended user profile information.
- **roles** - User role definitions.
- **ticket_requests** - Support tickets and questions.
- **request_images** - Uploaded ticket images (up to 5 per ticket).
- **ticket_responses** - Assistant and patron responses to tickets.
- **leagues** - League definitions and requirements.
- **leaderboards** - Assistant rankings per league.
- **notifications** - In-app notification system.
- **chat_messages** - In-app chat system.
- **newsletters** - Newsletter subscription management.
- **logs** - Activity and audit trail.

## Security Features

- Password hashing with PHP's `hash()` function.
- SQL injection prevention with prepared statements.
- Session management for user authentication.
- Role-based access control (RBAC).
- Input validation and sanitization.
- CSRF token form protection.
- Image validation and size restrictions.

## Future Enhancements

### Enhanced Gamification

- **Badges & Achievements** - Special awards for milestones.
- **Streak Bonuses** - Extra points for consecutive days.
- **Challenge System** - Special high-difficulty tickets.

### Platform Improvements

- **Mobile App** - Native iOS and Android applications.
- **Video Attachments** - Support for video tutorials.
- **Email Notifications** - SMTP integration for alerts.
- **Newsletter System** - Automated email campaigns and updates to subscribers.
- **Advanced Search** - Filter tickets by language, difficulty, tags.
- **Assistant Ratings** - Patron feedback on resolutions.
- **Multi-Language Support** - Internationalization.

### Analytics & Reporting

- **Advanced Statistics** - Detailed performance metrics.
- **Export Reports** - Generate reports in PDF/Excel.
- **Popular Topics** - Identify common issues.

## Roadmap

- [x] User authentication and role-based access.
- [x] Ticket creation with image uploads.
- [x] First-come-first-served ticket claiming.
- [x] League and leaderboard system.
- [x] In-app notifications.
- [x] Chat system.
- [x] Admin statistics dashboard.
- [x] Admin view switching.
- [ ] Real-time WebSocket integration.
- [ ] Email notifications (SMTP).
- [ ] Badge and achievement system.
- [ ] Mobile application.
- [ ] Advanced analytics dashboard.

## Let's Connect

If you enjoyed this project or have any questions, feel free to reach out!

[![Email](https://img.shields.io/badge/Email-D14836?style=for-the-badge&logo=gmail&logoColor=white)](mailto:balsa.bazovic@gmail.com)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/balsha-bazovich)
[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com/Balsha98)

⭐ If you found this project helpful, please consider giving it a star!

---

Made with PHP, HTML5, CSS3, JavaScript (jQuery), and ❤️!
