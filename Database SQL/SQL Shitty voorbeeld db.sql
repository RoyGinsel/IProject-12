create table tblRubriek(
	rubriekNummer int not null,
	rubriekNaam varchar(100) not null,
	parentRubriek int null,
	volgnr int not null,
	constraint pk_tblRubriek primary key (rubriekNummer),
	constraint fk_rubriek_rubriek foreign key (parentRubriek) references tblRubriek(rubriekNummer),
	constraint ck_rubrieknummer_volgnr check (rubriekNummer = volgnr)
)

create table tblVoorwerp(
	voorwerpNummer bigint not null,
	titel varchar(50) not null,
	beschrijving varchar(max) not null,
	startPrijs numeric(11,2) not null,
	betaalWijze varchar(16) not null,
	betalingsInstructie varchar(max) null,
	plaatsnaam varchar(60) not null,
	land varchar (50) not null,
	looptijd int not null,
	looptijdBeginDag date not null,
	looptijdBeginTijdstip time not null,
	verzendkosten numeric(5,2) null,
	verzendInstructie varchar(max) null,
	verkoper varchar(20) not null,
	koper varchar(20) null,
	looptijdEindeDag date not null,
	looptijdEindeTijdstip time not null,
	veilingGesloten bit not null,
	verkoopPrijs numeric (11,2) null,
	constraint pk_tblVoorwerp primary key(voorwerpnummer)
)

create table tblVoorwerpRubriek(
	voorwerpNummer bigint not null,
	rubriekNummer int not null,
	constraint pk_tblVoorwerpRubriek primary key (voorwerpNummer,rubriekNummer),
	constraint fk_tblVoorwerpRubriek_voorwerpNummer foreign key (voorwerpNummer) references tblVoorwerp(voorwerpNummer),
	constraint fk_tblVoorwerpRubriek_rubriekNummer foreign key (rubriekNummer) references tblRubriek(rubriekNummer)
)

create table tblBod(
	voorwerpNummer bigint not null,
	bodBedrag numeric(11,2) not null,
	gebruiker varchar(20) not null,
	bodDag date not null,
	bodTijdstip time not null,
	constraint pk_tblBod primary key (voorwerpNummer,bodBedrag),
	constraint fk_tblBod_voorwerpNummer foreign key (voorwerpNummer) references tblVoorwerp(voorwerpNummer)
	/*constraint fk_tblBod_gebruikersNaam foreign key (gebruikersNaam) references tblGebruiker(gebruikersNaam) */
)

insert into tblVoorwerp values
	(1,'Aston Martin Vulcan','Hele mooie waggie jonguh',2000000.20,'PayPal','gimme da money','Loo','Nederland','5','4/26/2018','14:48:00.0000',3.50,'in da box',20,20,'4/30/2018','14:48:00.0000',0,null),
	(2,'Diploma HBO-ICT','bespaat jezelf 4 jaar',1.50,'PayPal','gimme da money','Loo','Nederland','3','4/26/2018','14:48:00.0000',3.50,'in da box',20,20,'4/29/2018','14:48:00.0000',0,null)

insert into tblVoorwerp values
	(3,'gesdaw HBO-ICT','bespaat jezelf 4 jaar',1.50,'PayPal','gimme da money','Loo','Nederland','3','4/26/2018','14:48:00.0000',3.50,'in da box',20,20,'4/29/2018','14:48:00.0000',0,null)

insert into tblbod values
	(1,9000000.00,'Dinosaurus-Dex','4/27/2018','14:48:00.0000'),
	(2,3.21,'Dinosaurus-Dex','4/27/2018','14:48:00.0000'),
	(2,4.32,'LEEEROOOOOY-roy','4/27/2018','14:48:00.0000')

select * from tblRubriek where parentRubriek = 260

select * from tblbod
select * from tblVoorwerp