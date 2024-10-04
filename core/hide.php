<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jordan Blake WebDev</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #007bff;
            color: white;
            padding: 1.5rem 0;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 20px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #ffd700; /* Gold color on hover */
        }

        main {
            padding: 20px;
        }

        section {
            margin-bottom: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        section:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        footer {
            text-align: center;
            padding: 1rem 0;
            background: #333;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #1a0dab; /* Gold color for footer links */
            text-decoration: underline;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white; /* Change color on hover */
        }

        /* Responsive styling */
        @media (max-width: 600px) {
            nav ul li {
                display: block;
                margin: 10px 0;
            }

            section {
                padding: 15px;
            }
        }

        .profile-container {
            text-align: center;
            margin: 20px 0;
        }

        .profile-image {
            width: 150px; /* Set width for the image */
            height: 150px; /* Set height for the image */
            border-radius: 50%; /* Make it circular */
            border: 3px solid #007bff; /* Blue border similar to LinkedIn */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow */
            object-fit: cover; /* Cover to maintain aspect ratio */
        }

        .profile-container h3 {
            margin: 10px 0 5px;
            font-size: 1.5em;
            color: #333;
        }

        .profile-container p {
            margin: 0;
            color: #666;
        }


    </style>

<script src="static/js/hide-page.js"></script>
</head>
<body>
    <header>
        <h1>Jordan Blake</h1>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" id="closePopup">&times;</span>
            <h2>Welcome to My Website!</h2>
            <p>Thank you for visiting. Feel free to explore!</p>
            <p><strong>Click on my name in the footer to be redirected back!</strong></p>
            <button id="closeButton">Close</button>
        </div>
    </div>

        <section id="home">
            <div class="profile-container">
                <img src="../storage/jordanblake.png" alt="Profile Picture" class="profile-image">
                <h3>Jordan Blake</h3>
                <p>Web Developer</p>
                <p>I am a leading web development professional dedicated to bringing your digital vision to life. With a focus on innovative design and user-friendly functionality, I specialize in creating custom websites tailored to meet the unique needs of businesses across various industries.</p>
            </div>
        </section>

        

        <section id="about">
            <h2>About Me</h2>
            <p>I am a seasoned web development professional with over a decade of experience in crafting innovative digital solutions. With a strong foundation in both design and coding, I combine technical expertise with a keen eye for aesthetics to deliver websites that are not only functional but also visually compelling.</p>
            <p>After earning a degree in Computer Science, I began my career as a front-end developer, quickly rising through the ranks due to my passion for creating seamless user experiences. Today, I lead a dynamic team dedicated to helping businesses establish a robust online presence.</p>
            <p>I believe that every business has a unique story to tell, and it’s my mission to translate that story into engaging digital experiences. By staying up-to-date with the latest industry trends and technologies, I ensure that each project leverages cutting-edge solutions tailored to client needs.</p>
            <p>In addition to my technical skills, I value strong communication and collaboration. I work closely with clients throughout the development process, ensuring that goals are met and visions are realized.</p>
            <p>Outside of work, I am an avid traveler and enjoy exploring different cultures, which inspires my creativity and approach to design. Whether you’re a startup looking to make your mark or an established company aiming to revamp your online presence, I am committed to delivering results that drive success.</p>
        </section>

        <section id="services">
            <h2>Services:</h2>
            <ul>
                <li><strong>Custom Website Development:</strong> Tailored solutions that align with your brand and goals.</li>
                <li><strong>E-commerce Solutions:</strong> Seamless online shopping experiences to boost your sales.</li>
                <li><strong>Responsive Design:</strong> Mobile-friendly websites that look great on any device.</li>
                <li><strong>SEO Optimization:</strong> Strategies to enhance your online visibility and drive traffic.</li>
                <li><strong>Ongoing Support & Maintenance:</strong> Reliable support to keep your website running smoothly.</li>
            </ul>
        </section>

        <section id="contact">
            <h2>Contact</h2>
            <p><strong>Name:</strong> Jordan Blake</p>
            <p><strong>Phone:</strong> (555) 678-9012</p>
            <p><strong>Email:</strong> <a href="#contact">jordan.blake@email.com</a></p>
            <p><strong>Website:</strong> <a href="#contact" target="_blank">www.jordanblakedev.com</a></p>
            <p><strong>Address:</strong> 101 Hill Street, San Francisco, CA 90220</p>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 <a href="index.php" onclick="unhide();">Jordan Blake</a> All rights reserved.</p>
    </footer>
</body>



<style>
    .popup {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1000; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
    }

    .popup-content {
        background-color: white;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
        max-width: 500px; /* Maximum width */
        border-radius: 8px; /* Rounded corners */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #closeButton {
        background-color: #007bff; /* Blue background */
        color: white; /* White text */
        border: none; /* No border */
        padding: 10px 20px; /* Padding */
        border-radius: 5px; /* Rounded corners */
        cursor: pointer; /* Pointer cursor */
        margin-top: 15px; /* Spacing from the content */
    }

    #closeButton:hover {
        background-color: #0056b3; /* Darker blue on hover */
    }
</style>

<script>
    // Get the modal
    var popup = document.getElementById("popup");

    // Show the popup after the page loads
    window.onload = function() {
        popup.style.display = "block";

        // Set timeout to close the popup after 5 seconds
        setTimeout(function() {
            popup.style.display = "none";
        }, 2500); // 5000 milliseconds = 5 seconds
    };

    // Get the <span> element that closes the popup
    var closePopup = document.getElementById("closePopup");
    
    // Get the "Close" button
    var closeButton = document.getElementById("closeButton");

    // When the user clicks on <span> (x) or the "Close" button, close the popup
    closePopup.onclick = function() {
        popup.style.display = "none";
    };

    closeButton.onclick = function() {
        popup.style.display = "none";
    };

    // Close the popup when clicking outside of the popup content
    window.onclick = function(event) {
        if (event.target == popup) {
            popup.style.display = "none";
        }
    };

    function unhide() {
        const lastVisited = localStorage.getItem('lastVisited');
        if (lastVisited) {
            window.location.href = lastVisited;
        } else {
            window.location.href = "./index.php"; 
        }

    }
</script>


</html>
