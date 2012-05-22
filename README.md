## Technologie NoSQL

* Import danych do bazy mongoDB - urucha się skryptem importToMongo.sh (sposob uruchomienia opisany w pliku).
* Import danych do bazy couchDB - urucha się skryptem importToCouchDB.sh (sposob uruchomienia opisany w pliku).
* Eksport danych z bazy mongoDB do MySQL (php5). Uruchamiany skryptem mongoToMySQL.sh (sposob uruchomienia opisany w pliku).
* Funkcje map i reduce dla CouchDB - funkcje w pliku mapReduceCouchDB.js
* Funkcje map i reduce dla MongoDB - funkcje w pliku mapReduceMongoDB.js
                                
## Jak uruchomić na SIGMIE
Import danych do bazy mongoDB - importToCouchDB.sh

* Uruchamiamy MongoDB
~~~ mongod --dbpath=$HOME/.data/var/lib/mongodb --port=27015 
~~~

* Uruchamiamy skrypt importujący dane
~~~ 
./importToMongo.sh [sciezkaDoPlikuZdanymi] [nazwaBazy] [nazwa kolekcji] [port]
~~~

* Przykładowy komunikat o poprawny dodaniu
~~~ 
connected to: 127.0.0.1:27011;
imported 80 objects; ~
~~~