create procedure spCreateIDLinks
@counter bigint = 0
as
begin
	if (select count(*) from tblVoorwerp) = 0
	begin
		insert into IDtable values(null,0)
	end
	else
	begin
		insert into IDtable values(null,(select max(voorwerpNummer) from tblVoorwerp))
	end
	while (select count(*) from noHTML) > @counter
	begin
		insert into IDtable values((select id from noHTML where counter = @counter),(select max(new) from IDtable)+1)
		set @counter = @counter +1
	end
	return
end

create procedure spRemoveJS
@Counter bigint = 0
as
begin
	if(select count(*) from items) = 0
	begin
		return
	end
	else
	begin
		while(select count(*) from items) > @Counter
		begin
			while(select count(*) from items where counter = @counter and Beschrijving like '%<script%' and Beschrijving like '%</script>%') > 0
			begin
				update items
					set Beschrijving = stuff(Beschrijving,CHARINDEX('<script', Beschrijving),CHARINDEX('</script>',Beschrijving)+9-CHARINDEX('<script', Beschrijving),'')
					where Beschrijving like '%<script%' and Beschrijving like '%</script>%' and counter = @Counter
			end
		set @counter = @counter + 1
		end
	end
end

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
	if (select count(*) from tblBod where voorwerpNummer = @voorwerpNummer) = 0
	begin
		if(select startprijs from tblVoorwerp where voorwerpNummer = @voorwerpNummer) <= @bodBedrag
		begin
			INSERT into tblBod values (@voorwerpNummer,@bodBedrag,@username,convert(date,current_timestamp),convert(time,current_timestamp))
			return
		end
		else
		begin
			raiserror ('U moet hoger bieden dan de start prijs',16,1)
			return
		end
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