<?php
// In get_section.php

require_once '../Model/SubjectSection.php';
$studentId = $_SESSION['StudentID'];

if (isset($_GET['subjectId'])) {
    $subjectId = intval($_GET['subjectId']);
    $semester = intval($_GET['semester']);
    $subjectSectionObj = new SubjectSection();
    $sections = $subjectSectionObj->getSectionsBySubjectId($subjectId,$semester);

    // Generate HTML for sections
    if ($sections) {
        echo '<table class="table table-bordered">';
        echo '<thead><tr><th>Section ID</th><th>Section Name</th><th>Semester</th></tr></thead>';
        echo '<tbody>';
        foreach ($sections as $section) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($section['SectionID']) . '</td>';
            echo '<td>' . htmlspecialchars($section['Schedule']) . '</td>';
            echo '<td>' . htmlspecialchars($section['Semester']) . '</td>';
            echo '<td><button class="btn btn-success" onclick="registerSection(' . $section['SectionID'] . ', \'' . htmlspecialchars($section['Semester']) . '\', ' . $studentId . ')">Register</button></td>';            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No sections available for this subject.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}

?>
