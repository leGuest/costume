-- Enable foreign keys
PRAGMA foreign_keys = ON;
PRAGMA foreign_keys;


-- Create tables
CREATE TABLE crew (
  id integer unique primary key autoincrement,
  name varchar(10),
  permission varchar(3) default 'r-x'
);

CREATE TABLE tipper (
  id integer unique primary key autoincrement,
  name varchar(255),
  mfcname varchar(255),
  mail text,
  bag varchar(255),
  password text,
  ip text,
  created_at varchar(255),
  updated_at varchar(255),
  id_crew integer default 1,
  foreign key(id_crew) references crew(id)
    on delete cascade
    on update cascade
);

CREATE TABLE status_costume (
  id integer unique primary key autoincrement,
  status text default "pending"
);

CREATE TABLE costume (
  id integer unique primary key autoincrement,
  name varchar(255),
  hash_id varchar(8),
  image text,
  id_status integer default 1,
  foreign key(id_status) references status_costume(id)
    on delete cascade
    on update cascade
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
