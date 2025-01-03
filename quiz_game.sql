-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT  AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL UNIQUE,
    password VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create questions table
CREATE TABLE IF NOT EXISTS questions (
    id INT  AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answers JSON NOT NULL,
    correct_answer INT NOT NULL,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


-- Insert categories
INSERT INTO categories (name, description) VALUES
('Science', 'Questions sur la science, la physique, la biologie et plus'),
('Films', 'Questions sur le cinéma, les acteurs et les films'),
('Jeux', 'Questions sur les jeux vidéo et autres jeux'),
('Culture Générale', 'Questions de culture générale variées'),
('Voyage', 'Questions sur les pays, la géographie et les cultures');

-- Insert questions with category references
INSERT INTO questions (question, answers, correct_answer, category_id) VALUES
-- Science
('Quelle est la formule chimique de l''eau?', '["H2O", "CO2", "O2", "H2SO4"]', 0, 1),
('Quelle planète est surnommée la planète rouge?', '["Venus", "Mars", "Jupiter", "Saturne"]', 1, 1),
-- Films
('Qui a réalisé le film "Titanic"?', '["Steven Spielberg", "James Cameron", "Christopher Nolan", "Martin Scorsese"]', 1, 2),
('En quelle année est sorti le premier Star Wars?', '["1975", "1977", "1980", "1983"]', 1, 2),
-- Jeux
('Quel est le personnage principal de Mario Bros?', '["Luigi", "Mario", "Bowser", "Yoshi"]', 1, 3),
('Quelle entreprise a créé la PlayStation?', '["Microsoft", "Nintendo", "Sony", "Sega"]', 2, 3),
-- Voyage
('Quelle est la plus grande ville d''Australie?', '["Melbourne", "Sydney", "Brisbane", "Perth"]', 1, 5),
('Dans quel pays se trouve la Tour de Pise?', '["France", "Espagne", "Italie", "Grèce"]', 2, 5),
-- Culture Générale
('Quel est le symbole chimique de l''or?', '["Ag", "Fe", "Au", "Cu"]', 2, 4),
('Qui a écrit "Les Misérables"?', '["Émile Zola", "Victor Hugo", "Gustave Flaubert", "Alexandre Dumas"]', 1, 4);

-- Create scores table for tracking user performance
CREATE TABLE IF NOT EXISTS scores (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    played_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

ADD COLUMN is_admin BOOLEAN DEFAULT FALSE;

-- Make your test user an admin
UPDATE users SET is_admin = TRUE WHERE email = 'maevabouvard@gmail.com';
