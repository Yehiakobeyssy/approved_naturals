<?php
session_start();
include 'settings/connect.php';
include 'common/function.php';
include 'common/head.php';
?>

<link rel="shortcut icon" href="images/logo.png" type="image/x-icon">
<link href="common/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="common/fcss/all.min.css">
<link rel="stylesheet" href="common/fcss/fontawesome.min.css">
<link rel="stylesheet" href="common/root.css">
<link rel="stylesheet" href="index.css?v=1.1">
</head>
<body>

<?php include 'common/jslinks.php'?>
<header id="main-header">
    <div class="container d-flex justify-content-between align-items-center">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <img src="images/logo_name.png" alt="Approved Natural Logo" height="60">
        </a>

        <!-- Navigation Menu (اختياري) -->
        <nav class="main-nav">
            <ul class="d-flex list-unstyled mb-0">
                <li><a href="#hero">Home</a></li>
                <li><a href="#help">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
<!-- Hero Section -->
<?php
$stmt = $con->prepare("SELECT * FROM tblSection WHERE sectionID=1");
$stmt->execute();
$section = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section id="hero" style="background-image: url('images/<?php echo $section['hero_img']; ?>');">
    <div class="overlay">
        <h1><?php echo $section['hero_title']; ?></h1>
        <p><?php echo $section['hero_content']; ?></p>
    </div>
</section>

<!-- How Can We Help Section -->
<section id="help">
    <div class="container">
        <h2><?php echo $section['aboutus_title']; ?></h2>
        <p><?php echo $section['aboutus_text']; ?></p>
    </div>
</section>

<!-- Services Section -->
<section id="services">
    <div class="container">
        <h2>Our Services</h2>
        <div class="row">
        <?php
        $stmt = $con->prepare("SELECT * FROM tblServices");
        $stmt->execute();
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($services as $service):
        ?>
            <div class="col-md-6 service-card">
                <img src="images/<?php echo $service['service_img']; ?>" alt="<?php echo $service['service_title']; ?>">
                <h3><?php echo $service['service_title']; ?></h3>
                <p><?php echo $service['service_description']; ?></p>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="classes">
    <div class="container">
        <h2>Our Classes</h2>
        <div class="row">
            <?php
                $stmt = $con->prepare('SELECT * FROM tblClasses');
                $stmt->execute();
                $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($classes as $class){
                ?>
                    <div class="col-md-6 service-card">
                        <img src="images/<?php echo $class['classImg']; ?>" alt="<?php echo $class['classTitle']; ?>">
                        <h3><?php echo $class['classTitle']; ?></h3>
                        <p><?php echo $class['classTitle']; ?></p>
                    </div>
                <?php 
                }
            ?>
        </div>
    </div>
</section>
<!-- Contact Section -->
<?php
$stmt = $con->prepare("SELECT * FROM tblContact WHERE contactID=1");
$stmt->execute();
$contact = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section id="contact">
    <div class="container">
        <h2>Contact Us</h2>
        <div class="contact-wrapper">
            <form id="contactForm" method="post">
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="text" name="companyName" placeholder="Company Name">
                <input type="text" name="phoneNumber" placeholder="Phone Number">
                <input type="email" name="email" placeholder="Your Email" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit" class="btn">Send Message</button>
            </form>
            <div class="contact-info">
                <img src="images/logo.png" alt="Contact Image" style="width: 75px; height:75px">
                <p><strong>Email:</strong> <?php echo $contact['email']; ?></p>
                <p><strong>Address:</strong> <?php echo $contact['address']; ?></p>
                <p><strong>Days:</strong> <?php echo $contact['days_opening']; ?></p>
                <p><strong>Hours:</strong> <?php echo $contact['hours_opening']; ?></p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p>© Approved Natural 2025</p>
    </div>
</footer>


<script src="index.js"></script>
</body>
</html>
