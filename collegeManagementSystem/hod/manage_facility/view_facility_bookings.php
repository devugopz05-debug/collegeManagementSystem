<!DOCTYPE html>
<?php
    session_start();
    $hid=$_SESSION['hid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from facility_bookings where hod='hid'");
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD - View Facility Request Status</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
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
            --pending-color: #ffc107; /* Warning yellow */
            --approved-color: #20c997; /* Success green */
            --rejected-color: #dc3545; /* Danger red */
            --info-color: #17a2b8;
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 10px;
        }

        /* Base & Sidebar Styles (reused) */
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

        /* Sidebar Styles (Minimum needed for structure) */
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

        /* Main Content Structure */
        .main-content {
            flex-grow: 1; 
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .department-title { font-size: 1.8rem; font-weight: 700; color: var(--primary-color); }
        .user-info { font-weight: 600; color: var(--text-dark); }
        
        .dashboard-body {
            padding: 30px;
            flex-grow: 1;
        }
        
        /* --- Management Card & Header --- */
        .manage-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
        }
        
        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header-controls h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        /* --- Action Button (New Request) --- */
        .btn-new-request {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            box-shadow: 0 2px 8px rgba(91, 60, 196, 0.4);
        }
        .btn-new-request:hover {
            background-color: #4a2f9c;
        }

        /* --- Data Table Styling --- */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .data-table th, .data-table td {
            padding: 15px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        .data-table th {
            background-color: var(--bg-light);
            color: var(--text-dark);
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        
        .data-table tbody tr:hover {
            background-color: rgba(0, 188, 212, 0.03);
        }
        
        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px; /* Pill shape */
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
            min-width: 80px;
            text-align: center;
        }
        .status-badge.pending { background-color: var(--pending-color); color: var(--text-dark); }
        .status-badge.approved { background-color: var(--approved-color); }
        .status-badge.rejected { background-color: var(--rejected-color); }

        /* Action Buttons within the Table */
        .action-btns button {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            margin: 0 5px;
            padding: 5px;
            transition: color 0.2s;
        }

        .btn-view { color: var(--info-color); }
        .btn-cancel { color: var(--rejected-color); }
        
        .action-btns button:hover {
            opacity: 0.8;
            transform: scale(1.1);
        }
        
        /* --- Footer (Minimum needed for structure) --- */
        .footer {
            padding: 15px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
            margin-top: auto; 
        }

        /* Responsive Adjustments */
        @media (max-width: 900px) {
            .sidebar { width: 60px; }
            .sidebar-header span, .sidebar-menu-item a span { display: none; }
            .sidebar-menu-item a { justify-content: center; padding: 15px 0; }
            .sidebar-menu-item a i { margin: 0; }
            .dashboard-body { padding: 20px 10px; }
            .header-controls { flex-direction: column; align-items: flex-start; }
            .header-controls h2 { margin-bottom: 15px; }
            .data-table th:nth-child(2), /* Hide ID on small screens */
            .data-table td:nth-child(2) { display: none; }
        }
        @media (max-width: 600px) {
            .data-table {
                display: block;
                overflow-x: auto; /* Allows horizontal scrolling for table */
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-microchip"></i> <span>HOD</span>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-menu-item active">
                <a href="../hod.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_students/students.php"><i class="fas fa-users"></i> <span>Students</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../viewCourse.php"><i class="fas fa-book-open"></i> <span>Courses</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="apply_facility.php"><i class="fas fa-user-check"></i> <span>Facility</span></a>
            </li>
            
            <li class="sidebar-menu-item" id="scholarship-menu-item">
                <a id="scholarship-toggle">
                    <i class="fas fa-graduation-cap"></i> <span>Scholarship</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="sub-menu" id="scholarship-sub-menu">
                    <li class="sub-menu-item">
                        <a href="../manage_scholarship/scholarship_ug.php"><i class="fas fa-angle-right"></i> UG Scholarship</a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="../manage_scholarship/scholarship_pg.php"><i class="fas fa-angle-right"></i> PG Scholarship</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="../profile.php"><i class="fas fa-person"></i> <span>Profile</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../../login.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="navbar">
            <div class="department-title">Facility Request Status</div>
            <div class="user-info">Dr. Elara Vance, HOD</div>
        </div>

        <div class="dashboard-body">
            <div class="manage-card">
                
                <div class="header-controls">
                    <h2>My Facility Applications</h2>
                    <button class="btn-new-request" onclick="location.href='apply_facility.php'">
                        <i class="fas fa-plus-circle"></i> New Request
                    </button>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Event Name</th>
                            <th>Room</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $counter=1;
                        while($res=mysqli_fetch_array($data)){
                            ?>
                        <tr>
                            <td><?php echo $counter++;?></td>
                            <td><?php echo $res['event'];?></td>
                            <td>
                                <?php echo $res['room'];?> - 
                                <?php
                                    if($res['room']=="Classroom"){
                                        echo $res['class_room'];
                                    }    
                                ?>

                            </td>
                            <td><?php echo $res['date'];?> (<?php echo $res['time_from'];?> - <?php echo $res['time_to'];?>)</td>
                            <td><span class="status-badge <?php echo strtolower($res['status']);?>"><?php echo $res['status'];?></span></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            &copy; 2025 HOD Dashboard.
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