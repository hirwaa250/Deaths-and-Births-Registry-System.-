<?php
require_once 'includes/auth.php';
require_login();

$page_title = 'Register Death - Village Register System';
$success = '';
$error = '';

if (isset($_GET['success'])) {
    $success = htmlspecialchars($_GET['success']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $deceased_name = isset($_POST['deceased_name']) ? trim($_POST['deceased_name']) : '';
    $date_of_death = isset($_POST['date_of_death']) ? $_POST['date_of_death'] : '';
    $place_of_death = isset($_POST['place_of_death']) ? trim($_POST['place_of_death']) : '';
    $family_contact = isset($_POST['family_contact']) ? trim($_POST['family_contact']) : '';
    $village = isset($_POST['village']) ? trim($_POST['village']) : '';
    $sector = isset($_POST['sector']) ? trim($_POST['sector']) : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $cause_of_death = isset($_POST['cause_of_death']) ? trim($_POST['cause_of_death']) : '';
    
    
    if (empty($deceased_name) || empty($date_of_death) || empty($place_of_death) || empty($family_contact) || empty($village) || empty($sector) || empty($gender) || empty($cause_of_death)) {
        $error = 'All fields are required.';
    } else {
        if (strtotime($date_of_death) > time()) {
            $error = 'Date of death cannot be in the future.';
        } else {
            
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            if (!$user_id) {
                die('Error: No user is logged in.');
            }
            
            $check_user_query = "SELECT id, username, full_name, role FROM users WHERE id = ?";
            $check_user_result = execute_query($check_user_query, 'i', [$user_id]);
            if (!$check_user_result || $check_user_result->num_rows == 0) {
                die('Error: Logged in user does not exist in users table.');
            }
            $query = "INSERT INTO deaths (deceased_name, date_of_death, place_of_death, family_contact, village, sector, gender, cause_of_death, registered_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $result = execute_query($query, 'ssssssssi', [
                $deceased_name, $date_of_death, $place_of_death, $family_contact, $village, $sector, $gender, $cause_of_death, $_SESSION['user_id']
            ]);
            if ($result) {
                $death_id = $result;
                header("Location: register_death.php?success=Death registered successfully! Death ID: $death_id");
                exit();
            } else {
                $error = 'Failed to register death. Please try again.';
            }
        }
    }
}

include 'includes/header.php';
?>

<div class="row mt-4">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4><i class="fas fa-cross"></i> Register New Death</h4>
            </div>
        <div class="card-body" style="padding-left: 2rem; padding-right: 2rem;">
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="deceased_name" class="form-label">
                                    <i class="fas fa-user"></i> Deceased Person's Full Name *
                                </label>
                                <input type="text" class="form-control" id="deceased_name" name="deceased_name" 
                                       value="<?php echo isset($_POST['deceased_name']) ? htmlspecialchars($_POST['deceased_name']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the deceased person's full name.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="date_of_death" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Date of Death *
                                </label>
                                <input type="date" class="form-control" id="date_of_death" name="date_of_death" 
                                       value="<?php echo isset($_POST['date_of_death']) ? htmlspecialchars($_POST['date_of_death']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the date of death.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="place_of_death" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Place of Death *
                                </label>
                                <input type="text" class="form-control" id="place_of_death" name="place_of_death" 
                                       value="<?php echo isset($_POST['place_of_death']) ? htmlspecialchars($_POST['place_of_death']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide the place of death.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="gender" class="form-label">
                                    <i class="fas fa-venus-mars"></i> Gender *
                                </label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                    <option value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                    <option value="Other" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select the gender.
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="family_contact" class="form-label">
                                    <i class="fas fa-phone"></i> Family Contact *
                                </label>
                                <input type="text" class="form-control" id="family_contact" name="family_contact" 
                                       value="<?php echo isset($_POST['family_contact']) ? htmlspecialchars($_POST['family_contact']) : ''; ?>"
                                       required>
                                <div class="invalid-feedback">
                                    Please provide a family contact.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="cause_of_death" class="form-label">
                                    <i class="fas fa-stethoscope"></i> Cause of Death *
                                </label>
                                <textarea class="form-control" id="cause_of_death" name="cause_of_death" 
                                          rows="3" required><?php echo isset($_POST['cause_of_death']) ? htmlspecialchars($_POST['cause_of_death']) : ''; ?></textarea>
                                <div class="invalid-feedback">
                                    Please provide the cause of death.
                                </div>
                                <div class="form-text">Provide detailed information about the cause of death.</div>
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
                                       value="<?php echo isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : ''; ?> (<?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : ''; ?>)" 
                                       readonly>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="view_deaths.php" class="btn btn-secondary me-md-2">
                            <i class="fas fa-list"></i> View Deaths
                        </a>
                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-save"></i> Register Death
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
