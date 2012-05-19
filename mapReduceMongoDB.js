/*   
   Funkcja map wyswietla liste krajow wszystkich osob
   Funkcja reduce zlicza osoby pochodzace z danego kraju
*/

DBQuery.shellBatchSize = 200;
m = function() { 
	emit(this.country,1) 
};

r = function(k,vals) { 
	var sum = 0;  
	for(var i=0; i < vals.length; i++) { 
		sum += vals[i];
	} 
	return sum;     
};

res = db.people.mapReduce(m, r, "MostPopularCountries" );
db[res.result].find()
