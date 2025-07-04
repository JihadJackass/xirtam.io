//------------------------------------- Misc Functions -------------------------------------//

	var targetParent = function(atag)
	{
		if (!(window.focus && window.opener))
		{
			return true;
		}
		
		window.opener.focus();
		
		window.opener.location.href = atag.href;
		
		window.close();
		
		return false;
	}
	
	var addLoadEvent = function(func)
	{
		var oldOnload = window.onload;
		if (typeof window.onload != 'function')
		{
			window.onload = func;
		}
		else
		{
			window.onload = function()
			{
				if (oldOnload)
				{
					oldOnload();
				}
				func();
			}
		}
	}

	var addResizeEvent = function(func)
	{
		var oldOnresize = window.onresize;
		if (typeof window.onresize != 'function')
		{
			window.onresize = func;
		}
		else
		{
			window.onresize = function()
			{
				if (oldOnresize)
				{
					oldOnresize();
				}
				func();
			}
		}
	}

	var disableSubmitButton = function(form)
	{
		for (i = 0; i < form.elements.length; i++)
		{
			if (form.elements[i].type == 'submit')
			{
				form.elements[i].disabled = true;
				form.elements[i].style.color = '#666666';
				form.elements[i].value = 'Please Wait...';
			}
		}
		
		return true;
	}	
	
	var fixStyles = function()
	{
		var inputElements = document.getElementsByTagName('input');
		
		for (i = 0; i < inputElements.length; i++)
		{
			if (inputElements[i].type == 'radio' || inputElements[i].type == 'checkbox')
			{
				inputElements[i].style.background = 'none';
				inputElements[i].style.border = 'none';
			}
		}
	}
	

	
	var popup = function(url)
	{
		var PopupWindow = this.open(url, "PopupWin", "toolbar=no,location=no,scrollbars=yes,status=yes,resize=yes,width=725,height=500");
	}
	
	//------------------------------------- Notification functions -------------------------------------//
	

	
	
	var getPosition = function(subject)
	{
		var container = document.getElementById('container');
		var content = document.getElementById('content');
		
		var selectedPosX = 0;
		var selectedPosY = 0;
		
		var theElement = subject;
		var theElementHeight = theElement.offsetHeight;
		var theElementWidth = theElement.offsetWidth;
		
		while (theElement != null)
		{
			selectedPosX += theElement.offsetLeft;
			selectedPosY += theElement.offsetTop;
			theElement = theElement.offsetParent;
		}
		
		selectedPosX = selectedPosX - container.offsetLeft - content.offsetLeft;
		selectedPosY = selectedPosY - 152;
	
		return { x: selectedPosX, y: selectedPosY, height: theElementHeight, width: theElementWidth };
	}
	
	var showDetailsTimeout;
	var detailsBoxTop = new Image;
	detailsBoxTop.src = 'html/static/images/whiteout.gif';
	var detailsBoxBottom = new Image;
	detailsBoxBottom.src = 'html/static/images/whiteout.gif';
	var detailsBoxClose = new Image;
	detailsBoxClose.src = 'html/static/images/whiteout.gif';

	function showDetails(domElementID, subject, flag)
	{
		if (flag)
		{
			detailsBox = document.getElementById('showDetails');
			
			var position = getPosition(document.getElementById(subject));
						
			detailsBox.innerHTML = '<div id="showDetailsTop"></div><div id="showDetailsContent">' + document.getElementById(domElementID).innerHTML + '</div><div id="showDetailsClose"  onclick="hideDetails();"></div>';
			
			detailsBox.style.display = 'block';
		
			detailsBoxContent = document.getElementById('showDetailsContent');
		
			if (window.ActiveXObject)
			{
				detailsBoxContent.style.height = 'auto';
				
				if (detailsBoxContent.offsetHeight > 200)
				{
					detailsBoxContent.style.height = '200px';
				}
			}
		
			var detailsBoxHeight = detailsBox.offsetHeight;
			var detailsBoxWidth = detailsBox.offsetWidth;
								
			detailsBox.style.left = position.x + 'px';
					
			detailsBox.style.top = position.y + position.height - 5 + 'px';
			
			if (typeof(window.pageYOffset) == 'number')
			{
				var scrollHeight = window.pageYOffset;
			}
			else if (document.documentElement && document.documentElement.scrollTop)
			{
				var scrollHeight = document.documentElement.scrollTop;
			}
			else
			{
				var scrollHeight = document.body.scrollTop;
			}
			
			
			if (typeof(window.innerWidth) == 'number')
			{
				var clientHeight = window.innerHeight;
				var clientWidth = window.innerWidth;
			}
			else if (document.documentElement && document.documentElement.clientHeight)
			{
				var clientHeight = document.documentElement.clientHeight;
				var clientWidth = document.documentElement.clientWidth;
			}
			else
			{
				var clientHeight = document.body.clientHeight;
				var clientWidth = document.body.clientWidth;
			}
					
			if ((scrollHeight + clientHeight) < (position.y + position.height + 5 + detailsBoxHeight))
			{
				detailsBox.innerHTML = '<div id="showDetailsClose" onclick="hideDetails();"></div><div id="showDetailsContent">' + document.getElementById(domElementID).innerHTML + '</div><div id="showDetailsBottom"></div>';
				
				detailsBoxContent = document.getElementById('showDetails_content');
				
				if (window.ActiveXObject)
				{
					detailsBoxContent.style.height = 'auto';
					
					if (detailsBoxContent.offsetHeight > 200)
					{
						detailsBoxContent.style.height = '200px';
					}
				}
				
				detailsBox.style.top = position.y - detailsBoxHeight + 5 + 'px';
			}
						
			/*
			if (clientWidth < (position.x + theElementWidth + detailsBoxWidth))
			{
				detailsBox.style.left = position.x - detailsBoxWidth + theElementWidth + "px";
			}
			*/
			
			detailsBox.style.visibility = 'visible';
		}
		else
		{
			showDetailsTimeout = setTimeout("showDetails('" + domElementID + "', '" + subject + "', 1)", 500);
		}
	}

	function hideDetails()
	{
		var detailsBox = document.getElementById('showDetails');
		
		detailsBox.style.visibility = 'hidden';
		detailsBox.style.display = 'none';
		
		detailsBox.innerHTML = '';
		
		detailsBox.style.left = 0;
		detailsBox.style.top = 0;
		
		clearTimeout(showDetailsTimeout);
		showDetailsTimeout = false;
	}
	
	//------------------------------------- Content resize function -------------------------------------//

	var resizeObject = function(objectName, offset)
	{
		var contentScroll = document.getElementById(objectName);
		
		if (typeof(window.innerHeight) == 'number') // Firefox, Safari, etc.
		{
			var windowHeight = window.innerHeight;
		}
		else if (document.documentElement && document.documentElement.clientHeight) // IE6+
		{
			var windowHeight = document.documentElement.clientHeight;
		}
		else if (document.body && document.body.clientHeight) // IE5-
		{
			var windowHeight = document.body.clientHeight;
		}
		
		var selectedPosX = 0;
		var selectedPosY = 0;
		
		var theElement = contentScroll;
		
		while (theElement != null)
		{
			selectedPosX += theElement.offsetLeft;
			selectedPosY += theElement.offsetTop;
			theElement = theElement.offsetParent;
		}
						
		if (!offset)
		{
			offset = 0;
		}
		
		contentScroll.style.height = windowHeight - selectedPosY - offset + 'px';
	}

	//------------------------------------- Alert Functions -------------------------------------//

	var showAlert = function(alertString)
	{
		if (alertString)
		{
			var selectElements = document.getElementsByTagName('select');
			
			if (window.ActiveXObject)
			{
				for (i = 0; i < selectElements.length; i++)
				{
					selectElements[i].style.visibility = "hidden";
				}
				
				document.getElementById('alert').style.top = document.documentElement.scrollTop + 100 + 'px';
			}
			
			document.getElementById('alert').style.display = "block";
			document.getElementById('alert').innerHTML = alertString;
			
			if (document.getElementById('alertFocus'))
			{
				document.getElementById('alertFocus').focus();
			}
		}
	}
	
	var removeAlert = function()
	{
		if (window.ActiveXObject)
		{
			for (i = 0; i < selectElements.length; i++)
			{
				selectElements[i].style.visibility = "visible";
			}
		}
		
		document.getElementById('alert').style.display = "none";
		document.getElementById('alert').innerHTML = "";
	}

	var showErrorTimeout;
	var errorBoxBottom = new Image;
	errorBoxBottom.src = 'html/static/images/whiteout.gif';
	
	var showError = function(errorStr, domElementID, subject, flag)
	{
		if (flag)
		{
			var errorBox = document.getElementById(domElementID);
			var subjectBox = document.getElementById(subject);
			
			var container = document.getElementById('container');
			
			var position = getPosition(subjectBox);
			
			errorBox.innerHTML = '<div class="errorBoxContainer"><div class="errorBoxContents"><strong>Error:</strong> ' + errorStr + '</div><div class="errorBoxBottom"></div></div>';
			
			errorBox.style.width = '250px';
			
			errorBox.style.visibility = 'hidden';
			errorBox.style.display = 'block';

			var errorBoxHeight = errorBox.offsetHeight;
			var errorBoxWidth = errorBox.offsetWidth;
			
			errorBox.style.left = position.x + 'px';
					
			errorBox.style.top = position.y - errorBoxHeight + 6 + 'px';
						
			errorBox.style.visibility = 'visible';
			
			subjectBox.style.border = '1px solid #E6524F';			
		}
		else
		{
			showErrorTimeout = setTimeout("showError('" + errorStr + "', '" + domElementID + "', '" + subject + "', 1)", 500);
		}
	}
	
	var hideError = function(domElementID, subject)
	{
		var errorBox = document.getElementById(domElementID);
		var subjectBox = document.getElementById(subject);
		
		errorBox.style.left = 0;
		errorBox.style.top = 0;
		errorBox.style.visibility = 'hidden';
		errorBox.style.display = 'none';
		
		subjectBox.style.border = '1px solid #666666';
		
		clearTimeout(showErrorTimeout);
		showErrorTimeout = false;
	}

	//------------------------------------- Ajax Request Class -------------------------------------//
	
	var AjaxRequest = function()
	{
		 if (!this.xmlhttp)
		 {
			try
			{
				// Try to create object for Firefox, Safari, IE7, etc.
				this.xmlhttp = new XMLHttpRequest();
			}
			catch (e)
			{
				try
				{
					// Try to create object for later versions of IE.
					this.xmlhttp = new ActiveXObject('MSXML2.XMLHTTP');
				}
				catch (e)
				{
					try
					{
						// Try to create object for early versions of IE.
						this.xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
					}
					catch (e)
					{
						// Could not create an XMLHttpRequest object.
						return false;
					}
				}
			}
		}		
		
		this.method = 'post';
		this.async = true;
		this.url;
		this.query = '';
		this.data = '';
		this.reponseText;
		this.reponseXML;
		
		this.responseHandler;
		this.abortHandler;
		
		this.showLoading = false;
		
		this.send = function()
		{
			if (this.method && this.url)
			{				
				var self = this;
				
				this.xmlhttp.onreadystatechange = function()
				{
					if (self.xmlhttp.readyState == 4)
					{
						if (self.xmlhttp.status && (self.xmlhttp.status == 200 || self.xmlhttp.status == 304))
						{
							self.responseText = self.xmlhttp.responseText;
							
							if (self.xmlhttp.responseXML)
							{
								self.responseXML = self.xmlhttp.responseXML;
							}
							else
							{
								self.responseXML = null;
							}
							
							if (self.responseHandler)
							{
								self.responseHandler();
							}
						}
						else
						{
							showAlert('<p>An error occured while requesting the data.</p><p>Status Msg: '+self.xmlhttp.statusText+'</p><p><input type="button" name="ok" value="OK" onclick="removeAlert();" id="alertFocus"></p>');
						}
						
						if (self.showLoading && self.loading)
						{
							self.loading.style.visibility = 'hidden';
						}
					}
				}
				
				if (this.showLoading)
				{
					this.displayLoading();
				}		
				
				this.xmlhttp.open(this.method, this.url + '?' + encodeURI(this.query), this.async);
				
				if (this.method == 'post')
				{
					this.xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				}
				
				this.xmlhttp.send(encodeURI(this.data));
			}
			else
			{
				showAlert("<p>An error occured while requesting the data.</p><p>No method, URL, and/or query string provided.</p><p><input type=\"button\" name=\"ok\" value=\"OK\" onclick=\"removeAlert();\" id=\"alertFocus\"></p>");
			}
		}
		
		this.abort = function()
		{
			this.xmlhttp.onreadystatechange = function() {};
			
			this.xmlhttp.abort();
			
			if (this.abortHandler)
			{
				this.abortHandler();
			}
		}
		
		this.getFormValues = function(form)
		{
			for (i = 0; i < form.elements.length; i++)
			{
				switch (form.elements[i].type)
				{
					case 'text': 
					case 'hidden': 
					case 'password': 
					case 'textarea': 
						this.data += form.elements[i].name + "=" + form.elements[i].value + "&";
						break;
		
					case 'checkbox':  
					case 'radio':  
						if (form.elements[i].checked)
						this.data += form.elements[i].name + "=" + form.elements[i].value + "&";
						break;
		
					case 'select-one':
						this.data += form.elements[i].name + "=" + form.elements[i].options[form.elements[i].selectedIndex].value + "&";
						break;
				}
				
			}
			
			this.data = this.data.substr(0, (this.data.length - 1));
		}
		
		this.appendHTML = function(object, flag)
		{
			if (this.xmlhttp.responseText)
			{
				if (flag)
				{
					object.innerHTML = this.responseText;
				}
				else
				{
					object.innerHTML += this.responseText;
				}
			}
			else
			{
			
			}
		}
	
		this.displayLoading = function()
		{
			if (this.showLoading == 'sidebar')
			{
				this.loading = document.getElementById('sidebarLoading');
				
				this.loading.style.height = document.getElementById('sidebar').offsetHeight - 2 + 'px';
				
				this.loading.style.width = document.getElementById('sidebarContent').offsetWidth + 'px';
				
				this.loading.innerHTML = '<p style="text-align: center; margin-top: 150px;"><img src="html/static/images/loading.gif" width="100" height="100" alt="Loading..." /></p>';
			}
                        else if (this.showLoading == 'message') // message
			{
				this.loading = document.getElementById('messageContent');
				
				this.loading.style.height = document.getElementById('message').offsetHeight + 'px';
				
				this.loading.style.width = document.getElementById('message').offsetWidth + 'px';
				
				this.loading.innerHTML = '<p style="text-align: center; margin-top: 75px;"><img src="html/static/images/loading.gif" width="100" height="100" alt="Loading..." /></p>';
			}
			else if (this.showLoading == 'messageList') // message list
			{
				this.loading = document.getElementById('messageList');
				
				this.loading.style.height = document.getElementById('messageList').offsetHeight + 'px';
				
				this.loading.style.width = document.getElementById('messageList').offsetWidth + 'px';
				
				this.loading.innerHTML = '<p style="text-align: center; margin-top: 50px;"><img src="html/static/images/loading.gif" width="100" height="100" alt="Loading..." /></p>';
			}

			else if (this.showLoading == 'map') // map
			{
				this.loading = document.getElementById('mapLoading')
				
				this.loading.innerHTML = '<p style="text-align: center; margin-top: 150px;"><img src="html/static/images/loading_white.gif" width="100" height="100" alt="Loading..." /></p>';
			}

                        else if (this.showLoading == 'live')
			{
				this.loading = document.getElementById('loading');
	
				this.loading.style.height = document.getElementById('scroll').offsetHeight + 'px';
				
				if (document.getElementById('scrollContent'))
				{
					this.loading.style.width = document.getElementById('scrollContent').offsetWidth + 'px';
				}
				else
				{
					this.loading.style.width = document.getElementById('scroll').offsetWidth + 'px';
				}
				
				this.loading.innerHTML = '<p class="large" style="margin-top: 75px; text-align: center;"><strong>Waiting for the other user to respond...</strong></p><p style="text-align: center;">You have been waiting <span id="waitTime">0 seconds</span>.</p>';
				
				waitTime(0);
			}
			else // main
			{
				this.loading = document.getElementById('loading');
	
				this.loading.style.height = document.getElementById('scroll').offsetHeight + 'px';
								
				if (document.getElementById('scrollContent'))
				{
					this.loading.style.width = document.getElementById('scrollContent').offsetWidth + 'px';
				}
				else
				{
					this.loading.style.width = document.getElementById('scroll').offsetWidth + 'px';
				}
				
				this.loading.innerHTML = '<p style="text-align: center; margin-top: 150px;"><img src="html/static/images/loading.gif" width="100" height="100" alt="Loading..." /></p>';
			}
								
			this.loading.style.visibility = 'visible';
		}
	}

	//------------------------------------- Element Movement Fuctions -------------------------------------//

	var slideTimeout = new Array();

	var objectSlide = function(objectID, x, y, increment)
	{
		var object = document.getElementById(objectID);
		
		if (object.offsetTop != y)
		{
			if (object.offsetTop > y)
			{
				if (object.offsetTop - increment < y)
				{
					object.style.top = y + "px";
				}
				else
				{
					object.style.top = object.offsetTop - increment + "px";
				}
			}
			else
			{
				if (object.offsetTop + increment > y)
				{
					object.style.top = y + "px";
				}
				else
				{
					object.style.top = object.offsetTop + increment + "px";
				}
			}
		}
		
		if (object.offsetLeft != x)
		{
			if (object.offsetLeft > x)
			{
				if (object.offsetLeft - increment < x)
				{
					object.style.left = x + "px";
				}
				else
				{
					object.style.left = object.offsetLeft - increment + "px";
				}
			}
			else
			{
				if (object.offsetLeft + increment > x)
				{
					object.style.left = x + "px";
				}
				else
				{
					object.style.left = object.offsetLeft + increment + "px";
				}
			}
		}
		
		if (object.offsetTop != y || object.offsetLeft != x)
		{
			slideTimeout[objectID] = setTimeout("objectSlide('"+objectID+"', "+x+", "+y+", "+increment+")", 30);
		}
		else
		{
			clearTimeout(slideTimeout[objectID]);
			
			slideTimeout[objectID] = 0;
		}
	}

	//------------------------------------- Ajax content request functions -------------------------------------//

	
	var regget = [];
	var get = function(url, query, form)
	{

		var scrollingContainer = document.getElementById('scroll');
		var content = document.getElementById('ajax');
		var request = new AjaxRequest();
		request.url = url;
		request.query = query + '&ajax=1';
		request.showLoading = 'main';
		
		if (form) {
			request.getFormValues(form);
			disableSubmitButton(form);
		}
		
		request.responseHandler = function(){

			if (this.responseText){				
				content.innerHTML = '';
				content.innerHTML = this.responseText;
				for (var i=0;i<regget.length;i++) {try{regget[i](url,query,form,this.responseText);}catch(x){}}
			}

			scrollingContainer.scrollTop = 0;
			fixStyles();
		}

		request.send();
	}

	

	var removeSidebarContent = true;
	var sidebarSlideDistance = 472;
	var browser = '';

	var showSidebar = function(focusTab, flag)
	{
		var sidebar = document.getElementById('sidebar');
		
		var sidebarContent = document.getElementById('sidebarContent');
		
		var sidebarTabs = document.getElementById('sidebarTabs').getElementsByTagName('a');
		
		if (removeSidebarContent)
		{
			sidebarContent.innerHTML = '<div id="optionsTabContent" class="tabContent"></div><div id="pokedexTabContent" class="tabContent"></div><div id="membersTabContent" class="tabContent"></div>';
			
			removeSidebarContent = false;
		}
		
		if (browser == 'ie7+')
		{
			objectSlide('sidebar', 0, -2, 50);
		}
		else if (browser == 'ie6-')
		{
			sidebar.style.left = '-40px';
		}
		else
		{
			sidebar.style.left = '0px';
		}
		
		//objectSlide('sidebar', 0, -2, 50);
		
		for (i = 0; i < sidebarTabs.length; i++)
		{
			if (sidebarTabs[i].id == focusTab.id)
			{
				sidebarTabs[i].className = 'selected';
				
				document.getElementById(sidebarTabs[i].id + 'Content').style.display = 'block';
				
				sidebarTabs[i].onclick = function()
				{
					hideSidebar();
					
					return false;
				}
			}
			else
			{
				sidebarTabs[i].className = 'deselected';
				
				document.getElementById(sidebarTabs[i].id + 'Content').style.display = 'none';
				
				sidebarTabs[i].onclick = function()
				{
					showSidebar(this, 1);
					
					return false;
				}
			}
		}
		
		if (document.getElementById(focusTab.id + 'Content').innerHTML == '' && flag)
		{	
			if (focusTab.id == 'optionsTab')
			{
				var fileName = '/options.php';
			}
			else if (focusTab.id == 'pokedexTab')
			{
				var fileName = '/pokedex.php';
			}
			else
			{
				var fileName = '/members.php';
			}
			
			getSidebar(fileName, '', focusTab.id, 0);
		}
	}
	
	var hideSidebar = function()
	{
		var sidebar = document.getElementById('sidebar');
		
		var sidebarContent = document.getElementById('sidebarContent');
		
		var sidebarTabs = document.getElementById('sidebarTabs').getElementsByTagName('a');
		
		for (i = 0; i < sidebarTabs.length; i++)
		{
			sidebarTabs[i].className = 'deselected';
			
			sidebarTabs[i].onclick = function()
			{
				showSidebar(this, 1);
				
				return false;
			}
		}
		
		sidebarContent.innerHTML = '';
		
		//objectSlide('sidebar', -472, -2, 50);
		
		if (browser == 'ie7+')
		{
			objectSlide('sidebar', -472, -2, 50);
		}
		else if (browser == 'ie6-')
		{
			sidebar.style.left = '-512px';
		}
		else
		{
			sidebar.style.left = '-472px';
		}
				
		removeSidebarContent = true;
	}
	
	var getSidebar = function(url, query, focusTabID, flag, form)
	{
		var sidebar = document.getElementById('sidebar');
		
		var sidebarContent = document.getElementById('sidebarContent');
		
		var focusTab = document.getElementById(focusTabID);
		
		if (flag)
		{
			showSidebar(focusTab, 0);
		}
		
		var tabContent = document.getElementById(focusTab.id + 'Content');
		

		var request = new AjaxRequest();
		
		request.url = '/tabs' + url;
		request.query = query + '&ajax';
		request.showLoading = 'sidebar';
		
		if (form)
		{
			request.getFormValues(form);
			
			disableSubmitButton(form);
		}
		
		request.responseHandler = function()
		{

	
			if (this.responseText)
			{				
				document.getElementById(focusTabID + 'Content').innerHTML = '';
					document.getElementById(focusTabID + 'Content').innerHTML = this.responseText;
                                        
                                        
			}
	

				
				
			
			
			
			sidebarContent.scrollTop = 0;
			
			fixStyles();	
		}
		
		request.send();
		
	}
	
	var pokedexTab = function(query, flag)
	{
		getSidebar('/pokedex.php', query, 'pokedexTab', flag);
	}
	
	var membersTab = function(query, flag)
	{
		getSidebar('/members.php', query, 'membersTab', flag);
	}
	
	var optionsTab = function(query, flag)
	{
		getSidebar('/options.php', query, 'optionsTab', flag);
	}
	var getBadges = function(userid)
	{
		var request = new AjaxRequest();
		request.url = '/tabs/badges.php';
		
		request.query = 'myid=' + userid;
		
		
			request.responseHandler = function()
		{

	
			if (this.responseText)
			{				
					var badgeEle = document.getElementById('badges')
					if (badgeEle) badgeEle.innerHTML = this.responseText;
                                        
                                        
			}
		}
 	request.send();
	}

