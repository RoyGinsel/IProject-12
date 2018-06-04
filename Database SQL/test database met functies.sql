create function expired (@time time, @date date)
returns bit
as
begin
	if((@time < convert(time,GETDATE()) and @date <= CONVERT(date, GETDATE())) or @date < CONVERT(date, GETDATE()))
		return 1
	else
		return 0

	return 0
end

create function highestBid (@expired bit, @id bigint)
returns numeric(11,2)
as
begin
	if(@expired = 1 and (select max(bodBedrag) from tblBod where voorwerpNummer = @id) is not null)
		return (select max(bodBedrag) from tblBod
				where voorwerpNummer = @id)
	else
		return null
	return null
end

/* werkt nog niet buyer */
create function buyer (@expired bit, @id bigint)
returns varchar(20)
as
begin
	if(@expired = 1 and (select max(bodBedrag) from tblBod where voorwerpNummer = @id) is not null)
		return (select top 1 gebruiker from tblBod
				where voorwerpNummer = @id
				group by gebruiker
				order by max(bodbedrag) desc)
	else 
		return null
	return null
end

alter function higherBid (@bedrag numeric(11,2), @id bigint)
returns bit
as
begin
	if((select bodBedrag from tblBod where voorwerpNummer = @id) = null)
		return 1
	else if(@bedrag > (select max(bodBedrag) from tblBod where voorwerpNummer = @id))
		return 1
	else 
		return 0
	return 0
end

create function notSeller (@Username varchar(20), @id bigint)
returns bit
as
begin
	if((select gebruikersNaam from tblGebruiker g 
		full join tblVoorwerp v on v.verkoper=g.gebruikersNaam
		where verkoper = @Username and voorwerpNummer=@id) is null)
		return 1
	else
		return 0
	return 0
end

/* verbeterd */
create function availableSeller (@username varchar(20))
returns bit
as
begin
	if((select gebruikersNaam from tblGebruiker where gebruikersNaam = @username and mogelijkeVerkoper = 1) is not null)
		return 1
	else
		return 0
	return 0
end
/* verbeterd */
create function controle (@control varchar(15),@number varchar(25))
returns bit
as
begin
	if(@control = 'Creditcard' and @number is not null)
		return 1
	else
	if(@control = 'Post')
		return 1
	else
		return 0
	return 0
end

create function aBillingAddress (@address1 varchar(20),@address2 varchar(25))
returns bit
as
begin
	if(@address1 is null and @address2 is null)
		return 0
	else
		return 1
	return 1
end

create function maxPictures (@id bigint)
returns bit
as
begin
	if((select count(*)
		from tblBestand
		where voorwerpNummer = @id) <= 4)
		return 1
	else
		return 0
	return 0
end

select * from tblVoorwerp

alter table tblBod
drop constraint chk_tblBod_hoger_bedrag

select top 1 [dbo].[higherBid](1000000.50,2), * from tblVoorwerp

alter function higherBid (@bedrag numeric(11,2), @id bigint)
returns bit
as
begin
	declare @i int
	select @i = count(*) from tblBod where voorwerpNummer = @id 
	if @i = 0
		return 1
	else if(@bedrag >= (select max(bodBedrag) from tblBod where voorwerpNummer = @id))
		return 1
	else
		return 0
	return 0
end

insert into tblBod values
(2,1000000.80,'luukj17',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP)),
(2,1000010.50,'dexdieterman12',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP))

alter table tblBod
add constraint chk_tblBod_hoger_bedrag check([dbo].[higherBid](bodBedrag,voorwerpNummer) = 1)
*/
/* tblVraag */
create table tblVraag(
vraagNummer int identity(1,1),
tekstVraag varchar(40) not null,
constraint pk_tblVraag primary key(vraagNummer)
)

/* tblGebruiker af */
create table tblGebruiker(
gebruikersNaam varchar(20) not null,
voornaam varchar(50) not null,
achternaam varchar(52) not null,
adresRegel varchar(95) not null,
extraAdresRegel varchar(95) null,
postcode varchar(9) not null,
plaatsNaam varchar(35) not null,
land varchar(55) not null,
geboorteDag date not null,
mail varchar(254) not null,
wachtwoord varchar(100) not null,
vraagNummer int not null,
antwoordVraag varchar(50) not null,
mogelijkeVerkoper bit not null default 0,
constraint pk_tblGebruiker primary key(gebruikersNaam),
constraint fk_tblGebruiker_vraag foreign key(vraagNummer) references tblVraag(vraagNummer)
)

