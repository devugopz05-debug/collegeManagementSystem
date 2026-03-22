<!DOCTYPE html>
<html lang="en">
<?php
    session_start();
    $sid=$_SESSION['sid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from applications where id='$sid'");
    $res=mysqli_fetch_array($data);
    $cp=$res['password'];
    if(isset($_POST['submit'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $cpword=$_POST['cpword'];
        $npword=$_POST['npword'];
        if(!$npword){
            $query=mysqli_query($conn,"update applications set fname='$fname',lname='$lname',email='$email',phone='$phone',address='$address'");
                echo "<script>alert('Profile Updated');window.location.href='profile.php';</script>";
        }else{
            if($cpword!=$cp){
                echo "<script>alert('Wrong Current Password');</script>";
            }else{
                $query=mysqli_query($conn,"update applications set fname='$fname',lname='$lname',email='$email',phone='$phone',address='$address',password='$npword'");
                echo "<script>alert('Profile Updated');window.location.href='profile.php';</script>";
            }
        }
    }
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Student Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* --- Variables & Base Styles --- */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --success-color: #20c997;
            --danger-color: #dc3545;
            --border-color: #e3e7ed;
            --card-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
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
        
        a { text-decoration: none; color: white; }

        /* --- Header/Navigation --- */
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

        /* --- Form Container --- */
        .container {
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
        }

        .form-card h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 5px;
            font-weight: 800;
        }
        .form-card p.subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        /* --- Form Section & Grid Layout --- */
        .form-section {
            margin-bottom: 35px;
        }
        .form-section h3 {
            font-size: 1.5rem;
            color: var(--accent-color);
            margin-bottom: 20px;
            padding-bottom: 5px;
            border-bottom: 1px dashed var(--accent-color);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px 30px;
        }
        .full-width {
            grid-column: 1 / -1;
        }

        /* --- Floating Label Inputs (Consistent with Apply Form) --- */
        .form-field {
            position: relative;
        }
        input[type="text"], 
        input[type="password"], 
        input[type="email"], 
        input[type="tel"], 
        input[type="date"], 
        textarea, 
        select {
            width: 100%;
            padding: 15px 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--bg-light);
            transition: all 0.2s;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-field label {
            position: absolute;
            top: 18px;
            left: 12px;
            color: #6c757d;
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.2s ease;
            background-color: var(--bg-light); /* Ensure label is visible */
            padding: 0 5px;
        }

        /* Floating effect for input */
        input:focus + label,
        input:not(:placeholder-shown) + label,
        textarea:focus + label,
        textarea:not(:placeholder-shown) + label,
        select:focus + label,
        select[value]:not([value=""]) + label {
            top: -10px;
            left: 8px;
            font-size: 0.75rem;
            color: var(--primary-color);
            background-color: white;
            font-weight: 600;
        }

        input:focus, textarea:focus, select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
            outline: none;
        }
        
        /* Special style for Select to force label float */
        select[value]:not([value=""]) {
            /* This style is a visual hack to make the select look "filled" for the label float */
            background-color: white; 
        }

        /* --- File Upload for Avatar (Simple version) --- */
        .avatar-upload-field {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-top: 15px;
        }
        .current-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--accent-color);
        }
        .current-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        /* Style the actual file input button */
        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .file-input-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
        }
        .btn-upload {
            background-color: var(--success-color);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.2s;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .btn-upload:hover {
            background-color: #1a9e73;
        }

        /* --- Action Buttons --- */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn-action {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-save {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-save:hover {
            background-color: #4a2c9c;
        }

        .btn-cancel {
            background-color: #e9ecef;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }
        .btn-cancel:hover {
            background-color: #dee2e6;
        }

        /* --- Footer & Responsive --- */
        .footer {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid var(--border-color);
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            .header { padding: 15px 20px; }
            .container { padding: 20px 15px; }
            .form-card { padding: 20px; }
            .form-actions { justify-content: space-between; gap: 10px; }
            .btn-action { flex-grow: 1; padding: 10px 15px; }
            .avatar-upload-field { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <i class="fas fa-user-graduate"></i> Student Portal
        </div>
        <div class="nav-link">
            <a href="profile.php"><i class="fas fa-arrow-left"></i> Back to Profile</a>
        </div>
    </div>

    <div class="container">
        <div class="form-card">
            <h2>Edit Profile</h2>
            <p class="subtitle">Update your personal, contact, and security information below.</p>
            
            <form method="POST" enctype="multipart/form-data">

                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Basic Information</h3>
                    
                    <div class="avatar-upload-field">
                        <div class="current-avatar">
                            <img id="avatar-preview" src="../<?php echo $res['photo'];?>" alt="Current Avatar">
                        </div>
                        
                    </div>

                    <div class="form-grid" style="margin-top: 25px;">
                        
                        <div class="form-field">
                            <input type="text" id="first_name" name="fname" value="<?php echo $res['fname'];?>" placeholder=" " required>
                            <label for="first_name">First Name</label>
                        </div>
                        
                        <div class="form-field">
                            <input type="text" id="last_name" name="lname" value="<?php echo $res['lname'];?>" placeholder=" " required>
                            <label for="last_name">Last Name</label>
                        </div>
                        
                        <div class="form-field">
                            <input type="text" id="dob" name="dob" value="<?php echo $res['dob'];?>" placeholder=" " disabled>
                            <label for="dob">Date of Birth</label>
                        </div>

                        <div class="form-field">
                            <select id="gender" name="gender" value="Female" disabled>
                                <option selected disabled><?php echo $res['gender'];?></option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        
                    </div>
                </div>
                
                <div class="form-section">
                    <h3><i class="fas fa-address-book"></i> Contact Information</h3>
                    <div class="form-grid">
                        <div class="form-field">
                            <input type="email" id="email" name="email" value="<?php echo $res['email'];?>" placeholder=" " required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-field">
                            <input type="tel" id="phone" name="phone" value="<?php echo $res['phone'];?>" placeholder=" " required>
                            <label for="phone">Phone Number</label>
                        </div>
                        
                        <div class="form-field full-width">
                            <textarea id="address" name="address" placeholder=" " required><?php echo $res['address'];?></textarea>
                            <label for="address">Permanent Address</label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-lock"></i> Security & Account</h3>
                    <div class="form-grid">
                        <div class="form-field">
                            <input type="password" id="current_password" name="cpword" placeholder=" ">
                            <label for="current_password">Current Password (Leave blank to keep)</label>
                        </div>
                        <div class="form-field">
                            <input type="password" id="new_password" name="npword" placeholder=" ">
                            <label for="new_password">New Password</label>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-action btn-cancel" onclick="window.location.href='profile.php'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" name="submit" class="btn-action btn-save">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 Student Portal. All rights reserved. | <a href="#" style="color: var(--primary-color);">Help & Support</a>
    </div>

    
</body>
</html>