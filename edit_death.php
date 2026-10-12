<?php
require_once 'includes/auth.php';
require_login();
require_once 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: view_deaths.php');
    exit;
}

$death_id = (int)$_GET['id'];
$error = '';
$success = '';


$stmt = $conn->prepare("SELECT * FROM deaths WHERE id = ?");
$stmt->bind_param("i", $death_id);
$stmt->execute();
$result = $stmt->get_result();
$death = $result->fetch_assoc();

if (!$death) {
    header('Location: view_deaths.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $deceased_name = trim($_POST['deceased_name']);
    $date_of_death = $_POST['date_of_death'];
    $cause_of_death = trim($_POST['cause_of_death']);
    $family_contact = trim($_POST['family_contact']);
    $village = trim($_POST['village']);
    $sector = trim($_POST['sector']);

    if (
        empty($deceased_name) || empty($date_of_death) || empty($cause_of_death) ||
        empty($family_contact) || empty($village) || empty($sector)
    ) {
        $error = "All fields are required.";
    } else {
        $stmt = $conn->prepare("UPDATE deaths SET deceased_name=?, date_of_death=?, cause_of_death=?, family_contact=?, village=?, sector=? WHERE id=?");
        $stmt->bind_param("ssssssi", $deceased_name, $date_of_death, $cause_of_death, $family_contact, $village, $sector, $death_id);
        if ($stmt->execute()) {
            $success = "Record Updated Successfully.";
            
            $death['deceased_name'] = $deceased_name;
            $death['date_of_death'] = $date_of_death;
            $death['cause_of_death'] = $cause_of_death;
            $death['family_contact'] = $family_contact;
            $death['village'] = $village;
            $death['sector'] = $sector;
        } else {
            $error = "Failed to update record. Please try again.";
        }
    }
}

$page_title = "Edit Death Record";
include 'includes/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-edit"></i> Edit Death Record</h4>
                </div>
                <div class="card-body">
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Deceased Name</label>
                            <input type="text" name="deceased_name" class="form-control" value="<?php echo htmlspecialchars($death['deceased_name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Death</label>
                            <input type="date" name="date_of_death" class="form-control" value="<?php echo htmlspecialchars($death['date_of_death']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cause of Death</label>
                            <textarea name="cause_of_death" class="form-control" rows="3" required><?php echo htmlspecialchars($death['cause_of_death']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Family Contact</label>
                            <input type="text" name="family_contact" class="form-control" value="<?php echo htmlspecialchars($death['family_contact']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Village</label>
                            <input type="text" name="village" class="form-control" value="<?php echo htmlspecialchars($death['village']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sector</label>
                            <input type="text" name="sector" class="form-control" value="<?php echo htmlspecialchars($death['sector']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-warning"><i class="fas fa-save"></i> Update Record</button>
                        <a href="view_deaths.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>