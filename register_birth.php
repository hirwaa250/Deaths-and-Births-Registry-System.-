<?php
require_once 'includes/auth.php';
require_login();

$page_title = 'Register Birth - Village Register System';
$success = '';
$error = '';

if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $child_name = trim($_POST['child_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $place_of_birth = trim($_POST['place_of_birth']);
    $village = trim($_POST['village']);
    $sector = trim($_POST['sector']);
    $gender = $_POST['gender'];
    $mother_name = trim($_POST['mother_name']);
    $father_name = trim($_POST['father_name']);
    

    if (empty($child_name) || empty($date_of_birth) || empty($place_of_birth) || empty($village) || empty($sector) || empty($gender) || empty($mother_name) || 
        empty($father_name)) {
        $error = 'All fields are required.';
    } else {
        
        if (strtotime($date_of_birth) > time()) {
            $error = 'Date of birth cannot be in the future.';
        } else {
            
            $query = "INSERT INTO births (child_name, date_of_birth, place_of_birth, village, sector, gender, mother_name, father_name, registered_by) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $result = execute_query($query, 'ssssssssi', [
                $child_name, $date_of_birth, $place_of_birth, $village, $sector, $gender, $mother_name, $father_name, $_SESSION['user_id']
            ]);
            
            if ($result) {
                $birth_id = $result; 
                header("Location: register_birth.php?success=Birth registered successfully! Birth ID: $birth_id");
                exit();
            } else {
                $error = 'Failed to register birth. Please try again.';
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4><i class="fas fa-baby"></i> Register New Birth</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="child_name" class="form-label">
                                    <i class="fas fa-baby"></i> Child's Full Name *
                                </label>
                                <input type="text" class="form-control" id="child_name" name="child_name" 
                                       value="<?php echo isset($_POST['child_name']) ? htmlspecialchars($_POST['child_name']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the child's full name.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">
                                    <i class="fas fa-calendar"></i> Date of Birth *
                                </label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" 
                                       value="<?php echo isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : ''; ?>"
                                       max="<?php echo date('Y-m-d'); ?>" required>
                                <div class="invalid-feedback">
                                    Please provide a valid date of birth.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="place_of_birth" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Place of Birth *
                                </label>
                                <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" 
                                       value="<?php echo isset($_POST['place_of_birth']) ? htmlspecialchars($_POST['place_of_birth']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the place of birth.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="village" class="form-label">
                                    <i class="fas fa-home"></i> Village *
                                </label>
                                <input type="text" class="form-control" id="village" name="village" 
                                       value="<?php echo isset($_POST['village']) ? htmlspecialchars($_POST['village']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the village.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="sector" class="form-label">
                                    <i class="fas fa-map"></i> Sector *
                                </label>
                                <input type="text" class="form-control" id="sector" name="sector" 
                                       value="<?php echo isset($_POST['sector']) ? htmlspecialchars($_POST['sector']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the sector.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gender" class="form-label">
                                    <i class="fas fa-venus-mars"></i> Gender *
                                </label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a gender.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mother_name" class="form-label">
                                    <i class="fas fa-female"></i> Mother's Full Name *
                                </label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name" 
                                       value="<?php echo isset($_POST['mother_name']) ? htmlspecialchars($_POST['mother_name']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the mother's full name.
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="father_name" class="form-label">
                                    <i class="fas fa-male"></i> Father's Full Name *
                                </label>
                                <input type="text" class="form-control" id="father_name" name="father_name" 
                                       value="<?php echo isset($_POST['father_name']) ? htmlspecialchars($_POST['father_name']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the father's full name.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-user"></i> Registered By
                                </label>
                                <input type="text" class="form-control" 
                                       value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Unknown User'; ?> (<?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'Unknown'; ?>)" 
                                       readonly>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="view_births.php" class="btn btn-secondary me-md-2">
                            <i class="fas fa-list"></i> View Births
                        </a>
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Register Birth
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>

<?php include 'includes/footer.php'; ?>
