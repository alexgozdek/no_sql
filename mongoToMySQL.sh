#! /bin/bash
# skrypt eksportujacy danych z mongoDB do MySQL

# Funkcja pokazuje sposob uzycia skrypt
function helpme() {
  echo "[nazwaBazyMONGO] [nazwa kolekcji MONGO] [port MONGO]"
  exit 1
}

# sprawdzanie ilosci parametrow
if [ $# -ne 3 ]; then
	helpme;
fi

# pobieranie zmiennych
outputFile="./exportedDataTMP.json";
dbName=$1
collectionName=$2
port=$3


#/root/nosql/bin/mongodb/mongoexport -d $dbName -c $collectionName -o $outputFile --port $port
mongoexport -d $dbName -c $collectionName -o $outputFile --port $port

# skrypt php odpowiedzialny za odczyt pliku z eksportu i zapis 
# do bazy MySQL - niezbedna konfiguracja bazy danych w pliku
php readMongo.php $dbName $collectionName $outputFile
