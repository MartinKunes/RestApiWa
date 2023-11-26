RestApi bylo vytvořeno pomocí slim framework v PHP s xampp. Využívá apache a mysql. Práce s daty RestApi v Postman.

programy použité při vytváření:

https://www.jetbrains.com/phpstorm/
https://www.postman.com/
https://www.apachefriends.org/index.html
https://getcomposer.org/
https://www.slimframework.com/






programy potřebné ke spuštění: 

https://www.jetbrains.com/phpstorm/ (popřípadě vaše volba jiného kódovacího programu)
https://www.postman.com/
https://www.apachefriends.org/index.html







spuštění na localhost:
1. stažený rozbalený soubor (SkolaRestApi) vložíte do složky xampp\htdocs
2. soubor blog-ap.sql vložíte do složky xampp\mysql\data
3. SkolaRestApi si otevřete v kódovacím programu
4. Zapněte si xampp control panel a spusťte apache a mysql
5. do terminálu v kódovacím programu vložte tento příkaz: php -S localhost:8080 -t public public/index.php
6. Poté zkopíčujte odkaz, který vám to vytvoří a vložte jeho url s koncovkou:  /blog/all       např: http://localhost:8080/blog/all
   to vám ukáže veškerá data
7. Pokud chcete pracovat s daty, tak si stáhněte https://www.postman.com/, protože funguje s xampp jen stažený
8. Do url vložte localhosta s koncovkou, který jsou rozepsány níže, podle vašich úmyslů s daty






1. POST /blog/add - Vytvoření nového blog postu

Popis:
Tento endpoint slouží k vytvoření nového blog postu. Data blog postu jsou očekávána ve formátu JSON s požadavky na obsah ( blog_id, nickname, text, date).


2. GET /blog/all - Zobrazení všech blog postů
   
Popis:
Tento endpoint slouží k zobrazení všech blog postů uložených v databázi.


3. GET /blog/(blog_id - napsání hodnoty) - Zobrazení konkrétního blog postu
Popis:
Tento endpoint slouží k získání konkrétního blog postu na základě poskytnutého identifikátoru.


5. DELETE /blog/(blog_id - napsání hodnoty) - Smazání blog postu
 
Popis:
Tento endpoint slouží k smazání blog postu na základě poskytnutého identifikátoru.


5. PATCH /api/blog/(id dáného blogpostu - napsání hodnoty) - Částečný update blog postu
   
Popis:
Tento endpoint slouží k aktualizaci části informací o blog postu na základě poskytnutého identifikátoru. Data k aktualizaci jsou očekávána ve formátu JSON.


