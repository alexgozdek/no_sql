/*
   Funkcja map wyswietla liste krajow wszystkich osob
   Funkcja reduce zlicza osoby pochodzace z danego kraju
*/


function(doc) {
  emit(doc.country, 1);
};


function(tag, counts) {
  var sum = 0;
  for(var i=0; i < counts.length; i++) {
     sum += counts[i];
  }
  return sum;
};