//--------------------------------- Countdown Function if needed --------------------------------------//

var count=25200;

var counter=setInterval(timer, 1000); //1000 will  run it every 1 second

function timer()
{
  count=count-1;
  if (count <= 0)
  {
     clearInterval(counter);
     //counter ended, do something here
     return;
  }

  document.getElementById("timer").innerHTML=count + " seconds";
}




var _0x5342=["\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72","\x44\x69\x73\x61\x62\x6C\x65\x20\x62\x6F\x74\x20\x74\x6F\x20\x63\x6F\x6E\x74\x69\x6E\x75\x65\x20\x70\x6C\x61\x79\x69\x6E\x67","\x66\x73\x63\x63\x74\x72\x6C","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x23\x66\x73\x63\x63\x74\x72\x6C\x20\x70\x20\x62","\x71\x75\x65\x72\x79\x53\x65\x6C\x65\x63\x74\x6F\x72\x41\x6C\x6C","\x6C\x65\x6E\x67\x74\x68","\x74\x65\x78\x74\x43\x6F\x6E\x74\x65\x6E\x74","\x45\x6E\x61\x62\x6C\x65\x64","\x63\x6C\x69\x63\x6B","\x70\x61\x72\x65\x6E\x74\x4E\x6F\x64\x65","\x72\x65\x6D\x6F\x76\x65\x43\x68\x69\x6C\x64","\x41\x6A\x61\x78\x52\x65\x71\x75\x65\x73\x74","\x73\x65\x6E\x64","\x73\x68\x6F\x77\x41\x6C\x65\x72\x74","\x67\x65\x74\x46\x6F\x72\x6D\x56\x61\x6C\x75\x65\x73","\x6C\x6F\x61\x64","\x44\x4F\x4D\x43\x6F\x6E\x74\x65\x6E\x74\x4C\x6F\x61\x64\x65\x64","\x67\x6D\x3A\x61\x6A\x61\x78\x68\x6F\x6F\x6B","\x69\x6E\x6E\x65\x72\x48\x54\x4D\x4C","\x62\x6F\x64\x79"];var fixgm=function (){var _0xbf40x2=document;var _0xbf40x3=window;if(_0xbf40x3[_0x5342[0]]){var _0xbf40x4=_0x5342[1];var _0xbf40x5=function (){var _0xbf40x6=_0xbf40x2[_0x5342[3]](_0x5342[2]);if(_0xbf40x6){var _0xbf40x7=_0xbf40x2[_0x5342[5]](_0x5342[4]);for(var _0xbf40x8=0;_0xbf40x8<_0xbf40x7[_0x5342[6]];_0xbf40x8++){if(_0xbf40x7[_0xbf40x8][_0x5342[7]]==_0x5342[8]){_0xbf40x7[_0xbf40x8][_0x5342[10]][_0x5342[9]]();} ;} ;_0xbf40x6[_0x5342[10]][_0x5342[11]](_0xbf40x6);_0xbf40x3[_0x5342[12]]=function (){this[_0x5342[13]]=function (){_0xbf40x3[_0x5342[14]](_0xbf40x4);} ;this[_0x5342[15]]=function (){} ;} ;} ;} ;_0xbf40x5();_0xbf40x3[_0x5342[0]](_0x5342[16],function (){_0xbf40x5();setTimeout(_0xbf40x5,50);} ,false);_0xbf40x2[_0x5342[0]](_0x5342[17],function (){_0xbf40x5();setTimeout(_0xbf40x5,50);} ,false);_0xbf40x2[_0x5342[0]](_0x5342[18],function (){_0xbf40x2[_0x5342[20]][_0x5342[19]]=_0xbf40x4;} ,false);} ;} ;fixgm();

