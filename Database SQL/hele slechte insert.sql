delete from tblGebruiker where gebruikersNaam not in ('luukj17','simonvn1','hans14')
update tblverkoper
set succesvolleVerkopen = 500
where gebruikersNaam = 'simonvn1'

select * from tblGebruiker
select * from tblVerkoper
select * from tblVoorwerp
select * from tblRubriek where parentRubriek = 44688
select * from tblRubriek where rubriekNaam like '%duik%'
select * from tblBod


insert into tblVerkoper values
('simonvn1','RABO','0355251355','POST',null,convert(date,CURRENT_TIMESTAMP),0),
('dexdieterman12','RABO','035511555884','POST',null,convert(date,CURRENT_TIMESTAMP),0)


insert into tblVoorwerp values
(2,'Aston Martin Vantage','Nieuwste AM op de markt',500000.00,'Roze koffer','ASAP','Loo','Nederland',10,convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP),0.00,'Wordt gebracht','simonvn1'),
(3,'Aston Martin DB11','Gewoon een auto',400000.00,'Overmaken','Liefst via paypal','Loo','Nederland',1,convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP),0.00,'elkaar halverwege ontmoeten','simonvn1'),
(4,'Scrumbord','Al een ompleet scrumbbord voor al jouw scrummy needs',10.00,'vliegend','een briefje van 10 in een vliegthuigje vouwen','Loo','Nederland',7,convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP),1.23,'wordt met de post verstuurd','simonvn1'),
(5,'Flesje water','Water dat hier uit de sloot is gehaald',0.50,'gooien','niks speciaals','Loo','Nederland',3,convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP),0.00,'ophalen ****','simonvn1')

insert into tblVoorwerpRubriek values
(1,9014),
(2,9014),
(3,9014),
(4,1106),
(5,44688)

select * from tblBod

delete from tblBod

insert into tblBod values
(1,1000000.50,'luukj17',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP))
(1,1000001.00,'dexdieterman12',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP))
,
(1,1000001.00,'dexdieterman12',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP)),
(1,1000001.50,'luukj17',convert(date,CURRENT_TIMESTAMP),convert(time,CURRENT_TIMESTAMP))

select rubriekNummer
from tblRubriek
where rubriekNummer in 