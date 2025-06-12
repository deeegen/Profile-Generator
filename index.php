<?php
// users.json handler functions
function get_users() {
    $file = __DIR__.'/users.json';
    if (!file_exists($file)) file_put_contents($file, '[]');
    return json_decode(file_get_contents($file), true) ?: [];
}

function save_users($users) {
    file_put_contents(__DIR__.'/users.json', json_encode($users, JSON_PRETTY_PRINT));
}

// Template processing
function parse_custom_tags($text) {
    $text = preg_replace('/\[link href="(.*?)"\](.*?)\[\/link\]/i', '<a href="$1">$2</a>', $text);
    $text = preg_replace('/\[bold\](.*?)\[\/bold\]/i', '<strong>$1</strong>', $text);
    $text = preg_replace('/\[italics\](.*?)\[\/italics\]/i', '<em>$1</em>', $text);
    $text = preg_replace('/\[strike\](.*?)\[\/strike\]/i', '<del>$1</del>', $text);
    return $text;
}

function generate_user_files($email, $user) {
    $sanitized = preg_replace('/[^a-z0-9]/i', '_', $email);
    $dir = __DIR__."/users/$sanitized";
    if (!is_dir($dir)) mkdir($dir, 0755, true);
    
    $templates = [
        'index.html' => '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>%tab_title%</title>
  <link rel="stylesheet" href="%css_path%" />
</head>
<body>
  <header class="header">
    <h1>%name%</h1>
    <audio id="audio" controls crossorigin="anonymous"></audio>
    <ul id="playlist"></ul>
  </header>

  <section class="grid">
    <div class="iframe-overlay" id="iframeOverlay">
      <div class="close-btn" id="closeOverlay">×</div>
      <iframe id="iframeContent" src=""></iframe>
    </div>

    <div class="side-container">
      <div class="profile">
        <div class="profile-picture-container">
          <img src="%profile_picture%" alt="Profile picture" class="profile-img" />
        </div>
        <h2>@%username%</h2>
        <div class="status">%text1%</div>
        <p>Share a short bio or tagline here.</p>

        <div class="social-links">
          <a href="%link1%" target="_blank" class="social-btn" title="Twitter">
            <img src="" alt="Twitter" />
          </a>
          <a href="%link2%" target="_blank" class="social-btn" title="GitHub">
            <img src="" alt="GitHub" />
          </a>
          <a href="#" target="_blank" class="social-btn" title="LinkedIn">
            <img src="" alt="LinkedIn" />
          </a>
        </div>
      </div>

      <div class="media">
        <img src="" alt="Media Image" />
        <p><strong>Interests:</strong></p>
        <p>- Interest one</p>
        <p>- Interest two</p>
        <p>- Interest three</p>
      </div>

      <button id="openBlog" class="blog-btn">Open Blog</button>
    </div>

    <div class="main">
      <div class="main-text">
        <div class="title">%main_title%</div>
        <div class="subtitle">%subtitle%</div>
      </div>

      <div class="main-content-section">
        <h3>%section1_title%</h3>
        <p>%section1_content%</p>
      </div>

      <div class="main-content-section">
        <h3>%section2_title%</h3>
        <ul>
          <li>First item</li>
          <li>Second item</li>
          <li>Third item</li>
        </ul>
      </div>
    </div>
  </section>
</body>
</html>',
        
        'style.css' => '/* ============================
   1. BASIC SETUP FOR ALL ELEMENTS
   ============================ */

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
  background-color: var(--color-background);
  color: var(--color-text);
}

a {
  text-decoration: none;
  color: inherit;
}

/* ============================
   2. COLORS, SIZES & SPACES YOU CAN CHANGE EASILY
   ============================ */

:root {
  --color-background: #fafafa;
  --color-surface: #ffffff;
  --color-border: #e0e0e0;
  --color-text: #333333;
  --color-muted: #666666;
  --color-muted-bg: #f5f5f5;
  --color-hover-bg: #eaeaea;
  --color-focus: #005fcc;
  --border-radius: 8px;
  --box-shadow-light: 0 2px 4px rgba(0, 0, 0, 0.05);
  --box-shadow-hover: 0 4px 8px rgba(0, 0, 0, 0.1);
  --spacing-xs: 4px;
  --spacing-s: 6px;
  --spacing-m: 10px;
  --spacing-l: 20px;
  --font-size-base: 1rem;
  --font-size-small: 0.95rem;
  --font-size-large: 1.1rem;
  --font-size-xl: 1.5rem;
  --font-size-xxl: 2rem;
}

/* ============================
   3. BOX STYLES (CARDS & SECTIONS)
   ============================ */

.surface {
  background-color: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow-light);
}

header,
.side-container,
.main,
.media,
.main-content-section {
  background-color: var(--color-surface);
  border: 1px solid var(--color-border);
  border-radius: var(--border-radius);
  box-shadow: var(--box-shadow-light);
}

/* ============================
   4. PAGE LAYOUT
   ============================ */

.grid {
  display: grid;
  grid-template-areas: "side main";
  grid-template-columns: 1fr 2fr;
  gap: var(--spacing-l);
  padding: var(--spacing-l);
  max-width: 1200px;
  margin: 0 auto;
}

