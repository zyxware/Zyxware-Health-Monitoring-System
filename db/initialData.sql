use healthmonitor_db;
insert into user(username, userpasswd, status, usertype, lastlogin) values('admin0123', password('zyxware'), 'Approved', 'ADMIN', now());
insert into user(username, userpasswd, status, usertype, lastlogin) values('gmo0123', password('zyxware'), 'Approved', 'GMO', now());
insert into user(username, userpasswd, status, usertype, lastlogin) values('dao0123', password('zyxware'), 'Approved', 'DAO', now());
/*insert into user(username, userpasswd, status, usertype, lastlogin) values('hospital', password('zyxware'), 'Approved', 'HOSPITAL', now());
insert into user (username, userpasswd, status, usertype, lastlogin) values('prshospital',password('prshospital'),'Approved','HOSPITAL',now());*/


insert into state(name, latitude, longitude, latstart, longstart, latend, longend) values('Kerala', '8.503696', '76.952187',  '12.688573980262326', '74.9322509765625','8.233237111274553', '77.2393798828125');

insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(1,'Thiruvananthapuram','8.503696','76.952187','9.51745950452','76.6352466402','8.650915391725','76.77083523207999');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(2,'Kollam','8.886121','76.588096','9.73409553272','76.5368784461','8.714100899950001','76.64056383991999');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(3,'Pathanamthitta','9.260591','76.815277','9.77020153742','76.4438274517','8.687021396425','76.55548864504');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(4,'Alappuzha','9.490368','76.326492','10.0229435703','76.3348248583','9.6348040198','76.5421956458');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(5,'Kottayam','9.586446','76.521797','9.9236520574','76.3321662584','9.6709100245','76.4597790508');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(6,'Idukki','9.85','76.966667','9.61675101745','76.1939190667','8.70507439877','76.4996580484');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(7,'Ernakulam','10.01486','76.303467','10.212500095','76.2098706658','9.8875460527','76.34811785752');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(8,'Thrissur ','10.50792','76.209389','10.492321631425','76.07959927368','9.697989528025001','76.20189486631999');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(9,'Palakkad','10.76815','76.647812','10.41108312085','75.95730368104','9.354982483375','76.18860186712');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(10,'Malappuram','11.00579','76.012283','10.7901961702','75.89349728488','10.4652421279','76.09555087272');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(11,'Kozhikode','11.2554','75.781212','11.0790442078','75.78981189112','10.203473593825','75.92805908279999');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(12,'Wayanad','11.56194','76.143478','10.745063664325','75.73663989431999','9.806307542125001',	'75.86956988632');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(13,'Kannur','11.8553','75.361618','11.5845282736','75.65688189912','10.510374633775001','75.79247049096');
insert into district(districtid,name,latitude,longitude,latstart, longstart, latend, longend) values(14,'Kasaragod','12.49247','74.990623','11.936561819425','75.49470730888','11.16930921955','75.6489060996');


/*insert into dao values (1, 'Vijayan', 'Data entry officer', 'dao0123','dao0123@gmail.com', 'addressss1', 'addressss',  '04712122323', '9465665656',1, 1, 'Approved');

insert into gmo values (1, 'Rajan', 'DMO', 'gmo0123', 'gmo0123@gmail.com', 'address1', 'address', '04712356547', '04712356874', '09856544551',1,1, 'Approved');*/

insert into postoffice(postofficeid,name) values(1,'others');

/*insert into hospital (hospitalid ,name ,username ,emailid ,registerno ,hospitaladdress1 ,hospitaladdress2 ,
	hospitalphno1 ,hospitalphno2, mobilenumber, pincode ,districtid ,stateid ,status )
	values
	(1,'PRS Hospital','prshospital','prs@gmail.com','RegNo02ho123','Karamana, TVM', 'Trivandrum', '4712356894', '04752895623', '9987562314', 695001, 1, 1,'Approved');*/

insert into disease(diseaseid,name,description) values(1,'Chikungunya','Epidemic');
insert into disease(diseaseid,name,description) values(2,'Dengue','Epidemic');
insert into disease(diseaseid,name,description) values(3,'Viralfever','Epidemic');


/*insert into casereport(casereportid, username, hospitalid ,districtid , postofficeid , diseaseid ,fatal ,
	reportedon ,diedon ,casedate ,name ,age ,sex ,address1 ,address2 ,pincode ,createdon )
	values
	(1,'prshospital',1,1,1,1,'Fatal','2007-05-12','2007-06-01','2007-06-25',
'Thomsan R',73,'Male','address1','address2',695001,'2007-06-02');
insert into casereport(casereportid, username, hospitalid ,districtid , postofficeid , diseaseid ,fatal ,
	reportedon ,diedon ,casedate ,name ,age ,sex ,address1 ,address2 ,pincode ,createdon )
	values
	(2,'prshospital',1,1,1,1,'Admitted','2007-05-12',NULL,'2007-06-25',
'Tintu Mon T',15,'Male','address1,Trivandrum','address2',695001,'2007-06-02');*/


insert into mapimage (mapimagesid,width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1,437, 771, 'Kerala.jpg', 'Kerala', '12.688573980262326', '74.9322509765625','8.276727101164045', '77.4591064453125',1,1);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(785, 746, 'Thiruvananthapuram.jpg', 'Thiruvananthapuram', '9.51745950452', '76.6352466402', '8.650915391725', '76.77083523207999', 1, 1);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1036, 527, 'Kollam.jpg', 'Kollam', '9.73409553272','76.5368784461','8.714100899950001','76.64056383991999', 1,2);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(988, 521, 'Pathanamthitta.jpg', 'Pathanamthitta', '9.77020153742', '76.4438274517', '8.687021396425', '76.55548864504', 1, 3);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(590, 996, 'Alappuzha.jpg', 'Alappuzha', '10.0229435703', '76.3348248583', '9.6348040198', '76.5421956458', 1, 4);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(916, 682, 'Kottayam.jpg', 'Kottayam', '9.9236520574', '76.3321662584', '9.6709100245', '76.4597790508', 1, 5);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(722, 998, 'Idukki.jpg', 'Idukki', '9.61675101745', '76.1939190667', '8.70507439877', '76.4996580484', 1, 6);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1060, 562, 'Ernakulam.jpg', 'Ernakulam', '10.212500095','76.2098706658','9.8875460527','76.34811785752', 1, 7);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1764, 1142, 'Thrissur .jpg', 'Thrissur ', '10.492321631425', '76.07959927368', '9.697989528025001', '76.20189486631999', 1, 8);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(747, 807, 'Palakkad.jpg', 'Palakkad', '10.41108312085','75.95730368104','9.354982483375','76.18860186712', 1, 9);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(732, 874, 'Malappuram.jpg', 'Malappuram', '10.7901961702','75.89349728488','10.4652421279','76.09555087272', 1, 10);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(730, 782, 'Kozhikode.jpg', 'Kozhikode', '11.0790442078','75.78981189112','10.203473593825','75.92805908279999', 1, 11);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1262, 966, 'Wayanad.jpg', 'Wayanad', '10.745063664325', '75.73663989431999', '9.806307542125001', '75.86956988632', 1, 12);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(1395, 1128, 'Kannur.jpg', 'Kannur', '11.5845282736', '75.65688189912', '10.510374633775001', '75.79247049096', 1, 13);
insert into mapimage (width, height,imagename,filename, latstart,longstart, latend, longend,stateid, districtid )values(746, 941, 'Kasaragod.jpg', 'Kasaragod', '11.936561819425','75.49470730888','11.16930921955','75.6489060996', 1, 14);
