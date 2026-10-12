<?php
require_once 'includes/auth.php';
require_login();
require_once 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: view_births.php');
    exit;
}

$birth_id = (int)$_GET['id'];
$error = '';
$success = '';


$stmt = $conn->prepare("SELECT * FROM births WHERE id = ?");
$stmt->bind_param("i", $birth_id);
$stmt->execute();
$result = $stmt->get_result();
$birth = $result->fetch_assoc();

if (!$birth) {
    header('Location: view_births.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $child_name = trim($_POST['child_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $mother_name = trim($_POST['mother_name']);
    $father_name = trim($_POST['father_name']);
    $village = trim($_POST['village']);
    $sector = trim($_POST['sector']);

    if (
        empty($child_name) || empty($date_of_birth) || empty($gender) ||
        empty($mother_name) || empty($father_name) || empty($village) || empty($sector)
    ) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE births SET child_name=?, date_of_birth=?, gender=?, mother_name=?, father_name=?, village=?, sector=? WHERE id=?");
        $stmt->bind_param("sssssssi", $child_name, $date_of_birth, $gender, $mother_name, $father_name, $village, $sector, $birth_id);
        if ($stmt->execute()) {
            $success = "Record updated successfully.";
            
            $birth['child_name'] = $child_name;
            $birth['date_of_birth'] = $date_of_birth;
            $birth['gender'] = $gender;
            $birth['mother_name'] = $mother_name;
            $birth['father_name'] = $father_name;
            $birth['village'] = $village;
            $birth['sector'] = $sector;
        } else {
            $error = "Failed to update record. Please try again.";
        }
    }
}

$page_title = "Edit Birth Record";
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-edit"></i> Edit Birth Record</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Child Name</label>
                            <input type="text" name="child_name" class="form-control" value="<?php echo htmlspecialchars($birth['child_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($birth['date_of_birth']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?php if ($birth['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($birth['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control" value="<?php echo htmlspecialchars($birth['mother_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="<?php echo htmlspecialchars($birth['father_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Village</label>
                            <input type="text" name="village" class="form-control" value="<?php echo htmlspecialchars($birth['village']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sector</label>
                            <input type="text" name="sector" class="form-control" value="<?php echo htmlspecialchars($birth['sector']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Record</button>
                        <a href="view_births.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php