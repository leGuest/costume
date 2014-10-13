-- Insert dummy data
INSERT INTO status_costume
(id)
VALUES (1);

INSERT INTO status_costume
(status)
VALUES ("published");

INSERT INTO status_costume
(status)
VALUES ("denied");

INSERT INTO costume
(name, hash_id)
VALUES ("Sailor Moon", "shgbvb35");

INSERT INTO crew
(id, name)
VALUES (1, "user");

INSERT INTO tipper
(name, mfcname, mail, bag, password, ip, created_at, updated_at)
VALUES (
  "John",
  "kljhghu654az3g1",
  "John@doe.org",
  "adqdsf654z8a7r32zea1t",
  "za4rg653qsg4567a3zer41fq87er32",
  "kqsdf16s5f4qs6ze2e1aze3r24az65",
  "2014-08-12 12:15:20",
  "2014-08-12 12:15:20"
);

INSERT INTO  tipper_transaction
(id_tipper, id_costume, tokens_amount)
VALUES (1, 1, 100);

INSERT INTO total_token_costume
(id_costume, total)
VALUES (1, 100);

INSERT INTO total_token_tipper
(id_tipper, total)
VALUES (1,100);
