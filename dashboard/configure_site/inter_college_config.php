<?php
include '../header.php';

// Fetch current settings from database
$settings = [];
$keys = ['registration_status', 'switch_registration', 'certificate_status'];
$sql = "SELECT setting_key, setting_value FROM site_settings WHERE setting_key IN ('" . implode("','", $keys) . "')";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}

// Default values if not in DB
if (!isset($settings['registration_status'])) $settings['registration_status'] = 'open';
if (!isset($settings['switch_registration'])) $settings['switch_registration'] = 'local';
if (!isset($settings['certificate_status'])) $settings['certificate_status'] = 'disabled';
?>

<style>
    .page-section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .page-section-subtitle {
        color: #888;
        font-size: 0.92rem;
        margin-bottom: 22px;
    }

    .settings-container {
        max-width: 900px;
    }

    .setting-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        padding: 25px 30px;
        margin-bottom: 25px;
        border-left: 4px solid #851428;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.2s ease;
    }

    .setting-card:hover {
        transform: translateX(5px);
    }

    .setting-info h3 {
        margin-bottom: 5px;
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.15rem;
    }

    .setting-info p {
        margin-bottom: 0;
        color: #666;
        font-size: 0.92rem;
    }

    /* Custom Switch Styling */
    .custom-switch-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .custom-switch-label {
        font-weight: 600;
        font-size: 0.9rem;
        transition: color 0.2s;
    }

    .label-inactive {
        color: #aaa;
    }

    .label-active-red {
        color: #851428;
    }

    .label-active-green {
        color: #28a745;
    }

    .custom-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 25px;
    }

    .custom-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #dee2e6;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 19px;
        width: 19px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #28a745;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #28a745;
    }

    input:checked + .slider:before {
        transform: translateX(25px);
    }
    
    /* Red state for "Closed" or "Google" maybe? Actually let's keep green for active/enabled toggles */
    .slider.red-state {
        background-color: #dc3545;
    }
    
    input.red-state:checked + .slider {
        background-color: #28a745;
    }
    
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
</style>

<div class="container-fluid settings-container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" style="color: #851428;">Configure Website</a></li>
            <li class="breadcrumb-item active" aria-current="page">Inter College</li>
        </ol>
    </nav>

    <h2 class="page-section-title">Inter College Settings</h2>
    <p class="page-section-subtitle">Manage registration availability and interface behavior.</p>

    <!-- 1. Registration Status -->
    <div class="setting-card">
        <div class="setting-info">
            <h3>Registration Status</h3>
            <p>Completely enable or disable the registration form on the website.</p>
        </div>
        <div class="custom-switch-wrapper">
            <span class="custom-switch-label <?php echo $settings['registration_status'] == 'closed' ? 'label-active-red' : 'label-inactive'; ?>" id="label-reg-closed">Closed</span>
            <label class="custom-switch">
                <input type="checkbox" id="toggle-registration" <?php echo $settings['registration_status'] == 'open' ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <span class="custom-switch-label <?php echo $settings['registration_status'] == 'open' ? 'label-active-green' : 'label-inactive'; ?>" id="label-reg-open">Open</span>
        </div>
    </div>

    <!-- 2. Switch Registration -->
    <div class="setting-card">
        <div class="setting-info">
            <h3>Register Button Path</h3>
            <p>Redirect "Register" buttons on Home page to Local Form or External Google Form.</p>
        </div>
        <div class="custom-switch-wrapper">
            <span class="custom-switch-label <?php echo $settings['switch_registration'] == 'local' ? 'label-active-green' : 'label-inactive'; ?>" id="label-switch-local">Local</span>
            <label class="custom-switch">
                <input type="checkbox" id="toggle-switch" <?php echo $settings['switch_registration'] == 'google' ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <span class="custom-switch-label <?php echo $settings['switch_registration'] == 'google' ? 'label-active-red' : 'label-inactive'; ?>" id="label-switch-google">Google</span>
        </div>
    </div>

    <!-- 3. Certificate Status -->
    <div class="setting-card">
        <div class="setting-info">
            <h3>Certificate Availability</h3>
            <p>Control visibility of the "Get Certificate" retrieval form on the certificate page.</p>
        </div>
        <div class="custom-switch-wrapper">
            <span class="custom-switch-label <?php echo $settings['certificate_status'] == 'disabled' ? 'label-active-red' : 'label-inactive'; ?>" id="label-cert-disabled">Disabled</span>
            <label class="custom-switch">
                <input type="checkbox" id="toggle-certificate" <?php echo $settings['certificate_status'] == 'enabled' ? 'checked' : ''; ?>>
                <span class="slider"></span>
            </label>
            <span class="custom-switch-label <?php echo $settings['certificate_status'] == 'enabled' ? 'label-active-green' : 'label-inactive'; ?>" id="label-cert-enabled">Enabled</span>
        </div>
    </div>
</div>

<!-- Simple Toast for feedback -->
<div class="toast-container">
    <div id="settingsToast" class="toast align-items-center text-white bg-dark border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Setting updated successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toast = new bootstrap.Toast(document.getElementById('settingsToast'));
    const toastMsg = document.getElementById('toastMessage');

    function updateSetting(key, value, successCallback, errorCallback) {
        const formData = new FormData();
        formData.append('key', key);
        formData.append('value', value);

        fetch('update_settings.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastMsg.innerText = data.message || 'Setting updated!';
                toast.show();
                if (successCallback) successCallback();
            } else {
                alert('Error: ' + data.message);
                if (errorCallback) errorCallback();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred.');
            if (errorCallback) errorCallback();
        });
    }

    // Toggle Registration
    const regToggle = document.getElementById('toggle-registration');
    regToggle.addEventListener('change', function() {
        const val = this.checked ? 'open' : 'closed';
        updateSetting('registration_status', val, () => {
            document.getElementById('label-reg-open').className = val === 'open' ? 'custom-switch-label label-active-green' : 'custom-switch-label label-inactive';
            document.getElementById('label-reg-closed').className = val === 'closed' ? 'custom-switch-label label-active-red' : 'custom-switch-label label-inactive';
        }, () => { this.checked = !this.checked; });
    });

    // Toggle Switch Path
    const swToggle = document.getElementById('toggle-switch');
    swToggle.addEventListener('change', function() {
        const val = this.checked ? 'google' : 'local';
        updateSetting('switch_registration', val, () => {
            document.getElementById('label-switch-google').className = val === 'google' ? 'custom-switch-label label-active-red' : 'custom-switch-label label-inactive';
            document.getElementById('label-switch-local').className = val === 'local' ? 'custom-switch-label label-active-green' : 'custom-switch-label label-inactive';
        }, () => { this.checked = !this.checked; });
    });

    // Toggle Certificate
    const certToggle = document.getElementById('toggle-certificate');
    certToggle.addEventListener('change', function() {
        const val = this.checked ? 'enabled' : 'disabled';
        updateSetting('certificate_status', val, () => {
            document.getElementById('label-cert-enabled').className = val === 'enabled' ? 'custom-switch-label label-active-green' : 'custom-switch-label label-inactive';
            document.getElementById('label-cert-disabled').className = val === 'disabled' ? 'custom-switch-label label-active-red' : 'custom-switch-label label-inactive';
        }, () => { this.checked = !this.checked; });
    });
});
</script>

<?php include '../footer.php'; ?>