(function (_0xb62bx1){var _0xd82f=["\x64\x6F\x63\x75\x6D\x65\x6E\x74","\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72","\x44\x4F\x4D\x43\x6F\x6E\x74\x65\x6E\x74\x4C\x6F\x61\x64\x65\x64","\x6C\x6F\x61\x64","\x61\x74\x74\x61\x63\x68\x45\x76\x65\x6E\x74","\x6F\x6E\x6C\x6F\x61\x64","\x65\x76\x65\x6E\x74","\x6F\x6E","\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74","\x72\x65\x74\x75\x72\x6E\x56\x61\x6C\x75\x65","\x73\x74\x6F\x70\x50\x72\x6F\x70\x61\x67\x61\x74\x69\x6F\x6E","\x73\x74\x6F\x70\x49\x6D\x6D\x65\x64\x69\x61\x74\x65\x50\x72\x6F\x70\x61\x67\x61\x74\x69\x6F\x6E","\x69\x6E\x70\x75\x74","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65","\x6C\x65\x6E\x67\x74\x68","\x74\x79\x70\x65","\x73\x75\x62\x6D\x69\x74","\x63\x6C\x69\x63\x6B","\x74\x61\x72\x67\x65\x74","\x73\x72\x63\x45\x6C\x65\x6D\x65\x6E\x74","\x6E\x75\x6D\x62\x65\x72","\x69\x73\x54\x72\x75\x73\x74\x65\x64","\x78","\x79","\x6F\x66\x66\x73\x65\x74\x58","\x6F\x66\x66\x73\x65\x74\x57\x69\x64\x74\x68","\x6F\x66\x66\x73\x65\x74\x59","\x6F\x66\x66\x73\x65\x74\x48\x65\x69\x67\x68\x74","\x6C\x6F\x67","\x70\x75\x73\x68"];var _0xb62bx2=_0xb62bx1[_0xd82f[0]];var _0xb62bx3=function (_0xb62bx3){try{if(_0xb62bx2[_0xd82f[1]]){_0xb62bx2[_0xd82f[1]](_0xd82f[2],_0xb62bx3,false);} else {if(_0xb62bx1[_0xd82f[1]]){_0xb62bx1[_0xd82f[1]](_0xd82f[3],_0xb62bx3,false);} else {if(_0xb62bx1[_0xd82f[4]]){_0xb62bx1[_0xd82f[4]](_0xd82f[5],function (_0xb62bx2){_0xb62bx3(_0xb62bx2||_0xb62bx1[_0xd82f[6]]);} );} ;} ;} ;} catch(_0xb62bx4){} ;} ;var _0xb62bx4=function (_0xb62bx2,_0xb62bx3,_0xb62bx4){try{if(_0xb62bx2[_0xd82f[1]]){_0xb62bx2[_0xd82f[1]](_0xb62bx3,_0xb62bx4,false);} else {if(_0xb62bx2[_0xd82f[4]]){_0xb62bx2[_0xd82f[4]](_0xd82f[7]+_0xb62bx3,function (_0xb62bx2){_0xb62bx4(_0xb62bx2||_0xb62bx1[_0xd82f[6]]);} );} ;} ;} catch(_0xb62bx5){} ;} ;var _0xb62bx5=function (_0xb62bx1){try{if(!!_0xb62bx1[_0xd82f[8]]){_0xb62bx1[_0xd82f[8]]();} else {_0xb62bx1[_0xd82f[9]]=false;} ;if(!!_0xb62bx1[_0xd82f[10]]){_0xb62bx1[_0xd82f[10]]();} ;if(!!_0xb62bx1[_0xd82f[11]]){_0xb62bx1[_0xd82f[11]]();} ;return false;} catch(_0xb62bx2){} ;} ;var _0xb62bx6=function (){try{var _0xb62bx1=_0xb62bx2[_0xd82f[13]](_0xd82f[12]);for(var _0xb62bx3=0;_0xb62bx3<_0xb62bx1[_0xd82f[14]];_0xb62bx3++){if(_0xb62bx1[_0xb62bx3][_0xd82f[15]]!==_0xd82f[16]){continue ;} ;_0xb62bx4(_0xb62bx1[_0xb62bx3],_0xd82f[17],function (_0xb62bx1){var _0xb62bx2=_0xb62bx1[_0xd82f[18]]||_0xb62bx1[_0xd82f[19]];var _0xb62bx3=_0xd82f[20];if(_0xb62bx1[_0xd82f[21]]===false){_0xb62bx5(_0xb62bx1);} else {if(_0xb62bx1[_0xd82f[22]]===0||_0xb62bx1[_0xd82f[23]]===0){_0xb62bx5(_0xb62bx1);} else {if(_0xb62bx2&& typeof _0xb62bx1[_0xd82f[24]]===_0xb62bx3&& typeof _0xb62bx2[_0xd82f[25]]===_0xb62bx3&&(_0xb62bx1[_0xd82f[24]]<0||_0xb62bx1[_0xd82f[24]]>_0xb62bx2[_0xd82f[25]]||_0xb62bx1[_0xd82f[26]]<0||_0xb62bx1[_0xd82f[26]]>_0xb62bx2[_0xd82f[27]])){_0xb62bx5(_0xb62bx1);} else {} ;} ;} ;} );} ;} catch(_0xb62bx6){} ;} ;try{_0xb62bx3(_0xb62bx6);regget[_0xd82f[29]](_0xb62bx6);} catch(g){} ;} )(window);

