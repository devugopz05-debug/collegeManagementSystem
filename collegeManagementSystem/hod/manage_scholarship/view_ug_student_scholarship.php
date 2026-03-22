<!DOCTYPE html>
<html lang="en">
    <?php
    
    $id=$_GET['id'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from scholarship_ug where id='$id'");
    $res=mysqli_fetch_array($data);
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Scholarship Application</title>
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
            --info-color: #17a2b8;
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 8px;
        }

        /* Base & Sidebar Styles (Unchanged) */
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
        .main-content { flex-grow: 1; display: flex; flex-direction: column; }
        .navbar { background-color: white; padding: 20px 30px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); display: flex; justify-content: space-between; align-items: center; }
        .dashboard-body { padding: 30px; flex-grow: 1; }
        
        /* --- Profile Card Container --- */
        .profile-card { background: white; border-radius: var(--radius); box-shadow: var(--card-shadow); padding: 40px; max-width: 900px; margin: 0 auto; }

        /* --- Header Section (Photo & Name) --- */
        .profile-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 25px;
            margin-bottom: 30px;
        }
        
        .profile-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent-color);
            margin-right: 25px;
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
        }
        
        .profile-details h2 {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin: 0 0 5px 0;
            font-weight: 700;
        }
        
        .profile-details p {
            color: #6c757d;
            margin: 0;
            font-weight: 600;
        }

        /* --- Profile Sections --- */
        .data-section { margin-bottom: 30px; }
        
        .data-section h3 {
            font-size: 1.4rem;
            color: var(--info-color);
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px dashed var(--border-color);
        }

        .data-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px 30px;
        }

        .data-item { display: flex; flex-direction: column; }

        .data-item .label {
            font-size: 0.85rem;
            color: #999;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        
        .data-item .value {
            font-size: 1rem;
            color: var(--text-dark);
            font-weight: 500;
            padding: 5px 0;
            border-bottom: 1px solid var(--bg-light);
            word-wrap: break-word; /* Ensure long emails/addresses break */
        }

        /* --- Document Links --- */
        .document-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }

        .document-links a {
            display: inline-flex;
            align-items: center;
            padding: 10px 15px;
            background-color: var(--primary-color);
            color: white;
            border-radius: var(--radius);
            font-size: 0.9rem;
            transition: background-color 0.2s;
        }

        .document-links a:hover {
            background-color: #4a2f9c;
            transform: translateY(-1px);
        }
        
        .document-links a i { margin-right: 8px; }

        /* Responsive Adjustments (Unchanged) */
        @media (max-width: 900px) {
            .sidebar { width: 60px; }
            .sidebar-header span, .sidebar-menu-item a span { display: none; }
            .sidebar-menu-item a { justify-content: center; padding: 15px 0; }
            .sidebar-menu-item a i { margin: 0; }
            .dashboard-body { padding: 20px 10px; }
        }
        @media (max-width: 600px) {
            .profile-card { padding: 20px; }
            .profile-header { flex-direction: column; text-align: center; }
            .profile-photo { margin: 0 0 15px 0; }
            .data-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-graduation-cap"></i> <span>Admin</span>
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
            
            <div class="profile-card">
                
                <div class="profile-header">
                    <img src="../<?php echo $res['photo']; ?>" alt="Student Photo" class="profile-photo">
                    <div class="profile-details">
                        <h2><?php echo $res['name'] ?></h2>
                        <p>Application ID: <?php echo $id; ?></p>
                        <p>Application Date: <?php echo $res['date']; ?></p>
                    </div>
                </div>

                <div class="data-section">
                    <h3><i class="fas fa-user-circle"></i> Personal Information</h3>
                    <div class="data-grid">
                        <div class="data-item">
                            <span class="label">Name</span>
                            <span class="value"><?php echo $res['name']; ?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Email</span>
                            <span class="value"><?php echo $res['email'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Phone</span>
                            <span class="value"><?php echo $res['phone'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Date of Birth</span>
                            <span class="value"><?php echo $res['dob'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Gender</span>
                            <span class="value"><?php echo $res['gender'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Marital Status</span>
                            <span class="value"><?php echo $res['marital_status'];?></span>
                        </div>
                        <div class="data-item" style="grid-column: 1 / -1;">
                            <span class="label">Address</span>
                            <span class="value"><?php echo $res['address'];?></span>
                        </div>
                    </div>
                </div>
                
                <div class="data-section">
                    <h3><i class="fas fa-home"></i> Family & Financial Details</h3>
                    <div class="data-grid">
                        <div class="data-item">
                            <span class="label">Father's Name</span>
                            <span class="value"><?php echo $res['father_name'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Father's Occupation</span>
                            <span class="value"><?php echo $res['father_occupation'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Mother's Name</span>
                            <span class="value"><?php echo $res['mother_name'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Mother's Occupation</span>
                            <span class="value"><?php echo $res['mother_occupation'];?></span>
                        </div>
                    </div>
                </div>

                <div class="data-section">
                    <h3><i class="fas fa-briefcase"></i> Scholarship Request</h3>
                    <div class="data-grid">
                        <div class="data-item">
                            <span class="label">Scholarship Type</span>
                            <span class="value"><?php echo $res['scholarship_type'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Department / Course</span>
                            <span class="value"><?php echo $res['department'];?></span>
                        </div>
                        <div class="data-item">
                            <span class="label">Application Status</span>
                            <span class="value"><span style="color: var(--info-color); font-weight: 700;"><?php echo $res['status'];?> REVIEW</span></span>
                        </div>
                    </div>
                </div>

                <div class="data-section" style="margin-bottom: 0;">
                    <h3><i class="fas fa-file-alt"></i> Submitted Documents</h3>
                    <div class="document-links">
                        <a href="../<?php echo $res['income_cert'];?>" target="_blank" title="View Income Certificate">
                            <i class="fas fa-file-pdf"></i> Income Certificate
                        </a>
                        <a href="../<?php echo $res['caste_cert'];?>" target="_blank" title="View Cast Certificate">
                            <i class="fas fa-file-pdf"></i> Cast Certificate
                        </a>
                        <a href="../<?php echo $res['sem_cert'];?>" target="_blank" title="View Semester Certificate">
                            <i class="fas fa-file-pdf"></i> Semester Certificate
                        </a>
                        <a href="../<?php echo $res['photo'];?>" target="_blank" title="View Student Photo">
                            <i class="fas fa-image"></i> Student Photo
                        </a>
                    </div>
                </div>

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