/* tblVerkoper */
create table tblVerkoper(
gebruikersNaam varchar(20) not null,
bank varchar(10) null,
bankrekening varchar(20) null,
controle varchar(15) not null,
creditcardNummer varchar(25) null,
lidSinds date not null,
succesvolleVerkopen int not null
constraint pk_tblVerkoper primary key(gebruikersNaam),
constraint fk_tblVerkoper_gebruikersNaam foreign key(gebruikersNaam) references tblGebruiker(gebruikersNaam),
constraint chk_tblVerkoper_kan_verkoper_worden check([dbo].[availableSeller](gebruikersNaam) = 1),
constraint chk_tblVerkoper_controle check(controle = 'Creditcard' or controle = 'Post'),
constraint chk_tblVerkoper_creditcardNummer check([dbo].[controle](controle,creditcardNummer) = 1),
constraint chk_tblVerkoper_geenrekening check([dbo].[aBillingAddress](bankrekening,creditcardNummer) = 1)
)


/* tblVoorwerp af */
create table tblVoorwerp(
	voorwerpNummer bigint not null,
	titel varchar(50) not null,
	beschrijving varchar(max) not null,
	startPrijs numeric(11,2) not null default 0.00,
	betaalWijze varchar(16) not null,
	betalingsInstructie varchar(max) null,
	plaatsnaam varchar(60) not null,
	land varchar(50) not null,
	looptijd int not null default 7,
	looptijdBeginDag date not null,
	looptijdBeginTijdstip time not null,
	verzendkosten numeric(5,2) null,
	verzendInstructie varchar(max) null,
	verkoper varchar(20) not null,
	koper as [dbo].[buyer]([dbo].[expired](looptijdBeginTijdstip,dateadd(day,looptijd,looptijdBeginDag)),voorwerpNummer),
	looptijdEindeDag as dateadd(day,looptijd,looptijdBeginDag),
	looptijdEindeTijdstip as looptijdBeginTijdstip,
	veilingGesloten as [dbo].[expired](looptijdBeginTijdstip,dateadd(day,looptijd,looptijdBeginDag)),
	verkoopPrijs as [dbo].[highestBid]([dbo].[expired](looptijdBeginTijdstip,dateadd(day,looptijd,looptijdBeginDag)),voorwerpNummer),
	constraint pk_tblVoorwerp primary key(voorwerpnummer),
	constraint fk_tblVoorwerp_verkoper foreign key(verkoper) references tblVerkoper(gebruikersNaam),
	/*constraint fk_tblVoorwerp_koper foreign key(koper) references tblGebruiker(gebruikersNaam),*/
	constraint chk_tblvoorwerp_looptijd check (looptijd in (1,3,5,7,10))
)

/* tblrubriek uitfaseren colom toevoegen */
create table tblRubriek(
	rubriekNummer int not null,
	rubriekNaam varchar(100) not null,
	parentRubriek int null,
	constraint pk_tblRubriek primary key (rubriekNummer),
	constraint fk_rubriek_rubriek foreign key (parentRubriek) references tblRubriek(rubriekNummer)
)

/* tblVoorwerpRubriek af */
create table tblVoorwerpRubriek(
	voorwerpNummer bigint not null,
	rubriekNummer int not null,
	constraint pk_tblVoorwerpRubriek primary key (voorwerpNummer,rubriekNummer),
	constraint fk_tblVoorwerpRubriek_voorwerpNummer foreign key (voorwerpNummer) references tblVoorwerp(voorwerpNummer),
	constraint fk_tblVoorwerpRubriek_rubriekNummer foreign key (rubriekNummer) references tblRubriek(rubriekNummer)
)

/* tblbod af */
/* verbeterd */
create table tblBod(
	voorwerpNummer bigint not null,
	bodBedrag numeric(11,2) not null,
	gebruiker varchar(20) not null,
	bodDag date not null,
	bodTijdstip time not null,
	constraint pk_tblBod primary key (voorwerpNummer,bodBedrag),
	constraint fk_tblBod_voorwerpNummer foreign key (voorwerpNummer) references tblVoorwerp(voorwerpNummer),
	constraint fk_tblBod_gebruikersNaam foreign key (gebruiker) references tblGebruiker(gebruikersNaam),
	constraint chk_tblBod_hoger_bedrag check([dbo].[higherBid](bodBedrag,voorwerpNummer) = 1),
	constraint chk_tblBod_Niet_verkoper check([dbo].[notSeller](gebruiker,voorwerpNummer) = 1)
)

