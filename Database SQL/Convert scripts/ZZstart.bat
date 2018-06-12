for %%G in (*.sql) do sqlcmd /S (local) /d test -E -i"%%G"
pause