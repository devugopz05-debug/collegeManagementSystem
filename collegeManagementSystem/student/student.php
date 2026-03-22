<!DOCTYPE html>
<?php
session_start();
$fname=$_SESSION['fname'];
$lname=$_SESSION['lname'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - My Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet (Used for key buttons/titles) */
            --accent-color: #00bcd4; /* Cyan/Teal (Used for highlights/progress) */
            --bg-light: #f4f6f9; /* Main Page Background */
            --text-dark: #343a40;
            --info-color: #17a2b8;
            --success-color: #20c997;
            --border-color: #e3e7ed;
            --card-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            --radius: 12px;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }

        a { text-decoration: none; color: var(--primary-color); }

        /* --- Navbar/Header --- */
        .header {
            background: linear-gradient(90deg, var(--primary-color), #7f58d9);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 800;
        }
        
        /* Nav Links Container */
        .nav-links {
            display: flex; /* Ensure links are side-by-side */
            gap: 25px; /* Use gap for spacing instead of margin-left */
        }
        
        /* Individual Nav Item (Crucial for Dropdown) */
        .nav-item {
            position: relative; /* Set positioning context for the dropdown */
        }
        
        .nav-links a {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            transition: color 0.2s;
            display: block; /* Make the main link cover the padding area */
            padding: 5px 0;
        }
        
        .nav-links a:hover {
            color: var(--accent-color);
        }

        /* --- NEW: Dropdown Menu Styles --- */
        .dropdown-menu {
            display: none; /* Hidden by default */
            position: absolute;
            top: 100%; /* Position right below the parent link */
            left: 50%;
            transform: translateX(-50%); /* Center the dropdown */
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            min-width: 220px;
            z-index: 100; /* Ensure it stays on top of other content */
        }

        .dropdown-menu a {
            color: var(--text-dark); /* Use dark text color for sub-links */
            padding: 10px 20px;
            text-align: left;
            font-size: 0.95rem;
            white-space: nowrap;
        }
        
        .dropdown-menu a:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }
        
        /* Show the dropdown on hover of the nav-item */
        .nav-item:hover .dropdown-menu {
            display: block;
        }

        /* --- Other existing styles retained for completeness --- */
        .dashboard-container { grid-template-columns: 2.5fr 1fr; gap: 40px; max-width: 1400px; margin: 0 auto; padding: 40px; }
        .card { background: white; padding: 30px; border-radius: var(--radius); box-shadow: var(--card-shadow); margin-bottom: 20px; }
        /* ... (rest of the existing dashboard styles) ... */
        @media (max-width: 992px) {
            .dashboard-container { grid-template-columns: 1fr; padding: 20px; gap: 20px; }
            .header { padding: 15px 20px; }
            /* On mobile, you might want to show the links in a hamburger menu toggle */
            .nav-links { /* To make the mobile version functional, we will not hide the links */
                flex-direction: column;
                gap: 10px;
                padding-top: 10px;
                width: 100%;
                /* You would typically use JS here to toggle visibility */
            }
            .nav-links a { margin-left: 0; }
            .academic-summary { flex-direction: column; }
        }


        /* --- Main Content Layout --- */
        .dashboard-container {
            padding: 40px;
            display: grid;
            grid-template-columns: 2.5fr 1fr; /* Main content wider than sidebar */
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* --- Grid Cards --- */
        .card {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 20px;
        }
        
        .card h3 {
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px dashed var(--border-color);
            font-weight: 700;
        }

        /* --- 1. Main Column (Grades & Courses) --- */
        .main-column {
            grid-column: 1 / 2;
        }
        
        /* Academic Summary */
        .academic-summary {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 30px;
        }

        .metric-box {
            background-color: var(--bg-light);
            padding: 15px 20px;
            border-radius: 8px;
            flex: 1;
            border-left: 5px solid var(--accent-color);
        }

        .metric-box h4 {
            font-size: 1rem;
            color: #6c757d;
            margin: 0 0 5px 0;
            font-weight: 600;
        }
        
        .metric-box p {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
            line-height: 1;
        }
        
        /* Course List */
        .course-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }
        
        .course-item:last-child {
            border-bottom: none;
        }
        
        .course-info h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .course-info p {
            margin: 5px 0 0 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .course-grade {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--accent-color);
        }
        
        .btn-view-course {
            padding: 8px 15px;
            background-color: var(--info-color);
            color: white;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        
        .btn-view-course:hover {
            background-color: #128799;
        }

        /* --- 2. Sidebar Column (Notices & Calendar) --- */
        .sidebar-column {
            grid-column: 2 / 3;
        }

        /* Notices/Alerts */
        .notice-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .notice-list li {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.95rem;
        }
        
        .notice-list li:last-child {
            border-bottom: none;
        }

        .notice-list li i {
            margin-right: 10px;
            color: var(--danger-color); /* Assuming urgent for some */
        }

        .notice-list li .date {
            display: block;
            font-size: 0.8rem;
            color: #999;
            margin-top: 5px;
        }

        /* --- Footer --- */
        .footer {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
            margin-top: 40px;
        }
        
        /* --- Responsive Adjustments --- */
        @media (max-width: 992px) {
            .dashboard-container {
                grid-template-columns: 1fr; /* Single column on tablets/mobile */
                padding: 20px;
                gap: 20px;
            }
            .header {
                padding: 15px 20px;
            }
            .nav-links {
                display: none; /* Hide for space on mobile, often moved to a toggle menu */
            }
            .academic-summary {
                flex-direction: column; /* Stack KPIs vertically */
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <i class="fas fa-user-graduate"></i> Student Portal
        </div>
        <div class="nav-links">
            <a href="student.php"><i class="fas fa-home"></i> Home</a>
            
            <div class="nav-item">
                <a href="#"><i class="fas fa-book"></i> Scholarship <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <a href="apply_scholarship.php">
                        <i class="fas fa-graduation-cap"></i> Scholarship for UG
                    </a>
                    <a href="apply_scholarship_pg.php">
                        <i class="fas fa-user-tie"></i> Scholarship for PG
                    </a>
                    <a href="view_scholarship.php">
                        <i class="fas fa-tasks"></i> View Status
                    </a>
                </div>
            </div>
            <a href="profile.php"><i class="fas fa-person"></i> Profile</a>
            <a href="id_card.php"><i class="fas fa-address-card"></i> ID Card</a>
            <a href="../login.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>


    <div class="dashboard-container">
        
        <div class="main-column">

            <div class="card" style="padding: 30px; border-left: 5px solid var(--primary-color);">
                <h2 style="font-size: 2.2rem; margin: 0 0 10px 0; color: var(--text-dark); font-weight: 800;">
                    Welcome back, <?php echo $fname?> <?php echo $lname?>!
                </h2>
                <p style="color: #6c757d; font-size: 1.1rem; margin-bottom: 25px;">
                    Computer Science Major
                </p>

                <div class="academic-summary">
                    <div class="metric-box">
                        <h4>Current GPA</h4>
                        <p>3.85</p>
                    </div>
                    <div class="metric-box" style="border-left-color: var(--success-color);">
                        <h4>Credits Completed</h4>
                        <p>75</p>
                    </div>
                    <div class="metric-box" style="border-left-color: var(--info-color);">
                        <h4>Assignments Due</h4>
                        <p>3</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sidebar-column">
            
            <div class="card">
                <h3><i class="fas fa-bullhorn"></i> Latest Notices</h3>
                <ul class="notice-list">
                    <li>
                        <i class="fas fa-exclamation-triangle" style="color: var(--danger-color);"></i> Library closure on Oct 20th.
                        <span class="date">Oct 11, 2025</span>
                    </li>
                    <li>
                        <i class="fas fa-info-circle" style="color: var(--info-color);"></i> Fall registration window opens next week.
                        <span class="date">Oct 09, 2025</span>
                    </li>
                    <li>
                        <i class="fas fa-calendar-check" style="color: var(--success-color);"></i> Career Fair details released.
                        <span class="date">Oct 05, 2025</span>
                    </li>
                </ul>
            </div>
            
            <div class="card">
                <h3><i class="fas fa-calendar-day"></i> Upcoming Deadlines</h3>
                <ul class="notice-list">
                    <li>
                        **FIN201:** Case Study 1 submission.
                        <span class="date">Due: Mon, Oct 14</span>
                    </li>
                    <li>
                        **CS301:** Midterm Exam.
                        <span class="date">Wed, Oct 16 (48 hours left!)</span>
                    </li>
                    <li>
                        **ENG101:** Final Draft Outline.
                        <span class="date">Fri, Oct 18</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

    <div class="footer">
        &copy; 2025 Student Portal. All rights reserved. | <a href="#">Help & Support</a>
    </div>
    
</body>
</html>