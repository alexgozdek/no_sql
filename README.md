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

## Import danych do bazy couchDB - importToCouchDB.sh
* Uruchamiamy CouchDB np. ( konfigracja serwera według wskazówek ze strony : http://wbzyl.inf.ug.edu.pl/nosql/instalacja
~~~ 
cd /home/studinf/hwojciec/noSQL/couchdb/bin;
./couchdb -A ~/.data/etc/couchdb/local.d;
~~~

* Uruchamiamy skrypt importujący dane
~~~
./importToCouchDB.sh [sciezkaDoPlikuZdanymi] [nazwaBazy]  [host:port]
~~~

* Przykładowy komunikat o poprawny dodaniu
~~~
Tworzenie bazy danych: people
{"ok":true}
Kopiowanie danych : people
{"ok":true,"id":"bf41cc1149de006478594f975f04d8ea","rev":"1-a9653e967873e9e8b7c1b2e17a459ebb"}
{"ok":true,"id":"bf41cc1149de006478594f975f04daae","rev":"1-c8beffae43bec70237dc623ac3a8e44e"}
~~~

## Export danych z bazy MongoDB do CouchDB - mongoToCouch.sh
* Uruchamiamy CouchDB ( sposób uruchomienia podany powyżej )
* Uruchamiamy MongoDB ( sposób uruchomienia podany powyżej )
* Pamiętajmy, aby ustawić aplikacjom różne porty
* Uruchamiamy skrypt eksportujący dane

~~~
 ./mongoToCouch.sh [nazwaBazyMONGO] [nazwa kolekcji MONGO] [port MONGO] [bazaCouch] [host:port Couch]
~~~
~~~
./mongoToCouch.sh people peopleCo 27011 people http://0.0.0.0:27015/
~~~

* Przykładowy komunikat o poprawny dodaniu
~~~
connected to: 127.0.0.1:27011;
exported 220 records
{"ok":true,"id":"bf41cc1149de006478594f975f0dfb0b","rev":"1-a9653e967873e9e8b7c1b2e17a459ebb"}
{"ok":true,"id":"bf41cc1149de006478594f975f0e01a2","rev":"1-9efdedf70b6204a7e42ad4935adc8861}
{"ok":true,"id":"bf41cc1149de006478594f975f0e0a0f","rev":"1-653cc7d35790502bcc90a7b67263fb0a"}
~~~

## Map i reduce dla CouchDB
* Uruchamiamy CouchDB ( sposób uruchomienia podany powyżej )
* Uruchamiamy Futon - http://0.0.0.0:27015/_util
* Dodajemy funkcję map i reduce z pliku mapReduceMongoDB.txt do widoków i uruchamiamy :
* Przykładowe wyniki :
~~~
"Solomon Islands"    1
"Pitcairn"  2
"Bahamas"     2
"United Arab Emirates"    1
"Morocco"   2
"Papua New Guinea"     1
"Monaco"  2
"United Kingdom"    1
"Samoa"    2
...
~~~


## Map i reduce dla MongoDB
* Uruchamiamy MongoDB ( sposób uruchomienia podany powyżej )
* Uruchamiamy konsol mongo np.  mongo people --port 27015
* W konsoli wpisujemy nastepujace polecenia ( są w pliku mapReduceMongoDB.sh ) zakładając, że nasza baza nazywa się "people" a kolekcja "peopleCo"

~~~
DBQuery.shellBatchSize = 200;
m = function() { emit(this.artist,1) };
r = function(k,vals) { var sum = 0;  for(var i=0; i < vals.length; i++) { sum += vals[i]; } return sum;     }
res = db.people.mapReduce(m, r, "TopCountries" );
db[res.result].find()
~~~

* Przykładowe wyniki:

~~~
{ "_id" : "Solomon Islands", "value" : 1 }
{ "_id" : "Pitcairn", "value" : 2 }
{ "_id" : "Bahamas", "value" : 2 }
{ "_id" : "Lebanon", "value" : 2 }
{ "_id" : "United Arab Emirates", "value" : 1 }
{ "_id" : "Morocco", "value" : 1 }
{ "_id" : "Brazil", "value" : 1 }
{ "_id" : "Samoa", "value" : 2 }
~~~