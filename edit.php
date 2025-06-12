<?php
$users = get_users();
$user = current(array_filter($users, fn($u) => $u['email'] === $_SESSION['email']));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Your Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
            resize: vertical;
        }
        .explanation {
            color: #999;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        h3 {
            color: #444;
            margin-top: 20px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Your Page</h2>
        
        <div class="card">
            <h3>Basic Information</h3>
            <form method="post">
                <div class="form-group">
                    <label for="tab_title">Tab Title</label>
                    <input type="text" id="tab_title" name="tab_title" value="<?= htmlspecialchars($user['tab_title'] ?? '') ?>" placeholder="Enter the title that appears in the browser tab">
                    <div class="explanation">This is the title that appears in your browser's tab</div>
                </div>

                <div class="form-group">
                    <label for="favicon_url">Favicon URL</label>
                    <input type="url" id="favicon_url" name="favicon_url" value="<?= htmlspecialchars($user['favicon_url'] ?? '') ?>" placeholder="https://example.com/favicon.ico">
                    <div class="explanation">A small icon that appears in the browser tab (32x32 pixels recommended)</div>
                </div>

                <div class="form-group">
                    <label for="page_address">Page Address</label>
                    <input type="text" id="page_address" name="page_address" value="<?= htmlspecialchars($user['page_address'] ?? '') ?>" placeholder="Your custom page address">
                    <div class="explanation">Your unique page address (cannot contain spaces or special characters)</div>
                </div>
            </div>

            <div class="card">
                <h3>Profile Information</h3>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" placeholder="Your username">
                    <div class="explanation">Your public username (max 30 characters)</div>
                </div>

                <div class="form-group">
                    <label for="profile_picture">Profile Picture URL</label>
                    <input type="url" id="profile_picture" name="profile_picture" value="<?= htmlspecialchars($user['profile_picture'] ?? '') ?>" placeholder="https://example.com/image.jpg">
                    <div class="explanation">Direct link to your profile picture (recommended size: 200x200 pixels)</div>
                </div>

                <div class="form-group">
                    <label for="text1">Profile Description</label>
                    <textarea id="text1" name="text1" placeholder="Write your profile description here"><?= htmlspecialchars($user['text1'] ?? '') ?></textarea>
                    <div class="explanation">This text appears in your profile section. You can use basic HTML formatting.</div>
                </div>
            </div>

            <div class="card">
                <h3>Content Sections</h3>
                <div class="form-group">
                    <label for="main_title">Main Title</label>
                    <input type="text" id="main_title" name="main_title" value="<?= htmlspecialchars($user['main_title'] ?? '') ?>" placeholder="Your main content title">
                </div>

                <div class="form-group">
                    <label for="subtitle">Subtitle</label>
                    <input type="text" id="subtitle" name="subtitle" value="<?= htmlspecialchars($user['subtitle'] ?? '') ?>" placeholder="Your subtitle">
                </div>

                <div class="form-group">
                    <label for="section1_title">Section 1 Title</label>
                    <input type="text" id="section1_title" name="section1_title" value="<?= htmlspecialchars($user['section1_title'] ?? '') ?>" placeholder="Title for your first section">
                </div>

                <div class="form-group">
                    <label for="section1_content">Section 1 Content</label>
                    <textarea id="section1_content" name="section1_content" placeholder="Write your section content here"><?= htmlspecialchars($user['section1_content'] ?? '') ?></textarea>
                    <div class="explanation">You can use basic HTML formatting in this text</div>
                </div>

                <div class="form-group">
                    <label for="section2_title">Section 2 Title</label>
                    <input type="text" id="section2_title" name="section2_title" value="<?= htmlspecialchars($user['section2_title'] ?? '') ?>" placeholder="Title for your second section">
                </div>

                <div class="form-group">
                    <label for="section2_content">Section 2 Content</label>
                    <textarea id="section2_content" name="section2_content" placeholder="Write your section content here"><?= htmlspecialchars($user['section2_content'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="card">
                <h3>Social Media Links</h3>
                <div class="form-group">
                    <label for="link1">Social Media Link 1</label>
                    <input type="url" id="link1" name="link1" value="<?= htmlspecialchars($user['link1'] ?? '') ?>" placeholder="https://twitter.com/yourusername">
                </div>

                <div class="form-group">
                    <label for="link2">Social Media Link 2</label>
                    <input type="url" id="link2" name="link2" value="<?= htmlspecialchars($user['link2'] ?? '') ?>" placeholder="https://github.com/yourusername">
                </div>
            </div>

            <div class="form-group">
                <button type="submit">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>
