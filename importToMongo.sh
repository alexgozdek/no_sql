#! /bin/bash
# Skrypt importujacy dane (JSON) z pliku do bazy mongoDB

# Funkcja pokazuje sposob uzycia skrypt
function helpme() {
  echo "";
  echo "Uzycie:"
  echo "[sciezkaDoPlikuZdanymi] [nazwaBazy] [nazwa kolekcji] [port]"
  echo "Przyklad:"
  echo "dane.txt people peopleCo 27017"
  echo "";
  exit 1
}

# sprawdzanie ilosci parametrow
if [ $# -ne 4 ]; then
   helpme;
fi

# pobieranie zmiennych
 filePath=$1;
 dbName=$2;
 collectionName=$3;
 port=$4;

# /clint/nosql/bin/mongodb/mongoimport -d $dbName -c $collectionName --port $port $filePath

# wykoananie polecenia importu
 mongoimport -d $dbName -c $collectionName --port $port $filePath


exit 0
