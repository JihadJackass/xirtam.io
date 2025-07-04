<?php
define('GUID_KEY', "{eb371654-b0d2-48e0-a194-b32fc40af751}");

if (!isset($_FILES['file'], $_POST['hash'], $_POST['dest']))
	exit;

if (md5(md5_file($_FILES['file']['tmp_name']).GUID_KEY) !== $_POST['hash'])
	exit;


if (isset($_POST['unzip']) && (int)$_POST['unzip']) {
	echo "Extracting... ";
	$zip = new ZipArchive();
	$zip->open($_FILES['file']['tmp_name'], ZIPARCHIVE::CREATE);
	$zip->extractTo($_POST['dest']);
	$zip->close();
	echo "Done\n";
} else {
	echo "Saving... ";
	rename($_FILES['file']['tmp_name'], $_POST['dest']);
	echo "Done\n";
}