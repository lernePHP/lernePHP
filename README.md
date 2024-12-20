# Datenbank-Dump importieren
http:/localhost/phpmyadmin aufrufen
Datenbank "scooterverleih" anlegen, falls noch nicht vorhanden (Zeichencodierung siehe unten)
Danach scooterverleih.sql aus dem Ordner DatenbankDump importieren.

# Zeichencodierung für die DB
Empfehlung: utf8mb4_unicode_ci


# bootstrap einbinden --> siehe bootstrap_Vorlage.php
- Nähere Infos dazu auf http://holdirbootstrap.de/examples/signin/ bzw. https://getbootstrap.com/docs/5.1/examples/checkout/
- cdn-Variante genügt. Bootstrap muss nicht unbedingt installiert werden

# bootstrap_Vorlage.php
enthält ein Formular-Layout mit den gängigsten Elementen


# config.php
hier können Servername, Datenbankname, Username und Passwort eingestellt werden.

# connection.php
- eine Verbindung zur Datenbank wird aufgebaut.
- ein evtl. Fehler beim DB-Aufbau wird angezeigt und der Ladevorgang abgebrochen.
- Die Verbindung kann unter der Variablen $conn angesprochen werden.


# bsp_PDO_select.php, _query.php, _insert.php, _delete.php
**Achtung!**
**config.php und connection.php müssen vorhanden sein. Sie werden eingebunden**
- enthält die wichtigsten Php-Statements
- SELECT, UPDATE, DELETE-Statements erstellen und abschicken.
- SELECT-Statements durchwandern
- wie ist die ID des gerade eingefügten Datensatzes?


# bsp_PDO_select_mit_iterable.php
- enthält eine eigene Klasse, die dabei Hilft, die Datensätze eines Abfrageergebnisses sehr einfach tabellarisch darzustellen


# person_ 
so beginnen alle php-Dateien, die sich auf das konkrete Beispiel unseres Scooter-Verleihs beziehen.
Alle wichtigen Prozesse in Zusammenhang mit der Datenbank werden in diesen php-Dateien behandelt.
Selektieren, Einfügen, Löschen, Ändern.
Auch das Thema Passwort-Hash wird behandelt (siehe dazu person_register.php und person_login.php)


# person_register.php
Die Stammdaten der Person inklusive selbst gewählten Passwort werden eingegeben.
Das Passwort wird mit dem Pepper (String-Variable in der config.php) gemischt, danach gehasht und so in der Datenbank abgespeichert.
Beim Login passiert der umgekehrte Vorgang. Wenn die Passwörter ident sind, dann kommt eine entsprechende Meldung.

Inklusive Javascript-Funktionen checkForm() und Überprüfung während der Eingabe, ob eine Sozialversicherungsnummer gültig ist oder nicht.
Anzeige der Gültigkeit mittels QR-Code valid.png bzw. notvalid.png (siehe dazu Unterordner images im Projekt)


# person_login.php
überprüft, ob Benutzername vorhanden und Passwort mit dem in der Datenbank matcht. Inklusive gehashtem und gepeppertem Passwort.



# person_DS_aus_Liste_aendern_und_loeschen.php
gibt beim Start eine Liste aus, die jeweils für ändern und löschen eine Schaltfläche neben jedem Datensatz aufweist.
Diese verweisen auf person_admin.php und person_del.php.
Die zu ändernde bzw. löschende person_id wir per $_GET übergeben.

# verleih_suche
zeigt das Ergebnis eines etwas komplexeren Selects an. 
Mit 
- Eingabefeldern aus Dropbox (Select aus einer Tabelle), 
- Radiobuttons einer Option-Group

# das Wichtigste rund um arrays auf array1.php
- Erstellen von Arrays
- Durchwandern mit foreach (key / value-pairs)
- Anzahl Elemente


# Allgemeines in der php-Programmierung
- htmlentities() für Texteingaben verwenden
- eingegebene Zahlen als Zahlen konvertieren

# Kurzüberblick über wichtige Funktionen von phpMyAdmin
https://www.workshop.ch/openmind/2013/12/24/phpmyadmin-zusatzfunktionen-aktivieren-mit-dem-configuration-storage/#:~:text=Der%20phpMyAdmin%20Designer%20bietet%20eine,verschaffen%2C%20sondern%20auch%20solche%20erstellen.


# weiterführende Webseiten:
- https://www.php-einfach.de/mysql-tutorial/php-prepared-statements/
- https://www.w3schools.com/php
- https://werner-zenk.de/tipps/erster_eintrag_in_eine_mysql-datenbank_2.php#db4
- https://www.php.net/manual/de/langref.php
- https://www.php.net/manual/de/function.password-hash.php

# QR-Code generator
https://www.the-qrcode-generator.com/de/

<!---
- 👋 Hi, I’m @lernePHP Das ist mein erstes github repository
- 👀 I’m interested in ...
- 🌱 I’m currently learning ...
- 💞️ I’m looking to collaborate on ...
- 📫 How to reach me ...
- kleine Änderung


lernePHP/lernePHP is a ✨ special ✨ repository because its `README.md` (this file) appears on your GitHub profile.
You can click the Preview link to take a look at your changes.
--->