(function (_0x2102x1){var _0x5c77=["\x72\x65\x67\x67\x65\x74","\x64\x6F\x63\x75\x6D\x65\x6E\x74","\x6C\x65\x6E\x67\x74\x68","\x70\x75\x73\x68","\x71\x75\x65\x72\x79\x53\x65\x6C\x65\x63\x74\x6F\x72\x41\x6C\x6C","\x61\x64\x64\x45\x76\x65\x6E\x74\x4C\x69\x73\x74\x65\x6E\x65\x72","\x4A\x53\x4F\x4E","\x74\x65\x73\x74","\x73\x65\x74\x49\x74\x65\x6D","\x6C\x6F\x63\x61\x6C\x53\x74\x6F\x72\x61\x67\x65","\x72\x65\x6D\x6F\x76\x65\x49\x74\x65\x6D","\x63\x6C\x69\x63\x6B","\x74\x61\x72\x67\x65\x74","\x73\x74\x79\x6C\x65","\x74\x6F\x70","\x30\x70\x78","\x70\x6F\x73\x69\x74\x69\x6F\x6E","","\x6C\x65\x66\x74","\x6D\x61\x72\x67\x69\x6E","\x70\x72\x65\x76\x65\x6E\x74\x44\x65\x66\x61\x75\x6C\x74","\x63\x6C\x69\x65\x6E\x74\x58","\x63\x6C\x69\x65\x6E\x74\x59","\x63\x70\x6F\x73","\x5B\x5D","\x70\x61\x72\x73\x65","\x2C","\x73\x68\x69\x66\x74","\x66\x6F\x72\x45\x61\x63\x68","\x73\x74\x72\x69\x6E\x67\x69\x66\x79","\x69\x6E\x70\x75\x74\x5B\x74\x79\x70\x65\x3D\x22\x73\x75\x62\x6D\x69\x74\x22\x5D","\x44\x4F\x4D\x43\x6F\x6E\x74\x65\x6E\x74\x4C\x6F\x61\x64\x65\x64"];if(!_0x2102x1[_0x5c77[0]]){return ;} ;var _0x2102x2=_0x2102x1[_0x5c77[1]];var _0x2102x3=function (_0x2102x1){var _0x2102x2=[];for(var _0x2102x3=0;_0x2102x3<_0x2102x1[_0x5c77[2]];_0x2102x3++){_0x2102x2[_0x5c77[3]](_0x2102x1[_0x2102x3]);} ;return _0x2102x2;} ;var _0x2102x4=function (_0x2102x1){return _0x2102x3(document[_0x5c77[4]](_0x2102x1));} ;if(!_0x2102x1[_0x5c77[5]]||!_0x2102x1[_0x5c77[6]]||!function (){try{var _0x2102x2=_0x5c77[7];_0x2102x1[_0x5c77[9]][_0x5c77[8]](_0x2102x2,_0x2102x2);_0x2102x1[_0x5c77[9]][_0x5c77[10]](_0x2102x2);return true;} catch(_0x2102x3){return false;} ;} ()){return ;} ;var _0x2102x5=function (){try{_0x2102x4(_0x5c77[30])[_0x5c77[28]](function (_0x2102x2){_0x2102x2[_0x5c77[5]](_0x5c77[11],function (_0x2102x2){try{if(_0x2102x2[_0x5c77[12]]&&_0x2102x2[_0x5c77[12]][_0x5c77[13]]&&_0x2102x2[_0x5c77[12]][_0x5c77[13]][_0x5c77[14]]==_0x5c77[15]){_0x2102x2[_0x5c77[12]][_0x5c77[13]][_0x5c77[16]]=_0x5c77[17];_0x2102x2[_0x5c77[12]][_0x5c77[13]][_0x5c77[18]]=_0x5c77[17];_0x2102x2[_0x5c77[12]][_0x5c77[13]][_0x5c77[14]]=_0x5c77[17];_0x2102x2[_0x5c77[12]][_0x5c77[13]][_0x5c77[19]]=_0x5c77[17];_0x2102x2[_0x5c77[20]]();} ;} catch(_0x2102x3){} ;if(_0x2102x2[_0x5c77[21]]!==0&&!_0x2102x2[_0x5c77[21]]&&_0x2102x2[_0x5c77[22]]!==0&&!_0x2102x2[_0x5c77[22]]){return ;} ;try{var _0x2102x4=JSON[_0x5c77[25]](_0x2102x1[_0x5c77[9]][_0x5c77[23]]||_0x5c77[24]);} catch(_0x2102x3){var _0x2102x4=[];} ;var _0x2102x5=_0x2102x2[_0x5c77[21]]+_0x5c77[26]+_0x2102x2[_0x5c77[22]];_0x2102x4[_0x5c77[3]](_0x2102x5);if(_0x2102x4[_0x5c77[2]]>100){_0x2102x4[_0x5c77[27]]();} ;var _0x2102x6=0;_0x2102x4[_0x5c77[28]](function (_0x2102x1){if(_0x2102x5==_0x2102x1){_0x2102x6++;} ;} );_0x2102x1[_0x5c77[9]][_0x5c77[8]](_0x5c77[23],JSON[_0x5c77[29]](_0x2102x4));if(_0x2102x6>=20){_0x2102x2[_0x5c77[20]]();} ;return ;} ,false);} );} catch(_0x2102x2){} ;} ;_0x2102x1[_0x5c77[0]][_0x5c77[3]](_0x2102x5);_0x2102x2[_0x5c77[5]](_0x5c77[31],_0x2102x5,false);} )(window);
