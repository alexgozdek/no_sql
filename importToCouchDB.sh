#! /bin/bash

# Skrypt importuje dane (JSON ) z pliku do bazy mongoDB

function helpme() {
  echo "";
  echo "Uzycie:"
  echo "[sciezkaDoPlikuZdanymi] [nazwaBazy] [host:port]"
  echo "Przyklad: "
  echo "dane.txt baza http://127.0.0.1:5984"
  echo "";
  exit 1
}

# sprawdzanie ilosci parametrow
 if [ $# -ne 3 ]; 
  then
    helpme; 
 fi

# pobieranie zmiennych
 filePath=$1; 
 dbName=$2; 
 host=$3; 

echo "Usuwanie bazy: $dbName " 
 curl -X DELETE $host/$dbName 

echo "Tworzenie bazy danych: $dbName " 
 curl -X PUT $host/$dbName

#echo "Pobieramy informacje : $dbName" 
 curl -X GET $host/$dbName

echo "Kopiowanie danych : $dbName"
 #curl -d '{"name":"abc"}' -X POST -H "Content-Type: application/json" $host/$dbName 

 while read line do
    curl -d "$line" -X POST -H "Content-Type: application/json" $host/$dbName 
 done < $filePath;

exit 0
