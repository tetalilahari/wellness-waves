
# EcoTrack Waste Management System

EcoTrack is a web-based platform designed to address waste management and sanitation concerns. It enables citizens to report problems while allowing authorities to track and update their resolution status efficiently.

## Features

- User and Admin login system
- User registration
- Report waste management issues
- Track status of submitted reports
- View recycling guidelines
- Collection schedule management
- Admin dashboard for complaint management

## Setup Instructions

### Requirements

- WAMP Server (Windows, Apache, MySQL, PHP)
- Web browser

### Installation

1. Download and install WAMP Server from [https://www.wampserver.com/en/](https://www.wampserver.com/en/)

2. Start WAMP Server and make sure the services are running (the WAMP icon should be green in your system tray)

3. Clone or download this repository to your local machine

4. Place the project folder in the `www` directory of your WAMP installation (typically located at `C:\wamp64\www\`)

5. Open your web browser and navigate to:
   ```
   http://localhost/ecotrack/
   ```

### Default Credentials

The system comes with two default user accounts:

#### User Login
- Username: user
- Password: password

#### Admin Login
- Username: admin
- Password: admin123

## File Structure

```
/ecotrack
│
├── api/                     # API endpoints for data operations
│   ├── login.php           # Handles user authentication
│   ├── register.php        # Handles user registration
│   └── reports.php         # CRUD operations for reports
│
├── css/                     # Stylesheets
│   └── styles.css          # Main stylesheet
│
├── data/                    # Data storage (will be created automatically)
│   ├── reports.json        # Stores all reports
│   └── users.json          # Stores registered users
│
├── includes/                # PHP includes for page components
│   ├── collection_schedule.php
│   ├── dashboard.php
│   ├── login.php
│   ├── navbar.php
│   ├── recycling_guide.php
│   └── waste_reporting.php
│
├── js/                      # JavaScript files
│   └── main.js             # Main JavaScript functionality
│
├── admin.php               # Admin dashboard page
├── index.php               # Main entry point
├── logout.php              # Logout functionality
└── README.md               # Project documentation
```

## Usage

### For Regular Users:

1. Register an account or use the default user account
2. Login with your credentials
3. Navigate through the different tabs:
   - Dashboard: Overview of waste statistics
   - Collection: View and schedule waste collections
   - Reporting: Report waste management issues
   - Recycling: Access recycling guidelines and information

### For Administrators:

1. Login with admin credentials
2. Access the admin dashboard to:
   - View all reported issues
   - Update the status of reports (pending, in-progress, completed)
   - Manage user complaints

## Important Notes

- This is a prototype system that uses file-based storage (JSON files) instead of a database for simplicity
- The data will be stored in the `data` directory which will be created automatically
- In a production environment, you would typically use a proper MySQL database
