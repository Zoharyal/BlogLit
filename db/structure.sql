drop table if exists t_chapter;
drop table if exists t_comment;
drop table if exists t_user;

create table t_chapter (
chap_id integer not null primary key auto_increment,
chap_title varchar(100) not null,
chap_content varchar(4000) not null,
chap_dateAjout date not null
) engine=innodb character set utf8 collate utf8_unicode_ci;



create table t_comment (
    com_id integer not null primary key auto_increment,
    com_content varchar(500) not null,
    parent_id integer not null,
    chap_id integer not null,
    com_date date not null,
    com_author varchar(150) not null,
    constraint fk_com_chap foreign key(chap_id) references t_chapter(chap_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_user (
    usr_id integer not null primary key auto_increment,
    usr_name varchar(50) not null,
    usr_password varchar(88) not null,
    usr_salt varchar(23) not null,
    usr_role varchar(50) not null 
) engine=innodb character set utf8 collate utf8_unicode_ci;