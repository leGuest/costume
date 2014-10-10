-- Insert dummy data
INSERT INTO costume
(name, hash_id)
VALUES ("Sailor Moon", "shgbvb35");

INSERT INTO tipper
(name)
VALUES ("John");

INSERT INTO  tipper_transaction
(id_tipper, id_costume, tokens_amount)
VALUES (1, 1, 100);

INSERT INTO total_token_costume
(id_costume, total)
VALUES (1, 100);

INSERT INTO total_token_tipper
(id_tipper, total)
VALUES (1,100);
