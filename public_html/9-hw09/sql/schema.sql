-- Mock user data
SET search_path TO stephen;
/* 
alice's password: alicePass123
bob's password: bobSecureP@ss
charlie's password: charlieR0cks!
*/


INSERT INTO book_users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Alice Wonderland', 'alice@example.com', CURRENT_TIMESTAMP, '$2y$12$rmhoAyzZ3VTv1X05zJY.K.fPJblThDwkHNQhyS0Tgk9bQLFskXq.m', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO book_users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Bob The Builder', 'bob@example.com', CURRENT_TIMESTAMP, '$2y$12$HhkvCuGQx7FY00MnGFfcXOSnlykDS3cfJQTX1UabuLnC/DELMwLj6', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

INSERT INTO book_users (name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES
('Charlie Brown', 'charlie@example.com', CURRENT_TIMESTAMP, '$2y$12$23r2ig6wmPI7e/LqUHUnMePNJ2C407WuqS8V1K69CPqamB3LDEeci', NULL, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Books for Alice (user_id = 1)
INSERT INTO books (title, book_condition, price, user_id, created_at, updated_at) VALUES
('The Great Gatsby', '3', 10.99, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('To Kill a Mockingbird', '4', 15.50, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Adventures in Wonderland', '2', 8.75, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Books for Bob (user_id = 2)
INSERT INTO books (title, book_condition, price, user_id, created_at, updated_at) VALUES
('1984', '4', 7.25, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Brave New World', '3', 9.00, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Building for Dummies', '1', 19.99, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- Books for Charlie (user_id = 3)
INSERT INTO books (title, book_condition, price, user_id, created_at, updated_at) VALUES
('Pride and Prejudice', '3', 22.00, 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('The Catcher in the Rye', '2', 12.75, 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Peanuts Collection', '4', 25.00, 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

-- More diverse books
INSERT INTO books (title, book_condition, price, user_id, created_at, updated_at) VALUES
('Dune', '4', 18.50, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('The Hobbit', '3', 11.20, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('Moby Dick', '1', 5.99, 3, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('War and Peace', '2', 14.30, 1, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
('The Lord of the Rings', '4', 29.99, 2, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);