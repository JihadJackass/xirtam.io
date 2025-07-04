<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/global.css" media="screen" />
<link rel="stylesheet" type="text/css" href="http://static.pokemon-vortex.com/css/black/game.css" media="screen" />
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<title>v3</title>

<script>

$(document).ready(function () {
            $('#dialog-confirm').hide();

            $("#btnArchive").click(function () {
                $('#dialog-confirm').dialog({
                    resizable: false,
                    height: "600",
                    width: "800",
                    modal: true,
                    buttons: {
                        "Close": function () {
                            $(this).dialog("close");
                        },
                        "Message": function () {
                            $(this).dialog("close");
                        },
                        "Friend": function () {
                            $(this).dialog("close");
                        },
                        "Ignore": function () {
                            $(this).dialog("close");
                        },
                        "Trade": function () {
                            $(this).dialog("close");
                        },
                        Battle: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            });
        });

       </script>
</head>
<body>
<form id="form1" runat="server">
<div id="page" style="text-align:center;">
<div id="header">
<h2>Profile</h2>
<asp:Button ID="btnMnu" runat="server" Text="Manage Tasks" PostBackUrl="http://v3.pokemon-vortex.com/tabs/members.php?uid=1" />
<input id="btnArchive" type="button" value="Patrick's Profile" />
<asp:Button ID="btnDelete" runat="server" Text="Delete Selected" />
</div>
<div id="dialog-confirm" title="Patrick's Profile">
<p>
<?php
$_REQUEST['uid'] = '1';
include('/var/www/html/v3/jqueryprofile.php');
?>
<span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>
</p>
</div>
<div id="footer">
</div>
</div>
</form>
</body>
</html>