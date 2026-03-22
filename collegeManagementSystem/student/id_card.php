<!DOCTYPE html>
<?php
    // PHP variables are correctly populated from your session and database query
    session_start();
    $sid=$_SESSION['sid'];
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $data=mysqli_query($conn,"Select * from applications where id='$sid'");
    $res=mysqli_fetch_array($data);

    // Dummy data for example purposes if PHP fails
    $student_name = isset($res['fname']) ? $res['fname'] . ' ' . $res['lname'] : 'RIYA SHARMA';
    $student_id = isset($res['id']) ? 'STU-2025-' . $res['id'] : 'STU-2025-7890';
    $program = isset($res['department']) ? $res['department'] : 'B.Tech. Computer Science';
    $address = isset($res['address']) ? $res['address'] : '123, Gandhi Marg, Block C, New Delhi, India - 110027';
    $dob = isset($res['dob']) ? $res['dob'] : '15-JAN-2003';
    $photo_path = isset($res['photo']) ? '../' . $res['photo'] : 'https://via.placeholder.com/150/5b3cc4/ffffff?text=RS';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student ID Card</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <style>
        /* --- Variables --- */
        :root {
            --primary-color: #5b3cc4;
            --accent-color: #00bcd4;
            --bg-light: #f4f6f9;
            --text-dark: #343a40;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            --card-width: 350px;
            --card-height: 222px;
            --border-color: #e3e7ed;
        }

        /* --- Base & Layout --- */
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* --- ID Card Container (For Digital View) --- */
        .id-card-container-wrapper {
            margin-bottom: 30px;
            /* This div contains the flip effect on screen */
        }
        
        .id-card-flip-wrapper {
            width: var(--card-width);
            height: var(--card-height);
            perspective: 1000px;
            box-shadow: var(--card-shadow);
            border-radius: 12px;
        }

        .id-card-flip {
            position: relative;
            width: 100%;
            height: 100%;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            cursor: pointer;
        }
        
        .id-card-flip:hover {
            transform: rotateY(180deg);
        }

        /* Styles common to both sides */
        .card-side {
            width: var(--card-width);
            height: var(--card-height);
            border-radius: 12px;
            background: white;
            box-sizing: border-box;
            color: var(--text-dark);
            overflow: hidden;
            display: block;
        }
        
        .id-card-front, .id-card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            overflow: hidden;
        }

        .id-card-back {
            transform: rotateY(180deg);
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* --- PRINT/DOWNLOAD CONTAINER (Hidden on screen) --- */
        /* This container is used by html2canvas to capture the stacked view */
        .id-card-print-container {
            /* Hide by default, only shown briefly for PDF generation */
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            pointer-events: none;
            z-index: -10;
            padding: 20px;
        }
        
        .print-side {
            width: var(--card-width);
            height: var(--card-height);
            margin-bottom: 20px; /* Separates the two cards in the PDF */
            border-radius: 12px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            background: white;
            overflow: hidden;
        }
        
        /* --- ALL INNER STYLES (FRONT/BACK) REMAIN UNCHANGED --- */
        
        .front-header-strip {
            background-color: var(--primary-color); color: white; padding: 5px 15px; display: flex; justify-content: space-between; align-items: center; font-size: 0.75rem; font-weight: 600;
        }
        .college-branding {
            display: flex; align-items: center; gap: 10px; padding: 10px 15px 5px; border-bottom: 2px solid var(--accent-color); margin-bottom: 5px;
        }
        .college-logo-img { height: 40px; width: auto; flex-shrink: 0; }
        .university-title-text { font-size: 1.1rem; font-weight: 800; color: var(--text-dark); margin: 0; line-height: 1.2; }
        .student-info-section { display: flex; gap: 15px; padding: 5px 15px 15px; }
        .photo-container { flex-shrink: 0; width: 85px; height: 105px; border: 3px solid var(--accent-color); overflow: hidden; background-color: var(--bg-light); box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .info-details { font-size: 0.8rem; line-height: 1.4; flex-grow: 1; }
        .info-details strong { display: block; font-size: 0.95rem; font-weight: 800; color: var(--primary-color); margin-bottom: 3px; line-height: 1.1; }
        .info-details .label { color: #6c757d; font-weight: 600; margin-top: 5px; display: block; text-transform: uppercase; font-size: 0.65rem; }
        .front-signature { margin-top: 10px; display: flex; justify-content: space-between; align-items: center; font-size: 0.65rem; padding-top: 5px; }
        .front-signature .signature-text { font-style: italic; color: var(--primary-color); font-weight: 700; border-top: 1px dashed var(--border-color); padding-top: 2px; }
        
        .back-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 15px 15px 10px; border-bottom: 1px dashed var(--border-color); }
        .back-address h5 { font-size: 0.75rem; color: var(--accent-color); margin: 0 0 5px 0; font-weight: 700; }
        .back-address p { margin: 0; line-height: 1.3; font-size: 0.7rem; color: var(--text-dark); }
        .back-instructions { padding: 0 15px; }
        .back-instructions h5 { font-size: 0.75rem; color: var(--primary-color); margin: 0 0 5px 0; font-weight: 700; }
        .back-instructions p { font-size: 0.65rem; color: #6c757d; margin: 0; line-height: 1.3; }
        .barcode-area { text-align: center; margin-top: 10px; padding: 10px 15px; border-top: 1px dashed var(--border-color); }
        .barcode-area span { display: block; margin-top: 5px; font-size: 0.6rem; font-weight: 600; color: var(--text-dark); }

        /* --- Download Button --- */
        .download-btn {
            background-color: var(--accent-color); color: white; padding: 12px 25px; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; transition: background-color 0.3s, transform 0.2s; font-size: 1rem;
        }

        .download-btn:hover {
            background-color: #008fa7; transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="id-card-container-wrapper" id="digital-card-view">
        <div class="id-card-flip-wrapper">
            <div class="id-card-flip">
                
                <div class="id-card-front card-side" id="card-front-content">
                    <div class="front-header-strip">
                        <span><i class="fas fa-id-card"></i> Student ID</span>
                        <span>Issued: 2025</span>
                    </div>
                    
                    <div class="college-branding">
                        <img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Emblem_B.C.M-College-Kottayam-150x150-1.png" alt="BCM College" class="college-logo-img">
                        <div class="university-title-text">BCM College, Kottayam</div>
                    </div>
                    
                    <div class="student-info-section">
                        <div class="photo-container">
                            <img src="<?php echo $photo_path; ?>" alt="<?php echo $student_name; ?>">
                        </div>
                        
                        <div class="info-details">
                            <span class="label">Name</span>
                            <strong><?php echo $student_name; ?></strong>

                            <span class="label">Student ID</span>
                            <strong><?php echo $student_id; ?></strong>
                            
                            <span class="label">Program</span>
                            <strong><?php echo $program; ?></strong>

                        
                        </div>
                    </div>
                </div>
                
                <div class="id-card-back card-side" id="card-back-content">
                    <div class="back-grid">
                        <div class="back-address">
                            <h5><i class="fas fa-building"></i> College Address</h5>
                            <p>
                                HGQG+RXX, Kottayam - Kumily Rd, Kottayam, Kerala 686001
                            </p>
                        </div>
                        
                        <div class="back-address">
                            <h5><i class="fas fa-home"></i> Student Permanent Address</h5>
                            <p>
                                <?php echo $address; ?>
                            </p>
                        </div>
                    </div>

                    <div class="back-instructions">
                        <h5>Important Notice</h5>
                        <p>This ID is property of BCM. It must be carried at all times on campus. Misuse or failure to present upon request may result in disciplinary action. Report loss immediately to security.</p>
                    </div>
                    
                    <div class="barcode-area">
                        <span><?php echo $student_id; ?> | DOB: <?php echo $dob; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="id-card-print-container" id="pdf-container">
        <div class="print-side" id="pdf-front">
            <div class="front-header-strip">
                <span><i class="fas fa-id-card"></i> Student ID</span>
                <span>Issued: 2025</span>
            </div>
            
            <div class="college-branding">
                <img src="https://bcmcollege.ac.in/wp-content/uploads/2025/05/Emblem_B.C.M-College-Kottayam-150x150-1.png" alt="BCM College" class="college-logo-img">
                <div class="university-title-text">BCM College, Kottayam</div>
            </div>
            
            <div class="student-info-section">
                <div class="photo-container">
                    <img src="<?php echo $photo_path; ?>" alt="<?php echo $student_name; ?>">
                </div>
                
                <div class="info-details">
                    <span class="label">Name</span>
                    <strong><?php echo $student_name; ?></strong>

                    <span class="label">Student ID</span>
                    <strong><?php echo $student_id; ?></strong>
                    
                    <span class="label">Program</span>
                    <strong><?php echo $program; ?></strong>

                    
                </div>
            </div>
        </div>

        <div class="print-side" id="pdf-back">
            <div class="back-grid">
                <div class="back-address">
                    <h5><i class="fas fa-building"></i> College Address</h5>
                    <p>
                        HGQG+RXX, Kottayam - Kumily Rd, Kottayam, Kerala 686001
                    </p>
                </div>
                
                <div class="back-address">
                    <h5><i class="fas fa-home"></i> Student Permanent Address</h5>
                    <p>
                        <?php echo $address; ?>
                    </p>
                </div>
            </div>

            <div class="back-instructions">
                <h5>Important Notice</h5>
                <p>This ID is property of BCM. It must be carried at all times on campus. Misuse or failure to present upon request may result in disciplinary action. Report loss immediately to security.</p>
            </div>
            
            <div class="barcode-area">
                <span><?php echo $student_id; ?> | DOB: <?php echo $dob; ?></span>
            </div>
        </div>
    </div>
    
    <button class="download-btn" onclick="downloadIDCard()">
        <i class="fas fa-file-pdf"></i> Download ID Card (PDF)
    </button>

    <script>
        // Ensure jsPDF is available via the window object
        const { jsPDF } = window.jspdf;

        async function downloadIDCard() {
            // Get the two sections to be converted
            const frontElement = document.getElementById('pdf-front');
            const backElement = document.getElementById('pdf-back');
            
            // Show the container briefly for accurate rendering (it's off-screen)
            const pdfContainer = document.getElementById('pdf-container');
            pdfContainer.style.opacity = '1';
            pdfContainer.style.zIndex = '9999';

            // 1. Convert Front Side to Canvas/Image
            const frontCanvas = await html2canvas(frontElement, { 
                scale: 3, // Increase scale for higher resolution
                useCORS: true 
            });
            const frontImgData = frontCanvas.toDataURL('image/png');

            // 2. Convert Back Side to Canvas/Image
            const backCanvas = await html2canvas(backElement, { 
                scale: 3, 
                useCORS: true 
            });
            const backImgData = backCanvas.toDataURL('image/png');

            // Hide the container again immediately
            pdfContainer.style.opacity = '0';
            pdfContainer.style.zIndex = '-10';

            // Define target card dimensions in mm (standard credit card size)
            const CARD_WIDTH_MM = 85.6; // 3.375 inches
            const CARD_HEIGHT_MM = 53.98; // 2.125 inches
            const MARGIN_MM = 10;
            
            // Create PDF instance (A4 size default)
            const pdf = new jsPDF('p', 'mm', 'a4');

            let yOffset = MARGIN_MM;

            // 3. Add Front Side to PDF
            pdf.addImage(frontImgData, 'PNG', MARGIN_MM, yOffset, CARD_WIDTH_MM, CARD_HEIGHT_MM);
            
            // Update yOffset for the back side
            yOffset += CARD_HEIGHT_MM + MARGIN_MM; 
            
            // 4. Add Back Side to PDF
            pdf.addImage(backImgData, 'PNG', MARGIN_MM, yOffset, CARD_WIDTH_MM, CARD_HEIGHT_MM);

            // 5. Save the PDF
            pdf.save(`ID-Card-<?php echo $student_id; ?>.pdf`);
        }
    </script>
</body>
</html>