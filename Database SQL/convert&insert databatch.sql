create FUNCTION [dbo].[udf_StripHTML]
(
@HTMLText varchar(MAX)
)
RETURNS varchar(MAX)
AS
BEGIN
DECLARE @Start  int
DECLARE @End    int
DECLARE @Length int

-- Replace the HTML entity &amp; with the '&' character (this needs to be done first, as
-- '&' might be double encoded as '&amp;amp;')
SET @Start = CHARINDEX('&amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '&')
SET @Start = CHARINDEX('&amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &lt; with the '<' character
SET @Start = CHARINDEX('&lt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '<')
SET @Start = CHARINDEX('&lt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &gt; with the '>' character
SET @Start = CHARINDEX('&gt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '>')
SET @Start = CHARINDEX('&gt;', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &amp; with the '&' character
SET @Start = CHARINDEX('&amp;amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '&')
SET @Start = CHARINDEX('&amp;amp;', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace the HTML entity &nbsp; with the ' ' character
SET @Start = CHARINDEX('&nbsp;', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, ' ')
SET @Start = CHARINDEX('&nbsp;', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1
END

-- Replace any <br> tags with a newline
SET @Start = CHARINDEX('<br>', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, CHAR(13) + CHAR(10))
SET @Start = CHARINDEX('<br>', @HTMLText)
SET @End = @Start + 3
SET @Length = (@End - @Start) + 1
END

-- Replace any <br/> tags with a newline
SET @Start = CHARINDEX('<br/>', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, CHAR(13) + CHAR(10))
SET @Start = CHARINDEX('<br/>', @HTMLText)
SET @End = @Start + 4
SET @Length = (@End - @Start) + 1
END

-- Replace any <br /> tags with a newline
SET @Start = CHARINDEX('<br />', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, CHAR(13) + CHAR(10))
SET @Start = CHARINDEX('<br />', @HTMLText)
SET @End = @Start + 5
SET @Length = (@End - @Start) + 1
END

-- Remove anything between <whatever> tags
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1

WHILE (@Start > 0 AND @End > 0 AND @Length > 0) BEGIN
SET @HTMLText = STUFF(@HTMLText, @Start, @Length, '')
SET @Start = CHARINDEX('<', @HTMLText)
SET @End = CHARINDEX('>', @HTMLText, CHARINDEX('<', @HTMLText))
SET @Length = (@End - @Start) + 1
END

RETURN LTRIM(RTRIM(@HTMLText))

END

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
select * from noHTML

select * from users
select * from tblGebruiker

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

insert into tblVoorwerp

select * from tblvoorwerp order by 
