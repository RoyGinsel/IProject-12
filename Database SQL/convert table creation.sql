drop table items
drop table Illustraties
drop table noHTML
drop table Users
drop table IDtable

create table items(
ID varchar(max) not null,
Titel varchar(max) not null,
Categorie varchar(max) not null,
Postcode varchar(max) not null,
Locatie varchar(max) not null,
Land varchar(max) not null,
Verkoper varchar(max) not null,
Prijs varchar(max) not null,
Valuta varchar(max) not null,
Conditie varchar(max) not null,
Thumbnail varchar(max) not null,
Beschrijving varchar(max) not null)

create table Illustraties (
ItemID varchar(max) not null,
IllustratieFile varchar(max) not null
)

create table noHTML(
counter bigint identity(1,1),
ID bigint not null,
Titel varchar(50) not null,
Categorie int not null,
plaatsnaam varchar(60) not null,
land varchar(50) not null,
verkoper varchar(20) not null,
startPrijs numeric(11,2) not null,
Thumbnail varchar(max) not null,
Beschrijving varchar(max) not null
)

create table Users(
Username varchar(max) not null,
Postalcode varchar(9) not null,
Location varchar(35) not null,
Country varchar(55) not null,
Rating numeric (4,1) not null
)

create table IDtable(
original bigint null,
new bigint not null
)