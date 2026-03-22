<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD Dashboard - Department Overview</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --sidebar-bg: #34495e; /* Sidebar Background */
            --sidebar-dark: #2c3e50;
            --bg-light: #f4f6f9; /* Main Page Background */
            --text-dark: #343a40;
            --text-light: #ecf0f1;
            --success-color: #20c997;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --border-color: #e3e7ed;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            --radius: 10px;
        }

        /* Base Styles (reused) */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex; 
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }

        /* --- Sidebar (Simple & Functional) --- */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--text-light);
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
        }

        .sidebar-header {
            text-align: center;
            padding: 0 20px 30px;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu-item {
            position: relative; /* Needed for submenu positioning */
        }
        
        .sidebar-menu-item a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: var(--text-light);
            font-weight: 600;
            transition: background-color 0.2s, color 0.2s;
            border-left: 5px solid transparent;
        }

        .sidebar-menu-item a i {
            margin-right: 15px;
            font-size: 1.1rem;
        }

        .sidebar-menu-item a:hover {
            background-color: var(--sidebar-dark);
            color: var(--accent-color);
        }

        .sidebar-menu-item.active a {
            background-color: var(--sidebar-dark);
            color: var(--accent-color);
            border-left-color: var(--accent-color);
        }

        /* --- Submenu Styles (NEW) --- */
        .sub-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: var(--sidebar-dark); /* Slightly darker background */
            display: none; /* Hidden by default */
        }

        .sub-menu-item a {
            padding: 10px 20px 10px 55px; /* Adjust padding for indentation */
            font-size: 0.95rem;
            font-weight: 400;
            color: #bdc3c7; /* Lighter text color */
            border-left: 5px solid transparent;
        }
        
        .sub-menu-item a:hover {
            background-color: #3f5166; /* Darker hover for submenu */
            color: var(--accent-color);
            border-left-color: var(--accent-color);
        }
        
        /* Ensure the main link uses cursor:pointer to indicate clickability */
        #scholarship-toggle {
            cursor: pointer;
            position: relative;
        }
        
        /* Dropdown arrow rotation for Scholarship link */
        #scholarship-toggle .fa-chevron-down {
            margin-right: 0;
            margin-left: auto;
            font-size: 0.7rem;
            transition: transform 0.3s;
        }
        
        #scholarship-toggle.open .fa-chevron-down {
            transform: rotate(180deg);
        }
        
        /* --- Main Content Structure --- (Unchanged) */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; }
        .navbar { background-color: white; padding: 20px 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .department-title { font-size: 1.8rem; font-weight: 700; color: var(--primary-color); }
        .user-info { font-weight: 600; color: var(--text-dark); }
        .dashboard-body { padding: 30px; flex-grow: 1; }
        
        /* KPI Grid (Unchanged) */
        .kpi-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 25px; margin-bottom: 40px; }
        .kpi-card { background: white; padding: 25px; border-radius: var(--radius); box-shadow: var(--card-shadow); border-left: 5px solid var(--primary-color); transition: transform 0.2s; }
        .kpi-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1); }
        .kpi-icon { font-size: 1.5rem; color: var(--primary-color); margin-bottom: 10px; }
        .kpi-card h3 { margin: 0; font-size: 2.2rem; font-weight: 800; color: var(--text-dark); line-height: 1; }
        .kpi-card p { margin: 5px 0 0 0; color: #6c757d; font-weight: 600; font-size: 0.9rem; text-transform: uppercase; }

        /* Main Grid (Unchanged) */
        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .content-card { background: white; padding: 25px; border-radius: var(--radius); box-shadow: var(--card-shadow); }
        .content-card h3 { font-size: 1.4rem; color: var(--primary-color); border-bottom: 1px solid var(--border-color); padding-bottom: 10px; margin-bottom: 20px; font-weight: 700; }
        .chart-placeholder { height: 300px; background-color: var(--bg-light); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #999; font-weight: 600; border: 1px dashed var(--border-color); }

        /* Quick Links/Actions List (Unchanged) */
        .action-list { list-style: none; padding: 0; margin: 0; }
        .action-list li a { display: flex; align-items: center; justify-content: space-between; padding: 15px 10px; border-bottom: 1px solid var(--border-color); transition: background-color 0.2s; font-weight: 500; }
        .action-list li a:hover { background-color: var(--bg-light); color: var(--primary-color); }
        .action-list li a i { margin-right: 10px; color: var(--accent-color); }
        .action-list li:last-child a { border-bottom: none; }

        /* Footer (Unchanged) */
        .footer { padding: 15px 30px; text-align: center; color: #6c757d; font-size: 0.85rem; border-top: 1px solid var(--border-color); margin-top: auto; }

        /* Responsive Adjustments (Unchanged) */
        @media (max-width: 992px) { .main-grid { grid-template-columns: 1fr; } }
        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar-header span, .sidebar-menu-item a span { display: none; }
            .sidebar-menu-item a { justify-content: center; padding: 15px 0; }
            .sidebar-menu-item a i { margin: 0; }
            /* Submenu needs to be hidden on collapse */
            .sub-menu { display: none !important; }
            .navbar { flex-direction: column; align-items: flex-start; gap: 10px; }
            .dashboard-body { padding: 20px; }
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-microchip"></i> <span>CS</span>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item active">
                <a href="scholarshipcell.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="students.php"><i class="fas fa-users"></i> <span>Students</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="viewCourse.php"><i class="fas fa-book-open"></i> <span>Courses</span></a>
            </li>
            
            <li class="sidebar-menu-item" id="scholarship-menu-item">
                <a id="scholarship-toggle">
                    <i class="fas fa-graduation-cap"></i> <span>Scholarship</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="sub-menu" id="scholarship-sub-menu">
                    <li class="sub-menu-item">
                        <a href="manage_scholarship/scholarship_ug.php"><i class="fas fa-angle-right"></i> UG Scholarship</a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="manage_scholarship/scholarship_pg.php"><i class="fas fa-angle-right"></i> PG Scholarship</a>
                    </li>
                </ul>
            </li>
            
            <li class="sidebar-menu-item">
                <a href="profile.php"><i class="fas fa-person"></i> <span>Profile</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../login.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="navbar">
            <div class="department-title">Computer Science Department Overview</div>
            <div class="user-info">Dr. Elara Vance, HOD</div>
        </div>

        <div class="dashboard-body">
            
            <div class="kpi-grid">
                <div class="kpi-card" style="border-left-color: var(--success-color);">
                    <div class="kpi-icon" style="color: var(--success-color);"><i class="fas fa-check-circle"></i></div>
                    <h3>85.2%</h3>
                    <p>Average Pass Rate</p>
                </div>

                <div class="kpi-card" style="border-left-color: var(--accent-color);">
                    <div class="kpi-icon" style="color: var(--accent-color);"><i class="fas fa-users"></i></div>
                    <h3>450</h3>
                    <p>Total Students</p>
                </div>
                
                <div class="kpi-card" style="border-left-color: var(--primary-color);">
                    <div class="kpi-icon" style="color: var(--primary-color);"><i class="fas fa-chalkboard-teacher"></i></div>
                    <h3>18</h3>
                    <p>Faculty Members</p>
                </div>
                
                <div class="kpi-card" style="border-left-color: var(--warning-color);">
                    <div class="kpi-icon" style="color: var(--warning-color);"><i class="fas fa-bell"></i></div>
                    <h3>6</h3>
                    <p>Action Items Pending</p>
                </div>
            </div>
        </div>

        <div class="footer">
            &copy; 2025 HOD Dashboard. Computer Science Department.
        </div>

    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scholarshipToggle = document.getElementById('scholarship-toggle');
            const subMenu = document.getElementById('scholarship-sub-menu');

            scholarshipToggle.addEventListener('click', function(event) {
                // Prevent the default link behavior (navigating to scholarship.php)
                event.preventDefault();

                // Toggle the 'open' class on the anchor element
                scholarshipToggle.classList.toggle('open');

                // Toggle the display of the submenu
                if (subMenu.style.display === 'block') {
                    subMenu.style.display = 'none';
                } else {
                    subMenu.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>