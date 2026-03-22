<!DOCTYPE html>
<html lang="en">
    <?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from course");
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System - Comprehensive Home</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* Variables */
        :root {
            --primary-color: #0c3c6f; /* Deep Ocean Blue */
            --secondary-color: #2a6f99; /* Medium Blue */
            --accent-color: #f7a01d; /* Vibrant Gold/Orange */
            --text-dark: #333;
            --text-light: #fff;
            --bg-light: #f9f9f9;
            --bg-medium: #eef3f6;
            --border-radius: 6px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Base & Typography */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            background-color: var(--bg-light);
            scroll-behavior: smooth;
        }

        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        /* Utility */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 0;
        }

        .section-heading {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 50px;
        }
        
        .cta-button {
            display: inline-block;
            background-color: var(--accent-color);
            color: var(--text-light) !important;
            padding: 10px 25px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: background-color 0.3s, transform 0.3s;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        .cta-button:hover {
            background-color: #e59119; /* Darker accent */
            transform: translateY(-2px);
        }

        /* Header (Sticky) */
        header {
            background-color: var(--primary-color);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.8rem;
            font-weight: 700;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            margin-left: 20px;
            border-radius: var(--border-radius);
            transition: background-color 0.3s;
        }
        
        nav ul li a:hover {
            background-color: var(--secondary-color);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(12, 60, 111, 0.8), rgba(12, 60, 111, 0.7)), url('https://via.placeholder.com/1500x500/0c3c6f/ffffff?text=University+Digital+Campus') no-repeat center center/cover;
            color: var(--text-light);
            text-align: center;
            padding: 100px 20px;
        }

        .hero h1 {
            font-size: 3.5rem;
            color: var(--text-light);
            margin-bottom: 10px;
        }

        .hero p {
            font-size: 1.4rem;
            margin-bottom: 30px;
            font-weight: 300;
        }

        /* --- Courses Section --- */
        #courses {
            background-color: var(--bg-medium);
        }
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .course-card {
            background-color: var(--text-light);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 25px;
            border-left: 5px solid var(--accent-color);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .course-card h4 {
            font-size: 1.3rem;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        .course-card p {
            font-size: 0.95rem;
            color: #555;
        }
        .course-card a {
            display: block;
            margin-top: 15px;
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 700;
        }

        /* --- Gallery Section --- */
        #gallery {
            background-color: var(--bg-light);
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
        }
        .gallery-item {
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }
        .gallery-item img:hover {
            transform: scale(1.05);
        }
        .gallery-footer {
            text-align: center;
            margin-top: 40px;
        }

        /* --- Contact Section --- */
        #contact {
            background-color: var(--secondary-color);
            color: var(--text-light);
        }
        #contact .section-heading {
            color: var(--text-light);
        }
        .contact-content {
            display: flex;
            gap: 40px;
        }
        .contact-info, .contact-form-container {
            flex: 1;
        }

        .contact-info h3 {
            color: var(--accent-color);
            margin-top: 0;
        }
        .contact-info p {
            margin-bottom: 20px;
            opacity: 0.9;
        }
        .contact-info ul {
            list-style: none;
        }
        .contact-info ul li {
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .contact-info ul li strong {
            color: var(--accent-color);
            margin-right: 10px;
        }

        .contact-form-container {
            background-color: var(--text-light);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        .contact-form-container h3 {
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--primary-color);
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--accent-color);
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        .form-submit-btn {
            width: 100%;
            border: none;
            cursor: pointer;
        }
        /* Inherit CTA button styles */
        .form-submit-btn.cta-button {
            padding: 12px;
        }

        /* Footer */
        footer {
            background-color: var(--primary-color);
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            padding: 20px 0;
            font-size: 0.9rem;
        }
        footer a {
            color: var(--accent-color);
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .contact-content {
                flex-direction: column;
            }
            .contact-info, .contact-form-container {
                flex: none;
                width: 100%;
            }
            .contact-info {
                padding: 0 20px;
            }
        }
        @media (max-width: 600px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            .section-heading {
                font-size: 2rem;
            }
            .header-content {
                flex-direction: column;
            }
            nav ul {
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 10px;
            }
            nav ul li a {
                margin: 5px 10px;
            }
        }

    </style>
</head>
<body>

    <header>
        <div class="container header-content">
            <div class="logo">
                <a href="#hero">🎓 BCM College</a>
            </div>
            <nav>
                <ul>
                    <li><a href="#hero">Home</a></li>
                    <li><a href="#courses">Courses</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="login.php" class="cta-button" style="margin-left: 20px;">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="hero" class="hero">
        <h1>Navigate Your Academic Journey with Confidence</h1>
        <p>The central hub for students, faculty, and administration—efficient, connected, and intelligent.</p>
        <a href="applicationform.php" class="cta-button" style="padding: 15px 40px; font-size: 1.2rem;">Apply Now &rarr;</a>
    </section>

    <section id="courses">
        <div class="container">
            <h2 class="section-heading">Explore Our Top Programs</h2>
            <div class="course-grid">
                <?php
                while($res=mysqli_fetch_array($data)){
                    ?>
                    
                    <div class="course-card">
                        <h4><?php echo $res['cname'];?></h4>
                        <p><?php echo $res['description'];?></p>
                        <a href="applicationform.php">Apply &rarr;</a>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>

    <section id="gallery">
        <div class="container">
            <h2 class="section-heading">Campus Life & Infrastructure</h2>
            <div class="gallery-grid">
                <div class="gallery-item"><img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Frame-1272637819-2.png" alt="Campus Library"></div>
                <div class="gallery-item"><img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Frame-1272637820-3.png" alt="Main Auditorium"></div>
                <div class="gallery-item"><img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Frame-1272637820-1-1.png" alt="Modern Lab Facility"></div>
                <div class="gallery-item"><img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Frame-1272637819-1-1.png" alt="Sports Field"></div>
            </div>
            
        </div>
    </section>

    <section id="contact">
        <div class="container">
            <h2 class="section-heading">Connect With Us</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Contact Information</h3>
                    <p>We're here to help you with admissions, technical support, or general inquiries. Reach out to the relevant department below.</p>
                    <ul>
                        <li><strong>Admissions:</strong> admissions@unifiedcms.edu</li>
                        <li><strong>Support:</strong> support@unifiedcms.edu</li>
                        <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                        <li><strong>Location:</strong> Main Administration Building, University Avenue, CC 12345</li>
                    </ul>
                </div>
                
                <div class="contact-form-container">
                    <h3>Send Us a Quick Message</h3>
                    <form action="process_contact.php" method="POST">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" required></textarea>
                        </div>
                        <button type="submit" class="form-submit-btn cta-button">Submit Inquiry</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            &copy; 2025 Unified CMS | Powered by PHP & Modern Web Standards | 
            <a href="privacy.html">Privacy</a> | 
            <a href="sitemap.html">Sitemap</a>
        </div>
    </footer>

</body>
</html>