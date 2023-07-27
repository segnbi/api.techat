create table comment_scored (
  id int unsigned auto_increment,
  comment_id int unsigned,
  user_id int unsigned,
  primary key (id)
);