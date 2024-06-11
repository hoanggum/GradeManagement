<?php

require_once '../Model/SubjectSection.php';

$SubjectSectionObj = new SubjectSection();
if (isset($_GET['subjectId'])) {
    // Retrieve the subject ID from the GET request
    $subjectId = $_GET['subjectId'];

    // Call the method in the Section model to fetch sections by subject ID
    $sections = $SubjectSectionObj->getSectionsBySubjectId($subjectId);

    // Convert the retrieved sections to JSON format and echo it
    echo json_encode($sections);
} else {
    // If subject ID is not provided, return an empty array
    echo json_encode([]);
}
?>