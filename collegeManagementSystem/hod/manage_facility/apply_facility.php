<!DOCTYPE html>
<?php
session_start();
$hod = $_SESSION['hid'];
$email = $_SESSION['hemail'];
$conn = mysqli_connect("localhost", "root", "", "collegemanagementsystem");

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $room = $_POST['room'];
    $class = $_POST['class'];
    $date = $_POST['date'];
    $time_from = $_POST['time_from'];
    $time_to = $_POST['time_to'];

    $checkQuery = mysqli_query($conn, "SELECT * FROM facility_bookings WHERE room = '$room' AND date = '$date' AND ((time_from <= '$time_to' AND time_to >= '$time_from'))");

    if(mysqli_num_rows($checkQuery) > 0){
        echo "<script>alert('This room is already booked for the selected time period!');window.location.href='add_facility.php';</script>";
    } else {
        $insertQuery = mysqli_query($conn, "INSERT INTO facility_bookings(hod,event, room, class_room, date, time_from, time_to)VALUES('$hod','$name', '$room', '$class', '$date', '$time_from', '$time_to')");
        if($insertQuery){
            echo "<script>window.location.href='mail.php?email=$email';</script>";
        } else {
            echo "<script>alert('Failed to book');window.location.href='apply_facility.php';</script>";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOD - Apply for College Facility</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --sidebar-bg: #34495e; /* Sidebar Background */
            --sidebar-dark: #2c3e50;
            --bg-light: #f4f6f9; /* Main Page Background */
            --text-light: #ecf0f1;
            --text-dark: #343a40;
            --success-color: #20c997;
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --radius: 10px;
        }
        a { text-decoration: none; color: inherit; }


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

        .btn-add-course {
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
        .btn-add-course:hover {
            background-color: #4a2f9c;
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
        .dashboard-body {
            padding: 30px;
            flex-grow: 1;
        }
        
        /* --- Form Card & Layout --- */
        .form-card {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            max-width: 750px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns */
            gap: 30px 30px;
        }
        
        /* Ensure Event Name and Description take full width */
        .full-width {
            grid-column: 1 / -1; 
        }

        /* --- Input Fields (Floating Label Style) --- */
        .form-field {
            position: relative;
            margin-bottom: 20px; /* Adjust margin since we have grid gap */
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
        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--bg-light);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            -webkit-appearance: none; 
            -moz-appearance: none;
            appearance: none;
            position: relative;
            z-index: 1; /* Keep input above background */
        }

        /* Custom styling for select dropdown arrow */
        select {
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%235b3cc4%22%20d%3D%22M287%20197.8L146.2%2057%205.4%20197.8z%22%2F%3E%3C%2Fsvg%3E");
            background-repeat: no-repeat;
            background-position: right 10px top 50%;
            background-size: 12px auto;
            padding-right: 30px;
        }
        
        /* Floating Label Logic */
        input:focus + label,
        input:not(:placeholder-shown) + label,
        select:focus + label,
        select:not([value=""]) + label {
            top: -12px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input:focus,
        select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
            outline: none;
        }

        /* --- Submit Button --- */
        .btn-submit {
            padding: 15px 30px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 15px rgba(91, 60, 196, 0.4);
            width: auto;
        }

        .btn-submit:hover {
            background-color: #4a2f9c; 
            transform: translateY(-2px);
        }

        /* Hide by default for dynamic fields */
        .hidden-field {
            display: none;
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
            .form-card { padding: 20px; }
            .form-grid { grid-template-columns: 1fr; } /* Single column on mobile */
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
            <div class="department-title">Request College Facility</div>
        </div>

        <div class="dashboard-body">
            
            <div class="form-card">
                <div class="header-controls">
                    <h2>Facility Booking Form</h2>
                    <button class="btn-add-course" onclick="location.href='view_facility_bookings.php'">
                        <i class="fas fa-eye"></i> View
                    </button>
                </div>
                <form method="POST">
                    
                    <div class="form-field full-width">
                        <input type="text" id="event_name" name="name" placeholder=" " required>
                        <label for="event_name">Event Name / Purpose</label>
                    </div>

                    <div class="form-grid">
                        
                        <div class="form-field">
                            <select id="room_type" name="room" onchange="toggleClassroomDropdown()" required value="">
                                <option value="" disabled selected>Select Room</option>
                                <option value="Classroom">Classroom (General Use)</option>
                                <option value="Seminar Hall">Seminar Hall</option>
                                <option value="Lab">Computer Lab</option>
                                <option value="Auditorium">Auditorium</option>
                            </select>
                        </div>

                        <div class="form-field hidden-field" id="classroom_field">
                            <select id="classroom" name="class" required value="">
                                <option value="" disabled selected>Select Specific Classroom</option>
                                <option>Classroom C101</option>
                                <option>Classroom C102</option>
                                <option>Classroom C205</option>
                                <option>Classroom C301</option>
                            </select>
                        </div>
                        
                        <div class="form-field">
                            <input type="date" id="date" name="date" placeholder=" " required>
                            <label for="date">Date</label>
                        </div>
                        
                        <div class="form-field">
                            <input type="time" id="time_from" name="time_from" placeholder=" " required>
                            <label for="time_from">Time From</label>
                        </div>
                        
                        <div class="form-field">
                            <input type="time" id="time_to" name="time_to" placeholder=" " required>
                            <label for="time_to">Time To</label>
                        </div>
                        
                    </div>
                    
                    <div class="full-width" style="text-align: right; margin-top: 30px;">
                        <button type="submit" name="submit" class="btn-submit">
                            <i class="fas fa-calendar-check"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="footer">
            &copy; 2025 HOD Dashboard.
        </div>

    </div>

    <script>
        function toggleClassroomDropdown() {
            const roomType = document.getElementById('room_type').value;
            const classroomField = document.getElementById('classroom_field');
            const classroomSelect = document.getElementById('classroom');

            if (roomType === 'Classroom') {
                classroomField.classList.remove('hidden-field');
                classroomSelect.required = true;
            } else {
                classroomField.classList.add('hidden-field');
                classroomSelect.required = false;
                // Optional: Reset value when hidden
                classroomSelect.value = ""; 
            }
        }
        
        // Initialize floating labels for selects on page load
        document.addEventListener('DOMContentLoaded', () => {
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                // Set initial value to trigger floating label logic if pre-filled
                if (select.value) {
                    select.setAttribute('value', select.value);
                } else {
                    // Set empty value to ensure default behavior for required field
                    select.setAttribute('value', '');
                }
            });
            
            // Check initial state of the dynamic field on load (important if data is pre-populated)
            toggleClassroomDropdown();
        });
    </script>
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