<?php
// INTER COLLEGE EVENTS COUNT STARTS HERE!
require_once __DIR__ . '/../config.php';
global $conn;

//Debugging count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Debugging' OR `event2` = 'Debugging'";
$result = $conn->query($sql);
// Initialize counters
$countEvent1_c_debugging = 0;
$countEvent2_c_debugging = 0;

// Loop through the results
while ($row = mysqli_fetch_assoc($result)) {
    // Check if the participant is in event1
    if ($row['event1'] == 'Debugging') {
        $countEvent1_c_debugging++;
    }
    // Check if the participant is in event2
    if ($row['event2'] == 'Debugging') {
        $countEvent2_c_debugging++;
    }
}
$total_c_debugging = $countEvent1_c_debugging + $countEvent2_c_debugging;


//Biz Masters count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` IN ('Biz Masters', 'Marketing') OR `event2` IN ('Biz Masters', 'Marketing')";
$result = $conn->query($sql);
$countEvent1_c_marketing = 0;
$countEvent2_c_marketing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Biz Masters' || $row['event1'] == 'Marketing') {
        $countEvent1_c_marketing++;
    }
    if ($row['event2'] == 'Biz Masters' || $row['event2'] == 'Marketing') {
        $countEvent2_c_marketing++;
    }
}
$total_c_marketing = $countEvent1_c_marketing + $countEvent2_c_marketing;


//paper presentation count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Paper Presentation' OR `event2` = 'Paper Presentation'";
$result = $conn->query($sql);
$countEvent1_c_paper_presentation = 0;
$countEvent2_c_paper_presentation = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Paper Presentation') {
        $countEvent1_c_paper_presentation++;
    }
    if ($row['event2'] == 'Paper Presentation') {
        $countEvent2_c_paper_presentation++;
    }
}
$total_c_paper_presentation = $countEvent1_c_paper_presentation + $countEvent2_c_paper_presentation;


//web designing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Web Designing' OR `event2` = 'Web Designing'";
$result = $conn->query($sql);
$countEvent1_c_web_designing = 0;
$countEvent2_c_web_designing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Web Designing') {
        $countEvent1_c_web_designing++;
    }
    if ($row['event2'] == 'Web Designing') {
        $countEvent2_c_web_designing++;
    }
}
$total_c_web_designing = $countEvent1_c_web_designing + $countEvent2_c_web_designing;


//poster designing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Poster Designing' OR `event2` = 'Poster Designing'";
$result = $conn->query($sql);
$countEvent1_c_poster_designing = 0;
$countEvent2_c_poster_designing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Poster Designing') {
        $countEvent1_c_poster_designing++;
    }
    if ($row['event2'] == 'Poster Designing') {
        $countEvent2_c_poster_designing++;
    }
}
$total_c_poster_designing = $countEvent1_c_poster_designing + $countEvent2_c_poster_designing;

//ideathon count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `participants` WHERE `event1` = 'Ideathon' OR `event2` = 'Ideathon'";
$result = $conn->query($sql);
$countEvent1_c_ideathon = 0;
$countEvent2_c_ideathon = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Ideathon') {
        $countEvent1_c_ideathon++;
    }
    if ($row['event2'] == 'Ideathon') {
        $countEvent2_c_ideathon++;
    }
}
$total_c_ideathon = $countEvent1_c_ideathon + $countEvent2_c_ideathon;

// INTER COLLEGE EVENTS COUNT END

//_______________________________________________________

//INTER DEPARTMENT EVENTS COUNT STARTS HERE!

//Debugging count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Debugging' OR `event2` = 'Debugging'";
$result = $conn->query($sql);
$countEvent1_i_debugging = 0;
$countEvent2_i_debugging = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Debugging') {
        $countEvent1_i_debugging++;
    }
    if ($row['event2'] == 'Debugging') {
        $countEvent2_i_debugging++;
    }
}
$total_i_debugging = $countEvent1_i_debugging + $countEvent2_i_debugging;


//Biz Masters count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` IN ('Biz Masters', 'Marketing') OR `event2` IN ('Biz Masters', 'Marketing')";
$result = $conn->query($sql);
$countEvent1_i_marketing = 0;
$countEvent2_i_marketing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Biz Masters' || $row['event1'] == 'Marketing') {
        $countEvent1_i_marketing++;
    }
    if ($row['event2'] == 'Biz Masters' || $row['event2'] == 'Marketing') {
        $countEvent2_i_marketing++;
    }
}
$total_i_marketing = $countEvent1_i_marketing + $countEvent2_i_marketing;


