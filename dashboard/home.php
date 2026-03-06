<?php
include 'header.php';
include 'count.php';
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

    .card-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #851428;
        margin-bottom: 5px;
    }

    .card-count span {
        font-size: 0.85rem;
        color: #999;
        font-weight: 500;
        margin-left: 4px;
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
</style>

<div class="page-wrapper">
    <!-- Quick Actions Section -->
    <h2 class="page-section-title">Quick Actions</h2>
    <p class="page-section-subtitle">Manage participants and search registrations across events</p>

    <div class="row g-4 mb-5">
        <!-- All participants -->
        <div class="col-xl-4 col-md-6">
            <div class="event-card">
                <img class="card-icon" src="./icons/participants.png" alt="participants">
                <div class="card-title">All Inter-College participants</div>
                <div class="card-desc">View and manage the complete list of all registered inter-college participants
                </div>
                <a href="c_all.php" class="card-btn">View All</a>
            </div>
        </div>
        <!-- Search by Mobile -->
        <div class="col-xl-4 col-md-6">
            <div class="event-card">
                <img class="card-icon" src="./icons/mobile_search.png" alt="Search">
                <div class="card-title">Search by Mobile</div>
                <div class="card-desc">Quickly find participant details using their registered 10-digit mobile number
                </div>
                <a href="./search/c_search_mobile.php" class="card-btn">Search Now</a>
            </div>
        </div>
        <!-- Search by Email -->
        <div class="col-xl-4 col-md-6">
            <div class="event-card">
                <img class="card-icon" src="./icons/gmail.png" alt="Email">
                <div class="card-title">Search by Email</div>
                <div class="card-desc">Locate registration records by searching with participant email addresses</div>
                <a href="./search/c_search_email.php" class="card-btn">Search Now</a>
            </div>
        </div>
    </div>

    <hr class="section-divider">

    <!-- Inter-College Event Registration Counts -->
    <h2 class="page-section-title">Inter-College Stats</h2>
    <p class="page-section-subtitle">Real-time registration counts for all inter-college events</p>

    <div class="row g-4 mb-5">
        <?php
        $college_events = [
            ['title' => 'Paper Presentation', 'icon' => 'ppt.png', 'count' => $total_c_paper_presentation],
            ['title' => 'Poster Designing', 'icon' => 'poster_design.png', 'count' => $total_c_poster_designing],
            ['title' => 'Marketing', 'icon' => 'marketing.png', 'count' => $total_c_marketing],
            ['title' => 'Ideathon', 'icon' => 'ideathon.png', 'count' => $total_c_ideathon],
            ['title' => 'Debugging', 'icon' => 'debugging.png', 'count' => $total_c_debugging],
            ['title' => 'Web Designing', 'icon' => 'web_designing.png', 'count' => $total_c_web_designing],
        ];

        foreach ($college_events as $event) {
            echo '
            <div class="col-xl-4 col-md-6">
                <div class="event-card">
                    <img class="card-icon" src="./icons/' . $event['icon'] . '" alt="' . $event['title'] . '">
                    <div class="card-title">' . $event['title'] . '</div>
                    <div class="card-count">' . $event['count'] . '<span>registrations</span></div>
                    <div class="card-desc">Current total registrations for the ' . $event['title'] . ' event</div>
                </div>
            </div>';
        }
        ?>
    </div>

    <hr class="section-divider">

    <!-- Inter-Department Section -->
    <h2 class="page-section-title">Inter-Department Overview</h2>
    <p class="page-section-subtitle">Manage internal department events and registrations</p>

    <div class="row g-4 pb-4">
        <div class="col-xl-4 col-md-6">
            <div class="event-card">
                <img class="card-icon" src="./icons/participants.png" alt="participants">
                <div class="card-title">All Department participants</div>
                <div class="card-desc">View and manage registrations for all internal inter-department events</div>
                <a href="i_all.php" class="card-btn">View All</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>