<?php

/* 
   Skrypt odczytujacy dane JSON z pliku,
   tworzy baze danych na podstawie struktury obiektow
   i imortujacy dane do bazy. 
*/

// Odczytywanie argumentow
$argc = count($argv);
if ($argc != 4 ) {
    echo 'Nie przezkazano zmiennych do skryptu [nazwaBazyDanych] [nazwaTabeli] [plik_z_danymi]\n';
    return 1;
} 

$dbTable = $argv[1];
$dbName = $argv[2];
$filename = $argv[3];

/* Konfiguracja polaczenia z baza danych */
$dbUser = '';
$dbPass = '';
$dbHost = '';

if (empty($dbUser) || empty($dbHost)) {
    echo 'Nie skonfigurowano polczenia z baza danych w pliku readMongo.php\n';
    return 1;
}


// Polczenie do bazy danych 
$dbConnection = mysql_connect($dbHost, $dbUser,$dbPass);
if (!$dbConnection) {
    echo "Blad polczenia z baza danych MYSQL\n";
    return 1;
}


// Jesli bazadanych nie istnieje 
if (!mysql_select_db($dbName)) {  
// tworzymy ja
    echo "Baza danych utworzona.\n";
    $query = 'CREATE DATABASE '. $dbName ;
    mysql_query($query);
}

// Wybieramy baze danych
mysql_select_db($dbName);

// Usuwamy stare dane z tabeli
$query = "DROP TABLE IF EXISTS ". $dbTable;
mysql_query($query);


// Odczytywanie danych z pliku JSON
$result = null;
foreach (file($filename) as $json) {  
    $result[]=json_decode($json,true); 
}

// Odczytywanie struktury
$record = $result[0]; 

foreach ($record as $key=>$value) {
    
    if ($key == 'id') {
        continue;
    }
    
    if (is_string($value)) {
        $tableStruct[] = $key . ' TEXT NOT NULL';
        continue;
    }
    
    if (is_int($value)) {
        $tableStruct[] = $key . ' INT NOT NULL';
        continue;
    }
}

// Utworzenie zapytania i tabeli
$tableStruct = implode(',',$tableStruct);
$query =
    "CREATE TABLE $dbTable ( 
        id INT NOT NULL AUTO_INCREMENT,
        $tableStruct,
          PRIMARY KEY (id)
    );
    ";
mysql_query($query);


// Dodawanie rekordow
$imported = 0;
foreach ($result as $record) {
    foreach ($record as $key=>$value) {
        
        if (is_string($value)) {
            $cols[] = $key;
            $vals[] = '"'. mysql_escape_string($value).'"';
            continue;
        }

        if (is_int($value)) {
            $cols[] = $key; 
            $vals[] = $value;
            continue;
        }
    }
    $query = 'INSERT INTO ' . $dbTable . ' ( '. implode(',',$cols)   . ') VALUES ('. implode(',',$vals)  .')';
    $cols = null;
    $vals = null;
    mysql_query($query);
    $imported++;
    
    
}

echo "ZAIMPORTOWANO : $imported";