.side-container {
  grid-area: side;
  padding: var(--spacing-l);
  display: flex;
  flex-direction: column;
  gap: var(--spacing-l);
}

.main {
  grid-area: main;
  padding: var(--spacing-l);
  display: flex;
  flex-direction: column;
  gap: var(--spacing-l);
}

/* ============================
   5. HEADER (TOP OF THE PAGE)
   ============================ */

.header {
  text-align: center;
  padding: 1.5rem var(--spacing-l);
  margin-bottom: var(--spacing-l);
}

.header h1 {
  font-size: var(--font-size-xxl);
  margin-bottom: var(--spacing-s);
}

.header audio {
  width: 100%;
  max-width: 360px;
  height: 50px;
  margin: 0 auto;
  display: block;
  border-radius: 4px;
  border: none;
}

#playlist {
  list-style: none;
  display: flex;
  flex-wrap: wrap;
  gap: var(--spacing-m);
  justify-content: center;
  margin-top: var(--spacing-s);
}

#playlist li {
  background-color: var(--color-muted-bg);
  border: 1px solid var(--color-border);
  border-radius: 6px;
  padding: var(--spacing-s) var(--spacing-l);
  cursor: pointer;
  font-size: var(--font-size-small);
  color: var(--color-text);
  user-select: none;
  transition: background-color 0.2s, box-shadow 0.2s;
  white-space: nowrap;
}

#playlist li:hover,
#playlist li:focus {
  background-color: var(--color-hover-bg);
  box-shadow: var(--box-shadow-hover);
  outline: none;
}

#playlist li.selected {
  background-color: #ddd;
  border-color: #bbb;
  font-weight: 600;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* ============================
   6. PROFILE (SIDE BAR)
   ============================ */

.profile {
  text-align: center;
  padding: var(--spacing-l);
}

.profile-picture-container {
  display: inline-block;
  position: relative;
  margin-bottom: var(--spacing-s);
}

.profile-picture-container .profile-img {
  width: 7.5rem;
  height: 7.5rem;
  border-radius: 50%;
  border: 2px solid var(--color-border);
}

.profile h2 {
  font-size: var(--font-size-xl);
  margin-bottom: var(--spacing-s);
}

.status {
  display: inline-block;
  padding: var(--spacing-xs) var(--spacing-m);
  border-radius: 12px;
  font-size: var(--font-size-small);
  border: 1px solid var(--color-border);
  background-color: var(--color-muted-bg);
}

.profile p {
  margin-top: var(--spacing-s);
  font-size: var(--font-size-small);
}

/* ============================
   7. SOCIAL LINKS (SIDE BAR)
   ============================ */

.social-links {
  display: flex;
  justify-content: center;
  gap: var(--spacing-m);
  margin-top: var(--spacing-s);
}

.social-btn {
  width: 40px;
  height: 40px;
  border: 1px solid var(--color-border);
  border-radius: 50%;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.2s, box-shadow 0.2s;
}

.social-btn:hover,
.social-btn:focus {
  transform: translateY(-2px);
  box-shadow: var(--box-shadow-hover);
  outline: none;
}

.social-btn img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.blog-btn {
  display: block;
  margin: 10px auto;
  width: 80%;
  padding: 12px 20px;
  font-size: 16px;
  color: #333;
  background-color: #f0f0f0;
  border: 2px solid #ccc;
  border-radius: 6px;
  filter: grayscale(100%);
  transition: all 0.3s ease;
  cursor: pointer;
}

.blog-btn:hover {
  background-color: #e0e0e0;
  filter: grayscale(60%);
}

/* ============================
   8. MEDIA SECTION (SIDE BAR)
   ============================ */

.media {
  padding: var(--spacing-l);
  display: flex;
  flex-direction: column;
  gap: var(--spacing-s);
  overflow-y: auto;
}

.media img {
  width: 100%;
  max-width: 200px;
  border: 1px solid var(--color-border);
  border-radius: 4px;
}

.media p {
  font-size: var(--font-size-small);
}

/* ============================
   9. MAIN CONTENT SECTIONS
   ============================ */

.main-text {
  text-align: center;
  margin-bottom: var(--spacing-l);
}

.main-text .title {
  font-size: 1.8rem;
  margin-bottom: var(--spacing-s);
}

.main-text .subtitle {
  font-size: var(--font-size-large);
  color: var(--color-muted);
}

.main-content-section {
  padding: var(--spacing-l);
}

.main-content-section h3 {
  font-size: 1.3rem;
  margin-bottom: var(--spacing-s);
  border-bottom: 1px solid var(--color-border);
  padding-bottom: var(--spacing-xs);
}

.main-content-section p,
.main-content-section li {
  margin-bottom: var(--spacing-s);
  font-size: var(--font-size-small);
}

.main-content-section ul {
  list-style: disc;
  margin-left: var(--spacing-l);
}

/* ============================
   10. POP-UP OVERLAY (IFRAME MODAL)
   ============================ */

.iframe-overlay {
  display: none;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 999;
}

.iframe-overlay.active {
  display: flex;
}

