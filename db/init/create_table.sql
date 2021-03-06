USE jumpbot;

DROP TABLE IF EXISTS buyers;
CREATE TABLE buyers(
    id tinyint primary key auto_increment,
    name varchar(31),
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    deleted_at timestamp null default null
) ENGINE=InnoDB;

DROP TABLE IF EXISTS jumps;
CREATE TABLE jumps(
    id int primary key auto_increment,
    release_day date not null,
    price int not null,
    combined_issue boolean not null
) ENGINE=InnoDB;

DROP TABLE IF EXISTS buyer_jump;
CREATE TABLE buyer_jump(
    id int primary key auto_increment,
    buyer_id tinyint,
    jump_id int,
    bought boolean not null default 0,
    created_at timestamp not null default current_timestamp,
    updated_at timestamp not null default current_timestamp on update current_timestamp,
    foreign key (buyer_id) references buyers(id),
    foreign key (jump_id) references jumps(id)
) ENGINE=InnoDB;
