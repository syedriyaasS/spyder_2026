<?php
include_once __DIR__ . '/header.php';
include_once __DIR__ . '/../includes/events.php';

$message = $message ?? '';
$error = $error ?? '';

if (isset($_POST['add_coordinator'])) {
    $name = $_POST['name'] ?? '';
    $event_tech = $_POST['event_tech'] ?? '';
    $event_non_tech = $_POST['event_non_tech'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $final_event = !empty($event_tech) ? $event_tech : $event_non_tech;
    $event_category = !empty($event_tech) ? 'Technical' : 'Non-Technical';

    if (!empty($name) && !empty($final_event) && !empty($username) && !empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $created_by = $_SESSION['user'] ?? 'admin';

        $sql = "INSERT INTO coordinators (name, event_name, event_category, username, password, created_by) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $final_event, $event_category, $username, $hashed_password, $created_by);

        try {
            if ($stmt->execute()) {
                $message = "Coordinator created successfully!";
            } else {
                $error = "Error: " . $stmt->error;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = "<i class='fas fa-exclamation-triangle me-2'></i> The username '<b>" . htmlspecialchars($username) . "</b>' is already taken! Please choose a different username.";
            } else {
                $error = "Database Error: " . $e->getMessage();
            }
        }
    } else {
        $error = "All fields are required, including at least one event!";
    }
}

// Fetch all coordinators
$coords = null;
try {
    $coords = $conn->query("SELECT * FROM coordinators ORDER BY created_at DESC");
} catch (Exception $e) {
    $error = "Database error: " . $e->getMessage();
}
$events_list = getWebsiteEvents();
?>

<style>
    .page-title {
        font-weight: 800;
        color: #1a1a1a;
        margin-bottom: 25px;
        font-size: 1.7rem;
        letter-spacing: -0.5px;
    }

    .custom-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 30px;
        background: #fff;
    }

    .custom-card-header {
        background-color: transparent;
        border-bottom: 2px solid #f8f9fa;
        padding: 22px 28px;
    }

    .custom-card-header h5 {
        font-weight: 700;
        color: #851428;
        font-size: 1.15rem;
        margin: 0;
    }

    .custom-card-body {
        padding: 30px 28px;
    }

    .form-label {
        font-weight: 600;
        color: #4a4a4a;
        font-size: 0.9rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 10px 16px;
        border: 1px solid #e0e0e0;
        background-color: #fafbfe;
        box-shadow: none !important;
        transition: all 0.2s;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #851428;
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(133, 20, 40, 0.1) !important;
    }

    .btn-spyder {
        background-color: #851428;
        color: white;
        border-radius: 8px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }

    .btn-spyder:hover {
        background-color: #6a0f20;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(133, 20, 40, 0.2);
    }

    .btn-accent {
        border-color: #d1d5db;
        border-radius: 8px;
        font-weight: 600;
        color: #4b5563;
        transition: 0.3s;
    }

    .btn-accent:hover {
        background-color: #f3f4f6;
        color: #1f2937;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-modern thead th {
        border: none;
        background: transparent;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 10px 15px;
    }

    .table-modern tbody tr {
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        border: 1px solid #f3f4f6;
        border-radius: 8px;
        transition: 0.2s;
    }

    .table-modern tbody tr:hover {
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }

    .table-modern td {
        border-top: 1px solid #f3f4f6;
        border-bottom: 1px solid #f3f4f6;
        padding: 18px 15px;
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .table-modern td:first-child {
        border-left: 1px solid #f3f4f6;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        font-weight: 600;
        color: #111827;
    }

    .table-modern td:last-child {
        border-right: 1px solid #f3f4f6;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .badge-soft-tech {
        background-color: #e0e7ff;
        color: #4338ca;
        font-weight: 600;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.8rem;
    }

    .badge-soft-non {
        background-color: #dcfce7;
        color: #15803d;
        font-weight: 600;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 0.8rem;
    }

    .badge-soft-event {
        background-color: #ffe4e6;
        color: #be123c;
        font-weight: 700;
        border-radius: 6px;
        padding: 6px 15px;
        font-size: 0.85rem;
    }

    .username-code {
        font-family: monospace;
        font-weight: 600;
        color: #4b5563;
        background: #f3f4f6;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
    }
</style>

<div class="container-fluid" style="padding: 20px 0;">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
            <h3 class="page-title"><i class="fas fa-users-cog me-2"></i> Managing Coordinators</h3>

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="custom-card">
                <div class="custom-card-header">
                    <h5><i class="fas fa-user-plus me-2"></i> Create New Coordinator</h5>
                </div>
                <div class="custom-card-body">
                    <form method="POST" action="" id="createCoordForm" onsubmit="return validateForm()">
                        <div class="row overflow-hidden">
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block text-truncate" style="height: 22px; line-height: 1.2;">Full Name</label>
                                <input type="text" name="name" class="form-control" required placeholder="e.g. Madhesh">
                            </div>
                            <div class="col-md-3 mb-3" id="techEventGroup">
                                <label class="form-label d-block text-truncate" style="height: 22px; line-height: 1.2;">Event 1 – Technical</label>
                                <select name="event_tech" id="event_tech" class="form-select" onchange="handleEventSelection('tech')">
                                    <option value="" selected>Select Technical Event</option>
                                    <?php foreach ($events_list['technical'] as $evt): ?>
                                        <option value="<?php echo htmlspecialchars($evt); ?>"><?php echo htmlspecialchars($evt); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3" id="nonTechEventGroup">
                                <label class="form-label d-block text-truncate" style="height: 22px; line-height: 1.2;">Event 2 – Non-Technical</label>
                                <select name="event_non_tech" id="event_non_tech" class="form-select" onchange="handleEventSelection('non_tech')">
                                    <option value="" selected>Non-Technical Event</option>
                                    <?php foreach ($events_list['non_technical'] as $evt): ?>
                                        <option value="<?php echo htmlspecialchars($evt); ?>"><?php echo htmlspecialchars($evt); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label d-block text-truncate" style="height: 22px; line-height: 1.2;">Username</label>
                                <input type="text" name="username" class="form-control" required placeholder="e.g. ideathon_admin">
                            </div>
                        </div>

                        <!-- Second row for password and button -->
                        <div class="row align-items-end mt-2">
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-truncate">Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" id="coordPassword" class="form-control" required placeholder="Enter password" style="padding-right: 40px;">
                                    <i class="fa-solid fa-eye position-absolute" style="right: 14px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; z-index: 10;" onclick="togglePassword('coordPassword', this)"></i>
                                </div>
                            </div>
                            <div class="col-md-9 mb-3">
                                <div id="eventError" class="text-danger small mb-2 fw-semibold" style="display: none;">
                                    <i class="fas fa-exclamation-circle"></i> Please select at least one event (Technical or Non-Technical).
                                </div>
                                <div class="d-flex gap-3 w-100 justify-content-end">
                                    <button type="reset" class="btn btn-outline-secondary btn-accent px-4 py-2" style="min-width: 140px;">
                                        <i class="fas fa-undo-alt me-1"></i> Reset
                                    </button>
                                    <button type="submit" name="add_coordinator" class="btn btn-spyder px-4 py-2" style="min-width: 200px;">
                                        <i class="fas fa-check-circle me-1"></i> Create Coordinator
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="custom-card">
                <div class="custom-card-header">
                    <h5><i class="fas fa-list-ul me-2"></i> Existing Coordinators</h5>
                </div>
                <div class="custom-card-body pt-2">
                    <div class="table-responsive">
                        <table class="table table-modern" style="border-collapse: separate; border-spacing: 0 10px;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Event Type</th>
                                    <th>Event Name</th>
                                    <th>Username</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($coords && $coords->num_rows > 0): ?>
                                    <?php while ($row = $coords->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><span class="badge <?php echo ($row['event_category'] == 'Technical' ? 'badge-soft-tech' : 'badge-soft-non'); ?>"><?php echo htmlspecialchars($row['event_category'] ?? 'N/A'); ?></span></td>
                                            <td><span class="badge-soft-event"><?php echo htmlspecialchars($row['event_name']); ?></span></td>
                                            <td><span class="username-code"><?php echo htmlspecialchars($row['username']); ?></span></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="status_<?php echo $row['id']; ?>"
                                                        <?php echo ($row['login_status'] === 'active') ? 'checked' : ''; ?>
                                                        onchange="toggleStatus(<?php echo $row['id']; ?>, this)">
                                                </div>
                                            </td>
                                            <td>
                                                <button class="btn btn-sm" onclick="resetPassword(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars(addslashes($row['username'])); ?>')" style="color: #4b5563; background: #f3f4f6; border-radius: 6px; border: 1px solid #e5e7eb; transition: 0.2s; padding: 6px 10px;" title="Reset Password" onmouseover="this.style.color='#851428'; this.style.borderColor='#851428';" onmouseout="this.style.color='#4b5563'; this.style.borderColor='#e5e7eb';">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No coordinators found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function resetPassword(id, username) {
        Swal.fire({
            title: 'Reset Password',
            html: `
                <div style="font-size: 0.95rem; margin-bottom: 20px;">Enter the new password for coordinator <b>${username}</b>:</div>
                <div style="position: relative; width: 100%; max-width: 300px; margin: 0 auto;">
                    <input id="swal-new-password" type="password" class="form-control" placeholder="New password" style="height: 48px; border-radius: 8px; padding-right: 45px; font-size: 1rem;">
                    <i class="fas fa-eye" id="swal-toggle-password" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #888; font-size: 1.1rem; padding: 5px;"></i>
                </div>
            `,
            didOpen: () => {
                const toggleBtn = document.getElementById('swal-toggle-password');
                const pswdInput = document.getElementById('swal-new-password');
                toggleBtn.addEventListener('click', () => {
                    if (pswdInput.type === 'password') {
                        pswdInput.type = 'text';
                        toggleBtn.classList.remove('fa-eye');
                        toggleBtn.classList.add('fa-eye-slash');
                    } else {
                        pswdInput.type = 'password';
                        toggleBtn.classList.remove('fa-eye-slash');
                        toggleBtn.classList.add('fa-eye');
                    }
                });
            },
            showCancelButton: true,
            confirmButtonText: 'Reset Password',
            confirmButtonColor: '#851428',
            cancelButtonColor: '#6c757d',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                const newPassword = document.getElementById('swal-new-password').value;
                if (!newPassword) {
                    Swal.showValidationMessage('Password cannot be empty');
                    return false;
                }

                return fetch('../api/reset_coordinator_password.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${id}&new_password=${encodeURIComponent(newPassword)}`
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        return response.json()
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                    });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.value.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: result.value.message,
                        icon: 'success',
                        confirmButtonColor: '#198754'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: result.value.message,
                        icon: 'error',
                        confirmButtonColor: '#dc3545'
                    });
                }
            }
        });
    }

    function handleEventSelection(type) {
        const techSelect = document.getElementById('event_tech');
        const nonTechSelect = document.getElementById('event_non_tech');
        const techGroup = document.getElementById('techEventGroup');
        const nonTechGroup = document.getElementById('nonTechEventGroup');
        const errorDiv = document.getElementById('eventError');

        // Reset error message when selection changes
        errorDiv.style.display = 'none';

        if (type === 'tech') {
            if (techSelect.value !== "") {
                // If Technical selected, hide Non-Tech
                nonTechGroup.style.display = "none";
                nonTechSelect.value = "";
            } else {
                // If Technical cleared, show both
                nonTechGroup.style.display = "";
                techGroup.style.display = "";
            }
        } else if (type === 'non_tech') {
            if (nonTechSelect.value !== "") {
                // If Non-Technical selected, hide Tech
                techGroup.style.display = "none";
                techSelect.value = "";
            } else {
                // If Non-Technical cleared, show both
                techGroup.style.display = "";
                nonTechGroup.style.display = "";
            }
        }
    }

    function validateForm() {
        const techValue = document.getElementById('event_tech').value;
        const nonTechValue = document.getElementById('event_non_tech').value;
        const errorDiv = document.getElementById('eventError');

        if (techValue === "" && nonTechValue === "") {
            errorDiv.style.display = 'block';
            return false;
        }
        return true;
    }

    function toggleStatus(id, checkbox) {
        const status = checkbox.checked ? 'active' : 'disabled';

        fetch('../api/toggle_coordinator_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `id=${id}&status=${status}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert if DB update failed
                    checkbox.checked = !checkbox.checked;
                    showToast('Error: ' + data.message, 'danger');
                } else {
                    showToast('Status updated to ' + status, 'success');
                }
            })
            .catch(() => {
                checkbox.checked = !checkbox.checked;
                showToast('Network error — please try again.', 'danger');
            });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.cssText = `
            position:fixed; bottom:24px; right:24px; z-index:9999;
            background:${type === 'success' ? '#198754' : '#dc3545'};
            color:#fff; padding:12px 20px; border-radius:8px;
            font-size:14px; font-weight:600; box-shadow:0 4px 12px rgba(0,0,0,0.2);
            transition: opacity 0.5s;
        `;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 500);
        }, 2500);
    }

    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

<?php include_once __DIR__ . '/footer.php'; ?>