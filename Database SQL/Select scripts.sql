select titel, beschrijving, b.bodBedrag
from tblVoorwerp v 
inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
			from tblBod
			group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
where v.voorwerpNummer in(select top 2 voorwerpNummer
							from tblBod
							group by voorwerpNummer
							order by count(voorwerpnummer) desc)

select titel, beschrijving, b.bodBedrag
from tblVoorwerp v 
inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
			from tblBod
			group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
where v.voorwerpNummer in (select top 2 v.voorwerpNummer
							from tblVoorwerp v 
							inner join (select voorwerpNummer, max(bodBedrag) as bodBedrag
							from tblBod
							group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
							order by startprijs/bodbedrag*100 desc)

select * from tblvoorwerp

select count(*) as aantal
from tblVoorwerp
where  looptijdBeginDag >= '2018-5-9'


select h.rubriekNaam as hoofdRubriek, s.rubriekNaam as subRubriek
from tblRubriek h 
	inner join tblRubriek s on h.rubriekNummer=s.parentRubriek
where h.parentrubriek= -1
order by h.rubriekNaam asc, s.rubriekNaam asc

select rubriekNaam, rubriekNummer
from tblRubriek
where parentRubriek = -1

select * from tblRubriek
where rubriekNummer = 2

select titel, beschrijving, b.bodBedrag, startPrijs
from tblVoorwerp v 
full join (select voorwerpNummer, max(bodBedrag) as bodBedrag
			from tblBod
			group by voorwerpNummer) b on v.voorwerpNummer=b.voorwerpNummer
inner join tblVoorwerpRubriek vr on v.voorwerpNummer= vr.voorwerpNummer
inner join tblRubriek r on vr.rubriekNummer=r.rubriekNummer
where r.rubriekNaam like '%uto%'