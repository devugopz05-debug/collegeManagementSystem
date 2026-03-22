<!DOCTYPE html>
<?php
    session_start();
    $sid=$_SESSION['sid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from applications where id='$sid'");
    $res=mysqli_fetch_array($data);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* --- Variables & Base Styles --- */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --info-color: #17a2b8;
            --success-color: #20c997;
            --border-color: #e3e7ed;
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            --radius: 12px;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }
        
        a { text-decoration: none; color: white; } /* Default link color for header */

        /* --- Header/Navigation (Consistent Portal Look) --- */
        .header {
            background: linear-gradient(90deg, var(--primary-color), #7f58d9);
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .logo { font-size: 1.8rem; font-weight: 800; }
        .nav-link a { text-decoration: none; color: white; font-weight: 600;}

        /* --- Main Content Layout --- */
        .container {
            padding: 40px 20px;
            max-width: 900px;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 800;
        }
        .profile-header p {
            color: var(--info-color);
            margin-top: 0;
            margin-bottom: 30px;
        }

        /* --- Profile Card (Top Section) --- */
        .profile-card {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap; /* Allow wrapping on smaller screens */
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--accent-color);
            flex-shrink: 0; /* Prevent shrinking */
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-info {
            flex-grow: 1; /* Allows this section to take available space */
        }

        .profile-info h2 {
            margin: 0 0 5px 0;
            font-size: 2rem;
            color: var(--text-dark);
            font-weight: 800;
        }

        .profile-info p {
            margin: 0;
            color: #6c757d;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        .profile-info .status-badge {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.85rem;
            font-weight: 700;
            background-color: var(--success-color);
            color: white;
        }

        /* --- Profile Details Tabs --- */
        .profile-details-tabs {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden; /* Contains child floats/margins */
        }

        .tab-buttons {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--bg-light);
        }

        .tab-button {
            flex: 1;
            padding: 15px 20px;
            text-align: center;
            font-size: 1.05rem;
            font-weight: 600;
            color: var(--info-color);
            cursor: pointer;
            transition: all 0.2s ease;
            border-bottom: 3px solid transparent; /* For active indicator */
        }

        .tab-button:hover {
            color: var(--primary-color);
            background-color: #e9ecef;
        }

        .tab-button.active {
            color: var(--primary-color);
            border-bottom-color: var(--primary-color);
            background-color: white;
        }

        .tab-content {
            padding: 30px;
        }

        .tab-pane {
            display: none; /* Hidden by default */
        }

        .tab-pane.active {
            display: block; /* Show active pane */
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px 30px;
        }

        .detail-item {
            margin-bottom: 15px;
        }

        .detail-item strong {
            display: block;
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .detail-item span {
            font-size: 1.05rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Call to Action Button */
        .edit-profile-btn {
            display: block;
            width: fit-content;
            margin: 30px auto 0; /* Center the button */
            padding: 12px 30px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            text-align: center;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.2);
        }

        .edit-profile-btn:hover {
            background-color: #008fa7;
            transform: translateY(-2px);
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
        @media (max-width: 768px) {
            .header { padding: 15px 20px; }
            .logo { font-size: 1.4rem; }
            .container { padding: 20px 15px; }
            h1 { font-size: 1.8rem; }
            .profile-card { flex-direction: column; text-align: center; gap: 20px; }
            .profile-avatar { margin-bottom: 15px; } /* Add space below avatar when stacked */
            .tab-buttons { flex-wrap: wrap; } /* Allow tabs to wrap */
            .tab-button { flex: 1 1 50%; border-bottom: none; /* Remove individual borders */ border-right: 1px solid var(--border-color); }
            .tab-button:nth-child(even) { border-right: none; } /* No border on last of row */
            .tab-button.active { border-bottom: 3px solid var(--primary-color); } /* Restore active indicator */
            .detail-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .tab-button { flex: 1 1 100%; border-right: none; } /* Stack tabs completely */
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <i class="fas fa-user-graduate"></i> Student Portal
        </div>
        <div class="nav-link">
            <a href="student.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="profile-header">
            <h1>Student Profile</h1>
            <p>View and manage your personal and academic information.</p>
        </div>

        <div class="profile-card">
            <div class="profile-avatar">
                <img src="../<?php echo $res['photo'];?>" alt="<?php echo $res['fname'];?> <?php echo $res['lname'];?>">
            </div>
            <div class="profile-info">
                <h2><?php echo $res['fname'];?> <?php echo $res['lname'];?></h2>
                <p><?php echo $res['department'];?></p>
                <span class="status-badge">Active Student</span>
            </div>
        </div>

        <div class="profile-details-tabs">
            <div class="tab-buttons">
                <div class="tab-button active" data-tab="personal">
                    <i class="fas fa-user"></i> Personal Info
                </div>
                <div class="tab-button" data-tab="academic">
                    <i class="fas fa-graduation-cap"></i> Academic Details
                </div>
                <div class="tab-button" data-tab="contact">
                    <i class="fas fa-address-book"></i> Contact Info
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane active" id="personal">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <strong>Full Name</strong>
                            <span><?php echo $res['fname'];?> <?php echo $res['lname'];?></span>
                        </div>
                        <!-- <div class="detail-item">
                            <strong>Student ID</strong>
                            <span>STU-2022-7890</span>
                        </div> -->
                        <div class="detail-item">
                            <strong>Date of Birth</strong>
                            <span><?php echo $res['dob'];?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Gender</strong>
                            <span><?php echo $res['gender'];?></span>
                        </div>
                        <!-- <div class="detail-item">
                            <strong>Nationality</strong>
                            <span>Indian</span>
                        </div>
                        <div class="detail-item">
                            <strong>Marital Status</strong>
                            <span>Single</span>
                        </div> -->
                    </div>
                </div>

                <div class="tab-pane" id="academic">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <strong>Major</strong>
                            <span><?php echo $res['department'];?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Enrollment Date</strong>
                            <span><?php echo $res['date'];?></span>
                        </div>
                        
                        
                    </div>
                </div>

                <div class="tab-pane" id="contact">
                    <div class="detail-grid">
                        <div class="detail-item">
                            <strong>Email Address</strong>
                            <span><?php echo $res['email'];?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Phone Number</strong>
                            <span><?php echo $res['phone'];?></span>
                        </div>
                        <div class="detail-item">
                            <strong>Permanent Address</strong>
                            <span><?php echo $res['address'];?></span>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <a href="edit_profile.php" class="edit-profile-btn">
            <i class="fas fa-edit"></i> Edit Profile Information
        </a>

    </div>

    <div class="footer">
        &copy; 2025 Student Portal. All rights reserved. | <a href="#" style="color: var(--primary-color);">Help & Support</a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabPanes = document.querySelectorAll('.tab-pane');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const tabId = button.dataset.tab;

                    // Remove active class from all buttons and panes
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabPanes.forEach(pane => pane.classList.remove('active'));

                    // Add active class to the clicked button and corresponding pane
                    button.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
        });
    </script>
</body>
</html>