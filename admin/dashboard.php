<?php
session_start();
include '../settings/connect.php';
include '../common/function.php';
include '../common/head.php';

// حماية الصفحة – فقط للإدمن
if(!isset($_SESSION['admin_id'])){
    header('Location: index.php');
    exit;
}

// ======= Section Hero + About =======
if(isset($_POST['update_section'])){
    $hero_title = htmlspecialchars($_POST['hero_title']);
    $hero_content = htmlspecialchars($_POST['hero_content']);
    $aboutus_title = htmlspecialchars($_POST['aboutus_title']);
    $aboutus_text = htmlspecialchars($_POST['aboutus_text']);

    if(isset($_FILES['hero_img']) && $_FILES['hero_img']['name'] != ""){
        $ext = pathinfo($_FILES['hero_img']['name'], PATHINFO_EXTENSION);
        $newName = time().rand(1000,9999).".".$ext;
        move_uploaded_file($_FILES['hero_img']['tmp_name'], "../images/".$newName);
        $stmt = $con->prepare("UPDATE tblSection SET hero_img=?, hero_title=?, hero_content=?, aboutus_title=?, aboutus_text=? WHERE sectionID=1");
        $stmt->execute([$newName,$hero_title,$hero_content,$aboutus_title,$aboutus_text]);
    } else {
        $stmt = $con->prepare("UPDATE tblSection SET hero_title=?, hero_content=?, aboutus_title=?, aboutus_text=? WHERE sectionID=1");
        $stmt->execute([$hero_title,$hero_content,$aboutus_title,$aboutus_text]);
    }
    $success = "Section updated successfully!";
}

// ======= Services CRUD =======
if(isset($_POST['add_service'])){
    $service_title = htmlspecialchars($_POST['service_title']);
    $service_description = htmlspecialchars($_POST['service_description']);
    $ext = pathinfo($_FILES['service_img']['name'], PATHINFO_EXTENSION);
    $newName = time().rand(1000,9999).".".$ext;
    move_uploaded_file($_FILES['service_img']['tmp_name'], "../images/".$newName);

    $stmt = $con->prepare("INSERT INTO tblServices (service_img, service_title, service_description) VALUES (?,?,?)");
    $stmt->execute([$newName, $service_title, $service_description]);
    $success = "Service added successfully!";
}

if(isset($_POST['update_service'])){
    $serviceID = $_POST['serviceID'];
    $service_title = htmlspecialchars($_POST['service_title']);
    $service_description = htmlspecialchars($_POST['service_description']);
    
    if(isset($_FILES['service_img']) && $_FILES['service_img']['name']!=""){
        $ext = pathinfo($_FILES['service_img']['name'], PATHINFO_EXTENSION);
        $newName = time().rand(1000,9999).".".$ext;
        move_uploaded_file($_FILES['service_img']['tmp_name'], "../images/".$newName);
        $stmt = $con->prepare("UPDATE tblServices SET service_img=?, service_title=?, service_description=? WHERE serviceID =?");
        $stmt->execute([$newName, $service_title, $service_description, $serviceID]);
    } else {
        $stmt = $con->prepare("UPDATE tblServices SET service_title=?, service_description=? WHERE serviceID =?");
        $stmt->execute([$service_title, $service_description, $serviceID]);
    }
    $success = "Service updated successfully!";
}

if(isset($_GET['delete_service'])){
    $id = intval($_GET['delete_service']);
    $stmt = $con->prepare("DELETE FROM tblServices WHERE serviceID=?");
    $stmt->execute([$id]);
    $success = "Service deleted successfully!";
}

// ======= Classes CRUD =======
if(isset($_POST['add_class'])){
    $classTitle = htmlspecialchars($_POST['classTitle']);
    $classDiscription = htmlspecialchars($_POST['classDiscription']);
    
    if(isset($_FILES['classImg']) && $_FILES['classImg']['name'] != ""){
        $ext = pathinfo($_FILES['classImg']['name'], PATHINFO_EXTENSION);
        $newName = time().rand(1000,9999).".".$ext;
        move_uploaded_file($_FILES['classImg']['tmp_name'], "../images/".$newName);

        $stmt = $con->prepare("INSERT INTO tblClasses (classImg, classTitle, classDiscription) VALUES (?,?,?)");
        $stmt->execute([$newName, $classTitle, $classDiscription]);
        $success = "Class added successfully!";
    }
}

