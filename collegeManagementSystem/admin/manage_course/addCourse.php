<!DOCTYPE html>
<html lang="en">
    <?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    if(isset($_POST['submit'])){
        $cname=$_POST['cname'];
        $desc=mysqli_real_escape_string($conn,$_POST['description']);
        $query=mysqli_query($conn,"insert into course(cname,description)values('$cname','$desc')");
        if($query){
            echo "<script>alert('Course Added');window.location.href='addCourse.php';</script>";
        }else{
            echo "<script>alert('Failed to Add');window.location.href='addCourse.php';</script>";
        }
    }
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add New Course</title>
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
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 8px;
        }

        /* Base Styles (reused from Admin Template) */
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
        
        /* --- Form Card Specific Styles --- */
        .form-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            max-width: 700px;
            margin: 0 auto; /* Center the form card */
        }
        
        .form-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        /* --- Input Fields (Floating Label Style) --- */
        .form-field {
            position: relative;
            margin-bottom: 40px; 
        }
        
        .form-field label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #999;
            font-size: 1rem;
            transition: all 0.2s ease-out;
            pointer-events: none;
            background: white; 
            padding: 0 5px;
            z-index: 5;
            font-weight: 400;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 1rem;
            background-color: var(--bg-light);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            resize: vertical;
        }
        
        textarea {
            min-height: 150px;
        }

        /* Floating Label Logic */
        input:focus + label,
        input:not(:placeholder-shown) + label,
        textarea:focus + label,
        textarea:not(:placeholder-shown) + label {
            top: -12px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input:focus,
        textarea:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
            outline: none;
        }

        /* --- Action Button --- */
        .btn-submit {
            padding: 12px 30px;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(32, 201, 151, 0.4);
        }

        .btn-submit:hover {
            background-color: #1e8745;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(32, 201, 151, 0.5);
        }
        
        /* --- Footer (Minimum needed for structure) --- */
        .footer {
            padding: 15px 30px;
            text-align: center;
            color: #6c757d;
            font-size: 0.85rem;
            border-top: 1px solid var(--border-color);
            margin-top: auto; /* Push to bottom */
        }
        
        /* Responsive Adjustments (minimal) */
        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar-header span, .sidebar-menu-item a span { display: none; }
            .sidebar-menu-item a { justify-content: center; padding: 15px 0; }
            .sidebar-menu-item a i { margin: 0; }
            .form-card { padding: 20px; }
            .dashboard-body { padding: 20px 10px; }
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
                <a href="../admin.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_students/new_applications.php"><i class="fas fa-users"></i> <span>New Applications</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_students/students.php"><i class="fas fa-users"></i> <span>Students</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="viewCourse.php"><i class="fas fa-book-open"></i> <span>Courses</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_hod/view_hod.php"><i class="fas fa-user-check"></i> <span>HOD</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_facility/view_facility_bookings.php"><i class="fas fa-chart-line"></i> <span>Facility Bookings</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="../manage_scholarshipcell/scholarshipcell.php"><i class="fas fa-cog"></i> <span>Scholarship Cell</span></a>
            </li>
            <li class="sidebar-menu-item" id="scholarship-menu-item">
                <a id="scholarship-toggle">
                    <i class="fas fa-graduation-cap"></i> <span>Scholarship</span>
                    <i class="fas fa-chevron-down"></i>
                </a>
                <ul class="sub-menu" id="scholarship-sub-menu">
                    <li class="sub-menu-item">
                        <a href="../scholarship/scholarship_ug.php"><i class="fas fa-angle-right"></i> UG Scholarship</a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="../scholarship/scholarship_pg.php"><i class="fas fa-angle-right"></i> PG Scholarship</a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-menu-item">
                <a href="../../login.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        
        <div class="navbar">
            <div class="user-info">Admin User</div>
        </div>

        <div class="dashboard-body">
            <div class="form-card">
                <h2>Add New Course Offering</h2>
                <form method="POST">
                    
                    <div class="form-field">
                        <input type="text" id="course_name" name="cname" placeholder=" " required>
                        <label for="course_name">Course Name</label>
                    </div>

                    <div class="form-field">
                        <textarea id="description" name="description" placeholder=" " required></textarea>
                        <label for="description">Course Description (Detailed overview, prerequisites, etc.)</label>
                    </div>
                    
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="submit" name="submit" class="btn-submit">
                            <i class="fas fa-plus-circle"></i> Add Course
                        </button>
                    </div>
                </form>
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