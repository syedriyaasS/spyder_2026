<?php

function getWebsiteEvents() {
    $htmlFile = __DIR__ . '/../interdept_register.html';
    $technical = [];
    $nonTechnical = [];

    if (file_exists($htmlFile)) {
        $content = file_get_contents($htmlFile);
        
        // Use simpler but safer regex to find all event1 (Technical) inputs
        preg_match_all('/name="event1" value="([^"]+)"/i', $content, $techMatches);
        if (!empty($techMatches[1])) {
            $technical = array_unique($techMatches[1]);
        }
    }

    // User-specified Non-Technical items
    $nonTechnical = [
        'Solo Singing', 
        'Solo Dance', 
        'Group Singing', 
        'Group Dance', 
        'Mime', 
        'Individual Talent'
    ];

    // Cleanup: Sort alphabetically for better UX
    sort($technical);
    sort($nonTechnical);

    return [
        'technical' => $technical,
        'non_technical' => $nonTechnical
    ];
}