if(isset($_POST['update_class'])){
    $classID = $_POST['classID'];
    $classTitle = htmlspecialchars($_POST['classTitle']);
    $classDiscription = htmlspecialchars($_POST['classDiscription']);

    if(isset($_FILES['classImg']) && $_FILES['classImg']['name'] != ""){
        $ext = pathinfo($_FILES['classImg']['name'], PATHINFO_EXTENSION);
        $newName = time().rand(1000,9999).".".$ext;
        move_uploaded_file($_FILES['classImg']['tmp_name'], "../images/".$newName);

        $stmt = $con->prepare("UPDATE tblClasses SET classImg=?, classTitle=?, classDiscription=? WHERE classID=?");
        $stmt->execute([$newName, $classTitle, $classDiscription, $classID]);
    } else {
        $stmt = $con->prepare("UPDATE tblClasses SET classTitle=?, classDiscription=? WHERE classID=?");
        $stmt->execute([$classTitle, $classDiscription, $classID]);
    }
    $success = "Class updated successfully!";
}

if(isset($_GET['delete_class'])){
    $id = intval($_GET['delete_class']);
    $stmt = $con->prepare("DELETE FROM tblClasses WHERE classID=?");
    $stmt->execute([$id]);
    $success = "Class deleted successfully!";
}

// ======= Contact Update =======
if(isset($_POST['update_contact'])){
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);
    $days = htmlspecialchars($_POST['days_opening']);
    $hours = htmlspecialchars($_POST['hours_opening']);

    $stmt = $con->prepare("UPDATE tblContact SET email=?, phone_number=?, address=?, days_opening=?, hours_opening=? WHERE contactID=1");
    $stmt->execute([$email,$phone,$address,$days,$hours]);
    $success = "Contact updated successfully!";
}

// ======= Fetch Data =======
$section = $con->query("SELECT * FROM tblSection WHERE sectionID=1")->fetch(PDO::FETCH_ASSOC);
$services = $con->query("SELECT * FROM tblServices")->fetchAll(PDO::FETCH_ASSOC);
$classes = $con->query("SELECT * FROM tblClasses")->fetchAll(PDO::FETCH_ASSOC);
$contact = $con->query("SELECT * FROM tblContact WHERE contactID=1")->fetch(PDO::FETCH_ASSOC);
?>

