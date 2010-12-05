create database healthmonitor_db;
create  user zyxware;
grant all on healthmonitor_db.* to 'zyxware'@'192.168.1.%' 
identified by 'user0123';
use healthmonitor_db;
create table user
(
	username varchar(25) NOT NULL,
	PRIMARY KEY(username),
	userpasswd varchar(42),
	status varchar(20),
	usertype varchar(25),
	lastlogin timestamp,
	index(username)
)engine=innodb;
create table state
(
	stateid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(stateid),
	name varchar(50),
	latitude float(12,8),
	longitude float(12,8),
	latstart float(12,8),
	longstart float(12,8),
	latend float(12,8),
	longend float(12,8),
	index(stateid)
)engine=innodb;
create table district
(
	districtid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(districtid),
	stateid int,
	name varchar(50),
	latitude float(12,8),
	longitude float(12,8),
	latstart float(12,8),
	longstart float(12,8),
	latend float(12,8),
	longend float(12,8),
	index(districtid),
	index(stateid),
	FOREIGN KEY (stateid) REFERENCES  state (stateid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table dao
(
	daoid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(daoid),
	name varchar(50),
	designation varchar(100),
	username varchar(25),
	emailid varchar(150),
	address1 varchar(100),
	address2 varchar(100),
	phonenumber varchar(15),
	mobilenumber varchar(15),
	districtid int,
	stateid int,
	status varchar(20),
	index(username),
	FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE,
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table gmo
(
	gmoid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(gmoid),
	name varchar(50),
	designation varchar(25),
	username varchar(25),
	emailid varchar(150),
	officeaddress1 varchar(100),
	officeaddress2 varchar(100),
	officephno1 varchar(15),
	officephno2 varchar(15),
	mobilenumber varchar(15),
	districtid int,
	stateid int,
	status varchar(20),	
	index(username),
	FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE,
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table hospital
(
	hospitalid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(hospitalid),
	name varchar(50),
	username varchar(25),
	emailid varchar(150),
	registerno varchar(25),
	hospitaladdress1 varchar(100),
	hospitaladdress2 varchar(100),
	hospitalphno1 varchar(15),
	hospitalphno2 varchar(15),
	mobilenumber varchar(15),
	pincode int,
	districtid int,
	stateid int,
	status varchar(20),	 
	index(username),
	FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE,
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table disease
(
	diseaseid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(diseaseid),
	name varchar(50),
	imagename varchar(50),
	description text,
	symptoms text,
	precaution text,
	medication text,
	specialadvice text
)engine=innodb;
create table postoffice
(
	postofficeid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(postofficeid),
	name varchar(50),
	latitude float(12,8),
	longitude float(12,8),
	districtid int,
	pincode int,
	index(postofficeid),
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table newpostoffice
(
	postofficeid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(postofficeid),
	name varchar(50),
	districtid int,
	pincode int,
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table casereport
(
	casereportid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(casereportid),
	username varchar(25),
	hospitalid INT,
	districtid INT,
	postofficeid INT,
	diseaseid INT,
	fatal varchar(20),
	reportedon date,
	diedon date,
	casedate date,
	name varchar(50),
	age int,
	sex varchar(10),
	address1 varchar(100),
	address2 varchar(100),
	pincode int,
	createdon date,
	index(hospitalid),
	FOREIGN KEY (hospitalid) REFERENCES hospital (hospitalid)  ON DELETE CASCADE ON UPDATE CASCADE,
	index(diseaseid),
	FOREIGN KEY (diseaseid) REFERENCES disease (diseaseid)  ON DELETE CASCADE ON UPDATE CASCADE,
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON UPDATE CASCADE,
	index(postofficeid),
	FOREIGN KEY (postofficeid) REFERENCES postoffice (postofficeid) ON UPDATE CASCADE
)engine=innodb;
create table mapimage
(
	mapimagesid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(mapimagesid),
	width int,
	height int,
	imagename varchar(50),
	filename varchar(50),
	latstart float(12,8),
	longstart float(12,8),
	latend float(12,8),
	longend float(12,8),
	stateid INT,
	districtid INT,	
	index(districtid),
	FOREIGN KEY (districtid) REFERENCES district (districtid) ON DELETE CASCADE ON UPDATE CASCADE
)engine=innodb;
create table kmlfile
(
	kmlfileid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(kmlfileid),
	filename varchar(50),
	lastupdate date,
	filedata varchar(50),
	status varchar(25)
)engine=innodb;
create table dummycasereport
(
	casereportid INT NOT NULL AUTO_INCREMENT,
	username varchar(25),
	hospitalname varchar(100),
	districtname varchar(100),
	postofficename varchar(100),
	diseasename varchar(100),
	fatal varchar(20),
	reportedon date,
	diedon date,
	casedate date,
	name varchar(50),
	age int,
	sex varchar(10),
	address1 varchar(100),
	address2 varchar(100),
	pincode int,
	createdon date,
	PRIMARY KEY(casereportid)
)engine=innodb;
create table eventlog
(
	eventlogid INT NOT NULL AUTO_INCREMENT,
	primary key(eventlogid),
	event varchar(30),
	eventtype varchar(50),
	username varchar(25),
	eventtime timestamp,
	description varchar(100)	
)engine=innodb;
create table bulkcase
(
	bulkcaseid INT NOT NULL AUTO_INCREMENT,
	PRIMARY KEY(bulkcaseid),
	username varchar(25),
	districtid INT,
	diseaseid INT,
	reportedcase INT,	
	fatalcase INT,
	createdon date	
)engine=innodb;


