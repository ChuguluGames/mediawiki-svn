<?php

$aliases = array();
$messages = array();

$aliases['en'] = array(
	'Notificator' => array( 'Notificator' ),
);

$messages['qqq'] = array(
	'notificator' => 'Name',
	'notificator-description' => 'Description',
	'notificator-db-table-does-not-exist' => 'Error message',
	'notificator-e-mail-address' => 'Hint in text entry field',
	'notificator-notify' => 'Button label',
	'notificator-notify-address-or-name' => 'Button label',
	'notificator-revs-not-from-same-title' => 'Error message (unlikely to show up)',
	'notificator-return-to' => 'Link at the bottom of the special page',
	'notificator-special-page-accessed-directly' => 'Error message',
	'notificator-e-mail-address-invalid' => 'Error message',
	'notificator-notification-not-sent' => 'Message on special page',
	'notificator-change-tag' => 'Tag that goes into the e-mail subject (should be as short as possible)',
	'notificator-new-tag' => 'Tag that goes into the e-mail subject (should be as short as possible)',
	'notificator-notification-text-changes' => 'Message on special page',
	'notificator-notification-text-new' => 'Message on special page',
	'notificator-following-e-mail-sent-to' => 'Message on special page',
	'notificator-subject' => 'Clarifies that the following text is an e-mail subject',
	'notificator-error-sending-e-mail' => 'Error message',
	'notificator-error-parameter-missing' => 'Error message (unlikely to show up)',
	'notificator-notified-already' => 'Message on special page',
);

$messages['en'] = array(
	'notificator' => 'Notificator',
	'notificator-description' => 'Notifies someone by e-mail about changes to a page when a button on that page gets clicked.',
	'notificator-db-table-does-not-exist' => 'Database table \'notificator\' does not exist. The update.php maintenance script needs to be run before the Notificator extension can be used.',
	'notificator-e-mail-address' => 'e-mail address',
	'notificator-notify' => 'Notify',
	'notificator-notify-address-or-name' => 'Notify $1',
	'notificator-revs-not-from-same-title' => 'Revision IDs are not from the same title/article',
	'notificator-return-to' => 'Return to',
	'notificator-special-page-accessed-directly' => 'This special page cannot be accessed directly. It is intended to be used through a Notificator button.',
	'notificator-e-mail-address-invalid' => 'The provided e-mail address is invalid.',
	'notificator-notification-not-sent' => 'Notification <em>not</em> sent.',
	'notificator-change-tag' => 'change',
	'notificator-new-tag' => 'new',
	'notificator-notification-text-changes' => '$1 wants to notify you about the following changes to $2:',
	'notificator-notification-text-new' => '$1 wants to notify you about $2.',
	'notificator-following-e-mail-sent-to' => 'The following e-mail has been sent to <em>$1</em>:',
	'notificator-subject' => 'Subject:',
	'notificator-error-sending-e-mail' => 'There was an error when sending the notification e-mail to <em>$1</em>.',
	'notificator-error-parameter-missing' => 'Error: Missing parameter.',
	'notificator-notified-already' => '$1 has been notified about this page or page change before.',
);

$messages['de'] = array(
	'notificator' => 'Notificator',
	'notificator-description' => 'Sendet Benachrichtungs-Mails über Seitenänderungen, wenn ein Knopf auf der entsprechenden Seite betätigt wird.',
	'notificator-db-table-does-not-exist' => 'Datenbanktabelle \'notificator\' existiert nicht. Das update.php Maintenance Script muss ausgeführt werden, bevor die Notificator-Extension verwendet werden kann.',
	'notificator-e-mail-address' => 'E-Mail-Adresse',
	'notificator-notify' => 'Benachrichtigen',
	'notificator-notify-address-or-name' => '$1 benachrichtigen',
	'notificator-revs-not-from-same-title' => 'Revision-IDs gehören nicht zum selben Titel/Artikel',
	'notificator-return-to' => 'Zurück zu',
	'notificator-special-page-accessed-directly' => 'Auf diese Spezial-Seite kann nicht direkt zugegriffen werden. Sie sollte über einen Notificator-Knopf verwendet werden.',
	'notificator-e-mail-address-invalid' => 'Die angegebene E-Mail-Adresse ist ungültig.',
	'notificator-notification-not-sent' => 'Benachrichtigung <em>nicht</em> gesendet.',
	'notificator-change-tag' => 'Änderung',
	'notificator-new-tag' => 'Neu',
	'notificator-notification-text-changes' => '$1 möchte Sie zu folgenden Änderungen an $2 benachrichtigen:',
	'notificator-notification-text-new' => '$1 möchte Sie zu $2 benachrichtigen.',
	'notificator-following-e-mail-sent-to' => 'Folgende E-Mail wurde an <em>$1</em> gesendet:',
	'notificator-subject' => 'Betreff:',
	'notificator-error-sending-e-mail' => 'Beim Versenden der Benachrichtigungs-Mail an <em>$1</em> ist ein Fehler aufgetreten.',
	'notificator-error-parameter-missing' => 'Fehler: Fehlender Parameter.',
	'notificator-notified-already' => '$1 wurde bereits zu dieser Seite oder Seitenänderung benachrichtigt.',
);