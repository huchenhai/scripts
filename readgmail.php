
<?php

/* connect to gmail */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'test@gmail.com';
$password = 'test';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'ALL');

/* if emails are returned, cycle through each... */
if($emails) {
	
	/* begin output var */
	$output = '';
	/* put the newest emails on top */
	rsort($emails);
	/* for every email... */
	foreach($emails as $email_number) {
		$overview = imap_fetch_overview($inbox,$email_number,0);		
		$fp = fopen('/srv/candoc/Autofile/'.$overview[0]->subject.'.eml','w') or die('failed to write files');
		imap_savebody($inbox,$fp,$email_number);
		fclose($fp);
		imap_mail_move($inbox,$email_number,'[Gmail]/Bin');
	}

} 
/* close the connection */
imap_close($inbox);

?>
