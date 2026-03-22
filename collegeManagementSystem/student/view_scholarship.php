<!DOCTYPE html>
<?php
    session_start();
    $std=$_SESSION['sid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from scholarship_ug where student='$std'");
    if(!$data){
        $data=mysqli_query($conn,"Select * from scholarship_pg where student='$std'");
    }
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* --- Variables & Base Styles --- */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --success-color: #20c997; /* Green */
            --warning-color: #ffc107; /* Yellow */
            --danger-color: #dc3545; /* Red */
            --info-color: #6c757d;   /* Gray */
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
            max-width: 1000px;
            margin: 0 auto;
        }

        h1 {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 800;
        }
        .status-header p {
            color: var(--info-color);
            margin-top: 0;
            margin-bottom: 30px;
        }

        /* --- Status Card: Key Information Summary --- */
        .status-summary {
            background: white;
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border-left: 5px solid var(--accent-color);
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        .summary-item {
            display: flex;
            flex-direction: column;
        }
        .summary-item strong {
            font-size: 0.9rem;
            color: var(--info-color);
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .summary-item span {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        /* --- Status Badge (Dynamic) --- */
        .status-badge {
            padding: 8px 15px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.95rem;
            display: inline-block;
            text-transform: uppercase;
        }
        .status-badge.pending {
            background-color: #fff3cd;
            color: var(--warning-color);
        }
        .status-badge.approved {
            background-color: #d4edda;
            color: var(--success-color);
        }
        .status-badge.declined {
            background-color: #f8d7da;
            color: var(--danger-color);
        }
        .status-badge.submitted {
            background-color: #d1ecf1;
            color: var(--accent-color);
        }

        /* --- Timeline Tracker --- */
        .timeline {
            margin: 40px 0;
            position: relative;
        }
        .timeline h3 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 25px;
            border-bottom: 2px dashed var(--border-color);
            padding-bottom: 10px;
        }

        /* Vertical Line */
        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 60px;
            bottom: 0;
            width: 3px;
            background-color: var(--border-color);
        }

        .timeline-step {
            position: relative;
            padding-left: 50px;
            margin-bottom: 30px;
        }

        /* Circles */
        .timeline-step::before {
            content: '\f00c'; /* Checkmark icon */
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            border: 3px solid var(--border-color);
            color: var(--info-color);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            z-index: 10;
        }

        /* Active/Complete Steps */
        .timeline-step.complete::before {
            background-color: var(--success-color);
            border-color: var(--success-color);
            color: white;
        }
        .timeline-step.active::before {
            content: '\f14e'; /* Spinner icon (or other loading indicator) */
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: white;
            animation: pulse 1.5s infinite;
        }
        
        .timeline-step.active h4 {
            color: var(--accent-color);
        }

        .timeline-step h4 {
            margin: 0 0 5px 0;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .timeline-step p {
            margin: 0;
            color: #6c757d;
            font-size: 0.95rem;
        }

        /* Action Section */
        .action-section {
            padding: 30px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            text-align: center;
            background-color: white;
            margin-top: 30px;
        }
        .action-section h4 {
            color: var(--danger-color);
            font-size: 1.3rem;
            margin-top: 0;
        }
        .action-button {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .action-button:hover {
            background-color: #4a2c9c;
        }

        /* Keyframes */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 188, 212, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(0, 188, 212, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 188, 212, 0); }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 600px) {
            .header { padding: 15px 20px; }
            .logo { font-size: 1.4rem; }
            .container { padding: 20px 15px; }
            h1 { font-size: 1.8rem; }
            .timeline::before { left: 10px; }
            .timeline-step { padding-left: 40px; }
            .timeline-step::before { left: -5px; width: 30px; height: 30px; font-size: 0.9rem; }
            .action-button { width: 100%; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <i class="fas fa-user-graduate"></i> Student Portal
        </div>
        <div class="nav-link">
            <a href="student.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </div>
    </div>

    <div class="container">
        <div class="status-header">
            <h1>Application Status</h1>
            <p></p>
        </div>

        <?php
        while($res=mysqli_fetch_array($data)){
            ?>
        <div class="status-summary">
            <div class="summary-grid">
                <div class="summary-item">
                    <strong>Status</strong>
                    <span class="status-badge <?php echo strtolower($res['status']);?>" id="overall-status"><?php echo $res['status'];?> Review</span>
                </div>
                <div class="summary-item">
                    <strong>Scholarship</strong>
                    <span><?php echo $res['scholarship_type'];?></span>
                </div>
                <div class="summary-item">
                    <strong>Submission Date</strong>
                    <span><?php echo $res['date'];?></span>
                </div>
                <!-- <div class="summary-item">
                    <strong>Est. Review Date</strong>
                    <span>November 15, 2025</span>
                </div> -->
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</body>
</html>