## Jak spustit
    - naklonovat do složky např. na localhostu
    - composer install
    - vytvořit .env soubor v root složce s projektem a naplnit ho informacemi viz. komunikace
    - aplikaci najdete na URL adrese localhostu a složky /www
    - done!

## Jak to funguje
    - Aplikace si natáhne údaje z API a namapuje je na modely (entity)
    - V případě vyhození vyjímky během fetchování, oznámí uživateli, že nastala chyba a podrobnější informace loguje.
    - Využil jsem knihovnu contributte/guzzlette, která má lepší integraci pro Nette
    - Informace o coinech a marketech zobrazí uživateli v šabloně default.latte
    - Na aplikaci jsem strávil celkově cca 6,5 hodiny

## Tipy pro zlepšení
    - určitě doimplementovat testování (není to má silná stránka, projel jsem kód pouze přes statickou analýzu -> PHPStan)
    - dodělat Entity a ukládat data do databáze přes Doctrine by nebyl problém, modely jsou na to připraveny
    - předpokládám, že údaje o cenách se musí udržovat aktuální -> udělal bych JobScheduler, který bude efektivně dávkovat data o cenách, aby se nezahltil server 14 000 údaji najednou
    
