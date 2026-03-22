<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
$conn=mysqli_connect("localhost","root","","collegemanagementsystem");
if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $pword=$_POST['password'];
    $data=mysqli_query($conn,"select * from scholarshipcell where email='$email' and password='$pword'");
    $hdata=mysqli_query($conn,"select * from hod where email='$email' and password='$pword'");
    $sdata=mysqli_query($conn,"select * from applications where email='$email' and password='$pword'");
    $res=mysqli_fetch_array($data);
    $hres=mysqli_fetch_array($hdata);
    $sres=mysqli_fetch_array($sdata);
    if($res){
        if($res['rights']=='Admin'){
            header("location: admin/admin.php");
        }else if($res['rights']=='Scholarshipcell'){
            $_SESSION['schid']=$res['id'];
            header("location: scholarshipcell/scholarshipcell.php");
        }else if($res['rights']=='New Scholarshipcell'){
            echo "<script>alert('Kindly wait for the approvel from the admin!');</script>";
        }else{
            echo "<script>alert('Your registration has been rejected by admin!');</script>";
        }
    }else if($hres){
        if($hres['rights']=='Hod'){
            $_SESSION['hid']=$hres['id'];
            $_SESSION['hemail']=$hres['email'];
            $_SESSION['department']=$hres['department'];
            header("location: hod/hod.php");
        }
    }else if($sres){
        if($sres['rights']=='Student'){
            $_SESSION['sid']=$sres['id'];
            $_SESSION['department']=$sres['department'];
            $_SESSION['fname']=$sres['fname'];
            $_SESSION['lname']=$sres['lname'];
            header("location: student/student.php");
        }else if($sres['rights']=='Pending'){
            echo "<script>alert('Your application is still pending. Please wait for approval. ');</script>";
        }else{
            echo "<script>alert('Your application has been rejected');</script>";
        }
    }
    else{
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Your Account</title>
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

        .login-container {
            background: white;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: var(--box-shadow);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .login-container h2 {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 700;
        }

        .login-container p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        /* --- Floating Label Inputs --- */
        .form-field {
            position: relative;
            margin-bottom: 30px; /* More space for floating label */
        }
        
        .form-field label {
            position: absolute;
            top: 15px;
            left: 15px;
            color: #999;
            font-size: 1rem;
            transition: all 0.2s ease-out;
            pointer-events: none;
            background: white; /* To cover the input border when floating up */
            padding: 0 5px;
            z-index: 5;
            font-weight: 400;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: var(--bg-light);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.05);
            -webkit-appearance: none; /* Remove default browser styling */
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

        /* --- Checkbox for Remember Me --- */
        .remember-me {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: -10px; /* Adjust spacing with previous field */
            margin-bottom: 25px;
            font-size: 0.95rem;
        }
        
        .remember-me label {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #555;
            font-weight: 500;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            background-color: var(--bg-light);
            transition: background-color 0.2s, border-color 0.2s;
            position: relative;
            flex-shrink: 0;
        }

        .remember-me input[type="checkbox"]:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .remember-me input[type="checkbox"]:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 14px;
            font-weight: bold;
        }

        .remember-me a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .remember-me a:hover {
            color: var(--accent-color);
        }

        /* --- Login Button --- */
        .btn-login {
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
        }

        .btn-login:hover {
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

    <div class="login-container">
        <h2>Welcome Back!</h2>
        <p>Log in to access your student portal and manage your academic journey.</p>

        <form method="POST">
            <div class="form-field">
                <input type="text" id="username" name="email" placeholder=" " required>
                <label for="username">Email</label>
            </div>

            <div class="form-field">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password">Password</label>
            </div>

            <div class="remember-me">
                <label>
                    <input type="checkbox" name="remember_me">
                    Remember me
                </label>
            </div>

            <button type="submit" name="submit" class="btn-login">Login Securely</button>
        </form>

        <div class="additional-links">
            <p>Don't have an account? <a href="reg.php">Scholarship Cell Registration</a></p>
        </div>
    </div>

</body>
</html>