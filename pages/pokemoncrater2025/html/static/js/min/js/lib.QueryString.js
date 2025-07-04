QueryString = {
	"parse": function(str) {
		if (typeof str !== 'string') {
			return;
		}
		
		var obj = {}, i, pairs = str.split('&');
		for (i=0; i<pairs.length; i++) {
			var kv = pairs[i].split('=');
			kv[0] = this.d(kv[0]);
			obj[kv[0]] = (kv.length === 1) ? null : this.d(kv[1]);
		}
		
		return obj;
	},
	
	"build": function(obj) {
		var str = [], i;
		for (i in obj) {
			str.push(this.e(i) + ((obj[i] !== null) ? ("="+this.e(obj[i])) : "") );
		}
		return str.join("&");
	},
	
	"e": encodeURIComponent,
	"d": decodeURIComponent
};