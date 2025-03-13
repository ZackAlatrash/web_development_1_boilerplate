<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resource Management</title>
    <link rel="stylesheet" href="../../assets/css/resources_styles.css">
    <link rel="stylesheet" href="../../assets/css/navbar_styles.css">
</head>
<body>
    <?php
        $activePage = 'resources';
        require_once(__DIR__ . '/../partials/navbar.php');
    ?>

    <div class="resources-container">
        <h1>Resource Management</h1>

        <!-- Subject Info Section -->
        <div id="subjectDetails" class="subject-details hidden">
            <h2>Subject Details</h2>
            <p><strong>Subject:</strong> <span id="selectedSubjectName">N/A</span></p>
            <p><strong>Description:</strong> <span id="selectedSubjectDescription">No description available.</span></p>
        </div>

        <!-- Upload Resource Form -->
        <div class="upload-resource">
            <h2>Upload Resource</h2>
            <form id="uploadResourceForm" enctype="multipart/form-data">
                <div>
                    <label for="subjectDropdown">Select Subject:</label>
                    <select id="subjectDropdown" name="subject_id" required>
                        <option value="">-- Select Subject --</option>
                    </select>
                </div>

                <div>
                    <label for="resourceType">Resource Type:</label>
                    <select id="resourceType" name="type" required>
                        <option value="">-- Select Type --</option>
                        <option value="file">File</option>
                        <option value="link">Link</option>
                        <option value="note">Note</option>
                    </select>
                </div>

                <div id="fileInput" class="form-input hidden">
                    <label for="file">Upload File:</label>
                    <input type="file" id="file" name="file">
                </div>

                <div id="linkInput" class="form-input hidden">
                    <label for="link">Enter Link:</label>
                    <input type="url" id="link" name="resource_path" placeholder="https://example.com">
                </div>

                <div id="noteInput" class="form-input hidden">
                    <label for="note">Add Note:</label>
                    <textarea id="note" name="note" rows="4" placeholder="Enter your note"></textarea>
                </div>

                <button type="submit" class="btn">Upload Resource</button>
            </form>
            <p id="uploadResponse"></p>
        </div>

        <!-- Search and Filter -->
        <div class="resource-filters">
            <input type="text" id="searchResources" placeholder="Search Resources">
            <select id="filterType">
                <option value="">All Types</option>
                <option value="file">File</option>
                <option value="link">Link</option>
                <option value="note">Note</option>
            </select>
        </div>

        <!-- Resource List -->
        <div class="resource-list">
            <h2>Resource Library</h2>
            <table id="resourceTable">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Associated Task/Subject</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script src="../../assets/js/resources.js"></script>
</body>
</html>
