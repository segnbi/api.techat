-- create table comments (
--   id int unsigned auto_increment,
--   content text,
--   created_at timestamp,
--   primary key (id)
-- )engine=innodb;

-- alter table comments add replying_to_comment int unsigned;

-- alter table comments add user_id int unsigned;

-- alter table comments add constraint fk_user_id foreign key(user_id) references users(id);

-- alter table comments add score int unsigned default 0;