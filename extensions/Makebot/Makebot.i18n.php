<?php

/**
 * Internationalisation file for the MakeBot extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */

function efMakeBotMessages() {
	$messages = array(
	
/* English (Rob Church) */
'en' => array(
'makebot' => 'Grant or revoke bot status',
'makebot-header' => "'''A local bureaucrat can use this page to grant or revoke [[Help:Bot|bot status]] to another user account.'''<br />Bot status hides a user's edits from [[Special:Recentchanges|recent changes]] and similar lists, and is useful for flagging users who make automated edits. This should be done in accordance with applicable policies.",
'makebot-username' => 'Username:',
'makebot-search' => 'Go',
'makebot-isbot' => '[[User:$1|$1]] has bot status.',
'makebot-notbot' => '[[User:$1|$1]] does not have bot status.',
'makebot-privileged' => '[[User:$1|$1]] has [[Special:Listadmins|administrator or bureaucrat privileges]], and cannot be granted bot status.',
'makebot-change' => 'Change status:',
'makebot-grant' => 'Grant',
'makebot-revoke' => 'Revoke',
'makebot-comment' => 'Comment:',
'makebot-granted' => '[[User:$1|$1]] now has bot status.',
'makebot-revoked' => '[[User:$1|$1]] no longer has bot status.',
'makebot-logpage' => 'Bot status log',
'makebot-logpagetext' => 'This is a log of changes to users\' [[Help:Bot|bot]] status.',
'makebot-logentrygrant' => 'granted bot status to [[$1]]',
'makebot-logentryrevoke' => 'removed bot status from [[$1]]',
),

/* Old Church Slavonic (language file) */
'cu' => array(
'makebot-search' => 'Прѣиди',
),

/* Czech (bug 8455) */
'cs' => array(
'makebot' => 'Přidat nebo odebrat příznak bot',
'makebot-header' => "'''Místní byrokraté používají tuto stránku pro přidělení nebo odebrání příznaku [[{{ns:help}}:Bot|bot]] uživatelskému účtu.\'\'\'<br />Příznak bot zajisti, že editace uživatele jsou skryty ze stránky [[Special:Recentchanges|posledních změn]] a podobných seznamů. Jsou užitečné pro roboty provádějící automatické editace.",
'makebot-username' => 'Uživatelské jméno:',
'makebot-search' => 'Provést',
'makebot-isbot' => '[[User:$1|$1]] má příznak bot.',
'makebot-notbot' => '[[User:$1|$1]] nemá příznak bot.',
'makebot-privileged' => '[[User:$1|$1]] má [[Special:Listadmins|práva správce nebo byrokrata]], proto mu nemůže být přidělen příznak bot.',
'makebot-change' => 'Změnit stav:',
'makebot-grant' => 'Přidělit',
'makebot-revoke' => 'Odebrat',
'makebot-comment' => 'Komentář:',
'makebot-granted' => '[[User:$1|$1]] nyní má příznak bot.',
'makebot-revoked' => '[[User:$1|$1]] již nemá příznak bot.',
'makebot-logpage' => 'Kniha příznaků bot',
'makebot-logpagetext' => 'Tato kniha zobrazuje změny v udělovaných příznacích [[{{ns:help}}:Bot|bot]].',
'makebot-logentrygrant' => 'přiděluje účtu [[$1]] příznak bot',
'makebot-logentryrevoke' => 'odebírá účtu [[$1]] příznak bot',
),

/* German (Raymond) */
'de' => array(
'makebot' => 'Botstatus erteilen oder entziehen',
'makebot-header' => "'''Ein Bürokrat dieses Projektes kann anderen Benutzern – in Übereinstimmung mit den lokalen Richtlinien – [[Help:Bot|Botstatus]] erteilen oder entziehen.'''<br /> Mit Botstatus werden die Bearbeitungen eines Bot-Benutzerkontos in den [[Special:Recentchanges|Letzten Änderungen]] und ähnlichen Listen versteckt. Die Botmarkierung ist darüberhinaus zur Feststellung automatischer Bearbeitungen nützlich.",
'makebot-username' => 'Benutzername:',
'makebot-search' => 'Ausführen',
'makebot-isbot' => '[[User:$1|$1]] hat Botstatus.',
'makebot-notbot' => '[[User:$1|$1]] hat keinen Botstatus.',
'makebot-privileged' => '[[User:$1|$1]] hat [[Special:Listusers/sysop|Administrator- oder Bürokratenrechte]], Botstatus kann nicht erteilt werden.',
'makebot-change' => 'Status ändern:',
'makebot-grant' => 'Erteilen',
'makebot-revoke' => 'Zurücknehmen',
'makebot-comment' => 'Kommentar:',
'makebot-granted' => '[[User:$1|$1]] hat nun Botstatus.',
'makebot-revoked' => '[[User:$1|$1]] hat keinen Botstatus mehr.',
'makebot-logpage' => 'Botstatus-Logbuch',
'makebot-logpagetext' => 'Dieses Logbuch protokolliert alle [[Help:Bot|Botstatus]]-Änderungen.',
'makebot-logentrygrant' => 'erteilte Botstatus für [[$1]]',
'makebot-logentryrevoke' => 'entfernte den Botstatus von [[$1]]',
),

/* Finnish (Niklas Laxström) */
'fi' => array(
'makebot' => 'Anna tai poista botti-merkintä',
'makebot-header' => "'''Paikallinen byrokraatti voi antaa tai poista [[Ohje:Botti|botti-merkinnän]] toiselle käyttäjätunnukselle.'''<br />Botti-merkintä piilottaa botti-tunnuksella tehdyt muokkaukset [[Special:Recentchanges|tuoreista muutoksista]] ja vastaavista listoista. Merkintä on hyödyllinen, jos tunnuksella tehdään automaattisia muutoksia. Merkinnän antaminen tai poistaminen tulee tapahtua voimassa olevien käytäntöjen mukaan.",
'makebot-username' => 'Tunnus:',
'makebot-search' => 'Hae',
'makebot-isbot' => '[[User:$1|$1]] on botti.',
'makebot-notbot' => '[[User:$1|$1]] ei ole botti.',
'makebot-privileged' => '[[User:$1|$1]] on [[Special:Listadmins|ylläpitäjä tai byrokraatti]], eikä hänelle voida myöntää botti-merkintää.',
'makebot-change' => 'Muuta merkintää:',
'makebot-grant' => 'Anna',
'makebot-revoke' => 'Poista',
'makebot-comment' => 'Kommentti:',
'makebot-granted' => '[[User:$1|$1]] on nyt botti.',
'makebot-revoked' => '[[User:$1|$1]] ei ole enää botti.',
'makebot-logpage' => 'Botti-loki',
'makebot-logpagetext' => 'Tämä on loki muutoksista käyttäjätunnusten [[Ohje:Botti|botti-merkintään]].',
'makebot-logentrygrant' => 'antoi botti-merkinnän tunnukselle [[$1]]',
'makebot-logentryrevoke' => 'poisti botti-merkinnän tunnukselta [[$1]]',
),

/* French (Bertrand Grondin) */
'fr' => array(
'makebot' => 'Donner ou retirer les droits de bot',
'makebot-header' => "'''Un bureaucrate local peut utiliser cette page pour accorder ou révoquer le [[Aide:Bot|Statut de Bot]] à un autre compte d'utilisateur.'''<br />Le statut de bot a pour particularité de masquer les éditions des utilisateurs dans la page des [[Special:Recentchanges|modification récentes]] et de toutes autres listes similaires. Ceci est très utile pour marquer les utilisateurs qui veulent faire des éditions automatiques. Ceci ne doit être fait que conformément aux règles édictées au sein de chaque projet.",
'makebot-username' => 'Nom d’utilisateur :',
'makebot-search' => 'Valider',
'makebot-isbot' => '[[User:$1|$1]] a le statut de bot.',
'makebot-notbot' => '[[User:$1|$1]] n’a pas le statut de bot.',
'makebot-privileged' => '[[User:$1|$1]] est déjà [[Special:Listadmins|un administrateur]] et ne peut avoir le statut de « bot ».',
'makebot-change' => 'Changer les droits :',
'makebot-grant' => 'Accorder',
'makebot-revoke' => 'Révoquer',
'makebot-comment' => 'Commentaire :',
'makebot-granted' => '[[User:$1|$1]] a désormais le statut de bot.',
'makebot-revoked' => '[[User:$1|$1]] n’a plus le statut de bot.',
'makebot-logpage' => 'Historique des changements de statut des bots',
'makebot-logpagetext' => 'Cette page répertorie les changements (acquisitions et pertes) de statut des [[Project:Bot|bots]].',
'makebot-logentrygrant' => 'a donné le statut de bot à [[$1]]',
'makebot-logentryrevoke' => 'a retiré le statut de bot de [[$1]]',
),

/* Hebrew (Rotem Liss) */
'he' => array(
'makebot'          => 'הענק או בטל הרשאת בוט',
'makebot-header'   => "'''ביורוקרט מקומי יכול להשתמש בדף זה כדי להעניק או לבטל [[{{ns:help}}:בוט|הרשאת בוט]] למשתמש אחר.'''<br />הרשאת בוט מסתירה את עריכותיו של המשתמש מ[[{{ns:special}}:Recentchanges|השינויים האחרונים]] ורשימות דומות, ושימושי למשתמשים המבצעים עריכות אוטומטיות. יש להעניק הרשאת בוט אך ורק לפי הנהלים המתאימים.",
'makebot-username' => 'שם משתמש:',
'makebot-search'   => 'עבור',
'makebot-isbot'      => 'למשתמש [[{{ns:user}}:$1|$1]] יש הרשאת בוט.',
'makebot-notbot'     => 'למשתמש [[{{ns:user}}:$1|$1]] אין הרשאת בוט.',
'makebot-privileged' => 'למשתמש [[{{ns:user}}:$1|$1]] יש כבר [[{{ns:special}}:Listadmins|הרשאות מפעיל מערכת או ביורוקרט]], ולפיכך אי אפשר להעניק לו דגל בוט.',
'makebot-change'     => 'מה לבצע:',
'makebot-grant'      => 'הענקת הרשאה',
'makebot-revoke'     => 'ביטול הרשאה',
'makebot-comment'    => 'סיבה:',
'makebot-granted'    => 'המשתמש [[{{ns:user}}:$1|$1]] קיבל הרשאת בוט.',
'makebot-revoked'    => 'הרשאת הבוט של המשתמש [[{{ns:user}}:$1|$1]] הוסרה בהצלחה.',
'makebot-logpage'        => 'יומן הרשאות בוט',
'makebot-logpagetext'    => 'זהו יומן השינויים בהרשאות ה[[{{ns:help}}:בוט|בוט]] של המשתמשים.',
'makebot-logentrygrant'  => 'העניק הרשאת בוט למשתמש [[$1]]',
'makebot-logentryrevoke' => 'ביטל את הרשאת הבוט למשתמש [[$1]]',
),

/* Italian (BrokenArrow) */
'it' => array(
'makebot' => 'Assegna o revoca lo status di bot',
'makebot-header' => "'''Questa pagina consente ai burocrati di assegnare o revocare lo [[{{ns:help}}:Bot|status di bot]] a un'altra utenza.'''<br /> Tale status nasconde le modifiche effettuate dall'utenza nell'elenco delle [[{{ns:special}}:Recentchanges|ultime modifiche]] e nelle liste simili; è utile per contrassegnare le utenze che effettuano modifiche in automatico. Tale operazione dev'essere effettuata in conformità con le policy del sito.",
'makebot-username' => 'Nome utente:',
'makebot-search' => 'Vai',
'makebot-isbot' => 'L\'utente [[{{ns:user}}:$1|$1]] ha lo status di bot.',
'makebot-notbot' => 'L\'utente [[{{ns:user}}:$1|$1]] non ha lo status di bot.',
'makebot-privileged' => 'L\'utente [[{{ns:user}}:$1|$1]] possiede i privilegi di [[Special:Listadmins|amministratore o burocrate privileges]], che sono incompatibili con lo status di bot.',
'makebot-change' => 'Modifica lo status:',
'makebot-grant' => 'Concedi',
'makebot-revoke' => 'Revoca',
'makebot-comment' => 'Commento:',
'makebot-granted' => 'L\'utente [[{{ns:user}}:$1|$1]] ha ora lo status di bot.',
'makebot-revoked' => 'L\'utente [[{{ns:user}}:$1|$1]] non ha più lo status di bot.',
'makebot-logpage' => 'Registro dei bot',
'makebot-logpagetext' => 'Qui di seguito viene riportata la lista dei cambiamenti di status dei [[{{ns:help}}:bot]].',
'makebot-logentrygrant' => 'ha concesso lo status di bot a [[$1]]',
'makebot-logentryrevoke' => 'ha revocato lo status di bot a [[$1]]',
),

/* nld . Dutch (Siebrand Mazeland) */
'nl' => array(
'makebot' => 'Botstatus beheren',
'makebot-header' => "'''Een lokale bureaucraat kan via deze pagina een [[Help:Bot|botstatus]] aan een andere gebruiker verlenen of die status intrekken.'''<br />De botstatus verbergt de bewerkingen van een gebruiker in de [[Special:Recentchanges|recente wijzigingen]] en gelijksoortige lijsten. Het is handig voor gebruikers die automatisch bewerkingen maken. Dit hoort aan de hand van het geldende beleid te gebeuren.",
'makebot-username' => 'Gebruiker:',
'makebot-search' => 'OK',
'makebot-isbot' => '[[User:$1|$1]] heef de botstatus.',
'makebot-notbot' => '[[User:$1|$1]] heeft geen botstatus.',
'makebot-privileged' => '[[User:$1|$1]] heeft de rol [[Special:Listadmins|beheerder of bureaucraat]] en kan geen botstatus krijgen.',
'makebot-change' => 'Status wijzigen:',
'makebot-grant' => 'Verlenen',
'makebot-revoke' => 'Intrekken',
'makebot-comment' => 'Opmerking:',
'makebot-granted' => '[[User:$1|$1]] heeft nu de botstatus.',
'makebot-revoked' => '[[User:$1|$1]] heeft niet langer de botstatus.',
'makebot-logpage' => 'Botstatuslogboek',
'makebot-logpagetext' => 'Dit is een logboek waarin wijzigingen ten aanzien van de [[Help:Bot|botstatus]] van gebruikers te zien zijn.',
'makebot-logentrygrant' => 'heeft de botstatus gegeven aan [[$1]]',
'makebot-logentryrevoke' => 'heeft de botstatus van [[$1]] ingetrokken',
),

/* Portuguese (Lugusto) */
'pt' => array(
'makebot' => 'Conceder ou remover estatuto de bot',
'makebot-header' => "'''Um burocrata local poderá a partir desta página conceder ou remover [[Help:Bot|estatutos de bot]] em outras contas de utilizador.'''<br />Um estatuto de bot faz com que as edições do utilizador sejam ocultadas da página de [[Special:Recentchanges|mudanças recentes]] e listagens similares, sendo bastante útil para marcar contas de utilizadores que façam edições automatizadas. Isso deverá ser feito de acordo com as políticas aplicáveis.",
'makebot-username' => 'Utilizador:',
'makebot-search' => 'Ir',
'makebot-isbot' => '[[User:$1|$1]] possui estatuto de bot.',
'makebot-notbot' => '[[User:$1|$1]] não possui estatuto de bot.',
'makebot-privileged' => '[[User:$1|$1]] possui [[Special:Listadmins|privilégios de administrador ou burocrata]], não podendo que o estatuto de bot seja a ele concedido.',
'makebot-change' => 'Alterar estado:',
'makebot-grant' => 'Conceder',
'makebot-revoke' => 'Remover',
'makebot-comment' => 'Comentário:',
'makebot-granted' => '[[User:$1|$1]] agora possui estatuto de bot.',
'makebot-revoked' => '[[User:$1|$1]] deixou de ter estatuto de bot.',
'makebot-logpage' => 'Registo de estatutos de bot',
'makebot-logpagetext' => 'Este é um registo de alterações quanto ao\' estatuto de [[Help:Bot|bot]].',
'makebot-logentrygrant' => 'concedido estatuto de bot para [[$1]]',
'makebot-logentryrevoke' => 'removido estatuto de bot para [[$1]]',
),

/* Indonesian (Ivan Lanin) */
'id' => array(
'makebot' => 'Pemberian atau penarikan status bot',
'makebot-header' => "'''Birokrat lokal dapat menggunakan halaman ini untuk memberikan atau menarik [[Help:Bot|status bot]] untuk akun pengguna lain.'''<br />Status bot akan menyembunyikan suntingan pengguna dari [[Special:Recentchanges|perubahan terbaru]] dan daftar serupa lainnya, dan berguna untuk menandai pengguna yang melakukan penyuntingan otomatis. Hal ini harus dilakukan sesuai dengan kebijakan yang telah digariskan.",
'makebot-username' => 'Nama pengguna:',
'makebot-search' => 'Cari',
'makebot-isbot' => '[[User:$1|$1]] mempunyai status bot.',
'makebot-notbot' => '[[User:$1|$1]] tak mempunyai status bot.',
'makebot-privileged' => '[[User:$1|$1]] mempunyai [[Special:Listadmins|berstatus pengurus atau birokrat]], karenanya tak bisa mendapat status bot.',
'makebot-change' => 'Ganti status:',
'makebot-grant' => 'Berikan',
'makebot-revoke' => 'Tarik',
'makebot-comment' => 'Komentar:',
'makebot-granted' => '[[User:$1|$1]] sekarang mempunyai status bot.',
'makebot-revoked' => '[[User:$1|$1]] sekarang tidak lagi mempunyai status bot.',
'makebot-logpage' => 'Log perubahan status bot',
'makebot-logpagetext' => 'Di bawah adalah log perubahan status [[Help:Bot|bot]] pengguna.',
'makebot-logentrygrant' => 'memberikan status bot untuk [[$1]]',
'makebot-logentryrevoke' => 'menarik status bot dari [[$1]]',
),

/* Slovak (helix84) */
'sk' => array(
'makebot' => 'Udeliť alebo odobrať status bota',
'makebot-header' => "'''Miestny byrokrat m§že použiť túto stránku na udelenie alebo odobranie [[Help:Bot|statusu bot]] inému užívateľskému účtu.'''<br />Status bot skrýva úpravy používateľa z [[Special:Recentchanges|posledných zmien]] a podobných zoznamov, používa sa na označenie používateľov, ktorí robia automatizované úpravy. Využívanie tejto stránky by malo prebiehať v súlade s prijatými zásadami.",
'makebot-username' => 'Používateľské meno:',
'makebot-search' => 'Choď',
'makebot-isbot' => '[[User:$1|$1]] má status bot.',
'makebot-notbot' => '[[User:$1|$1]] nemá status bot.',
'makebot-privileged' => '[[User:$1|$1]] má [[Special:Listadmins|privilégiá správcu alebo byrokrata]], a preto mu nemôže byt udelený status bot.',
'makebot-change' => 'Zmeniť stav:',
'makebot-grant' => 'Udeliť',
'makebot-revoke' => 'Odobrať',
'makebot-comment' => 'Komentár:',
'makebot-granted' => '[[User:$1|$1]] odteraz má status bot.',
'makebot-revoked' => '[[User:$1|$1]] odteraz nemá status bot.',
'makebot-logpage' => 'Záznam statusu bot',
'makebot-logpagetext' => 'Toto je záznam zmien statusu [[Help:Bot|bot]] používateľov.',
'makebot-logentrygrant' => 'udelený status bot užívateľovi [[$1]]',
'makebot-logentryrevoke' => 'odobratý status bot užívateľovi [[$1]]',
),

/* Serbian default (Sasa Stefanovic) */
'sr' => array(
'makebot' => 'Давање или одузимање статуса бота',
'makebot-header' => "'''Локални бирократа може користити ову страну да даје или одузима [[Помоћ:Бот|статус бота]] неком другом корисничком налогу.'''<br />Статус бота скрива измене корисника са [[Посебно:Recentchanges|скорашњих измена]] и сличних листа и користан је за обележавање корисника који врше аутоматске измене. Ово треба да се ради у складу са одговарајућим политикама.",
'makebot-username' => 'Корисничко име:',
'makebot-search' => 'Иди',
'makebot-isbot' => '[[User:$1|$1]] има статус бота.',
'makebot-notbot' => '[[User:$1|$1]] нема статус бота.',
'makebot-privileged' => '[[Корисник:$1|$1]] има [[Посебно:Listadmins|администраторске или бирократске привилегије]], и не може му се доделити статус бота.',
'makebot-change' => 'Промени статус:',
'makebot-grant' => 'Дај',
'makebot-revoke' => 'Одузми',
'makebot-comment' => 'Коментар:',
'makebot-granted' => '[[Корисник:$1|$1]] сада има статус бота.',
'makebot-revoked' => '[[Корисник:$1|$1]] више нема статус бота.',
'makebot-logpage' => 'историја статуса бота',
'makebot-logpagetext' => 'Ово је историја измена статуса [[Помоћ:Бот|бота]] корисника.',
'makebot-logentrygrant' => 'дао статус бота: [[$1]]',
'makebot-logentryrevoke' => 'уклонио статус бота: [[$1]]',
),

/* Serbian cyrillic (Sasa Stefanovic) */
'sr-ec' => array(
'makebot' => 'Давање или одузимање статуса бота',
'makebot-header' => "'''Локални бирократа може користити ову страну да даје или одузима [[Помоћ:Бот|статус бота]] неком другом корисничком налогу.'''<br />Статус бота скрива измене корисника са [[Посебно:Recentchanges|скорашњих измена]] и сличних листа и користан је за обележавање корисника који врше аутоматске измене. Ово треба да се ради у складу са одговарајућим политикама.",
'makebot-username' => 'Корисничко име:',
'makebot-search' => 'Иди',
'makebot-isbot' => '[[User:$1|$1]] има статус бота.',
'makebot-notbot' => '[[User:$1|$1]] нема статус бота.',
'makebot-privileged' => '[[Корисник:$1|$1]] има [[Посебно:Listadmins|администраторске или бирократске привилегије]], и не може му се доделити статус бота.',
'makebot-change' => 'Промени статус:',
'makebot-grant' => 'Дај',
'makebot-revoke' => 'Одузми',
'makebot-comment' => 'Коментар:',
'makebot-granted' => '[[Корисник:$1|$1]] сада има статус бота.',
'makebot-revoked' => '[[Корисник:$1|$1]] више нема статус бота.',
'makebot-logpage' => 'историја статуса бота',
'makebot-logpagetext' => 'Ово је историја измена статуса [[Помоћ:Бот|бота]] корисника.',
'makebot-logentrygrant' => 'дао статус бота: [[$1]]',
'makebot-logentryrevoke' => 'уклонио статус бота: [[$1]]',
),

/* Serbian latin (Sasa Stefanovic) */
'sr-el' => array(
'makebot' => 'Davanje ili oduzimanje statusa bota',
'makebot-header' => "'''Lokalni birokrata može koristiti ovu stranu da daje ili oduzima [[Pomoć:Bot|status bota]] nekom drugom korisničkom nalogu.'''<br />Status bota skriva izmene korisnika sa [[Posebno:Recentchanges|skorašnjih izmena]] i sličnih lista i koristan je za obeležavanje korisnika koji vrše automatske izmene. Ovo treba da se radi u skladu sa odgovarajućim politikama.",
'makebot-username' => 'Korisničko ime:',
'makebot-search' => 'Idi',
'makebot-isbot' => '[[User:$1|$1]] ima status bota.',
'makebot-notbot' => '[[User:$1|$1]] nema status bota.',
'makebot-privileged' => '[[Korisnik:$1|$1]] ima [[Posebno:Listadmins|administratorske ili birokratske privilegije]], i ne može mu se dodeliti status bota.',
'makebot-change' => 'Promeni status:',
'makebot-grant' => 'Daj',
'makebot-revoke' => 'Oduzmi',
'makebot-comment' => 'Komentar:',
'makebot-granted' => '[[Korisnik:$1|$1]] sada ima status bota.',
'makebot-revoked' => '[[Korisnik:$1|$1]] više nema status bota.',
'makebot-logpage' => 'istorija statusa bota',
'makebot-logpagetext' => 'Ovo je istorija izmena statusa [[Pomoć:Bot|bota]] korisnika.',
'makebot-logentrygrant' => 'dao status bota: [[$1]]',
'makebot-logentryrevoke' => 'uklonio status bota: [[$1]]',
),

/* Walloon (language file) */
'wa' => array(
'makebot' => 'Diner ou rsaetchî l\' livea d\' robot',
'makebot-header' => '\'\'\'On mwaisse-manaedjeu sol wiki pout eployî cisse pådje ci po dner ou rsaetchî l\' [[{{ns:help}}:Robots|livea d\' robot]] a èn ôte conte d\' uzeu.\'\'\'<br />El livea d\' robot fwait ki les candjmints da cist uzeu la si polèt catchî dins l\' pådje des [[{{special}}:Recentchanges|dierins candjmints]] et des sfwaitès djivêyes, çou k\' est ahessåve po mårker les uzeus ki fjhèt des candjmints otomatikes. Çoula doet esse fwait tot shuvant les rîles ki s\' aplikèt.',
'makebot-username' => 'No d\' uzeu:',
'makebot-search' => 'I va',
'makebot-change' => 'Candjî l\' livea:',
'makebot-grant' => 'Diner',
'makebot-revoke' => 'Rissaetchî',
'makebot-comment' => 'Comintaire:',
'makebot-logpage' => 'Djournå des liveas d\' robot',
'makebot-granted' => '[[{{ns:user}}:$1|$1]] a-st asteure li livea d\' robot.',
'makebot-isbot' => '[[{{ns:user}}:$1|$1]] a l\' livea d\' robot.',
'makebot-logentrygrant' => 'a dné l\' livea d\' robot a [[$1]]',
'makebot-logentryrevoke' => 'a rsaetchî l\' livea d\' robot da [[$1]]',
'makebot-logpagetext' => 'Çouchal, c\' est on djournå des dinaedjes eyet rsaetchaedjes do [[{{ns:help}}:Robots|livea d\' robot]] a des uzeus.',
'makebot-notbot' => '[[{{ns:user}}:$1|$1]] n\' a nén l\' livea d\' robot',
'makebot-privileged' => '[[{{ns:user}}:$1|$1]] a ddja on livea d\' [[{{ns:special}}:Listadmins|manaedjeu ou mwaisse-manaedjeu]], ça fwait k\' i n\' pout nén eployî ç\' conte la po on robot.',
'makebot-revoked' => '[[{{ns:user}}:$1|$1]] n\' a pus d\' livea d\' robot.',
),

/* Chinese (China) (下一次登录) */
'zh-cn' => array(
'makebot' => '授予或中止机器人身份',
'makebot-header' => "'''本地行政员可以使用此页授予或中止另一个帐号的[[Help:机器人|机器人身份]]。'''<br />机器人状态会导致该用户的编辑不被显示在[[Special:Recentchanges|最近更改]]和其他类似列表中，因此用于标识进行自动编辑的用户，但需要依据相应的可行方针。",
'makebot-username' => '用户名：',
'makebot-search' => '搜索',
'makebot-isbot' => '[[User:$1|$1]]拥有机器人身份。',
'makebot-notbot' => '[[User:$1|$1]]没有机器人身份。',
'makebot-privileged' => '[[User:$1|$1]]是[[Special:Listadmins|管理员]]，不能接受机器人身份。',
'makebot-change' => '改变身份：',
'makebot-grant' => '授予',
'makebot-revoke' => '中止',
'makebot-comment' => '备注：',
'makebot-granted' => '[[User:$1|$1]]拥有了机器人身份。',
'makebot-revoked' => '[[User:$1|$1]]已不再拥有机器人身份。',
'makebot-logpage' => '机器人状态日志',
'makebot-logpagetext' => '这是用户[[Help:机器人|机器人]]更改的日志。',
'makebot-logentrygrant' => '授予[[$1]]机器人身份',
'makebot-logentryrevoke' => ' 中止[[$1]]的机器人身份',
),

/* Chinese (Hong Kong) (KilluaZaoldyeck, Shinjiman) */
'zh-hk' => array(
'makebot' => '授予或終止機械人身份',
'makebot-header' => "'''所屬行政員允許使用此頁面授予或終止另一個帳號的[[Help:機械人|機械人身份]]。'''<br />機械人身份的帳號所進行的修改將不被顯示在[[Special:Recentchanges|最近更改]]和其他類關列表中，因此，此身份用於標記自動編輯的帳號。此項的相關操作必須符合現行方針。",
'makebot-username' => '用戶名：',
'makebot-search' => '搜索',
'makebot-isbot' => '[[User:$1|$1]]擁有機械人身份。',
'makebot-notbot' => '[[User:$1|$1]]沒有機械人身份。',
'makebot-privileged' => '[[User:$1|$1]]是[[Special:Listadmins|管理員]]，不能使用機械人身份。',
'makebot-change' => '改變身份：',
'makebot-grant' => '授予',
'makebot-revoke' => '終止',
'makebot-comment' => '備註：',
'makebot-granted' => '[[User:$1|$1]]擁有機械人身份。',
'makebot-revoked' => '[[User:$1|$1]]失去機械人身份。',
'makebot-logpage' => '機械人身份記錄',
'makebot-logpagetext' => '這是用戶[[Help:機械人|機械人]]更改的記錄。',
'makebot-logentrygrant' => '授予[[$1]]機械人身份',
'makebot-logentryrevoke' => ' 終止[[$1]]機械人身份',
),

/* Chinese (Taiwan) (KilluaZaoldyeck, Shinjiman) */
'zh-tw' => array(
'makebot' => '授予或終止機器人身分',
'makebot-header' => "'''所屬行政員允許使用此頁面授予或終止另一個帳號的[[Help:機器人|機器人身分]]。'''<br />機器人身分的帳號所進行的修改將不被顯示在[[Special:Recentchanges|最近更改]]和其他類關列表中，因此，此身分用於標記自動編輯的帳號。此項的相關操作必須符合現行方針。",
'makebot-username' => '帳號名稱：',
'makebot-search' => '搜索',
'makebot-isbot' => '[[User:$1|$1]]擁有機器人身分。',
'makebot-notbot' => '[[User:$1|$1]]沒有機器人身分。',
'makebot-privileged' => '[[User:$1|$1]]是[[Special:Listadmins|管理員]]，不能使用機器人身分。',
'makebot-change' => '改變身分：',
'makebot-grant' => '授予',
'makebot-revoke' => '終止',
'makebot-comment' => '備註：',
'makebot-granted' => '[[User:$1|$1]]擁有機器人身分。',
'makebot-revoked' => '[[User:$1|$1]]失去機器人身分。',
'makebot-logpage' => '機器人身分記錄',
'makebot-logpagetext' => '這是用戶[[Help:機器人|機器人]]更改的記錄。',
'makebot-logentrygrant' => '授予[[$1]]機器人身分',
'makebot-logentryrevoke' => ' 終止[[$1]]機器人身分',
),

/* Cantonese (Hillgentleman, Shinjiman) */
'zh-yue' => array(
'makebot' => '畀或收番機械人身份',
'makebot-header' => "'''本地事務員可以用哩頁畀或收番另一用户嘅 [[Help:機械人|機械人身份]]。'''<br />機械人可以喺[[Special:Recentchanges|最近更改]]之類嘅表道匿埋。機械人身份可用來嘜住啲自動化嘅編者。記住要參攷相關嘅政策。",
'makebot-username' => '用户名：',
'makebot-search' => '去',
'makebot-isbot' => '[[User:$1|$1]] 係隻機械人。',
'makebot-notbot' => '[[User:$1|$1]]唔係一隻機械人。',
'makebot-privileged' => '[[User:$1|$1]] 係 [[Special:Listadmins|管理員]]，唔准扮機械人。',
'makebot-change' => '改身份：',
'makebot-grant' => '畀',
'makebot-revoke' => '收番',
'makebot-comment' => '評論：',
'makebot-granted' => '[[User:$1|$1]] 而家係隻機械人。',
'makebot-revoked' => '[[User:$1|$1]] 而家唔一係隻機械人。',
'makebot-logpage' => '機械人身份記錄',
'makebot-logpagetext' => '哩頁紀錄各用户啲 [[Help:機械人|機械人]]身份記錄。',
'makebot-logentrygrant' => '畀咗[[$1]]嘅機械人身份',
'makebot-logentryrevoke' => ' 收番[[$1]]嘅機械人身份',
),

	);
	/* Chinese (Singapore), inherited from Chinese (China) */
	$messages['zh-sg'] = $messages['zh-cn'];
	return $messages;
}
?>
