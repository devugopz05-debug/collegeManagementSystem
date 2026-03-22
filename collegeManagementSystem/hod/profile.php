<!DOCTYPE html>
<?php
    session_start();
    $hid=$_SESSION['hid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from hod where id='$hid'");
    $res=mysqli_fetch_array($data);
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $npass=$_POST['npass'];
        $cpass=$_POST['cpass'];
        if(!$npass){
            $query=mysqli_query($conn,"update hod set name='$name',email='$email',phone='$phone'");
            if($query){
            echo "<script>alert('Profile Updated');window.location.href='profile.php';</script>";
            }else{
                echo "<script>alert('Failed to Update');window.location.href='profile.php';</script>";
            }
        }else{
            if($npass == $cpass){
                $query=mysqli_query($conn,"update hod set name='$name',email='$email',phone='$phone',password='$cpass'");
                if($query){
                    echo "<script>alert('Profile Updated');window.location.href='profile.php';</script>";
                }else{
                    echo "<script>alert('Failed to Update');window.location.href='profile.php';</script>";
                }
            }else{
                echo "<script>alert('Password Mismatch');</script>";
            }
        }
    }
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD - Edit Profile</title>
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
            --info-color: #17a2b8;
            --danger-color: #dc3545;
            --border-color: #e3e7ed;
            --card-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
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
        .dashboard-body { padding: 30px; flex-grow: 1; display: flex; justify-content: center; align-items: flex-start; /* Align content to the top */ }

        /* --- Edit Profile Card --- */
        .edit-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            padding: 40px;
            width: 100%;
            max-width: 650px; /* Max width for a clean form look */
            border-top: 4px solid var(--primary-color);
        }

        .edit-card h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color);
            font-weight: 700;
        }

        /* --- Form Styling --- */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box; /* Include padding in width calculation */
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            outline: none;
        }
        
        /* Grid layout for two columns */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Password Hint */
        .password-hint {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 5px;
            display: block;
        }

        /* Submit Button */
        .btn-submit {
            display: inline-block;
            width: 100%;
            padding: 12px 20px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.1s;
            margin-top: 15px;
        }

        .btn-submit:hover {
            background-color: #4a2f9c;
            transform: translateY(-1px);
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
        @media (max-width: 768px) {
            .sidebar { width: 60px; }
            .sidebar-header span, .sidebar-menu-item a span { display: none; }
            .sidebar-menu-item a { justify-content: center; padding: 15px 0; }
            .sidebar-menu-item a i { margin: 0; }
            .dashboard-body { padding: 20px 10px; }
            .form-grid {
                grid-template-columns: 1fr; /* Stack columns on small screens */
            }
            .edit-card { padding: 30px 20px; }
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
                <a href="hod.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_students/students.php"><i class="fas fa-users"></i> <span>Students</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="viewCourse.php"><i class="fas fa-book-open"></i> <span>Courses</span></a>
            </li>
            <li class="sidebar-menu-item">
                <a href="manage_facility/apply_facility.php"><i class="fas fa-user-check"></i> <span>Facility</span></a>
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
            <div class="department-title" style="font-size: 1.5rem; font-weight: 700; color: var(--primary-color);">HOD Profile Management</div>
            <div class="user-info"><?php echo $res['name'];?></div>
        </div>

        <div class="dashboard-body">
            
            <div class="edit-card">
                <h2><i class="fas fa-user-edit"></i> Edit Your Profile Details</h2>

                <form method="POST">
                    
                    <div class="form-grid">
                        
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $res['name'];?>" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo $res['email'];?>" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo $res['phone'];?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department" class="form-control" value="<?php echo $res['department'];?>" disabled>
                        </div>

                    </div>
                    
                    <hr style="border-top: 1px dashed var(--border-color); margin: 30px 0;">

                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input type="password" id="new_password" name="npass" class="form-control" placeholder="Enter new password to change">
                        <span class="password-hint">Leave blank if you do not wish to change your password.</span>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" id="confirm_password" name="cpass" class="form-control" placeholder="Re-enter new password">
                    </div>

                    <button type="submit" name="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                    
                </form>

            </div>
        </div>

        <div class="footer">
            &copy; 2025 College Management System.
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