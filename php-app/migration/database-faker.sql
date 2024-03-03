-- insert main "admin" user with password "admin"
INSERT INTO users(username, profile_name, password_hashed, role) VALUES ('admin', 'admin', '$2y$10$nl3.uDTAK0wbkNUr6JwZ1OG6dzh0HilmzK3QZXwARbz2oP71mR3zO', 'admin');

INSERT INTO users(username, profile_name, password_hashed, role)
SELECT
  LEFT(md5(random()::text), 10),
  LEFT(md5(random()::text), 10),
  LEFT(md5(random()::text), 10),
  'user'
FROM generate_series(1, 10000);