create table tblBestand(
fileNumber bigint identity(1,1),
fileNaam varbinary(MAX) not null,
voorwerpNummer bigint not null,
constraint pk_tblBestan primary key(fileNumber),
constraint fk_tblBestand_voorwerpNummer foreign key(voorwerpNummer) references tblVoorwerp(voorwerpNummer),
constraint chk_tblBestand_4plaatjes check([dbo].[maxPictures](voorwerpNummer) = 1)
)

create table tblFeedback(
voorwerpNummer bigint not null,
soortGebruiker bit not null,
feedbackSoort varchar(15) not null,
dag date not null,
tijd time not null,
commentaar varchar(max) null,
constraint pk_tblFeedback primary key(voorwerpNummer,soortGebruiker),
constraint fk_tblFeedback foreign key(voorwerpNummer) references tblVoorwerp(voorwerpNummer),
constraint chk_tblFeedback_soort check(feedbackSoort in ('Positief','Matig','Negatief'))
)

create table tblTelefoonNummer(
volgNummer bigint identity(1,1),
gebruikersNaam varchar(20) not null,
telefoonNummer varchar(50) not null,
constraint pk_tblTelefoonNummer primary key(volgNummer,gebruikersNaam),
constraint fk_tblTelefoonNummer_gebruikersNaam foreign key(gebruikersNaam) references tblGebruiker(gebruikersNaam)
)

create procedure spNieuwBod
@bodBedrag numeric(11,2),
@voorwerpNummer bigint,
@username varchar(20)
as
begin
	if (select top 1 gebruiker from tblBod where voorwerpNummer = @voorwerpNummer order by bodBedrag desc) = @username
	begin
		raiserror ('U heeft al het hoogste bod',16,1)
		return
	end
	if (select verkoper from tblVoorwerp where voorwerpNummer = @voorwerpNummer) = @username
	begin
		raiserror ('Dit is uw eigen product',16,1)
		return
	end
	if (select veilingGesloten from tblVoorwerp where voorwerpNummer = @voorwerpNummer) = 1
	begin
		raiserror ('Deze veiling is gesloten',16,1)
		return
	end
	if (select max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) < 50
	begin
		if (select @bodbedrag-max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) >= 0.5
		begin
			INSERT into tblBod values (@voorwerpNummer,@bodBedrag,@username,convert(date,current_timestamp),convert(time,current_timestamp))
			return
		end
		else
		begin
			raiserror ('U moet met minstens 50 cent vehogen',16,1)
			return
		end
	end
	else if (select max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) < 500
	begin
		if (select @bodbedrag-max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) >= 1.0
		begin
			INSERT into tblBod values (@voorwerpNummer,@bodBedrag,@username,convert(date,current_timestamp),convert(time,current_timestamp))
			return
		end
		else
		begin
			raiserror ('U moet met minstens 1 euro vehogen',16,1)
			return
		end
	end
	else if (select max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) < 1000
	begin
		if (select @bodbedrag-max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) >= 5.0
		begin
			INSERT into tblBod values (@voorwerpNummer,@bodBedrag,@username,convert(date,current_timestamp),convert(time,current_timestamp))
			return
		end
		else
		begin
			raiserror ('U moet met minstens 5 euro vehogen',16,1)
			return
		end
	end
	else
	begin
		if (select @bodbedrag-max(bodBedrag) from tblBod where voorwerpNummer = @voorwerpNummer) >= 50.0
		begin
			INSERT into tblBod values (@voorwerpNummer,@bodBedrag,@username,convert(date,current_timestamp),convert(time,current_timestamp))
			return
		end
		else
		begin
			raiserror ('U moet met minstens 50 euro vehogen',16,1)
			return
		end
	end
end

go
exec spNieuwBod 1000061.00, 3, 'timovn1'


select * from tblVoorwerp
select * from tblGebruiker
select * from tblBod

alter table tblBod
drop column bodDag

alter table tblBod
drop column bodTijdstip

alter table tblbod
add bodDag date not null
alter table tblbod
add bodTijdstip time not null