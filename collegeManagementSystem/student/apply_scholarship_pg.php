<!DOCTYPE html>
<?php
    session_start();
    $std=$_SESSION['sid'];
    $dept=$_SESSION['department'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from course");
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $dob=$_POST['dob'];
        $gender=$_POST['gender'];
        $marital_status=$_POST['marital_status'];
        $address=$_POST['address'];
        $fn=$_POST['father_name'];
        $fo=$_POST['father_occupation'];
        $mn=$_POST['mother_name'];
        $mo=$_POST['mother_occupation'];
        $sch_type=$_POST['sch_type'];

        $target_dir="../uploads/";
        $income=$target_dir . basename($_FILES['income_certificate']['name']);
        $caste=$target_dir . basename($_FILES['caste_certificate']['name']);
        $photo=$target_dir . basename($_FILES['photo']['name']);
        $semester=$target_dir . basename($_FILES['degree_certificate']['name']);
        
        if(move_uploaded_file($_FILES['income_certificate']['tmp_name'],$income)){
            if(move_uploaded_file($_FILES['caste_certificate']['tmp_name'],$caste)){
                if(move_uploaded_file($_FILES['photo']['tmp_name'],$photo)){
                    if(move_uploaded_file($_FILES['degree_certificate']['tmp_name'],$semester)){
                        $query=mysqli_query($conn,"insert into scholarship_pg(student,name,email,phone,dob,gender,marital_status,address,father_name,father_occupation,mother_name,mother_occupation,department,scholarship_type,income_cert,caste_cert,photo,degree_cert)values('$std','$name','$email','$phone','$dob','$gender','$marital_status','$address','$fn','$fo','$mn','$mo','$dept','$sch_type','$income','$caste','$photo','$semester')");
                        if($query){
                            echo "<script>alert('Application Success');window.location.href='view_scholarship.php';</script>";
                        }else{
                            echo "<script>alert('Failed to Apply');window.location.href='apply_scholarship.php';</script>";
                        }
                    }
                }
            }
        }
    }
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Scholarship Application</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --bg-light: #f4f6f9; /* Main Page Background */
            --text-dark: #343a40;
            --success-color: #20c997;
            --border-color: #e3e7ed;
            --card-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            --radius: 12px;
        }

        /* Base Styles (reused from Student Dashboard) */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-light);
            color: var(--text-dark);
            min-height: 100vh;
        }

        a { text-decoration: none; color: white; }

        /* --- Header/Navigation (Student Portal Look) --- */
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
        
        /* --- Main Content Layout --- */
        .container {
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
        }

        .header-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-controls h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }
        
        /* --- Add Course Button --- */
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
        
        /* --- Form Card --- */
        .form-card {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
        }
        
        .form-card h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 10px;
            font-weight: 800;
        }
        
        .form-card p.subtitle {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--border-color);
        }

        /* --- Form Sections --- */
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

        /* --- Input Fields (Floating Label Style) --- */
        .form-field {
            position: relative;
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
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        textarea,
        select {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--bg-light);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            resize: vertical;
            min-height: 50px;
        }
        
        textarea {
            min-height: 120px;
        }

        /* Floating Label Logic */
        input:focus + label,
        input:not(:placeholder-shown) + label,
        textarea:focus + label,
        textarea:not(:placeholder-shown) + label,
        select:focus + label,
        select:not([value=""]) + label {
            top: -12px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
            outline: none;
        }

        /* --- File Upload Styling --- */
        .file-upload-container {
    border: 2px dashed var(--border-color);
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    transition: border-color 0.3s;
    background-color: var(--bg-light);
    display: block; 
    
    /* ADD THIS LINE */
    position: relative; 
    /* The container must be relative for the absolute input to align correctly */
}

        .file-upload-container:hover {
            border-color: var(--primary-color);
        }
        .file-upload-container input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0; /* Makes it invisible, but the browser still registers it as a clickable element */
            cursor: pointer;
            z-index: 10;
        }
        .file-upload-container label {
            cursor: pointer;
            color: var(--primary-color);
            font-weight: 600;
            display: block;
            margin-top: 5px;
        }
        .file-upload-container p {
            font-size: 0.85rem;
            color: #6c757d;
            margin: 0;
        }
        .file-upload-container .file-name {
    font-size: 0.8rem;
    font-style: italic;
    color: #00bcd4; /* Accent color for visibility */
    font-weight: 500;
}
        
        /* --- Submit Button --- */
        .btn-submit {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: 30px auto 0;
            padding: 15px 30px;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 4px 15px rgba(32, 201, 151, 0.4);
        }

        .btn-submit:hover {
            background-color: #1a9d70;
            transform: translateY(-2px);
        }

        /* --- Footer --- */
        .footer {
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 40px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container { padding: 20px; }
            .form-card { padding: 30px 20px; }
            .form-grid { grid-template-columns: 1fr; } 
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <i class="fas fa-user-graduate"></i> Student Portal
        </div>
        <div class="nav-links">
            <a href="student.php"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>

    <div class="container">
        
        <div class="form-card">
            <div class="header-controls">
                <h2>Application</h2>
                <button class="btn-add-course" onclick="location.href='view_scholarship.php'">
                    <i class="fas fa-eye"></i> View
                </button>
            </div>
            <p class="subtitle">Provide your personal, demographic, and required certificate details.</p>
            <form method="POST" enctype="multipart/form-data">

                <div class="form-section">
                    <h3><i class="fas fa-user"></i> Personal & Contact Information</h3>
                    <div class="form-grid">
                        
                        <div class="form-field">
                            <input type="text" id="name" name="name" placeholder=" " required>
                            <label for="name">Full Name</label>
                        </div>
                        <div class="form-field">
                            <input type="email" id="email" name="email" placeholder=" " required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-field">
                            <input type="tel" id="phone" name="phone" placeholder=" " required>
                            <label for="phone">Phone Number</label>
                        </div>
                        <div class="form-field">
                            <input type="date" id="dob" name="dob" placeholder=" " required>
                            <label for="dob">Date of Birth</label>
                        </div>
                        
                        <div class="form-field">
                            <select id="gender" name="gender" required value="">
                                <option value="" disabled selected></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                        <div class="form-field">
                            <select id="marital_status" name="marital_status" required value="">
                                <option value="" disabled selected></option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Other">Other</option>
                            </select>
                            <label for="marital_status">Marital Status</label>
                        </div>

                        <div class="form-field full-width">
                            <textarea id="address" name="address" placeholder=" " required></textarea>
                            <label for="address">Permanent Address</label>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-users"></i> Family & Academic Context</h3>
                    <div class="form-grid">
                        <div class="form-field">
                            <input type="text" id="father_name" name="father_name" placeholder=" " required>
                            <label for="father_name">Father's Name</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="father_occupation" name="father_occupation" placeholder=" " required>
                            <label for="father_occupation">Father's Occupation</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="mother_name" name="mother_name" placeholder=" " required>
                            <label for="mother_name">Mother's Name</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="mother_occupation" name="mother_occupation" placeholder=" " required>
                            <label for="mother_occupation">Mother's Occupation</label>
                        </div>
                        <div class="form-field full-width">
                            <input type="text" id="department" name="department" value=<?php echo $dept;?> readonly>
                            <label for="department">Enrolled Department</label>
                        </div>
                        <div class="form-field full-width">
                            <select id="marital_status" name="sch_type" required value="">
                                <option value="" disabled selected>Scholarship Type</option>
                                <option>Financial Aid Scholarship</option>
                                <option>Private scholarships</option>
                                <option>Minority Scholarship</option>
                                <option>Post matric Scholarship</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3><i class="fas fa-file-upload"></i> Required Document Uploads</h3>
                    <div class="form-grid">
                        
                        <div class="form-field">
                            <div class="file-upload-container">
                                <p>
                                    <i class="fas fa-file-pdf"></i> 
                                    Income Certificate (PDF)
                                    <span class="file-name" id="name_income_certificate">No file chosen</span>
                                </p>
                                <input type="file" id="income_certificate" name="income_certificate" accept=".pdf" required>
                                <label for="income_certificate">Choose File</label>
                            </div>
                        </div>

                        <div class="form-field">
                            <div class="file-upload-container">
                                <p><i class="fas fa-file-pdf"></i> Caste Certificate (PDF)
                                <span class="file-name" id="name_caste_certificate">No file chosen</span>
                                </p>
                                <input type="file" id="caste_certificate" name="caste_certificate" accept=".pdf" required>
                                <label for="caste_certificate">Click here to upload</label>
                            </div>
                        </div>
                        
                        <div class="form-field">
                            <div class="file-upload-container" style="max-width: 400px; margin: 0 auto;">
                                <p><i class="fas fa-image"></i> Passport Size Photo (JPG/PNG)
                                <span class="file-name" id="name_photo">No file chosen</span>
                                </p>
                                <input type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png" required>
                                <label for="photo">Click here to upload</label>
                            </div>
                            
                        </div>
                        <div class="form-field">
                            <div class="file-upload-container" style="max-width: 400px; margin: 0 auto;">
                                <p><i class="fas fa-image"></i> Degree Certificate (PDF)
                                <span class="file-name" id="name_degree_certificate">No file chosen</span>
                                </p>
                                <input type="file" id="sem_certificate" name="degree_certificate" required>
                                <label for="photo">Click here to upload</label>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Finalize & Submit Application
                </button>
            </form>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 Student Portal. Financial Aid Office.
    </div>

    <script>
    // Existing DOMContentLoaded logic...
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('select').forEach(select => {
            if (select.value) {
                select.setAttribute('value', select.value);
            } else {
                select.setAttribute('value', '');
            }
        });

        // 🌟 NEW FILE NAME DISPLAY LOGIC 🌟
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function(event) {
                // Get the unique ID for the file name display span (e.g., name_income_certificate)
                const targetId = 'name_' + this.id; 
                const fileNameSpan = document.getElementById(targetId);
                
                if (this.files.length > 0) {
                    // Display the name of the first selected file
                    fileNameSpan.textContent = this.files[0].name;
                    fileNameSpan.style.color = 'var(--success-color)'; // Change color on success
                    
                    // Optional: Update the label text to indicate success
                    this.nextElementSibling.textContent = 'File selected!';
                } else {
                    fileNameSpan.textContent = 'No file chosen';
                    fileNameSpan.style.color = '#00bcd4'; 
                    this.nextElementSibling.textContent = 'Choose File';
                }
            });
        });
        
    });
</script>
    
</body>
</html>