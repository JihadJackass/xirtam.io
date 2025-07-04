<!DOCTYPE>
<html>
<head>

<title>Spying on the Top Trainers</title>

<style>
table {
	border-collapse: collapse;
	width: 800px;
}
td, th {
	border: 1px solid black;
	padding: 3px 10px;
	white-space: nowrap;
	background: #bbb;
	font-size: 10pt;
}
body {
	font-family: Arial;
	background: #eee;
}
td {
	color: #666;
}
.active, .active td {
	background-color: #aca;
	color: black;
}
#menu {
	margin-bottom: 10px;
}
#menu a {
	display: inline-block;
	margin-right: 10px;
	border: 1px solid black;
	padding: 4px 8px;
	background: #ddd;
}
</style>

<script>
    var w = window;
    var d = w.document;
    var $A = function(a){var b=[];for(var i=0;i<a.length;i++){b.push(a[i]);}return b;};
    var $$ = function(s,r){return $A((r || d).querySelectorAll(s));};
    var $1 = function(s,r){return (r || d).querySelector(s);};

var QueryString = {
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

var ServerDateDisparity = new Date().getTime() - (<?php echo time(); ?>*1000);
var ServerDate = function(timestamp) {
	if (!timestamp) {
		timestamp = new Date().getTime();
	}

	return new Date(timestamp - ServerDateDisparity);
}

Date.prototype.easyRead = function() {
	return this.getDate()+'/'+(this.getMonth()+1)+'/'+this.getFullYear()+' '+this.toLocaleTimeString();
};

	var TrainerRow = function(rowdata) {
		this.tr = document.createElement('tr');
		this.tr.setAttribute('class','inactive');
		
		this.id = rowdata.id;
		this.username = rowdata.username;
		this.startdata = rowdata;
		this.lastdata = rowdata;
		
		this.cells = {};
		var cellnames = ["id","username","server","lastbattle","avgpermin","battles","tbattles","s1exp","ip"];
		for (var c in cellnames) {
			this.cells[cellnames[c]] = this.addCell();
		}
		
		this.cells.id.set(this.id);
		this.cells.username.set(this.username);
		this.update(rowdata);
	};
	TrainerRow.prototype = {
		update: function(newdata) {
			if (newdata.btime*1000 > (ServerDate().getTime() - (30*1000) )) {
				this.cells.lastbattle.style.fontWeight = 'bold';
				this.cells.lastbattle.style.backgroundColor = '#eea';
				this.tr.setAttribute('class','active');
			} else {
				this.cells.lastbattle.style.fontWeight = '';
				this.cells.lastbattle.style.backgroundColor = '';
			}
			if (newdata.server != null) {
				this.cells.server.set(newdata.server);
				switch (newdata.server) {
					case 'theta': this.cells.server.style.backgroundColor = '#8BF'; break;
					case 'zeta': this.cells.server.style.backgroundColor = '#F98'; break;
					case 'mobile': this.cells.server.style.backgroundColor = '#DDF'; break;
				}
			} else {
				this.cells.server.set('(offline)');
				this.cells.server.style.backgroundColor = '';
			}
			this.cells.lastbattle.set(new Date(newdata.btime * 1000).easyRead());
			var secondsStalking = ((ServerDate().getTime()/1000)-parseInt(this.startdata.btime));
			var battlesAccumulated = (parseInt(newdata.battle)-parseInt(this.startdata.battle));
			if (secondsStalking > 0) {
				var avgpermin = Math.round((battlesAccumulated/(secondsStalking/60))*10)/10;
				this.cells.avgpermin.set(avgpermin);
				this.cells.avgpermin.style.backgroundColor = avgpermin >= 4.5 ? '#e77' : '';
			}
			if (parseInt(newdata.battle) > parseInt(this.lastdata.battle)) {
				this.flash(this.cells.battles.style,255,255,100,1);
			}
			this.cells.tbattles.set(newdata.battle);
			this.cells.s1exp.set(newdata.s1exp);
			this.cells.ip.set(newdata.ip);
			this.cells.battles.set(parseInt(newdata.battle) - parseInt(this.startdata.battle));
			this.lastdata = newdata;
		},
		
		appendTo: function(table) {
			table.appendChild(this.tr);
		},
		
		addCell: function() {
			var td = document.createElement('td');
			this.tr.appendChild(td);
			return {set:(function(str){td.innerText = str;}),style:td.style};
		},

		flash: function(style,r,g,b,a) {
			if (a == 1 && this.flashT) {
				window.clearTimeout(this.flashT);
				delete this.flashT;
			}
			if (a <= 0) {
				style.backgroundColor = '';
			} else {
				style.backgroundColor = "rgba("+r+","+g+","+b+","+a+")";
				this.flashT = window.setTimeout((function(){ this.flash(style,r,g,b,a-0.002); }).bind(this), 40);
			}
		}
	};
	
	
	var Botters = {
		init: function(table,throbber,q){
			Botters.q = q;
			Botters.table = table;
			Botters.throbber = throbber;
			Botters.rows = {};
			Botters.fetchFeed();
			Botters.hideInactiveCSS = document.createElement('style');
			Botters.hideInactiveCSS.textContent = 'tr.inactive {display:none;}';
		},
		
		update: function(data) {
			data.forEach(function(datarow){
				if (Botters.rows[datarow.id] == null) {
					Botters.rows[datarow.id] = new TrainerRow(datarow);
					Botters.rows[datarow.id].appendTo(Botters.table);
				} else {
					Botters.rows[datarow.id].update(datarow);
				}
			});
			
			window.setTimeout(Botters.fetchFeed, 6000);
		},
		
		fetchFeed: function() {
			Botters.throbber.style.display = 'block';
			var xhr = new XMLHttpRequest();
			xhr.open('GET', 'json.toptrainers.php?q='+Botters.q);
			xhr.onreadystatechange = function(){
				if (xhr.readyState == 4 && xhr.status == 200) {
					Botters.throbber.style.display = 'none';
					Botters.update(JSON.parse(xhr.responseText));
				}
			};
			xhr.send(null);
		},
		
		toggleHidden: function(hide){
			if (hide) {
				document.querySelector('head').appendChild(Botters.hideInactiveCSS);
			} else {
				Botters.hideInactiveCSS.parentNode.removeChild(Botters.hideInactiveCSS);
			}
		}
	};
	
	var qs = QueryString.parse(location.search.substr(1));

document.addEventListener('DOMContentLoaded', function(){
	Botters.init(document.getElementById('updatetable'),document.getElementById('throbber'), qs.q || '');
}, false);
</script>

</head>
<body>

<div id="menu">
	<a href="?q=tt">Top Trainers</a>
	<a href="?q=mb">Mobile Users</a>
	<a href="?q=ab">Active Battlers</a>
	<label><input type="checkbox" onclick="Botters.toggleHidden(this.checked);" /> Hide Inactive Users</label>
</div>

<table id="updatetable" style="float:left;">
<tr>
<th>ID</th>
<th>Username</th>
<th>Server</th>
<th>Last Battle Time</th>
<th onclick="var trs = $$('tr');
var tab = trs.shift().parentNode;
trs.forEach(function(tr){tr.parentNode.removeChild(tr);});
trs.sort(function(a,b){return parseFloat(b.childNodes[4].textContent)-parseFloat(a.childNodes[4].textContent); });
trs.forEach(function(tr){tab.appendChild(tr);});
" style="cursor:pointer; color: blue;">Avg Battles/Minute</th>
<th onclick="var trs = $$('tr');
var tab = trs.shift().parentNode;
trs.forEach(function(tr){tr.parentNode.removeChild(tr);});
trs.sort(function(a,b){return parseFloat(b.childNodes[5].textContent)-parseFloat(a.childNodes[5].textContent); });
trs.forEach(function(tr){tab.appendChild(tr);});
" style="cursor:pointer; color: blue;">Battles</th>
<th>Total Battles</th>
<th>S1 Exp</th>
<th onclick="var trs = $$('tr');
var tab = trs.shift().parentNode;
trs.forEach(function(tr){tr.parentNode.removeChild(tr);});
trs.sort(function(a,b){return parseFloat(b.childNodes[8].textContent)-parseFloat(a.childNodes[8].textContent); });
trs.forEach(function(tr){tab.appendChild(tr);});
" style="cursor:pointer; color: blue;">IP</th>
</tr>
</table>
<img id="throbber" src="http://static.pokemonvortex.org/images/loading_black.gif" style="float:left;display:none;" />

</body>
</html>