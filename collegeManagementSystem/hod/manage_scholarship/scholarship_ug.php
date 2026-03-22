<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    $dept=$_SESSION['department'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from scholarship_ug where department='$dept'");
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Students</title>
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
            --success-color: #20c997;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8; /* Used for view/details */
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 8px;
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
            justify-content: flex-end;
            align-items: center;
        }
        .dashboard-body {
            padding: 30px;
            flex-grow: 1;
        }
        
        /* --- Management Card --- */
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
        
        /* --- Search & Filter Bar --- */
        .search-bar {
            padding: 10px 0;
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .search-bar input {
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            flex-grow: 1;
        }
        .search-bar button {
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .search-bar button:hover { background-color: #4a2f9c; }


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
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            font-weight: 600;
            color: white;
        }
        .status-badge.active { background-color: var(--success-color); }
        .status-badge.suspended { background-color: var(--danger-color); }

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
        .btn-check { color: var(--success-color); }
        .btn-toggle { color: var(--danger-color); } /* Default for suspend */
        
        .action-btns button:hover {
            opacity: 0.8;
            transform: scale(1.1);
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
            .data-table th:nth-child(4), /* Hide Email on smaller screens */
            .data-table td:nth-child(4) { display: none; }
        }
        @media (max-width: 600px) {
             .data-table th:nth-child(3), /* Hide Program on small screens */
            .data-table td:nth-child(3) { display: none; }
            .search-bar { flex-direction: column; }
            .search-bar input, .search-bar button { width: 100%; }
            .data-table {
                display: block;
                overflow-x: auto; 
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-microchip"></i> <span>CS Dept.</span>
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
                <a href="../manage_facility/apply_facility.php"><i class="fas fa-user-check"></i> <span>Facility</span></a>
            </li>
            
            <li class="sidebar-menu-item" id="scholarship-menu-item">
                <a id="scholarship-toggle">
                    <i class="fas fa-graduation-cap"></i> <span>Scholarship</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="sub-menu" id="scholarship-sub-menu">
                    <li class="sub-menu-item">
                        <a href="scholarship_ug.php"><i class="fas fa-angle-right"></i> UG Scholarship</a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="scholarship_pg.php"><i class="fas fa-angle-right"></i> PG Scholarship</a>
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
           
        </div>

        <div class="dashboard-body">
            <div class="manage-card">
                
                <div class="header-controls">
                    <h2>Student Directory</h2>
                    
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Scholarship Type</th>
                            <th>Application date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter=1;
                        while($res=mysqli_fetch_array($data)){
                            ?>
                        <tr>
                            <td><?php echo $counter++;?></td>
                            <td><?php echo $res['name'];?></td>
                            <td><?php echo $res['scholarship_type'];?></td>
                            <td><?php echo $res['date'];?></td>
                            <td><span class="status-badge active"><?php echo $res['status'];?></span></td>
                            <td class="action-btns">
                                <button class="btn-view" title="View Profile" onclick="location.href='view_ug_student_scholarship.php?id=<?php echo $res['id'];?>'"><i class="fas fa-eye"></i></button>
                                <?php
                                if($res['status']=='Pending'){
                                    ?>
                                    <button class="btn-check" title="View Profile" onclick="location.href='approve_ug_scholarship.php?id=<?php echo $res['id'];?>'"><i class="fas fa-check"></i></button>
                                    <button class="btn-toggle" title="View Profile" onclick="location.href='reject_ug_scholarship.php?id=<?php echo $res['id'];?>&email=<?php echo $res['email'];?>&path=scholarship_ug.php'"><i class="fas fa-times"></i></button>
                                <?php
                                }
                            ?>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="footer">
            &copy; 2025 College Admin Dashboard.
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