<style>
body { background: #f0f2f5; font-family: Arial; padding-top: 70px; }
.container { max-width: 1200px; margin:auto; }
.section-box { background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 30px; }
.section-box h3 { color: #4CAF50; margin-bottom: 20px; font-size: 22px; }
input, textarea { width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #ccc; font-size:16px; }
button { background: #4CAF50; color: #fff; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-size:16px; }
button:hover { background: #388E3C; }
.service-box { border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:8px; background:#f9f9f9; position:relative; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; }
.service-box img { width:120px; height:120px; object-fit:cover; border-radius:6px; margin-right:15px; }
.service-flex { display:flex; align-items:center; gap:15px; width:100%; flex-wrap:wrap; }
.add-btn { margin-bottom:20px; }
.success { color: green; margin-bottom: 15px; }
.delete-service { background:#e74c3c; margin-top:10px; }
.delete-service:hover { background:#c0392b; }
@media(max-width:768px){
    .service-flex { flex-direction: column; align-items:flex-start; }
    input,textarea { font-size:18px; padding:18px; }
    .service-box img { width:100%; height:auto; margin-bottom:10px; }
}
</style>

<div class="container">

<?php if(isset($success)) echo '<div class="success">'.$success.'</div>'; ?>

<!-- Section Hero + About -->
<div class="section-box">
<h3>Section: Hero & About Us</h3>
<form method="post" enctype="multipart/form-data">
<label>Hero Image</label>
<input type="file" name="hero_img">
<?php if($section['hero_img']) echo "<img src='../images/".$section['hero_img']."' width='150'>"; ?>
<label>Hero Title</label>
<input type="text" name="hero_title" value="<?php echo $section['hero_title']; ?>">
<label>Hero Content</label>
<textarea name="hero_content"><?php echo $section['hero_content']; ?></textarea>
<label>About Us Title</label>
<input type="text" name="aboutus_title" value="<?php echo $section['aboutus_title']; ?>">
<label>About Us Text</label>
<textarea name="aboutus_text"><?php echo $section['aboutus_text']; ?></textarea>
<button type="submit" name="update_section">Update Section</button>
</form>
</div>

<!-- Services -->
<div class="section-box">
<h3>Services</h3>
<button type="button" class="add-btn btn btn-sm btn-success" data-target="services-list">Add New Service</button>
<div id="services-list">
<?php foreach($services as $s): ?>
<div class="service-box">
<form method="post" enctype="multipart/form-data">
<div class="service-flex">
<img src="../images/<?php echo $s['service_img']; ?>" alt="">
<div style="flex:1">
<input type="hidden" name="serviceID" value="<?php echo $s['serviceID']; ?>">
<label>Service Title</label>
<input type="text" name="service_title" value="<?php echo $s['service_title']; ?>">
<label>Service Description</label>
<textarea name="service_description"><?php echo $s['service_description']; ?></textarea>
<label>Service Image</label>
<input type="file" name="service_img">
<button type="submit" name="update_service">Update Service</button>
<a href="?delete_service=<?php echo $s['serviceID']; ?>" class="btn delete-service">Delete Service</a>
</div>
</div>
</form>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- Classes -->
<div class="section-box">
<h3>Classes</h3>
<button type="button" class="add-btn btn btn-sm btn-success" data-target="classes-list">Add New Class</button>
<div id="classes-list">
<?php foreach($classes as $c): ?>
<div class="service-box">
<form method="post" enctype="multipart/form-data">
<div class="service-flex">
<img src="../images/<?php echo $c['classImg']; ?>" alt="">
<div style="flex:1">
<input type="hidden" name="classID" value="<?php echo $c['classID']; ?>">
<label>Class Title</label>
<input type="text" name="classTitle" value="<?php echo $c['classTitle']; ?>" required>
<label>Class Description</label>
<textarea name="classDiscription" required><?php echo $c['classDiscription']; ?></textarea>
<label>Class Image</label>
<input type="file" name="classImg">
<button type="submit" name="update_class">Update Class</button>
<a href="?delete_class=<?php echo $c['classID']; ?>" class="btn delete-service">Delete Class</a>
</div>
</div>
</form>
</div>
<?php endforeach; ?>
</div>
</div>

<!-- Contact -->
<div class="section-box">
<h3>Contact Info</h3>
<form method="post">
<label>Email</label>
<input type="email" name="email" value="<?php echo $contact['email']; ?>">
<label>Phone Number</label>
<input type="text" name="phone_number" value="<?php echo $contact['phone_number']; ?>">
<label>Address</label>
<textarea name="address"><?php echo $contact['address']; ?></textarea>
<label>Days of Opening</label>
<input type="text" name="days_opening" value="<?php echo $contact['days_opening']; ?>">
<label>Hours of Opening</label>
<input type="text" name="hours_opening" value="<?php echo $contact['hours_opening']; ?>">
<button type="submit" name="update_contact">Update Contact</button>
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('.add-btn').click(function(){
        var target = $(this).data('target');
        var container = $('#' + target);
        if(target == 'services-list'){
            var newBox = `<div class="service-box">
                <form method="post" enctype="multipart/form-data">
                    <div class="service-flex">
                        <div style="flex:1">
                            <label>Service Title</label>
                            <input type="text" name="service_title" placeholder="Service Title" required>
                            <label>Service Description</label>
                            <textarea name="service_description" placeholder="Service Description" required></textarea>
                            <label>Service Image</label>
                            <input type="file" name="service_img" required>
                            <button type="submit" name="add_service">Add Service</button>
                        </div>
                    </div>
                </form>
            </div>`;
            container.append(newBox);
        }
        if(target == 'classes-list'){
            var newBox = `<div class="service-box">
                <form method="post" enctype="multipart/form-data">
                    <div class="service-flex">
                        <div style="flex:1">
                            <label>Class Title</label>
                            <input type="text" name="classTitle" placeholder="Class Title" required>
                            <label>Class Description</label>
                            <textarea name="classDiscription" placeholder="Class Description" required></textarea>
                            <label>Class Image</label>
                            <input type="file" name="classImg" required>
                            <button type="submit" name="add_class">Add Class</button>
                        </div>
                    </div>
                </form>
            </div>`;
            container.append(newBox);
        }
    });
});
</script>
