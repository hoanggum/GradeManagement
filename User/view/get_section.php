<?php
require_once '../Model/SubjectSection.php';

if (isset($_GET['subjectId'])) {
    $subjectId = $_GET['subjectId'];
    $subjectSectionObj = new SubjectSection();
    $sections = $subjectSectionObj->getSectionsBySubjectId($subjectId);

    if (!empty($sections)): ?>
        <div class="list-group">
            <?php foreach ($sections as $section): ?>
                <a href="#" class="list-group-item list-group-item-action">
                    Section ID: <?php echo htmlspecialchars($section['SectionID']); ?> - <?php echo htmlspecialchars($section['SectionName']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">No sections available for this subject.</div>
    <?php endif;
}
?>
