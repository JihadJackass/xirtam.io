
	fixStyles();

	var onResizeGame = function()
	{
		resizeObject('scroll', 0);
		
		resizeObject('sidebarTabs', 0);
		
		if (browser == 'ie6-' || browser == 'ie7+')
		{
			resizeObject('sidebarContent', 2);
		}
		else
		{
			resizeObject('sidebarContent', 0);
		}
				
		if (browser == 'ie6-')
		{
			var container = document.getElementById('container');
			
			if (document.documentElement && document.documentElement.clientWidth) // IE6+
			{
				var windowWidth = document.documentElement.clientWidth;
			}
			else if (document.body && document.body.clientWidth) // IE5-
			{
				var windowWidth = document.body.clientWidth;
			}
			
			if (windowWidth > 1030)
			{
				container.style.width = '1030px';
			}
			else
			{
				container.style.width = 'auto';
			}
		}
	}
	
	addResizeEvent(onResizeGame);
	
	addLoadEvent(onResizeGame);
	
	onResizeGame();

	// Maps Tab //
	document.getElementById('mapsTab').onmouseover = function()
	{
		showMenu('maps', 0);
	}
	
	document.getElementById('mapsTab').onclick = function()
	{
		showMenu('maps', 1);
		return false;
	}
	
	document.getElementById('mapsTab').onmouseout = function()
	{
		hideMenu(0);
	}
	
	// Battle Tab //
	document.getElementById('battleTab').onmouseover = function()
	{
		showMenu('battle', 0);
	}
	
	document.getElementById('battleTab').onclick = function()
	{
		showMenu('battle', 1);
		return false;
	}
	
	document.getElementById('battleTab').onmouseout = function()
	{
		hideMenu(0);
	}

	// Your Account Tab //
	document.getElementById('yourAccountTab').onmouseover = function()
	{
		showMenu('yourAccount', 0);
	}
	
	document.getElementById('yourAccountTab').onclick = function()
	{
		showMenu('yourAccount', 1);
		return false;
	}
	
	document.getElementById('yourAccountTab').onmouseout = function()
	{
		hideMenu(0);
	}

	// Community Tab //
	document.getElementById('communityTab').onmouseover = function()
	{
		showMenu('community', 0);
	}
	
	document.getElementById('communityTab').onclick = function()
	{
		showMenu('community', 1);
		return false;
	}
	
	document.getElementById('communityTab').onmouseout = function()
	{
		hideMenu(0);
	}
	
	// Options Tab //
	document.getElementById('optionsTab').onclick = function()
	{
		showSidebar(this, 1);
		return false;
	}
	
	// PokeDex Tab //
	document.getElementById('pokedexTab').onclick = function()
	{
		showSidebar(this, 1);
		return false;
	}
	
	// Members Tab //
	document.getElementById('membersTab').onclick = function()
	{
		showSidebar(this, 1);
		return false;
	}
/*
	var loadingBlack = new Image;
	loadingBlack.src = '/images/loading.gif';
	
	var loadingWhite = new Image;
	loadingWhite.src = '/images/loading.gif';
	
	var overshadow = new Image;
	overshadow.src = '/images/overshadow.png';
	
	var whiteout = new Image;
	whiteout.src = '/images/loading.gif';

	var grayout = new Image;
	grayout.src = '/images/loading.gif';
*/
var notifymessageshow = function()
{
	var request = new AjaxRequest();
	request.url = 'tabs/toolbox.php';
	request.query = 'notify=show';
	request.responseHandler = function()
	{
		
		if (this.responseText)
		{
			if(this.responseText == 1){
			}
			else{
				var notify = document.getElementById('notification');
				notify.innerHTML = this.responseText + "<br><br> To remove notification please click <a href=\"#\" onclick=\"notifymessagehide(); return false;\">here.</a>";
				notify.style.visibility = 'visible';
			}
		}
	}
	request.send();
}
var notifymessagehide = function()
{
	var request = new AjaxRequest();
	request.url = 'tabs/toolbox.php';
	request.query = 'notify=hide';
	document.getElementById('notification').style.visibility = 'hidden';
	request.send();
}
notifymessageshow();