.iframe-overlay iframe {
  width: 90%;
  height: 90%;
  border: none;
  border-radius: 4px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.iframe-overlay .close-btn {
  position: absolute;
  top: var(--spacing-l);
  right: var(--spacing-l);
  font-size: 1.5rem;
  cursor: pointer;
  background: transparent;
  border: none;
}

/* ============================
   11. HOW TO SEE FOCUSED ELEMENTS (KEYBOARD NAVIGATION)
   ============================ */

a:focus,
button:focus,
#playlist li:focus,
.social-btn:focus {
  outline: 2px solid var(--color-focus);
  outline-offset: 2px;
}',
        
        'script.js' => 'console.log("User page loaded");',
        
        'blog.html' => '<!DOCTYPE html>
<html>
<head>
  <title>Blog - %tab_title%</title>
  <link rel="stylesheet" href="%css_path%" />
</head>
<body>
  <h2>Blog</h2>
  <div>%text2%</div>
  <a href="%link2%">More</a>
</body>
</html>'
    ];
    
    foreach ($templates as $file => $template) {
        $content = $template;
        // Replace placeholders
        $content = str_replace('%name%', $user['name'] ?? '', $content);
        $content = str_replace('%favicon_url%', $user['favicon_url'] ?? '', $content);
        $content = str_replace('%tab_title%', $user['tab_title'] ?? '', $content);
        $content = str_replace('%text1%', parse_custom_tags($user['text1'] ?? ''), $content);
        $content = str_replace('%text2%', parse_custom_tags($user['text2'] ?? ''), $content);
        $content = str_replace('%link1%', $user['link1'] ?? '#', $content);
        $content = str_replace('%link2%', $user['link2'] ?? '#', $content);
        // New placeholders
        $content = str_replace('%profile_picture%', $user['profile_picture'] ?? '', $content);
        $content = str_replace('%username%', $user['username'] ?? '', $content);
        $content = str_replace('%main_title%', $user['main_title'] ?? 'Main Title', $content);
        $content = str_replace('%subtitle%', $user['subtitle'] ?? 'Subtitle goes here', $content);
        $content = str_replace('%section1_title%', $user['section1_title'] ?? 'Section Title', $content);
        $content = str_replace('%section1_content%', parse_custom_tags($user['section1_content'] ?? 'Write your content here.'), $content);
        $content = str_replace('%section2_title%', $user['section2_title'] ?? 'Another Section', $content);
        
        // Replace CSS path placeholder
        $css_path = "../users/$sanitized/lib/style.css";
        $content = str_replace('%css_path%', $css_path, $content);
        
        // Handle file paths
        $filepath = "$dir/$file";
        if ($file === 'style.css') {
            $lib_dir = "$dir/lib";
            if (!is_dir($lib_dir)) {
                mkdir($lib_dir, 0755, true);
            }
            $filepath = "$lib_dir/$file";
        }
        
        if (!file_put_contents($filepath, $content)) {
            die("Failed to create file: $filepath");
        }
    }
}

// Routing
session_start();
$action = $_GET['action'] ?? 'signup';

switch ($action) {
    case 'signup':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("Invalid email");
            }
            
            $users = get_users();
            if (array_filter($users, fn($u) => $u['email'] === $email)) {
                die("Email exists");
            }
            
            $users[] = ['email' => $email, 'password' => $password];
            save_users($users);
            $_SESSION['email'] = $email;
            header('Location: ?action=initial_info');
            exit;
        }
        include __DIR__.'/signup.php';
        break;

    case 'initial_info':
        if (!isset($_SESSION['email'])) header('Location: ?action=signup');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $users = get_users();
            foreach ($users as &$user) {
                if ($user['email'] === $_SESSION['email']) {
                    $user['name'] = $_POST['name'];
                    $user['favicon_url'] = $_POST['favicon_url'];
                    $user['tab_title'] = $_POST['tab_title'];
                    break;
                }
            }
            save_users($users);
            generate_user_files($_SESSION['email'], $user);
            header('Location: ?action=dashboard');
            exit;
        }
        include __DIR__.'/initial_info.php';
        break;

    case 'dashboard':
        if (!isset($_SESSION['email'])) header('Location: ?action=signup');
        include __DIR__.'/dashboard.php';
        break;

    case 'edit':
        if (!isset($_SESSION['email'])) header('Location: ?action=signup');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $users = get_users();
            foreach ($users as &$user) {
                if ($user['email'] === $_SESSION['email']) {
                    $user = array_merge($user, $_POST);
                    break;
                }
            }
            save_users($users);
            generate_user_files($_SESSION['email'], $user);
            header('Location: ?action=dashboard');
            exit;
        }
        include __DIR__.'/edit.php';
        break;

    case 'preview':
        $email = $_GET['user'] ?? '';
        $sanitized = preg_replace('/[^a-z0-9]/i', '_', $email);
        $filepath = __DIR__."/users/$sanitized/index.html";
        if (!file_exists($filepath)) {
            http_response_code(404);
            die('File not found');
        }
        header('Content-Type: text/html');
        readfile($filepath);
        exit;
}
?>
