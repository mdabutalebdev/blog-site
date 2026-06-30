USE amr_blog;

-- Password for all users is 'password'
INSERT INTO users (name, email, password_hash) VALUES 
('BlogSite Admin', 'admin@BlogSite.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Jane Doe', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO posts (author_id, title, slug, content, category) VALUES 
(1, 'Welcome to BlogSite Platform', 'welcome-to-BlogSite', '<p>Hello world! This is the first official post on the <strong>BlogSite Blog Platform</strong>.</p><p>We have built this platform using PHP 8, Tailwind CSS, and Vanilla JS for a smooth, app-like experience.</p>', 'Technology'),
(2, 'The Future of Web Development', 'future-of-web-dev', '<p>Web development is moving fast. We are seeing a trend towards more component-based architectures even in traditional server-rendered languages like PHP.</p>', 'Programming');

INSERT INTO comments (post_id, user_id, content) VALUES 
(1, 2, 'Great platform! Looks amazing.'),
(2, 1, 'Totally agree with you.');
