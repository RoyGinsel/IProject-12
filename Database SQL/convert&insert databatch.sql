go
exec spRemoveJS

insert into noHTML
select distinct cast(id as bigint) as ID,
	left([dbo].[udf_StripHTML](Titel),50) as Titel,
	cast(Categorie as int) as Categorie,
	left([dbo].[udf_StripHTML](Locatie),60) as plaatsnaam,
	left([dbo].[udf_StripHTML](Land),50) as land,
	left([dbo].[udf_StripHTML](verkoper),20) as verkoper,
	cast(Prijs as numeric(11,2)) as startprijs,
	cast(Thumbnail as varchar(max)) as Thumbnail,
	left([dbo].[udf_StripHTML](CONCAT('Conditie: ',Conditie,'. Beschrijving: ',Beschrijving)),4000) as Beschrijving
from items
UPDATE noHTML
SET Beschrijving = REPLACE(Beschrijving, char(9), '')
update noHTML
set Beschrijving = replace(replace(replace(Beschrijving,' ','<>'),'><',''),'<>',' ')
update noHTML
set Beschrijving = REPLACE(REPLACE(Beschrijving, CHAR(13), ''), char(10), '')

insert into tblGebruiker
select distinct left(Username,20) as gebruikersNaam,
	'unknown' as voornaam,
	'unknown' as achternaam,
	'unknown' as adresRegel,
	null as extraAdresRegel,
	Postalcode as postcode,
	'unknown' as plaatsNaam,
	Location as land,
	convert(date,CURRENT_TIMESTAMP) as geboorteDag,
	'unknown' as mail,
	'$2y$10$PuNXUvL2X6Ro.WSTAGlcCO5j5FibomwZO5YURb1zr/JDjJnc5jNdi' as wachtwoord,
	1 as vraagNummer,
	'nee' as antwoordVraag,
	1 as mogelijkeVerkoper
from users

insert into tblVerkoper
select distinct left(Username,20) as gebruikersNaam,
	'Geen' as bank,
	0000 as bankrekening,
	'Post' as controle,
	null as creditcardNummer,
	convert(date,Current_timestamp) as lidsinds,
	0 as succesvolleVerkopen
from users

go
exec spCreateIDLinks

insert into tblVoorwerp
select new as voorwerpnummer,
	titel as titel,
	Beschrijving as beshrijving,
	startPrijs as startPrijs,
	'Paypal' as betaalWijze,
	'niks speciaals' as betalingsInstructie,
	plaatsnaam as plaatsnaam,
	plaatsnaam as land,
	7 as looptijd,
	convert(date,current_timestamp) as looptijdBeginDag,
	convert(time,current_timestamp) as looptijdBegintijdstip,
	2.50 as verzendkosten,
	'DHL bezorging' as verzendInstructie,
	verkoper as verkoper
from noHTML inner join idtable on id=original

insert into tblBestand
select Thumbnail as fileNaam,
	new as voorwerpNummer
from noHTML inner join IDtable on id=original

delete from Illustraties
where IllustratieFile not in (select IllustratieFile from Illustraties where IllustratieFile like '__\_2\_%' ESCAPE '\' or IllustratieFile like '__\_1\_%' ESCAPE '\' or IllustratieFile like '__\_3\_%' ESCAPE '\')

insert into tblBestand
select IllustratieFile as fileNaam,
	new as voorwerpNummer
from Illustraties inner join IDtable on itemID=original

insert into tblVoorwerpRubriek
select new as voorwerpNummer,
	Categorie as rubriekNummer
from noHTML inner join IDtable on id=original

/*
select * from noHTML
select CHARINDEX('</script>',Beschrijving)+9-CHARINDEX('<script', Beschrijving) from items
select CHARINDEX('<script', Beschrijving) from items
select stuff(Beschrijving,CHARINDEX('<script', Beschrijving),CHARINDEX('</script>',Beschrijving)+9-CHARINDEX('<script', Beschrijving),'') from items
*/

select * from noHTML