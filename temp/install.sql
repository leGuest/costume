-- Enable foreign keys
PRAGMA foreign_keys = ON;
PRAGMA foreign_keys;


-- Create tables
CREATE TABLE tipper (
  id integer unique primary key autoincrement,
  name varchar(255)
);

CREATE TABLE costume (
  id integer unique primary key autoincrement,
  name varchar(255),
  hash_id varchar(8),
  image text
);

CREATE TABLE tipper_transaction (
  id integer primary key,
  id_tipper integer,
  id_costume integer,
  tokens_amount integer,
  foreign key(id_tipper) references tipper(id)
    on delete cascade
    on update cascade,
  foreign key(id_costume) references costume(id)
    on delete cascade
    on update cascade
);

CREATE TABLE total_token_costume (
  id integer primary key autoincrement,
  id_costume integer,
  total integer,
  foreign key(id_costume) references costume(id)
    on delete cascade
    on update cascade
);

CREATE TABLE total_token_tipper (
  id integer primary key autoincrement,
  id_tipper integer,
  total integer,
  foreign key(id_tipper) references tipper(id)
    on delete cascade
    on update cascade
);
