<!DOCTYPE html>
<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    if(isset($_POST['submit'])){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];
        $pass=$_POST['password'];
        $query=mysqli_query($conn,"insert into scholarshipcell(name,email,phone,password)values('$name','$email','$phone','$pass')");
        if($query){
            echo "<script>alert('Registration Succes. Kindly wait for approvel from the admin!');window.location.href='login.php';</script>";
        }else{
            echo "<script>alert('Failed to register');</script>";
        }
    }
    ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variables */
        :root {
            --primary-color: #5b3cc4; /* Deep Violet */
            --accent-color: #00bcd4; /* Cyan/Teal */
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --border-color: #e3e7ed;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --radius: 12px;
        }

        /* Base Styles */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: var(--text-dark);
            padding: 20px;
            box-sizing: border-box;
        }

        .signup-container {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 500px; /* Slightly wider than login for more fields */
            text-align: center;
        }

        .signup-container h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 700;
        }

        .signup-container p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        /* --- Floating Label Inputs (reused from login/app form) --- */
        .form-field {
            position: relative;
            margin-bottom: 30px; 
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
        input[type="tel"], /* Use tel for phone numbers for better mobile support */
        input[type="password"] {
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
        }

        input:focus + label,
        input:not(:placeholder-shown) + label {
            top: -10px;
            left: 10px;
            font-size: 0.8rem;
            color: var(--primary-color);
            font-weight: 600;
        }

        input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(0, 188, 212, 0.2);
            background-color: white;
            outline: none;
        }

        /* --- Sign Up Button --- */
        .btn-signup {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 4px 15px rgba(91, 60, 196, 0.4);
            margin-top: 10px; /* Space from last field */
        }

        .btn-signup:hover {
            background-color: #4a2f9c; /* Slightly darker primary */
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(91, 60, 196, 0.5);
        }

        /* --- Additional Links --- */
        .additional-links {
            margin-top: 30px;
            font-size: 0.95rem;
        }

        .additional-links a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .additional-links a:hover {
            color: var(--accent-color);
        }
        
        .additional-links p {
            margin-top: 15px;
            color: #6c757d;
        }
        .additional-links p a {
            margin-left: 5px;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <h2>Join Our Community</h2>
        <p>Create your account to get started with our college management system.</p>

        <form method="POST">
            <div class="form-field">
                <input type="text" id="name" name="name" placeholder=" " required>
                <label for="name">Full Name</label>
            </div>

            <div class="form-field">
                <input type="email" id="email" name="email" placeholder=" " required>
                <label for="email">Email Address</label>
            </div>

            <div class="form-field">
                <input type="tel" id="phone" name="phone" placeholder=" " pattern="[0-9]{3}[0-9]{3}[0-9]{4}" title="Phone number should be 10 digits" required>
                <label for="phone">Phone Number</label>
            </div>

            <div class="form-field">
                <input type="password" id="password" name="password" placeholder=" " required minlength="8">
                <label for="password">Password</label>
            </div>

            <button type="submit" name="submit" class="btn-signup">Create Account</button>
        </form>

        <div class="additional-links">
            <p>Already have an account? <a href="login.php">Log in here</a></p>
        </div>
    </div>

</body>
</html>