select titel, beschrijving, b.bodBedrag, startprijs
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
							order by bodBedrag-startPrijs desc)

select h.rubriekNaam as hoofdRubriek, s.rubriekNaam as subRubriek
from tblRubriek h 
	inner join tblRubriek s on h.rubriekNummer=s.parentRubriek
where h.parentrubriek= -1
order by h.rubriekNaam asc, s.rubriekNaam asc



select rubrieknaam from tblRubriek
where parentRubriek = -1