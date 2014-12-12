drop database if exists book;
create database book character set utf8 collate utf8_general_ci;
use book;
alter database character set utf8 collate utf8_general_ci;

create table user(
	id 		int not null primary key auto_increment,
	ime 		varchar(50) not null,
	prezime  	varchar(50) not null,
	username 	varchar(50) not null,
	email 		varchar(50) not null,
	pass  		char(32) not null,
	grad 		varchar(50) not null,
 	drzava 		varchar(50),
	ovlasti 	boolean not null,
	foto 		text,
	potvrda 	boolean not null	
)engine=innodb;

create table poruka(
	id 		int not null primary key auto_increment,
	posiljatelj 	int not null,
	primatelj 	int not null,
	vrijeme 	datetime not null,
	sadrzaj 	text not null,
	procitano 	boolean
)engine=innodb;

create table knjiga(
	id 		int not null primary key auto_increment,
	naziv 		varchar(100) not null,
	autor 		int not null,
	godina 		int,
	izdanje 	int,
	izdavac 	int,
	vlasnik 	int not null,
	ocijena 	int,
	status 		boolean
)engine=innodb;

create table izdavac(
	id 		int not null primary key auto_increment,
	naziv 		varchar(50) not null
)engine=innodb;

 create table autor(
	id 		int not null primary key auto_increment,
	ime 		varchar(50) not null
)engine=innodb;

create table zahtjev(
	knjiga 		int not null,
	posiljatelj 	int not null,
	primatelj 	int not null,
	ishod 		boolean not null,
	obrađen 	boolean not null
	
)engine=innodb;

create table posjed(
	knjiga 		int not null,
	user 		int not null,
	pocetak 	datetime,
	kraj 		datetime
)engine=innodb;
create table feedback(
	id 	 	int not null primary key auto_increment,
	sadrzaj 	text not null,
	user1  		int not null,
	user2		int not null
)engine=innodb;

create table komentar(
	id  		int not null primary key auto_increment,
	sadrzaj 	text not null,
	ocijena 	int not null
)engine=innodb;

create table chatporuka(
	id 		int not null primary key auto_increment,
	user 		int not null,
	sadrzaj  	text,
	vrijeme 	datetime not null
)engine=innodb;




alter table knjiga add foreign key (vlasnik) references user(id);
alter table knjiga add foreign key (izdavac) references izdavac(id);
alter table knjiga add foreign key (autor) references autor(id);

alter table posjed add foreign key (knjiga) references knjiga(id);
alter table posjed add foreign key (user) references user(id);

alter table zahtjev add foreign key (knjiga) references knjiga(id);
alter table zahtjev add foreign key (posiljatelj) references user(id);
alter table zahtjev add foreign key (primatelj) references user(id);

alter table poruka add foreign key (posiljatelj) references user(id);
alter table poruka add foreign key (primatelj) references user(id);



alter table feedback add foreign key (user1) references user(id);
alter table feedback add foreign key (user2) references user(id);

alter table chatporuka add foreign key (user) references user(id);

#1
insert into user(ime, prezime, username, email, pass, grad, ovlasti, potvrda) values('Mirko', 'Vadlja', 'keche89', 'mirko.vadlja@gmail.com', MD5('m'), 'Osijek', 1, 1);
#2
insert into user(ime, prezime, username, email, pass, grad, ovlasti, potvrda) values('Anita', 'Božičević', 'banita', 'anita.bozicevic@gmail.com', MD5('a'), 'Osijek', 0, 1);
#3
insert into user(ime, prezime, username, email, pass, grad, ovlasti, potvrda) values('Ivan', 'Mijač', 'mile', 'ivan@gmail.com', MD5('i'), 'Zagreb', 0, 1);
#4
insert into user(ime, prezime, username, email, pass, grad, ovlasti, potvrda) values('John', 'Doe', 'Seosko sunce', 'john.doe@gmail.com', MD5('0'), 'Osijek', 0, 1);



#1
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-24 12:22:01', 'probna poruka', 1 );
#2
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(3, 2, '2014-09-22 15:19:01', 'probna poruka broj 2', 0 );
#3
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 2, '2014-09-22 15:28:01', 'probna poruka broj 3', 0 );
#4
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(2, 1, '2014-09-22 15:15:01', 'probna poruka broj 6', 1 );
#5
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(3, 1, '2014-09-22 15:11:01', 'probna poruka broj 4', 0 );
#6
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-22 15:02:01', 'probna poruka broj 5', 1 );
#7
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-22 15:04:01', 'probna poruka broj 5', 1 );
#8
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 2, '2014-09-22 15:05:01', 'probna poruka broj 5', 1 );
#9
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-22 15:06:01', 'proporuka broj 5', 1 );
#10
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 3, '2014-09-22 15:07:01', 'probna pka broj 5', 0 );
#11
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-22 15:08:01', 'probnruka broj 5', 1 );
#12
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 2 , '2014-09-22 15:30:01', 'probna porukaoj 5', 0 );
#13
insert into poruka(primatelj, posiljatelj, vrijeme, sadrzaj, procitano) values(1, 4, '2014-09-22 15:29:01', 'probna pobr', 1 );


#1
insert into izdavac(naziv) values('Školska knjiga');
#2
insert into izdavac(naziv) values('mozaik');
#3
insert into izdavac(naziv) values('znanje');


#1
insert into autor(ime) values('August Šenoa');
#2
insert into autor(ime) values('Ivana Brlić-Mažuranić');
#3
insert into autor(ime) values('Ivo Andrić');



#1
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('na Drini čuprija', 3, 2014, 2, 2, 3, 0);
#2
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Puž', 2, 2002, 1, 3, 4, 1);
#3
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Vlak u snijegu', 2, 2004, 1, 3, 4, 0);
#4
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Ivica i Marica', 2, 2002, 1, 3, 4, 1);
#5
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Oblak', 3, 2002, 1, 3, 2, 0);
#6
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Bundeva žute boje', 2, 2002, 1, 2, 3, 1);
#7
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('pauk na krovu', 1, 1992, 1, 1, 2, 0);
#8
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Zeleni zid', 3, 2002, 1, 3, 1, 1);
#9
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Mali pas u ulici', 3, 2002, 1, 2, 4, 0);
#10
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('Drvo na brežuljku', 1, 2002, 1, 3, 4, 1);
#11
insert into knjiga(naziv, autor, godina, izdanje, izdavac, vlasnik, status) values('salata u kiselom', 2, 2002, 1, 2, 3, 0);


#1
insert into posjed(knjiga,user) values (1,3);
#2
insert into posjed(knjiga,user) values (2,4);
#3
insert into posjed(knjiga,user) values (2,1);

 





