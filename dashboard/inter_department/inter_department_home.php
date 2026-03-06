<?php
include 'header.php';
?>

<style>
    .page-wrapper {
        padding: 30px 35px;
        padding-top: 90px;
    }

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

    .section-divider {
        border: none;
        border-top: 2px solid #f0f0f0;
        margin: 35px 0;
    }

    .event-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.06);
        padding: 24px 20px 20px 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid #f2f2f2;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.1);
    }

    .event-card .card-icon {
        width: 52px;
        height: 52px;
        object-fit: contain;
        margin-bottom: 14px;
    }

    .event-card .card-title {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 6px;
    }

    .event-card .card-desc {
        color: #888;
        font-size: 0.88rem;
        flex: 1;
        margin-bottom: 18px;
        line-height: 1.5;
    }

    .card-btn {
        display: inline-block;
        background-color: #851428;
        color: white;
        padding: 8px 22px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        align-self: flex-start;
        transition: background 0.2s;
    }

    .card-btn:hover {
        background-color: #6a0f20;
        color: white;
    }

    .card-btn-validate {
        background-color: #2c3e50;
    }

    .card-btn-validate:hover {
        background-color: #1a252f;
    }

    .form-container {
        background: white;
        padding: 40px 50px;
        border-radius: 16px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.06);
    }

    .form-section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #851428;
        margin-bottom: 28px;
        text-align: center;
    }
</style>

<div class="page-wrapper">

    <!-- Technical Events -->
    <p class="page-section-title">Technical Events</p>
    <p class="page-section-subtitle">View registered inter-department participants for technical events</p>
    <div class="row g-4">
        <?php
        $tech_events = [
            ['title' => 'Paper Presentation', 'icon' => 'ppt.png', 'link' => 'view/i_paper_presentation.php'],
            ['title' => 'Poster Designing', 'icon' => 'poster_design.png', 'link' => 'view/i_poster_designing.php'],
            ['title' => 'Marketing', 'icon' => 'marketing.png', 'link' => 'view/i_marketing.php'],
            ['title' => 'Ideathon', 'icon' => 'ideathon.png', 'link' => 'view/i_ideathon.php'],
            ['title' => 'Debugging', 'icon' => 'debugging.png', 'link' => 'view/i_debugging.php'],
            ['title' => 'Web Designing', 'icon' => 'web_designing.png', 'link' => 'view/i_web_designing.php'],
        ];
        foreach ($tech_events as $event) {
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="event-card">
                    <img class="card-icon" src="../icons/' . $event['icon'] . '" alt="' . $event['title'] . '">
                    <div class="card-title">' . $event['title'] . '</div>
                    <div class="card-desc">View all registered participants for ' . $event['title'] . '</div>
                    <a href="./' . $event['link'] . '" class="card-btn">View</a>
                </div>
            </div>';
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Non-Technical Events -->
    <p class="page-section-title">Non-Technical Events</p>
    <p class="page-section-subtitle">View registered inter-department participants for non-technical events</p>
    <div class="row g-4">
        <?php
        $non_tech_events = [
            ['title' => 'Solo Singing', 'icon' => 'solo-singing.png', 'link' => 'view/i_solo_singing.php'],
            ['title' => 'Solo Dance', 'icon' => 'solo-dance.png', 'link' => 'view/i_solo_dance.php'],
            ['title' => 'Group Singing', 'icon' => 'grp_singing.png', 'link' => 'view/i_group_singing.php'],
            ['title' => 'Group Dance', 'icon' => 'group-dance.png', 'link' => 'view/i_group_dance.php'],
            ['title' => 'Mime', 'icon' => 'mime.png', 'link' => 'view/i_mime.php'],
            ['title' => 'Individual Talent', 'icon' => 'talent.png', 'link' => 'view/i_individual_talent.php'],
        ];
        foreach ($non_tech_events as $event) {
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="event-card">
                    <img class="card-icon" src="../icons/' . $event['icon'] . '" alt="' . $event['title'] . '">
                    <div class="card-title">' . $event['title'] . '</div>
                    <div class="card-desc">View all registered participants for ' . $event['title'] . '</div>
                    <a href="./' . $event['link'] . '" class="card-btn">View</a>
                </div>
            </div>';
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Registration Form -->
    <div class="row justify-content-center pb-4">
        <div class="col-lg-10">
            <div class="form-container">
                <h2 class="form-section-title">Inter-Department Registration</h2>
                <form method="post" id="registrationForm" action="add_int_dpt_participants.php" class="needs-validation"
                    novalidate>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input name="name" type="text" class="form-control form-control-lg" placeholder="Enter name"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Department</label>
                            <input name="department" type="text" class="form-control form-control-lg"
                                placeholder="Enter department" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">College Name</label>
                            <input name="college" type="text" class="form-control form-control-lg"
                                value="Hindusthan College of Arts & Science" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input name="email" type="email" class="form-control form-control-lg"
                                placeholder="email@example.com" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Mobile</label>
                            <input name="mobile" type="text" class="form-control form-control-lg"
                                placeholder="10-digit number" required>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label fw-semibold">Technical Event</label>
                            <?php foreach ($tech_events as $te): ?>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="radio" name="event1"
                                        value="<?php echo $te['title']; ?>"
                                        id="te_<?php echo str_replace(' ', '_', $te['title']); ?>">
                                    <label class="form-check-label"
                                        for="te_<?php echo str_replace(' ', '_', $te['title']); ?>"><?php echo $te['title']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label class="form-label fw-semibold">Non-Technical Event</label>
                            <?php foreach ($non_tech_events as $nte): ?>
                                <div class="form-check mt-1">
                                    <input class="form-check-input" type="radio" name="event2"
                                        value="<?php echo $nte['title']; ?>"
                                        id="nte_<?php echo str_replace(' ', '_', $nte['title']); ?>">
                                    <label class="form-check-label"
                                        for="nte_<?php echo str_replace(' ', '_', $nte['title']); ?>"><?php echo $nte['title']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" name="submit" class="card-btn border-0 py-3 px-5"
                                style="font-size:1rem;">Register Participant</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>