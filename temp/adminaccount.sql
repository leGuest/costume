INSERT INTO crew
(id, name, permission)
VALUES (2, "admin", "rwx");

INSERT INTO tipper
(name, mfcname, mail, bag, password, ip, created_at, updated_at, id_crew)
VALUES(
  "admin",
  "21232f297a57a5a743894a0e4a801fc3",
  "admin@admin.com",
  "9v360takjn8iavho5kddrd2ra6",
  "240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9",
  "12ca17b49af2289436f303e0166030a21e525d266e209267433801a8fd4071a0",
  "2014-10-13 02:33:25",
  "2014-10-13 02:33:25",
  1
);

UPDATE tipper
SET id_crew = 2
WHERE name = "admin";
