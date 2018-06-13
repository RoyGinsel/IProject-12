for %%G in (*.sql) do sqlcmd -S mssql2.iproject.icasites.nl -U iproject12 -P zGP7JWvP2U -x -f 65001  -i"%%G"
pause