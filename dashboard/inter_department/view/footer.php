</div> <!-- .main-content -->

<!-- Attendance Confirmation Modal -->
<div id="attendanceModal" class="attendance-modal">
    <div class="attendance-modal-content">
        <span class="attendance-modal-close" onclick="closeAttendanceModal()">&times;</span>
        <div class="attendance-modal-header">
            <h4>Confirm Attendance Validation</h4>
        </div>
        <div class="attendance-modal-body">
            Are you sure you want to mark attendance for this participant?<br>
            This action will record the student's attendance for the event.
        </div>
        <div class="attendance-modal-footer">
            <button id="confirmAttendanceBtn" class="btn-confirm-attendance">Confirm Attendance</button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
<script>
    if(document.querySelector(".toggle-sidebar")){
        document.querySelector(".toggle-sidebar").addEventListener("click", function () {
            document.querySelector(".sidebar").classList.toggle("active");
        });
    }

    let currentParticipantId = null;
    let currentEventType = null;
    let currentButton = null;

    function openAttendanceModal(participantId, eventType, button) {
        currentParticipantId = participantId;
        currentEventType = eventType;
        currentButton = button;
        document.getElementById('attendanceModal').classList.add('show');
    }

    function closeAttendanceModal() {
        document.getElementById('attendanceModal').classList.remove('show');
    }

    document.getElementById('confirmAttendanceBtn').addEventListener('click', function() {
        if (!currentParticipantId || !currentEventType) return;

        const btn = this;
        btn.disabled = true;
        btn.innerText = 'Processing...';

        const formData = new FormData();
        formData.append('participant_id', currentParticipantId);
        formData.append('event_type', currentEventType);

        fetch('update_interdepartment_attendance.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update the original button
                currentButton.innerText = 'Validated';
                currentButton.disabled = true;
                closeAttendanceModal();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating attendance.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = 'Confirm Attendance';
        });
    });

    // Close modal on outside click
    window.onclick = function(event) {
        const modal = document.getElementById('attendanceModal');
        if (event.target == modal) {
            closeAttendanceModal();
        }
    }
</script>
</body>
</html>
