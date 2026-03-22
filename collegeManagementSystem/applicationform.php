<!DOCTYPE html>
<html lang="en">
    <?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from course");
    if(isset($_POST['submit'])){
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $dob=$_POST['dob'];
        $gender=$_POST['gender'];
        $address=$_POST['address'];
        $school=$_POST['school'];
        $gpa=$_POST['gpa'];
        $gdate=$_POST['gdate'];
        $course=$_POST['course'];

        $target_dir="uploads/";
        $cert10=$target_dir . basename($_FILES['cert10']['name']);
        $cert12=$target_dir . basename($_FILES['cert12']['name']);
        $photo=$target_dir . basename($_FILES['photo']['name']);
        
        if(move_uploaded_file($_FILES['cert10']['tmp_name'],$cert10)){
            if(move_uploaded_file($_FILES['cert12']['tmp_name'],$cert12)){
                if(move_uploaded_file($_FILES['photo']['tmp_name'],$photo)){
                    $query=mysqli_query($conn,"insert into applications(fname,lname,email,phone,dob,gender,address,previous,gpa,gdate,department,certificate10,certificate12,photo,password)values('$fname','$lname','$email','$phone','$dob','$gender','$address','$school','$gpa','$gdate','$course','$cert10','$cert12','$photo','$phone')");
                    if($query){
                        echo "<script>alert('Application Success');window.location.href='applicationform.php';</script>";
                    }else{
                        echo "<script>alert('Failed to Apply');window.location.href='applicationform.php';</script>";
                    }
                }
            }
        }
    }
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Application - Streamlined Interface</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal (for highlights) */
            --success-color: #20c997;
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --border-color: #e3e7ed;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --radius: 12px;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            padding: 50px 20px;
        }

        .form-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--box-shadow);
            overflow: hidden; 
        }

        .form-header {
            background-color: var(--primary-color);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        
        .form-header h2 {
            font-size: 2rem;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .form-header p {
            opacity: 0.8;
            font-size: 1rem;
        }

        /* --- Progress Bar --- */
        .progress-bar-container {
            background-color: #e9ecef;
            padding: 20px 40px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .progress-bar {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 0 5%;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 5%;
            right: 5%;
            height: 4px;
            background-color: var(--border-color);
            z-index: 0;
            transform: translateY(-50%);
        }
        
        .progress-active-line {
            height: 4px;
            background-color: var(--primary-color);
            width: 0%; 
            transition: width 0.5s ease-in-out;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 20%;
            position: relative;
            z-index: 1;
        }

        .step-circle {
            width: 35px;
            height: 35px;
            background-color: white;
            border: 3px solid var(--border-color);
            border-radius: 50%;
            color: var(--text-dark);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .step.active .step-circle {
            border-color: var(--primary-color);
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 10px rgba(91, 60, 196, 0.5);
        }
        
        .step.completed .step-circle {
            border-color: var(--success-color);
            background-color: var(--success-color);
            color: white;
            font-size: 1.2rem;
            content: '✓';
        }

        .step-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-align: center;
            margin-top: 8px;
            font-weight: 600;
        }
        
        .step.active .step-label {
            color: var(--primary-color);
        }

        /* --- Form Content --- */
        .form-content {
            padding: 40px;
        }

        .form-section {
            background-color: white;
            padding: 0;
            margin-bottom: 30px;
            transition: opacity 0.3s;
            /* display: none; */ 
        }

        .form-section h3 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 25px;
            border-bottom: 1px dashed var(--border-color);
            padding-bottom: 10px;
        }

        /* --- Floating Label Inputs --- */
        .field-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 20px;
        }

        .form-field {
            position: relative;
            margin-top: 20px;
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

        input:focus + label,
        input:not(:placeholder-shown) + label,
        textarea:focus + label,
        textarea:not(:placeholder-shown) + label,
        select:focus + label,
        select:not([value=""]) + label {
            top: -10px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--bg-light);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%235b3cc4'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 12px;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
        }
        
        /* File Upload Styling */
        input[type="file"] {
            border: 2px dashed var(--border-color);
            background-color: white;
            padding: 20px 15px;
            cursor: pointer;
        }
        
        /* Checkbox Styling */
        .checkbox-container {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            background-color: var(--bg-light);
        }
        .checkbox-container label {
            position: static; 
            display: inline-block;
            margin-left: 10px;
            font-weight: 400;
            color: var(--text-dark);
        }
        
        /* --- Button Group --- */
        .button-group {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed var(--border-color);
        }

        .btn {
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-prev {
            background-color: #6c757d;
            color: white;
        }

        .btn-next {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-submit {
            background-color: var(--success-color);
            color: white;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        
        /* Responsive Adjustments (same as before) */
        @media (max-width: 950px) {
            .form-header, .progress-bar-container, .form-content {
                padding-left: 20px;
                padding-right: 20px;
            }
        }
        @media (max-width: 650px) {
            .field-group {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .button-group {
                flex-direction: column;
                gap: 15px;
            }
            .btn {
                width: 100%;
            }
            .progress-bar-container {
                padding: 15px 10px;
            }
            .progress-bar {
                margin: 0;
            }
            .step-label {
                display: none; 
            }
        }
    </style>
</head>
<body>

    <div class="form-container">
        
        <div class="form-header">
            <h2>Elite Admissions Application</h2>
            <p>Complete the four steps below to submit your application for the upcoming academic year.</p>
        </div>

        <div class="progress-bar-container">
            <div class="progress-bar">
                <div class="progress-line">
                    <div class="progress-active-line" id="progress-active-line"></div>
                </div>
                <div class="step active" id="step1">
                    <div class="step-circle">1</div>
                    <div class="step-label">Personal Details</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">2</div>
                    <div class="step-label">Academics</div>
                </div>
                <div class="step" id="step3">
                    <div class="step-circle">3</div>
                    <div class="step-label">Program Choice</div>
                </div>
                <div class="step" id="step4">
                    <div class="step-circle">4</div>
                    <div class="step-label">Uploads & Review</div>
                </div>
            </div>
        </div>

        <div class="form-content">
            <form id="admissionForm" method="POST" enctype="multipart/form-data">
            
                <div class="form-section active" data-step="1">
                    <h3>Your Personal Details</h3>
                    
                    <div class="field-group">
                        <div class="form-field">
                            <input type="text" id="first_name" name="fname" placeholder=" " required>
                            <label for="first_name">First Name</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="last_name" name="lname" placeholder=" " required>
                            <label for="last_name">Last Name</label>
                        </div>
                    </div>

                    <div class="field-group">
                        <div class="form-field">
                            <input type="email" id="email" name="email" placeholder=" " required>
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-field">
                            <input type="text" id="phone" name="phone" placeholder=" " required>
                            <label for="phone">Phone Number</label>
                        </div>
                    </div>

                    <div class="field-group">
                        <div class="form-field">
                            <input type="date" id="dob" name="dob" placeholder=" " required>
                            <label for="dob">Date of Birth</label>
                        </div>
                        <div class="form-field">
                            <select id="gender" name="gender" required value="">
                                <option value="" disabled selected></option> 
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            <label for="gender">Gender</label>
                        </div>
                    </div>
                    
                    <div class="form-field">
                        <textarea id="address" name="address" placeholder=" " required></textarea>
                        <label for="address">Full Mailing Address</label>
                    </div>
                </div>

                <div class="form-section" data-step="2">
                    <h3>Academic History</h3>
                    
                    <div class="form-field">
                        <input type="text" id="high_school" name="school" placeholder=" " required>
                        <label for="high_school">Previous School/College Name</label>
                    </div>
                    
                    <div class="field-group">
                        <div class="form-field">
                            <input type="text" id="gpa" name="gpa" placeholder=" " required>
                            <label for="gpa">Final GPA / Percentage</label>
                        </div>
                        <div class="form-field">
                            <input type="date" id="graduation_date" name="gdate" placeholder=" " required>
                            <label for="graduation_date">Graduation Date</label>
                        </div>
                    </div>
                    
                    </div>

                <div class="form-section" data-step="3">
                    <h3>Program Selection</h3>
                    
                    <div class="form-field" style="max-width: 400px; margin: 20px auto;">
                        <select id="degree_level" name="course" required value="">
                            <option value="" disabled selected></option>
                            <?php
                            while($res=mysqli_fetch_array($data)){
                                ?>
                            <option><?php echo $res['cname'];?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <label for="degree_level">Select Course</label>
                    </div>
                    
                    </div>

                <div class="form-section" data-step="4">
                    <h3>Document Upload & Declaration</h3>
                    
                    <p style="color: var(--primary-color); font-weight: 600; margin-bottom: 25px;">Please upload your certificates and ID copy in **PDF format**.</p>
                    
                    <div class="field-group">
                        <div class="form-field">
                            <label for="certificate_10th" style="position: static; padding: 0;">10th Certificate (Required)</label>
                            <input type="file" id="certificate_10th" name="cert10" accept=".pdf, .jpg, .png" required>
                        </div>
                        <div class="form-field">
                            <label for="certificate_12th" style="position: static; padding: 0;">12th Class Certificate (Required)</label>
                            <input type="file" id="certificate_12th" name="cert12" accept=".pdf, .jpg, .png" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label for="id_proof" style="position: static; padding: 0;">Photo</label>
                        <input type="file" id="id_proof" name="photo" required>
                    </div>


                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="declaration" value="true" required>
                            I confirm that all information provided in this application is true, accurate, and complete.
                        </label>
                    </div>
                    
                </div>
                
                <div class="button-group">
                    <button type="button" class="btn btn-prev" onclick="prevStep()" style="display: none;">&larr; Previous Step</button>
                    <button type="button" class="btn btn-next" onclick="nextStep()">Next Step &rarr;</button>
                    <button type="submit" name="submit" class="btn btn-submit" style="display: none;">Submit Application &check;</button>
                </div>
                
            </form>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;
        const formSections = document.querySelectorAll('.form-section');
        const steps = document.querySelectorAll('.step');
        const btnPrev = document.querySelector('.btn-prev');
        const btnNext = document.querySelector('.btn-next');
        const btnSubmit = document.querySelector('.btn-submit');
        const progressBar = document.getElementById('progress-active-line');
        const form = document.getElementById('admissionForm');

        function updateForm() {
            // Update sections visibility
            formSections.forEach(section => {
                const stepNum = parseInt(section.getAttribute('data-step'));
                section.style.display = (stepNum === currentStep) ? 'block' : 'none';
            });

            // Update progress bar
            steps.forEach(step => {
                const stepNum = parseInt(step.id.replace('step', ''));
                step.classList.remove('active', 'completed');
                
                if (stepNum < currentStep) {
                    step.classList.add('completed');
                    step.querySelector('.step-circle').innerHTML = '&#x2713;'; 
                } else {
                    step.querySelector('.step-circle').innerHTML = stepNum; 
                }
                
                if (stepNum === currentStep) {
                    step.classList.add('active');
                }
            });

            // Update progress line width
            const progress = (currentStep - 1) / (totalSteps - 1) * 100;
            progressBar.style.width = `${progress}%`;

            // Update button visibility
            btnPrev.style.display = (currentStep > 1) ? 'inline-block' : 'none';
            btnNext.style.display = (currentStep < totalSteps) ? 'inline-block' : 'none';
            btnSubmit.style.display = (currentStep === totalSteps) ? 'inline-block' : 'none';
        }
        
        function validateStep(step) {
            let isValid = true;
            const currentSection = document.querySelector(`.form-section[data-step="${step}"]`);
            const requiredFields = currentSection.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                field.style.borderColor = 'var(--border-color)';

                if (!field.value.trim() || (field.type === 'checkbox' && !field.checked) || (field.type === 'file' && !field.files.length)) {
                    field.style.borderColor = '#dc3545';
                    field.focus();
                    isValid = false;
                }
            });
            return isValid;
        }

        function nextStep() {
            if (validateStep(currentStep)) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateForm();
                    document.querySelector('.form-content').scrollIntoView({ behavior: 'smooth', block: 'start' }); 
                }
            } else {
                alert('Please fill out all required fields before proceeding.');
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateForm();
                document.querySelector('.form-content').scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        form.addEventListener('change', (e) => {
            if (e.target.type === 'file' && e.target.files.length > 0) {
                e.target.style.borderColor = 'var(--border-color)';
            }
        });

        // Initialize form display
        updateForm();

    </script>
</body>
</html>