//paper presentation count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Paper Presentation' OR `event2` = 'Paper Presentation'";
$result = $conn->query($sql);
$countEvent1_i_paper_presentation = 0;
$countEvent2_i_paper_presentation = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Paper Presentation') {
        $countEvent1_i_paper_presentation++;
    }
    if ($row['event2'] == 'Paper Presentation') {
        $countEvent2_i_paper_presentation++;
    }
}
$total_i_paper_presentation = $countEvent1_i_paper_presentation + $countEvent2_i_paper_presentation;


//web designing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Web Designing' OR `event2` = 'Web Designing'";
$result = $conn->query($sql);
$countEvent1_i_web_designing = 0;
$countEvent2_i_web_designing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Web Designing') {
        $countEvent1_i_web_designing++;
    }
    if ($row['event2'] == 'Web Designing') {
        $countEvent2_i_web_designing++;
    }
}
$total_i_web_designing = $countEvent1_i_web_designing + $countEvent2_i_web_designing;


//poster designing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Poster Designing' OR `event2` = 'Poster Designing'";
$result = $conn->query($sql);
$countEvent1_i_poster_designing = 0;
$countEvent2_i_poster_designing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Poster Designing') {
        $countEvent1_i_poster_designing++;
    }
    if ($row['event2'] == 'Poster Designing') {
        $countEvent2_i_poster_designing++;
    }
}
$total_i_poster_designing = $countEvent1_i_poster_designing + $countEvent2_i_poster_designing;

//ideathon count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Ideathon' OR `event2` = 'Ideathon'";
$result = $conn->query($sql);
$countEvent1_i_ideathon = 0;
$countEvent2_i_ideathon = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Ideathon') {
        $countEvent1_i_ideathon++;
    }
    if ($row['event2'] == 'Ideathon') {
        $countEvent2_i_ideathon++;
    }
}
$total_i_ideathon = $countEvent1_i_ideathon + $countEvent2_i_ideathon;

//____________________________
//NON-Technical Events 

//Solo-Singing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Solo Singing' OR `event2` = 'Solo Singing'";
$result = $conn->query($sql);
$countEvent1_i_solo_singing = 0;
$countEvent2_i_solo_singing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Solo Singing') {
        $countEvent1_i_solo_singing++;
    }
    if ($row['event2'] == 'Solo Singing') {
        $countEvent2_i_solo_singing++;
    }
}
$total_i_solo_singing = $countEvent1_i_solo_singing + $countEvent2_i_solo_singing;


//Solo-Dance count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Solo Dance' OR `event2` = 'Solo Dance'";
$result = $conn->query($sql);
$countEvent1_i_solo_dance = 0;
$countEvent2_i_solo_dance = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Solo Dance') {
        $countEvent1_i_solo_dance++;
    }
    if ($row['event2'] == 'Solo Dance') {
        $countEvent2_i_solo_dance++;
    }
}
$total_i_solo_dance = $countEvent1_i_solo_dance + $countEvent2_i_solo_dance;


//Group-Singing count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Group Singing' OR `event2` = 'Group Singing'";
$result = $conn->query($sql);
$countEvent1_i_group_singing = 0;
$countEvent2_i_group_singing = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Group Singing') {
        $countEvent1_i_group_singing++;
    }
    if ($row['event2'] == 'Group Singing') {
        $countEvent2_i_group_singing++;
    }
}
$total_i_group_singing = $countEvent1_i_group_singing + $countEvent2_i_group_singing;


//Group-Dance count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Group Dance' OR `event2` = 'Group Dance'";
$result = $conn->query($sql);
$countEvent1_i_group_dance = 0;
$countEvent2_i_group_dance = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Group Dance') {
        $countEvent1_i_group_dance++;
    }
    if ($row['event2'] == 'Group Dance') {
        $countEvent2_i_group_dance++;
    }
}
$total_i_group_dance = $countEvent1_i_group_dance + $countEvent2_i_group_dance;


//MIME count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Mime' OR `event2` = 'Mime'";
$result = $conn->query($sql);
$countEvent1_i_mime = 0;
$countEvent2_i_mime = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Mime') {
        $countEvent1_i_mime++;
    }
    if ($row['event2'] == 'Mime') {
        $countEvent2_i_mime++;
    }
}
$total_i_mime = $countEvent1_i_mime + $countEvent2_i_mime;

//Individual Talent count
$sql = "SELECT `name`, `department`, `college`, `email`, `mobile`, `event1`, `event2` FROM `interdepartment` WHERE `event1` = 'Individual Talent' OR `event2` = 'Individual Talent'";
$result = $conn->query($sql);
$countEvent1_i_individual_talent = 0;
$countEvent2_i_individual_talent = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['event1'] == 'Individual Talent') {
        $countEvent1_i_individual_talent++;
    }
    if ($row['event2'] == 'Individual Talent') {
        $countEvent2_i_individual_talent++;
    }
}
$total_i_individual_talent = $countEvent1_i_individual_talent + $countEvent2_i_individual_talent;
