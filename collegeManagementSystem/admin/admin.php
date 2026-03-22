<!DOCTYPE html>
<?php

$conn=mysqli_connect("localhost","root","","collegemanagementsystem");
$appdata=mysqli_query($conn,"select * from applications where rights='Pending'");
$stdata=mysqli_query($conn,"select * from applications where rights='Student'");
$cdata=mysqli_query($conn,"select * from course");

$appCount=mysqli_num_rows($appdata);
$stCount=mysqli_num_rows($stdata);
$cCount=mysqli_num_rows($cdata);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Modern Template</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --sidebar-dark: #2c3e50; /* Darker Blue/Grey */
            --sidebar-bg: #34495e; /* Sidebar Background */
            --sidebar-active: var(--primary-color);
            --bg-light: #f4f6f9; /* Main Page Background */
            --text-light: #ecf0f1; /* Light Text for Sidebar */
            --text-dark: #343a40;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 8px;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex; /* Setup for sidebar and main content */
            min-height: 100vh;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* --- 1. Sidebar (Navigation) --- */
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
        
        /* --- 2. Main Content Area --- */
        .main-content {
            flex-grow: 1; /* Take up remaining space */
            display: flex;
            flex-direction: column;
        }

        /* --- Header/Navbar --- */
        .navbar {
            background-color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-left: 10px;
            border: 2px solid var(--accent-color);
        }
        
        .notification-icon {
            font-size: 1.2rem;
            margin-right: 25px;
            color: #6c757d;
            cursor: pointer;
            position: relative;
        }
        
        .notification-icon .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
        }

        /* --- Dashboard Grid (Main Body) --- */
        .dashboard-body {
            padding: 30px;
            flex-grow: 1;
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 25px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .stat-icon {
            font-size: 2rem;
            color: white;
            background-color: var(--primary-color);
            padding: 15px;
            border-radius: var(--radius);
            opacity: 0.8;
        }

        .stat-info {
            text-align: right;
        }
        
        .stat-info h3 {
            margin: 0 0 5px 0;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        
        .stat-info p {
            margin: 0;
            color: #6c757d;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* --- Recent Activity/Large Table Area --- */
        .activity-card {
            background: white;
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
        }
        
        .activity-card h3 {
            color: var(--primary-color);
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 1.5rem;
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 10px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .data-table tr:hover {
            background-color: rgba(0, 188, 212, 0.05);
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
        }

        .status-badge.success { background-color: #28a745; }
        .status-badge.pending { background-color: #ffc107; color: var(--text-dark); }
        .status-badge.rejected { background-color: #dc3545; }

        /* --- Footer --- */
        .footer {
            padding: 15px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 900px) {
            .sidebar {
                width: 70px; /* Collapsed sidebar */
                overflow: hidden;
            }
            .sidebar-header span {
                display: none;
            }
            .sidebar-menu-item a {
                justify-content: center;
                padding: 15px 0;
            }
            .sidebar-menu-item a span {
                display: none;
            }
            .sidebar-menu-item a i {
                margin: 0;
            }
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
        @media (max-width: 600px) {
            .navbar {
                padding: 15px 20px;
            }
            .user-info span {
                display: none;
            }
            .dashboard-body {
                padding: 20px;
            }
        }

    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-graduation-cap"></i> <span>College Admin</span>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item active">
                <a href="admin.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_students/new_applications.php"><i class="fas fa-users"></i> <span>New Applications</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_students/students.php"><i class="fas fa-users"></i> <span>Students</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_course/viewCourse.php"><i class="fas fa-book-open"></i> <span>Courses</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_hod/view_hod.php"><i class="fas fa-user-check"></i> <span>HOD</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_facility/view_facility_bookings.php"><i class="fas fa-chart-line"></i> <span>Facility Bookings</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_scholarshipcell/scholarshipcell.php"><i class="fas fa-cog"></i> <span>Scholarship Cell</span></a>
            </li>
            <li class="sidebar-menu-item" id="scholarship-menu-item">
                <a id="scholarship-toggle">
                    <i class="fas fa-graduation-cap"></i> <span>Scholarship</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="sub-menu" id="scholarship-sub-menu">
                    <li class="sub-menu-item">
                        <a href="scholarship/scholarship_ug.php"><i class="fas fa-angle-right"></i> UG Scholarship</a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="scholarship/scholarship_pg.php"><i class="fas fa-angle-right"></i> PG Scholarship</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="../login.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="navbar">
            <div class="notification-icon">
                <i class="fas fa-bell"></i>
                <span class="badge">4</span>
            </div>
            <div class="user-info">
                <span>Admin User</span>
                <img src="https://via.placeholder.com/40/00bcd4/ffffff?text=AD" alt="Admin Profile">
            </div>
        </div>

        <div class="dashboard-body">
            
            <div class="page-title">Dashboard Overview</div>

            <div class="stats-grid">
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--primary-color);">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-info">
                        <p>New Applications</p>
                        <h3><?php echo $appCount;?></h3>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background-color: #28a745;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Students</p>
                        <h3><?php echo $stCount;?></h3>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--accent-color);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Courses</p>
                        <h3><?php echo $cCount;?></h3>
                    </div>
                </div>

            </div>

            <!-- <div class="activity-card">
                <h3>Recent Application Activity</h3>
                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Applicant ID</th>
                            <th>Name</th>
                            <th>Program</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#001025</td>
                            <td>Riya Sharma</td>
                            <td>Computer Science</td>
                            <td>Oct 10, 2025</td>
                            <td><span class="status-badge pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#001024</td>
                            <td>Amit Patel</td>
                            <td>Mechanical Engineering</td>
                            <td>Oct 09, 2025</td>
                            <td><span class="status-badge success">Approved</span></td>
                        </tr>
                        <tr>
                            <td>#001023</td>
                            <td>Sarah Lee</td>
                            <td>Business Admin</td>
                            <td>Oct 09, 2025</td>
                            <td><span class="status-badge rejected">Rejected</span></td>
                        </tr>
                        <tr>
                            <td>#001022</td>
                            <td>David Chen</td>
                            <td>Liberal Arts</td>
                            <td>Oct 08, 2025</td>
                            <td><span class="status-badge success">Approved</span></td>
                        </tr>
                    </tbody>
                </table>
            </div> -->

        </div>

        <div class="footer">
            &copy; 2025 College Admin Dashboard. All rights reserved.
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