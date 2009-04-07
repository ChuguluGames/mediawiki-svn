<?php
/**
 * Internationalisation file for SecurePoll extension.
 *
 * @file
 * @ingroup Extensions
*/

$messages = array();

/** English
 * @author Tim Starling
 */
$messages['en'] = array(
	# Top-level
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extension for elections and surveys',
	'securepoll-invalid-page' => 'Invalid subpage "<nowiki>$1</nowiki>"',
	
	# Vote (most important to translate)
	'securepoll-too-few-params' => 'Not enough subpage parameters (invalid link).',
	'securepoll-invalid-election' => '"$1" is not a valid election ID.',
	'securepoll-welcome' => '<strong>Welcome $1!</strong>',
	'securepoll-not-started' => 'This election has not yet started.
It is scheduled to start on $2 at $3.',
	'securepoll-not-qualified' => 'You are not qualified to vote in this election: $1',
	'securepoll-change-disallowed' => 'You have voted in this election before.
Sorry, you may not vote again.',
	'securepoll-change-allowed' => '<strong>Note: You have voted in this election before.</strong>
You may change your vote by submitting the form below.
Note that if you do this, your original vote will be discarded.',
	'securepoll-submit' => 'Submit vote',
	'securepoll-gpg-receipt' => 'Thank you for voting.

If you wish, you may retain the following receipt as evidence of your vote:

<pre>$1</pre>',
	'securepoll-thanks' => 'Thank you, your vote has been recorded.',
	'securepoll-return' => 'Return to $1',
	'securepoll-encrypt-error' => 'Failed to encrypt your vote record.
Your vote has not been recorded!

$1',
	'securepoll-no-gpg-home' => 'Unable to create GPG home directory.',
	'securepoll-secret-gpg-error' => 'Error executing GPG.
Use $wgSecurePollShowErrorDetail=true; in LocalSettings.php to show more detail.',
'securepoll-full-gpg-error' => 'Error executing GPG:

Command: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG keys are configured incorrectly.',
	'securepoll-gpg-parse-error' => 'Error interpreting GPG output.',
	'securepoll-no-decryption-key' => 'No decryption key is configured.
Cannot decrypt.',
	'securepoll-jump' => 'Go to the voting server',
	'securepoll-bad-ballot-submission' => '<div class="securepoll-error-box">
	Your vote was invalid: $1
	</div>',
	'securepoll-unanswered-questions' => 'You must answer all questions.',

	# Authorisation related
	'securepoll-remote-auth-error' => 'Error fetching your account information from the server.',
	'securepoll-remote-parse-error' => 'Error interpreting the authorisation response from the server.',
	
	'securepoll-api-invalid-params' => 'Invalid parameters.',
	'securepoll-api-no-user' => 'No user was found with the given ID.',
	'securepoll-api-token-mismatch' => 'Security token mismatch, cannot log in.',
	'securepoll-not-logged-in' => 'You must log in to vote in this election',
	'securepoll-too-few-edits' => 'Sorry, you cannot vote. You need to have made at least $1 {{PLURAL:$1|edit|edits}} to vote in this election, you have made $2.',
	'securepoll-blocked' => 'Sorry, you cannot vote in this election if you are currently blocked from editing.',
	'securepoll-not-in-group' => 'Only members of the "$1" group can vote in this election.',
	'securepoll-not-in-list' => 'Sorry, you are not in the predetermined list of users authorised to vote in this election.',

	# List page
	# Mostly for admins
	'securepoll-list-title' => 'List votes: $1',
	'securepoll-header-timestamp' => 'Time',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ip' => 'IP',
	'securepoll-header-xff' => 'XFF',
	'securepoll-header-ua' => 'User agent',
	'securepoll-header-token-match' => 'CSRF',
	'securepoll-header-strike' => 'Strike',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Strike',
	'securepoll-unstrike-button' => 'Unstrike',
	'securepoll-strike-reason' => 'Reason:',
	'securepoll-strike-cancel' => 'Cancel',
	'securepoll-strike-error' => 'Error performing strike/unstrike: $1',
	'securepoll-need-admin' => 'You need to be an admin to perform this action.',
	'securepoll-details-link' => 'Details',

	# Details page
	# Mostly for admins
	'securepoll-details-title' => 'Vote details: #$1',
	'securepoll-invalid-vote' => '"$1" is not a valid vote ID',
	'securepoll-header-id' => 'ID',
	'securepoll-header-voter-type' => 'Voter type',
	'securepoll-header-url' => 'URL',
	'securepoll-voter-properties' => 'Voter properties',
	'securepoll-strike-log' => 'Strike log',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Reason',
	'securepoll-header-admin' => 'Admin',

	# Dump page
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'No encrypted election record is available for this election, because the election is not configured to use encryption.',
	'securepoll-dump-not-finished' => 'Encrypted election records are only available after the finish date on $1 at $2', # FIXME: date/time split in message but not yet in file DumpPage.php because locked by Tim.
	'securepoll-dump-no-urandom' => 'Cannot open /dev/urandom. 
To maintain voter privacy, encrypted election records are only publically available when they can be shuffled with a secure random number stream.',

	# Translate page
	'securepoll-translate-title' => 'Translate: $1',
	'securepoll-invalid-language' => 'Invalid language code "$1"',
	'securepoll-header-trans-id' => 'ID',
	'securepoll-submit-translate' => 'Update',
	'securepoll-language-label' => 'Select language: ',
	'securepoll-submit-select-lang' => 'Translate',

	# Entry page
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Start date',
	'securepoll-header-end-date' => 'End date',
	'securepoll-subpage-vote' => 'Vote',
	'securepoll-subpage-translate' => 'Translate',
	'securepoll-subpage-list' => 'List',
	'securepoll-subpage-dump' => 'Dump',
);

/** Message documentation (Message documentation)
 * @author EugeneZelenko
 * @author Fryed-peach
 * @author IAlex
 * @author Kwj2772
 * @author Purodha
 * @author Raymond
 */
$messages['qqq'] = array(
	'securepoll-desc' => 'A short description of this extension shown in [[Special:Version]].
{{doc-important|Do not translate tag names.}}
{{doc-important|Do not translate links.}}',
	'securepoll-not-started' => '$1 is a data/time, $2 is the date of it, $3 is its time.',
	'securepoll-return' => '{{Identical|Return to $1}}',
	'securepoll-secret-gpg-error' => "<span style=\"color:red\">'''DO <u>NOT</u> translate LocalSettings.php and \$wgSecurePollShowErrorDetail=true;'''</span>",
	'securepoll-header-timestamp' => '{{Identical|Time}}',
	'securepoll-header-voter-name' => '{{Identical|Name}}',
	'securepoll-header-ip' => '{{optional}}',
	'securepoll-header-xff' => '{{optional}}',
	'securepoll-header-token-match' => '{{optional}}',
	'securepoll-header-strike' => '{{Identical|Strike}}',
	'securepoll-header-details' => '{{Identical|Details}}',
	'securepoll-strike-button' => '{{Identical|Strike}}',
	'securepoll-unstrike-button' => '{{Identical|Unstrike}}',
	'securepoll-strike-reason' => '{{Identical|Reason}}',
	'securepoll-strike-cancel' => '{{Identical|Cancel}}',
	'securepoll-details-link' => '{{Identical|Details}}',
	'securepoll-details-title' => '$1 identifies a single vote of a single voter.',
	'securepoll-invalid-vote' => 'The vote ID identifies a specific voting process.',
	'securepoll-header-id' => '{{optional}}',
	'securepoll-header-url' => '{{optional}}',
	'securepoll-header-reason' => '{{Identical|Reason}}',
	'securepoll-dump-not-finished' => '* $1 is the date
* $2 is the time',
	'securepoll-dump-no-urandom' => 'Do not translate "/dev/urandom".',
	'securepoll-translate-title' => '{{Identical|Translate}}',
	'securepoll-header-trans-id' => '{{optional}}',
	'securepoll-submit-select-lang' => '{{Identical|Translate}}',
	'securepoll-subpage-translate' => '{{Identical|Translate}}',
);

/** Arabic (العربية)
 * @author Shipmaster
 */
$messages['ar'] = array(
	'securepoll' => 'استطلاع رأي آمن',
	'securepoll-desc' => 'امتداد لأجل الانتخابات و استطلاعات الرأي',
	'securepoll-invalid-page' => 'صفحة فرعية غير صحيحة "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'قيم وسيطة صفحة فرعية غير كافية (وصلة غير صحيحة).',
	'securepoll-invalid-election' => '"$1" ليس رمز تعريف انتخابات صحيح.',
	'securepoll-welcome' => '<strong>مرحبا $1!</strong>',
	'securepoll-not-started' => 'هذه الانتخابات لم تبدأ بعد.
من المقرر لها ان تبدأ في  $2 ب $3.',
	'securepoll-not-qualified' => 'أنت غير مؤهل للتصويت في هذه الانتخابات: $1',
	'securepoll-change-disallowed' => 'لقد قمت بالتصويت في هذه الانتخابات من قبل.
عذرا، لا يمكنك التصويت مرة أخرى.',
	'securepoll-change-allowed' => '<strong>ملاحظة: لقد قمت بالتصويت في هذه الانتخابات من قبل</strong>
يمكنك تغيير صوتك باستخدام النموذج بالأسفل.
لاحظ انه اذا قمت بذلك، سيتم اهمال تصويتك السابق.',
	'securepoll-submit' => 'قدم صوتك',
	'securepoll-gpg-receipt' => 'شكرا لتصويتك

لو اردت، يمكنك الاحتفاظ بالايصال التالي كدليل على تصويتك:

<pre>$1</pre>',
	'securepoll-thanks' => 'شكرا لك، تم تسجيل تصويتك.',
	'securepoll-return' => 'ارجع الي $1',
	'securepoll-encrypt-error' => 'قد فشل تشفير سجل تصويتك.
تصويتك لم يتم تسجيله!

$1',
	'securepoll-no-gpg-home' => 'لم يمكن خلق دليل الموطن ل GPG.',
	'securepoll-secret-gpg-error' => 'خطأ أثناء تشغيل GPG.
قم باستخدام $wgSecurePollShowErrorDetail=true; في LocalSettings.php لاظهار المزيد من التفاصيل.',
	'securepoll-full-gpg-error' => 'خطأ أثناء تشغيل GPG:

الأمر: $1

الخطأ:

<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'مفاتيح GPG مهيئة بشكل غير صحيح.',
	'securepoll-gpg-parse-error' => 'خطأ بتفسير نتيجة GPG .',
	'securepoll-no-decryption-key' => 'لا توجد مفاتيح فك شفرة مهيئة.
لا يمكن فك الشفرة.',
	'securepoll-list-title' => 'قائمة التصويتات: $1',
	'securepoll-header-timestamp' => 'الوقت',
	'securepoll-header-voter-name' => 'الاسم',
	'securepoll-header-voter-domain' => 'النطاق',
	'securepoll-header-ua' => 'وكيل المستخدم',
	'securepoll-header-strike' => 'اشطب',
	'securepoll-header-details' => 'التفاصيل',
	'securepoll-strike-button' => 'اشطب',
	'securepoll-unstrike-button' => 'الغاء الشطب',
	'securepoll-strike-reason' => 'السبب:',
	'securepoll-strike-cancel' => 'الغاء',
	'securepoll-strike-error' => 'خطأ اثناء القيام بالشطب/الغاء الشطب: $1',
	'securepoll-need-admin' => 'يجب ات تكون اداري للقيام بهذا الاجراء.',
	'securepoll-details-link' => 'التفاصيل',
	'securepoll-details-title' => 'تفاصيل التصويت: #$1',
	'securepoll-invalid-vote' => '"$1" ليس رمز تعريف تصويت صحيح.',
	'securepoll-header-voter-type' => 'نوع المستخدم',
	'securepoll-voter-properties' => 'خصائص التصويت',
	'securepoll-strike-log' => 'سجل الشطب',
	'securepoll-header-action' => 'الاجراء',
	'securepoll-header-reason' => 'السبب',
	'securepoll-header-admin' => 'الادارة',
	'securepoll-dump-title' => 'النتيجة: $1',
	'securepoll-dump-no-crypt' => 'لا يوجد سجل انتخابات مشفر متاح لهذه الانتخابات، بسبب ان الانتخابات غير مهيئة لاستخدام التشفير.',
	'securepoll-dump-not-finished' => 'سجلات الانتخابات المشفرة متاحة فقط بعد تاريخ الانتهاء في $1 ب $2',
	'securepoll-dump-no-urandom' => 'لا يمكن فتح /dev/urandom.
للحفاظ على خصوصية المصوتين، سجلات الانتخابات المشفرة تتاح على الملأ عندما يمكن خلطهم عن طريق سيل ارقام عشوائية آمن.',
	'securepoll-translate-title' => 'ترجم: $1',
	'securepoll-invalid-language' => 'كود لغة غير صحيح "$1"',
	'securepoll-submit-translate' => 'تحديث',
	'securepoll-language-label' => 'اختر اللغة:',
	'securepoll-submit-select-lang' => 'ترجم',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'securepoll' => 'Бясьпечнае галасаваньне',
	'securepoll-desc' => 'Пашырэньне для выбараў і апытаньняў',
	'securepoll-invalid-page' => 'Няслушная падстаронка «<nowiki>$1</nowiki>»',
	'securepoll-too-few-params' => 'Недастаткова парамэтраў падстаронкі (няслушная спасылка).',
	'securepoll-invalid-election' => '«$1» — няслушны ідэнтыфікатар выбараў.',
	'securepoll-welcome' => '<strong>Вітаем, $1!</strong>',
	'securepoll-not-started' => 'Гэтыя выбары яшчэ не пачаліся.
Яны павінны пачацца $2 у $3.',
	'securepoll-not-qualified' => 'Вы не адпавядаеце крытэрам удзелу ў гэтых выбарах: $1',
	'securepoll-change-disallowed' => 'Вы ўжо галасавалі ў гэтых выбарах.
Прабачце, Вам нельга галасаваць паўторна.',
	'securepoll-change-allowed' => '<strong>Заўвага: Вы ўжо галасавалі ў гэтых выбарах.</strong>
Вы можаце зьмяніць Ваш голас, запоўніўшы форму ніжэй.
Заўважце, што калі Вы гэта зробіце, Ваш першапачатковы голас будзе ануляваны.',
	'securepoll-submit' => 'Даслаць голас',
	'securepoll-gpg-receipt' => 'Дзякуй за ўдзел ў галасаваньні.

Калі Вы жадаеце, Вы можаце атрымаць наступнае пацьверджаньне Вашага голасу:

<pre>$1</pre>',
	'securepoll-thanks' => 'Дзякуем, Ваш голас быў прыняты.',
	'securepoll-return' => 'Вярнуцца да $1',
	'securepoll-encrypt-error' => 'Памылка шыфраваньня Вашага голасу для запісу.
Ваш голас ня быў прыняты!

$1',
	'securepoll-no-gpg-home' => 'Немагчыма стварыць хатнюю дырэкторыю GPG.',
	'securepoll-secret-gpg-error' => 'Памылка выкананьня GPG.
Устанавіце $wgSecurePollShowErrorDetail=true; у LocalSettings.php каб паглядзець падрабязнасьці.',
	'securepoll-full-gpg-error' => 'Памылка выкананьня GPG:

Каманда: $1

Памылка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Ключы GPG былі няслушна сканфігураваны.',
	'securepoll-gpg-parse-error' => 'Памылка інтэрпрэтацыі вынікаў GPG.',
	'securepoll-no-decryption-key' => 'Няма скафігураваных ключоў для расшыфраваньня.
Немагчыма расшыфраваць.',
	'securepoll-jump' => 'Перайсьці на сэрвэр галасаваньня',
	'securepoll-remote-auth-error' => 'Памылка атрыманьня інфармацыі пра Ваш рахунак з сэрвэра.',
	'securepoll-remote-parse-error' => 'Памылка інтэрпрэтацыі адказу аўтарызацыі з сэрвэра.',
	'securepoll-api-invalid-params' => 'Няслушныя парамэтры.',
	'securepoll-api-no-user' => 'Ня знойдзены ўдзельнік з пададзеным ідэнтыфікатарам.',
	'securepoll-api-token-mismatch' => 'Неадпаведнасьць меткі бясьпекі, немагчыма ўвайсьці ў сыстэму.',
	'securepoll-not-logged-in' => 'Вам неабходна ўвайсьці ў сыстэму, каб галасаваць на гэтых выбарах',
	'securepoll-too-few-edits' => 'Прабачце, Вы ня можаце галасаваць. Вам неабходна зрабіць хаця б {{PLURAL:$1|рэдагаваньне|рэдагаваньні|рэдагаваньняў}}, каб галасаваць на гэтых выбарах, Вы зрабілі толькі $2.',
	'securepoll-blocked' => 'Прабачце, Вы ня можаце галасаваць на гэтых выбарах, калі Вы заблякаваны.',
	'securepoll-not-in-group' => 'Толькі ўдзельнікі групы $1 могуць галасаваць на гэтых выбарах.',
	'securepoll-not-in-list' => 'Прабачце, Вы не ўключаны ў сьпіс удзельнікаў, якія могуць галасаваць на гэтых выбарах.',
	'securepoll-list-title' => 'Сьпіс галасоў: $1',
	'securepoll-header-timestamp' => 'Час',
	'securepoll-header-voter-name' => 'Імя',
	'securepoll-header-voter-domain' => 'Дамэн',
	'securepoll-header-ua' => 'Агент удзельніка',
	'securepoll-header-strike' => 'Закрэсьліваньне',
	'securepoll-header-details' => 'Падрабязнасьці',
	'securepoll-strike-button' => 'Закрэсьліць',
	'securepoll-unstrike-button' => 'Адкрэсьліць',
	'securepoll-strike-reason' => 'Прычына:',
	'securepoll-strike-cancel' => 'Адмяніць',
	'securepoll-strike-error' => 'Памылка пад час закрэсьліваньня/адкрэсьліваньня: $1',
	'securepoll-need-admin' => 'Вам неабходна мець правы адміністратара, каб выканаць гэтае дзеяньне.',
	'securepoll-details-link' => 'Падрабязнасьці',
	'securepoll-details-title' => 'Падрабязнасьці галасаваньня: #$1',
	'securepoll-invalid-vote' => '«$1» не зьяўляецца слушным ідэнтыфікатарам голасу',
	'securepoll-header-voter-type' => 'Тып выбаршчыка',
	'securepoll-voter-properties' => 'Зьвесткі пра выбаршчыка',
	'securepoll-strike-log' => 'Журнал закрэсьліваньняў',
	'securepoll-header-action' => 'Дзеяньне',
	'securepoll-header-reason' => 'Прычына',
	'securepoll-header-admin' => 'Адміністратар',
	'securepoll-dump-title' => 'Выбарчыя запісы: $1',
	'securepoll-dump-no-crypt' => 'Для гэтых выбараў няма зашыфраваных выбарчых запісаў, таму што ў гэтых выбарах ня прадугледжана шыфраваньне.',
	'securepoll-dump-not-finished' => 'Зашыфраваныя выбарчыя запісы даступны толькі пасьля $1 у $2.',
	'securepoll-dump-no-urandom' => 'Не магчыма адкрыць /dev/urandom.
Каб захаваць прыватнасьць галасоў, зашыфраваныя выбарчыя запісы будуць даступныя для грамадзкасьці, толькі калі іх парадак будуць будзе зьменены з дапамогай бясьпечнай крыніцы выпадковых лікаў.',
	'securepoll-translate-title' => 'Пераклад: $1',
	'securepoll-invalid-language' => 'Няслушны код мовы «$1»',
	'securepoll-submit-translate' => 'Абнавіць',
	'securepoll-language-label' => 'Выбар мовы:',
	'securepoll-submit-select-lang' => 'Перакласьці',
	'securepoll-header-title' => 'Назва',
	'securepoll-header-start-date' => 'Дата пачатку',
	'securepoll-header-end-date' => 'Дата заканчэньня',
	'securepoll-subpage-vote' => 'Голас',
	'securepoll-subpage-translate' => 'Перакласьці',
	'securepoll-subpage-list' => 'Сьпіс',
	'securepoll-subpage-dump' => 'Дамп',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'securepoll-header-details' => 'Подробности',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Отмяна',
	'securepoll-details-link' => 'Подробности',
	'securepoll-header-action' => 'Действие',
	'securepoll-header-reason' => 'Причина',
	'securepoll-invalid-language' => 'Невалиден езиков код „$1“',
	'securepoll-submit-translate' => 'Актуализиране',
	'securepoll-language-label' => 'Избиране на език:',
	'securepoll-submit-select-lang' => 'Превеждане',
	'securepoll-header-title' => 'Име',
	'securepoll-header-start-date' => 'Начална дата',
	'securepoll-header-end-date' => 'Крайна дата',
	'securepoll-subpage-vote' => 'Гласуване',
	'securepoll-subpage-translate' => 'Превеждане',
);

/** Bosnian (Bosanski)
 * @author CERminator
 * @author Seha
 */
$messages['bs'] = array(
	'securepoll' => 'Sigurno glasanje',
	'securepoll-desc' => 'Proširenje za izbore i ankete',
	'securepoll-invalid-page' => 'Nevaljana podstranica "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Nema dovoljno parametara podstranice (nevaljan link).',
	'securepoll-invalid-election' => '"$1" nije valjan izborni ID.',
	'securepoll-welcome' => '<strong>Dobrodošao $1!</strong>',
	'securepoll-not-started' => 'Ovo glasanje još nije počelo.
Planirani početak glasanja je $2 u $3 sati.',
	'securepoll-not-qualified' => 'Niste kvalificirani da učestvujete na ovom glasanju: $1',
	'securepoll-change-disallowed' => 'Već ste ranije glasali na ovom glasanju.
Žao nam je, ne možete više glasati.',
	'securepoll-change-allowed' => '<strong>Napomena: Već ste ranije glasali na ovom glasanju.</strong>
Možete promijeniti Vaš glas slanjem obrasca ispod.
Zapamtite da ako ovo učinite, Vaš prvobitni glas će biti nevažeći.',
	'securepoll-submit' => 'Pošalji glas',
	'securepoll-gpg-receipt' => 'Hvala Vam za glasanje.

Ako želite, možete zadržati slijedeću potvrdu kao dokaz Vašeg glasanja:

<pre>$1</pre>',
	'securepoll-thanks' => 'Hvala Vam, Vaš glas je zapisan.',
	'securepoll-return' => 'Nazad na $1',
	'securepoll-encrypt-error' => 'Šifriranje Vašeg zapisa glasanja nije uspjelo.
Vaš glas nije sačuvan!

$1',
	'securepoll-no-gpg-home' => 'Nemoguće napraviti GPG početni direktorijum.',
	'securepoll-secret-gpg-error' => 'Greška pri izvršavanju GPG.
Koristite $wgSecurePollShowErrorDetail=true; u LocalSettings.php za više detalja.',
	'securepoll-full-gpg-error' => 'Greška pri izvršavanju GPG:

Komanda: $1

Grešaka:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG ključevi nisu pravilno podešeni.',
	'securepoll-gpg-parse-error' => 'Greška pri obradi GPG izlaza.',
	'securepoll-no-decryption-key' => 'Nijedan dekripcijski ključ nije podešen.
Ne može se dekriptovati.',
	'securepoll-jump' => 'Idi na server za glasanje',
	'securepoll-remote-auth-error' => 'Greška pri preuzimanju podataka o Vašem računu sa servera.',
	'securepoll-remote-parse-error' => 'Greška pri interpretaciji autentifikacijskog odgovora sa servera.',
	'securepoll-api-invalid-params' => 'Nevaljani parametri.',
	'securepoll-api-no-user' => 'Nije pronađen korisnik sa navedenim ID.',
	'securepoll-api-token-mismatch' => 'Nepodudata se sigurnosni token, ne može se prijaviti.',
	'securepoll-not-logged-in' => 'Morate se prijaviti za glasanje na ovim izborima',
	'securepoll-too-few-edits' => 'Žao nam je, ne možete glasati. Morate imati najmanje $1 izmjena da glasate na ovim izborima, Vi ste dosad napravili $2 izmjena.',
	'securepoll-blocked' => 'Žao nam je, ne možete trenutno glasati na ovim izborima ako ste trenutno blokirani za uređivanje.',
	'securepoll-not-in-group' => 'Samo članovi iz grupe $1 mogu učestovavati na ovim izborima.',
	'securepoll-not-in-list' => 'Žao nam je, niste na spisku korisnika kojima je odobreno glasanje na ovim izborima.',
	'securepoll-list-title' => 'Spisak glasova: $1',
	'securepoll-header-timestamp' => 'Vrijeme',
	'securepoll-header-voter-name' => 'Ime',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Korisnički agent',
	'securepoll-header-strike' => 'Precrtaj',
	'securepoll-header-details' => 'Detalji',
	'securepoll-strike-button' => 'Precrtaj',
	'securepoll-unstrike-button' => 'Poništi precrtavanje',
	'securepoll-strike-reason' => 'Razlog:',
	'securepoll-strike-cancel' => 'Odustani',
	'securepoll-strike-error' => 'Greška izvšavanja precrtavanja/uklanjanja: $1',
	'securepoll-need-admin' => 'Morate biti admin da bi ste izvršili ovu akciju.',
	'securepoll-details-link' => 'Detalji',
	'securepoll-details-title' => 'Detalji glasanja: #$1',
	'securepoll-invalid-vote' => '"$1" nije valjan glasački ID',
	'securepoll-header-voter-type' => 'Tip glasača',
	'securepoll-voter-properties' => 'Svojstva glasača',
	'securepoll-strike-log' => 'Zapisnik precrtavanja',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Razlog',
	'securepoll-header-admin' => 'Admin',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ne postoji dešifrirana varijanta ovog izbora, zato što izbor nije konfiguriran za korištenje šifriranja.',
	'securepoll-dump-not-finished' => 'Dešifrirani rezultati izbora su vidljivi tek poslije datuma završetka izbora $1 u $2 sati',
	'securepoll-dump-no-urandom' => 'Da bi se sačuvala privatnost glasača, dešifrirani rezultati glasanja su dostupni kada bude dostupna mogućnost prenosa slučajnim izborom brojki.',
	'securepoll-translate-title' => 'Prevedi: $1',
	'securepoll-invalid-language' => 'Pogrešan kod jezika "$1"',
	'securepoll-submit-translate' => 'Ažuriranje',
	'securepoll-language-label' => 'Izaberi jezik:',
	'securepoll-submit-select-lang' => 'Prevedi',
	'securepoll-header-title' => 'Ime',
	'securepoll-header-start-date' => 'Datum početka',
	'securepoll-header-end-date' => 'Datum završetka',
	'securepoll-subpage-vote' => 'Glasanje',
	'securepoll-subpage-translate' => 'Prijevod',
	'securepoll-subpage-list' => 'Spisak',
	'securepoll-subpage-dump' => 'Izvod',
);

/** Catalan (Català)
 * @author SMP
 * @author Vriullop
 */
$messages['ca'] = array(
	'securepoll' => 'Vot segur',
	'securepoll-desc' => 'Extensió per a eleccions i enquestes',
	'securepoll-invalid-page' => 'Subpàgina «<nowiki>$1</nowiki>» invàlida',
	'securepoll-too-few-params' => 'No hi ha prou paràmetres de subpàgina (enllaç invàlid).',
	'securepoll-invalid-election' => "«$1» no és un identificador d'elecció vàlid.",
	'securepoll-welcome' => '<strong>Benvingut $1!</strong>',
	'securepoll-not-started' => 'Aquesta elecció encara no ha començat.
Està programada per a que comenci el $1.',
	'securepoll-not-qualified' => 'No esteu qualificat per votar en aquesta elecció: $1',
	'securepoll-change-disallowed' => 'Ja heu votat en aquesta elecció.
Disculpeu, no podeu tornar a votar.',
	'securepoll-change-allowed' => '<strong>Nota: Ja heu votat en aquesta elecció.</strong>
Podeu canviar el vostre vot trametent el següent formulari.
Si ho feu, el vostre vot anterior serà descartat.',
	'securepoll-submit' => 'Tramet el vot',
	'securepoll-gpg-receipt' => 'Gràcies per votar.

Si ho desitgeu, podeu conservar el següent comprovant del vostre vot:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gràcies, el vostre vot ha estat enregistrat.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => "No s'ha aconseguit encriptar el registre del vostre vot.
El vostre vot no ha estat enregistrat!

$1",
	'securepoll-gpg-parse-error' => 'Error en la interpretació de la sortida de GPG',
	'securepoll-no-decryption-key' => 'No està configurada la clau de desxifrat.
No es pot desencriptar.',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domini',
	'securepoll-header-strike' => 'Anuŀlació',
	'securepoll-header-details' => 'Detalls',
	'securepoll-strike-button' => 'Anuŀla',
	'securepoll-unstrike-button' => "Desfés l'anuŀlació",
	'securepoll-strike-reason' => 'Motiu:',
	'securepoll-strike-cancel' => 'Canceŀla',
	'securepoll-need-admin' => 'Heu de ser administrador per a realitzar aquesta acció.',
	'securepoll-details-link' => 'Detalls',
	'securepoll-details-title' => 'Detalls de vot: #$1',
	'securepoll-invalid-vote' => '«$1» no és una ID de vot vàlida',
	'securepoll-header-voter-type' => "Tipus d'usuari",
	'securepoll-voter-properties' => 'Propietats del votant',
	'securepoll-strike-log' => "Registre d'anuŀlacions",
	'securepoll-header-action' => 'Acció',
	'securepoll-header-reason' => 'Motiu',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-translate-title' => 'Traducció: $1',
	'securepoll-invalid-language' => "Codi d'idioma «$1» no vàlid",
	'securepoll-submit-translate' => 'Actualitza',
	'securepoll-language-label' => 'Escolliu idioma:',
	'securepoll-submit-select-lang' => 'Tradueix',
);

/** Czech (Česky)
 * @author Mormegil
 */
$messages['cs'] = array(
	'securepoll' => 'Bezpečné hlasování',
	'securepoll-desc' => 'Rozšíření pro hlasování a průzkumy',
	'securepoll-invalid-page' => 'Neplatná podstránka „<nowiki>$1</nowiki>“',
	'securepoll-too-few-params' => 'Nedostatek parametrů pro podstránku (neplatný odkaz).',
	'securepoll-invalid-election' => '„$1“ není platný identifikátor hlasování.',
	'securepoll-welcome' => '<strong>Vítejte, {{GRAMMAR:$1|uživateli|uživatelko|uživateli}} $1!</strong>',
	'securepoll-not-started' => 'Toto hlasování dosud nebylo zahájeno.
Mělo by začít v $3, $2.',
	'securepoll-not-qualified' => 'Nesplňujete podmínky pro účast v tomto hlasování: $1',
	'securepoll-change-disallowed' => 'Tohoto hlasování jste se již {{GRAMMAR:zúčastnil|zúčastnila|zúčastnil}}.
Je mi líto, ale znovu hlasovat nemůžete.',
	'securepoll-change-allowed' => '<strong>Poznámka: Tohoto hlasování jste se již {{GRAMMAR:|zúčastnil|zúčastnila|zúčastnil}}.</strong>
Pokud chcete svůj hlas změnit, odešlete níže uvedený formulář.
Uvědomte si, že pokud to uděláte, váš původní hlas bude zahozen.',
	'securepoll-submit' => 'Odeslat hlas',
	'securepoll-gpg-receipt' => 'Děkujeme za váš hlas.

Pokud chcete, můžete si uschovat následující potvrzení vašeho hlasování:

<pre>$1</pre>',
	'securepoll-thanks' => 'Děkujeme vám, váš hlas byl zaznamenán.',
	'securepoll-return' => 'Vrátit se na stránku $1',
	'securepoll-encrypt-error' => 'Nepodařilo se zašifrovat záznam o vašem hlasování.
Váš hlas nebyl zaznamenán!

$1',
	'securepoll-no-gpg-home' => 'Nepodařilo se vytvořit domácí adresář pro GPG.',
	'securepoll-secret-gpg-error' => 'Chyba při provádění GPG.
Pokud chcete zobrazit podrobnosti, nastavte <code>$wgSecurePollShowErrorDetail=true;</code> v <tt>LocalSettings.php</tt>.',
	'securepoll-full-gpg-error' => 'Chyba při provádění GPG:

Příkaz: $1

Chyba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Jsou chybně nakonfigurovány klíče pro GPG.',
	'securepoll-gpg-parse-error' => 'Chyba při zpracovávání výstupu GPG.',
	'securepoll-no-decryption-key' => 'Nebyl nakonfigurován dešifrovací klíč.
Nelze dešifrovat.',
	'securepoll-jump' => 'Přejít na hlasovací server',
	'securepoll-list-title' => 'Seznam hlasů – $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Jméno',
	'securepoll-header-voter-domain' => 'Doména',
	'securepoll-header-ua' => 'Prohlížeč',
	'securepoll-header-strike' => 'Přeškrtnutí',
	'securepoll-header-details' => 'Podrobnosti',
	'securepoll-strike-button' => 'Přeškrtnout',
	'securepoll-unstrike-button' => 'Neškrtat',
	'securepoll-strike-reason' => 'Důvod:',
	'securepoll-strike-cancel' => 'Storno',
	'securepoll-strike-error' => 'Nepodařilo se provést přeškrtnutí či jeho zrušení: $1',
	'securepoll-need-admin' => 'K provedení této operace byste {{GENDER:|musel|musela|musel}} být správce.',
	'securepoll-details-link' => 'Podrobnosti',
	'securepoll-details-title' => 'Podrobnosti hlasu #$1',
	'securepoll-invalid-vote' => '„$1“ není platný identifikátor hlasu',
	'securepoll-header-voter-type' => 'Typ hlasujícího',
	'securepoll-voter-properties' => 'Vlastnosti hlasujícího',
	'securepoll-strike-log' => 'Záznam škrtání hlasu',
	'securepoll-header-action' => 'Operace',
	'securepoll-header-reason' => 'Důvod',
	'securepoll-header-admin' => 'Správce',
	'securepoll-dump-title' => 'Záznam – $1',
	'securepoll-dump-no-crypt' => 'U těchto voleb není k dispozici šifrovaný záznam hlasování, neboť v jejich konfiguraci není šifrování zapnuto.',
	'securepoll-dump-not-finished' => 'Šifrovaný záznam hlasování bude k dispozici až po skončení voleb, $1, $2',
	'securepoll-dump-no-urandom' => 'Nelze otevřít <tt>/dev/urandom</tt>.
Kvůli tajnosti hlasování je šifrovaný záznam hlasování veřejně dostupný pouze v případě, že hlasy mohou být zamíchány pomocí bezpečného zdroje náhodných čísel.',
	'securepoll-translate-title' => 'Překlad – $1',
	'securepoll-invalid-language' => 'Neplatný kód jazyka „$1“',
	'securepoll-submit-translate' => 'Uložit',
	'securepoll-language-label' => 'Zvolte jazyk:',
	'securepoll-submit-select-lang' => 'Překládat',
);

/** Danish (Dansk)
 * @author Kaare
 * @author Sir48
 */
$messages['da'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'En udvidelse til valg og undersøgelser',
	'securepoll-invalid-page' => 'Ugyldig underside "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Ikke tilstrækkeligt mange undersideparametre (ugyldigt link).',
	'securepoll-invalid-election' => '"$1" er ikke en gyldig valg-id.',
	'securepoll-welcome' => '<strong>Velkommen $1!</strong>',
	'securepoll-not-started' => 'Dette valg er endnu ikke begyndt.
Det er planlagt til at begynde den $1.',
	'securepoll-not-qualified' => 'Du er kvalificeret til at afgive din stemme ved dette valg: $1',
	'securepoll-change-disallowed' => 'Du har allerede afgivet din stemme ved dette valg.
Desværre kan du ikke stemme igen.',
	'securepoll-change-allowed' => '<strong>Bemærk: Du har allerede afgivet din stemme ved dette valg.</strong>
Du kan ændre din stemme ved at indsende formularen herunder.
Vær opmærksom på, at hvis du gør det, vil din oprindelige stemme blive smidt væk.',
	'securepoll-submit' => 'Afgiv stemme',
	'securepoll-gpg-receipt' => 'Tak fordi du stemte.

Hvis du ønsker det, kan du gemme følgende kvittering som bevis på din stemme:

<pre>$1</pre>',
	'securepoll-thanks' => 'Tak, din stemme er registreret.',
	'securepoll-return' => 'Tilbage til $1',
	'securepoll-encrypt-error' => 'Kunne ikke kryptere din stemme.
Din stemme er ikke registreret!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikke oprette GPG-hjemmemappe.',
	'securepoll-secret-gpg-error' => 'Fejl ved udførelse af GPG.
Anvend $wgSecurePollShowErrorDetail=true; i LocalSettings.php for at se flere oplysninger.',
	'securepoll-full-gpg-error' => 'Fejl ved udførelse af GPG:

Kommando: $1

Fejl:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøglerne er opsat forkert.',
	'securepoll-gpg-parse-error' => 'Fejl ved fortolkning af uddata fra GPG.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnøgle opsat.
Kan ikke dekryptere.',
	'securepoll-list-title' => 'Vis stemmer: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Navn',
	'securepoll-header-voter-domain' => 'Domæne',
	'securepoll-header-ua' => 'Useragent',
	'securepoll-header-strike' => 'Fjern',
	'securepoll-header-details' => 'Oplysninger',
	'securepoll-strike-button' => 'Fjern',
	'securepoll-unstrike-button' => 'Ophæv fjernelse',
	'securepoll-strike-reason' => 'Årsag:',
	'securepoll-strike-cancel' => 'Annuller',
	'securepoll-strike-error' => 'Fejl ved fjernelse eller ophævelse af fjernelse: $1',
	'securepoll-need-admin' => 'Du skal være administrator, for at udføre denne handling.',
	'securepoll-details-link' => 'Oplysninger',
	'securepoll-details-title' => 'Valgoplysninger: #$1',
	'securepoll-invalid-vote' => '"$1" er ikke en gyldig valg-id',
	'securepoll-header-voter-type' => 'Brugertype',
	'securepoll-voter-properties' => 'Stemmegiveregenskaber',
	'securepoll-strike-log' => 'Fjernelseslog',
	'securepoll-header-action' => 'Handling',
	'securepoll-header-reason' => 'Årsag',
	'securepoll-header-admin' => 'Admin',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Ingen krypterede valgregistreringer er tilgængelige til dette valg, fordi valget ikke er opsat til at anvende kryptering.',
	'securepoll-dump-not-finished' => 'Krypterede valgregistreringer er kun tilgængelige efter den sidste valgdag: $1',
	'securepoll-dump-no-urandom' => 'Kan ikke åbne /dev/urandom.
For at sikre en hemmelig afstemning er de krypterede valgregistrering kun offentligt  tilgængelige, når de kan blandes med en sikker strøm af tilfældige tal.',
	'securepoll-translate-title' => 'Oversæt: $1',
	'securepoll-invalid-language' => 'Ugyldig sprogkode "$1"',
	'securepoll-submit-translate' => 'Opdater',
	'securepoll-language-label' => 'Vælg sprog:',
	'securepoll-submit-select-lang' => 'Oversæt',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Metalhead64
 */
$messages['de'] = array(
	'securepoll' => 'Sichere Abstimmung',
	'securepoll-desc' => 'Erweiterung für Wahlen und Umfragen',
	'securepoll-invalid-page' => 'Ungültige Unterseite „<nowiki>$1</nowiki>“',
	'securepoll-too-few-params' => 'Nicht genügend Unterseitenparameter (ungültiger Link).',
	'securepoll-invalid-election' => '„$1“ ist keine gültige Abstimmungs-ID.',
	'securepoll-welcome' => '<strong>Willkommen $1!</strong>',
	'securepoll-not-started' => 'Diese Wahl hat noch nicht begonnen.
Sie beginnt voraussichtlich am $2 um $3.',
	'securepoll-not-qualified' => 'Du bist nicht qualifiziert, bei dieser Wahl abzustimmen: $1',
	'securepoll-change-disallowed' => 'Du hast bereits bei dieser Wahl abgestimmt.
Du darfst nicht erneut abstimmen.',
	'securepoll-change-allowed' => '<strong>Hinweis: Du hast bei dieser Wahl bereits abgestimmt.</strong>
Du kannst deine Stimme ändern, indem du das untere Formular abschickst.
Wenn du dies tust, wird deine ursprüngliche Stimme überschrieben.',
	'securepoll-submit' => 'Stimme abgeben',
	'securepoll-gpg-receipt' => 'Vielen Dank.

Es folgt eine Bestätigung als Beweis für deine Stimmabgabe:

<pre>$1</pre>',
	'securepoll-thanks' => 'Vielen Dank, deine Stimme wurde gespeichert.',
	'securepoll-return' => 'Zurück zu $1',
	'securepoll-encrypt-error' => 'Beim Verschlüsseln deiner Stimme ist ein Fehler aufgetreten.
Deine Stimme wurde nicht gespeichert!

$1',
	'securepoll-no-gpg-home' => 'GPG-Benutzerverzeichnis kann nicht erstellt werden.',
	'securepoll-secret-gpg-error' => 'Fehler beim Ausführen von GPG.
$wgSecurePollShowErrorDetail=true; in LocalSettings.php einfügen, um mehr Details anzuzeigen.',
	'securepoll-full-gpg-error' => 'Fehler beim Ausführen von GPG:

Befehl: $1

Fehler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-Schlüssel sind nicht korrekt konfiguriert.',
	'securepoll-gpg-parse-error' => 'Fehler beim Interpretieren der GPG-Ausgabe.',
	'securepoll-no-decryption-key' => 'Es ist kein Entschlüsselungsschlüssel konfiguriert.
Entschlüsselung nicht möglich.',
	'securepoll-jump' => 'Gehe zum Abstimmungsserver',
	'securepoll-remote-auth-error' => 'Fehler beim Abruf deiner Konteninformationen vom Server.',
	'securepoll-remote-parse-error' => 'Fehler beim Interpretieren der Berechtigungsantwort des Servers.',
	'securepoll-api-invalid-params' => 'Ungültige Parameter.',
	'securepoll-api-no-user' => 'Es wurde kein Benutzer mit der angegebenen ID gefunden.',
	'securepoll-api-token-mismatch' => 'Falsche Sicherheitstoken, Anmeldung fehlgeschlagen.',
	'securepoll-not-logged-in' => 'Du musst angemeldet sein, um bei dieser Wahl abstimmen zu können',
	'securepoll-too-few-edits' => 'Entschuldigung, du darfst nicht abstimmen. Du brauchst mindestens $1 Bearbeitungen, um bei dieser Wahl abzustimmen, du hast jedoch $2.',
	'securepoll-blocked' => 'Entschuldigung, du kannst nicht bei dieser Wahl abstimmen, wenn du gesperrt bist.',
	'securepoll-not-in-group' => 'Nur Mitglieder der $1 Gruppe können bei dieser Wahl abstimmen.',
	'securepoll-not-in-list' => 'Entschuldigung, du bist nicht in der Liste der berechtigten Benutzer, die bei dieser Wahl abstimmen dürfen.',
	'securepoll-list-title' => 'Stimmen auflisten: $1',
	'securepoll-header-timestamp' => 'Zeit',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domäne',
	'securepoll-header-ua' => 'Benutzeragent',
	'securepoll-header-strike' => 'Streichen',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Streichen',
	'securepoll-unstrike-button' => 'Streichung zurücknehmen',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-strike-cancel' => 'Abbrechen',
	'securepoll-strike-error' => 'Fehler bei der Streichung/Streichungsrücknahme: $1',
	'securepoll-need-admin' => 'Du musst ein Administrator sein, um diese Aktion durchzuführen.',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Abstimmungsdetails: #$1',
	'securepoll-invalid-vote' => '„$1“ ist keine gültige Abstimmungs-ID',
	'securepoll-header-voter-type' => 'Abstimmertyp',
	'securepoll-voter-properties' => 'Wählereigenschaften',
	'securepoll-strike-log' => 'Streichungs-Logbuch',
	'securepoll-header-action' => 'Aktion',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-dump-title' => 'Auszug: $1',
	'securepoll-dump-no-crypt' => 'Für diese Wahl sind keine verschlüsselten Abstimmungsaufzeichnungen verfügbar, da die Wahl nicht für Verschlüsselung konfiguriert wurde.',
	'securepoll-dump-not-finished' => 'Verschlüsselte Abstimmungsaufzeichnungen sind nur nach dem Endtermin am $1 um $2 verfügbar.',
	'securepoll-dump-no-urandom' => '/dev/urandom kann nicht geöffnet werden.
Um den Wählerdatenschutz zu wahren, sind verschlüsselte Abstimmungsaufzeichnungen nur öffentlich verfügbar, wenn sie mit einem sicheren Zufallszahlenstrom gemischt werden können.',
	'securepoll-translate-title' => 'Übersetzen: $1',
	'securepoll-invalid-language' => 'Ungültiger Sprachcode „$1“',
	'securepoll-submit-translate' => 'Aktualisieren',
	'securepoll-language-label' => 'Sprache auswählen:',
	'securepoll-submit-select-lang' => 'Übersetzen',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Beginn',
	'securepoll-header-end-date' => 'Ende',
	'securepoll-subpage-vote' => 'Abstimmen',
	'securepoll-subpage-translate' => 'Übersetzen',
	'securepoll-subpage-list' => 'Liste',
	'securepoll-subpage-dump' => 'Auszug',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 */
$messages['de-formal'] = array(
	'securepoll-not-authorised' => 'Sie sind nicht berechtigt, in dieser Wahl abzustimmen.',
	'securepoll-not-qualified' => 'Sie sind nicht qualifiziert, in dieser Wahl abzustimmen: $1',
	'securepoll-change-disallowed' => 'Sie haben bereits in dieser Wahl abgestimmt.
Sie dürfen nicht erneut abstimmen.',
	'securepoll-change-allowed' => '<strong>Hinweis: Sie haben in dieser Wahl bereits abgestimmt.</strong>
Sie können Ihre Stimme ändern, indem Sie das untere Formular abschicken.
Wenn Sie dies tun, wird Ihre ursprüngliche Stimme überschrieben.',
	'securepoll-gpg-receipt' => 'Vielen Dank.

Es folgt eine Bestätigung als Beweis für Ihre Stimmabgabe:

<pre>$1</pre>',
	'securepoll-thanks' => 'Vielen Dank, Ihre Stimme wurde gespeichert.',
	'securepoll-encrypt-error' => 'Beim Verschlüsseln Ihrer Stimme ist ein Fehler aufgetreten.
Ihre Stimme wurde nicht gespeichert!

$1',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'securepoll' => 'Wěste wótgłosowanje',
	'securepoll-desc' => 'Rozšyrjenje za wólby a napšašowanja',
	'securepoll-invalid-page' => 'Njepłaśiwy pódbok "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Nic dosć pódbokowych parametrow (njepłaśiwy wótkaz)',
	'securepoll-invalid-election' => '"$1" njejo płaśiwy wólbny ID.',
	'securepoll-welcome' => '<strong>Witaj $1!</strong>',
	'securepoll-not-started' => 'Toś ta wólba hyšći njejo se zachopiła.
Zachopijo nejskerjej $2 $3.',
	'securepoll-not-qualified' => 'Njejsy wopšawnjony w toś tej wólbje wótgłosowaś: $1',
	'securepoll-change-disallowed' => 'Sy južo wótgłosował w toś tej wólbje.
Njesmějoš hyšći raz wótgłosowaś.',
	'securepoll-submit' => 'Głos daś',
	'securepoll-thanks' => 'Źěkujomy se, twój głos jo se zregistrěrował.',
	'securepoll-return' => 'Slědk k $1',
	'securepoll-gpg-config-error' => 'GPG-kluce su wopak konfigurěrowane.',
	'securepoll-no-decryption-key' => 'Dešifrěrowański kluc njejo konfigurěrowany.
Njejo móžno dešifrěrowaś.',
	'securepoll-api-invalid-params' => 'Njepłaśiwe parametry.',
	'securepoll-api-no-user' => 'Wužywaŕ z pódanym ID njejo.',
	'securepoll-not-logged-in' => 'Musyš se pśizjawiś, aby w toś tej wólbje wótgłosował.',
	'securepoll-not-in-group' => 'Jano cłonki kupki $1 mógu w toś tej wólbje wótgłosowaś.',
	'securepoll-list-title' => 'Głose nalicyś: $1',
	'securepoll-header-timestamp' => 'Cas',
	'securepoll-header-voter-name' => 'Mě',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Identifikator wobglědowaka',
	'securepoll-header-strike' => 'Wušmarnuś',
	'securepoll-header-details' => 'Drobnostki',
	'securepoll-strike-button' => 'Wušmarnuś',
	'securepoll-unstrike-button' => 'Wušmarnjenje anulěrowaś',
	'securepoll-strike-reason' => 'Pśicyna:',
	'securepoll-strike-cancel' => 'Pśetergnuś',
	'securepoll-need-admin' => 'Musyš administrator byś, aby pśewjadł toś tu akciju.',
	'securepoll-details-link' => 'Drobnostki',
	'securepoll-details-title' => 'Wótgłosowańske drobnostki: #$1',
	'securepoll-invalid-vote' => '"$1" njejo płaśiwy wótgłosowański ID',
	'securepoll-header-voter-type' => 'Wólarski typ',
	'securepoll-voter-properties' => 'Kakosći wólarja',
	'securepoll-strike-log' => 'Protokol wušmarnjenjow',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Pśicyna',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-dump-title' => 'Wuśěg: $1',
	'securepoll-translate-title' => 'Pśełožyś: $1',
	'securepoll-invalid-language' => 'Njepłaśiwy rěcny kod "$1"',
	'securepoll-submit-translate' => 'Aktualizěrowaś',
	'securepoll-language-label' => 'Rěc wubraś:',
	'securepoll-submit-select-lang' => 'Přełožyś',
	'securepoll-header-title' => 'Mě',
	'securepoll-header-start-date' => 'Zachopny datum',
	'securepoll-header-end-date' => 'Kóńcny datum',
	'securepoll-subpage-vote' => 'Wótgłosowaś',
	'securepoll-subpage-translate' => 'Pśełožyś',
	'securepoll-subpage-list' => 'Lisćina',
	'securepoll-subpage-dump' => 'Wuśěg',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author Crazymadlover
 * @author Geraki
 * @author Omnipaedista
 * @author ZaDiak
 */
$messages['el'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Επέκταση για εκλογές και δημοσκοπήσεις',
	'securepoll-invalid-page' => 'Άκυρη υποσελίδα "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Μη αρκετές παράμετροι υποσελίδας (άκυρος σύνδεσμος).',
	'securepoll-invalid-election' => '"$1" δεν είναι ένα αποδεκτό ID ψηφοφορίας.',
	'securepoll-welcome' => '<strong>Καλωσήρθες $1!</strong>',
	'securepoll-not-started' => 'Η ψηφοφορία δεν έχει ξεκινήσει ακόμη.
Είναι προγραμματισμένη να ξεκινήσει στις $2 στις $3.',
	'securepoll-not-qualified' => 'Δεν καλύπτετε τα κριτήρια για να ψηφίσετε σε αυτή την ψηφοφορία: $1',
	'securepoll-change-disallowed' => 'Έχετε ψηφίσει προηγουμένως σε αυτή την ψηφοφορία.
Συγνώμη, δεν μπορείτε να ψηφίσετε ξανά.',
	'securepoll-change-allowed' => '<strong>Σημείωση: Έχετε ψηφίσει προηγουμένως σε αυτή την ψηφοφορία.</strong>
Μπορείτε να αλλάξετε την ψήφο σας αποστέλλοντας την φόρμα παρακάτω.
Λάβετε υπόψη ότι αν κάνετε αυτό, η αρχική ψήφος σας θα ακυρωθεί.',
	'securepoll-submit' => 'Καταχώρηση ψήφου',
	'securepoll-gpg-receipt' => 'Ευχαριστούμε που ψηφίσατε.

Αν επιθυμείτε, μπορείτε να διατηρήσετε την παρακάτω απόδειξη ως πειστήριο της ψήφου σας:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ευχαριστούμε, η ψήφος σας καταγράφηκε.',
	'securepoll-return' => 'Επιστροφή στην $1',
	'securepoll-encrypt-error' => 'Αποτυχία κρυπτογράφησης της καταγραφής ψήφου σας.
Η ψήφος σας δεν έχει καταγραφεί!

$1',
	'securepoll-no-gpg-home' => 'Αποτυχία δημιουργίας οικείου καταλόγου GPG.',
	'securepoll-secret-gpg-error' => 'Σφάλμα εκτέλεσης GPG. 
Χρησιμοποιήστε $wgSecurePollShowErrorDetail=true; στο LocalSettings.php για εμφάνιση περισσότερων λεπτομερειών.',
	'securepoll-full-gpg-error' => 'Σφάλμα εκτέλεσης GPG:

Εντολή: $1

Σφάλμα:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Τα κλειδιά GPG είναι ρυθμισμένα λανθασμένα.',
	'securepoll-gpg-parse-error' => 'Σφάλμα διερμηνείας εξόδου GPG.',
	'securepoll-no-decryption-key' => 'Δεν έχει ρυθμιστεί κλειδί αποκρυπτογράφησης.
Δεν είναι δυνατή η αποκρυπτογράφηση.',
	'securepoll-api-invalid-params' => 'Άκυροι παράμετροι.',
	'securepoll-not-logged-in' => 'Πρέπει να συνδεθείτε για να ψηφίσει στις εκλογές',
	'securepoll-not-in-group' => "Μόνο τα μέλη της ομάδας $1 μπορούν να ψηφίσουν σ' αυτές τις εκλογές.",
	'securepoll-not-in-list' => 'Λυπούμαστε, αλλά δεν βρίσκεστε στην προκαθορισμένη λίστα χρηστών που επιτρέπεται να ψηφίσουν στις εκλογές αυτές.',
	'securepoll-list-title' => 'Λίστα ψήφων: $1',
	'securepoll-header-timestamp' => 'Ώρα',
	'securepoll-header-voter-name' => 'Όνομα',
	'securepoll-header-voter-domain' => 'Περιοχή',
	'securepoll-header-details' => 'Λεπτομέρειες',
	'securepoll-strike-reason' => 'Λόγος:',
	'securepoll-strike-cancel' => 'Άκυρο',
	'securepoll-details-link' => 'Λεπτομέρειες',
	'securepoll-invalid-vote' => 'Η "$1" δεν είναι μια έγκυρη ψήφος βάση ταυτότητας',
	'securepoll-header-voter-type' => 'Τύπος ψηφοφόρου',
	'securepoll-voter-properties' => 'Ιδιότητες ψηφοφόρου',
	'securepoll-header-action' => 'Ενέργεια',
	'securepoll-header-reason' => 'Λόγος',
	'securepoll-header-admin' => 'Διαχειριστής',
	'securepoll-translate-title' => 'Μετάφραση: $1',
	'securepoll-submit-translate' => 'Ενημέρωση',
	'securepoll-language-label' => 'Επιλογή γλώσσας:',
	'securepoll-submit-select-lang' => 'Μετάφραση',
	'securepoll-header-title' => 'Όνομα',
	'securepoll-subpage-vote' => 'Ψήφος',
	'securepoll-subpage-translate' => 'Μετάφραση',
	'securepoll-subpage-list' => 'Λίστα',
);

/** Esperanto (Esperanto)
 * @author Yekrats
 */
$messages['eo'] = array(
	'securepoll' => 'Sekura Enketo',
	'securepoll-desc' => 'Kromprogramo por voĉdonadoj kaj enketoj',
	'securepoll-invalid-page' => 'Nevalida subpaĝo "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Ne sufiĉaj subpaĝaj parametroj (nevalida ligilo).',
	'securepoll-invalid-election' => '"$1" ne estas valida voĉdonada identigo.',
	'securepoll-welcome' => '<strong>Bonvenon, $1!</strong>',
	'securepoll-not-started' => 'Ĉi tiu voĉdonado ne jam pretas.
Ĝi estos komencata je $2, $3.',
	'securepoll-not-qualified' => 'Vi ne rajtas voĉdoni en ĉi tiu voĉdonado: $1',
	'securepoll-change-disallowed' => 'Vi antaŭe voĉdonis en ĉi tiu voĉdonado.
Bedaŭrinde vi ne rajtas revoĉdoni.',
	'securepoll-change-allowed' => '<strong>Notu: Vi voĉdonis en ĉi tiu voĉdonado antaŭe.</strong>
Vi povas ŝanĝi vian voĉdonon de sendi la jenan formularon.
Notu, ke se vi farus ĉi tiel, via originala voĉdono estos forviŝita.',
	'securepoll-submit' => 'Enmeti voĉdonon',
	'securepoll-gpg-receipt' => 'Dankon por via voĉdono.

Laŭvole, vi povas konservi la jena konfirmo de via voĉdono:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dankon, via voĉdono estis registrita.',
	'securepoll-return' => 'Reiri al $1',
	'securepoll-encrypt-error' => 'Malsukcesis enĉifri vian voĉdonan rekordon.
Via voĉdono ne estis rekordita!

$1',
	'securepoll-no-gpg-home' => 'Ne eblas krei GPG hejman dosierujon.',
	'securepoll-secret-gpg-error' => 'Eraro funkciigante GPG.
Uzu $wgSecurePollShowErrorDetail=true; en LocalSettings.php por montri pliajn detalojn.',
	'securepoll-full-gpg-error' => 'Eraro funkciigante GPG:

Komando: $1

Eraro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ŝlosiloj estas konfiguritaj malĝuste.',
	'securepoll-jump' => 'Iri al la voĉdona servilo',
	'securepoll-api-invalid-params' => 'Malvalidaj parametroj.',
	'securepoll-blocked' => 'Bedaŭrinde, vi ne povas voĉdoni en ĉi tiu voĉdonado se vi nune estas forbarita de redaktado.',
	'securepoll-header-timestamp' => 'Tempo',
	'securepoll-header-voter-name' => 'Nomo',
	'securepoll-header-voter-domain' => 'Domajno',
	'securepoll-header-details' => 'Detaloj',
	'securepoll-strike-reason' => 'Kialo:',
	'securepoll-strike-cancel' => 'Nuligi',
	'securepoll-details-link' => 'Detaloj',
	'securepoll-details-title' => 'Detaloj de voĉdono: #$1',
	'securepoll-invalid-vote' => '"$1" ne estas valida voĉdona identigo',
	'securepoll-header-voter-type' => 'Speco de voĉdonanto',
	'securepoll-header-action' => 'Ago',
	'securepoll-header-reason' => 'Kialo',
	'securepoll-header-admin' => 'Administranto',
	'securepoll-translate-title' => 'Traduki: $1',
	'securepoll-invalid-language' => 'Malvalida lingva kodo "$1"',
	'securepoll-submit-translate' => 'Ĝisdatigi',
	'securepoll-language-label' => 'Elekti lingvon:',
	'securepoll-submit-select-lang' => 'Traduki',
	'securepoll-header-start-date' => 'Komenca dato',
	'securepoll-header-end-date' => 'Fina dato',
	'securepoll-subpage-translate' => 'Traduki',
);

/** Spanish (Español)
 * @author Crazymadlover
 * @author Dferg
 * @author DoveBirkoff
 */
$messages['es'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extensiones para elecciones y encuentas',
	'securepoll-invalid-page' => 'Subpágina inválida "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Parámetros de subpágina insuficientes (vínculo inválido).',
	'securepoll-invalid-election' => '"$1" no es un identificador de elección valido.',
	'securepoll-welcome' => '<strong>Bienvenido $1!</strong>',
	'securepoll-not-started' => 'Esta elección aún no ha comenzado.
Está programada de comenzar en $2 de $3.',
	'securepoll-not-qualified' => 'No cumples los requisitos para votar en esta elección: $1',
	'securepoll-change-disallowed' => 'Ya has votado antes en esta elección.
Lo siento, no puede votar de nuevo.',
	'securepoll-change-allowed' => '<strong>Nota: Has votado en esta elección antes.</strong>
Puedes cambiar tu voto enviando el formulario de abajo.
Nota que si haces esto, tu voto original será descartado.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Gracias por votar.

Si deseas, puedes retener el siguiente comprobante como evidencia de tu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gracias, tu voto ha sido guardado.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Fracasaste en encriptar tu registro de voto.
Tu voto no ha sido registrado!

$1',
	'securepoll-secret-gpg-error' => 'Error ejecutando GPG.
Usar $wgSecurePollShowErrorDetail=true; en LocalSettings.php para mostrar más detalle.',
	'securepoll-full-gpg-error' => 'Error ejecutando GPG:

Comando: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Teclas GPG están configuradas incorrectamente.',
	'securepoll-gpg-parse-error' => 'Error interpretando salida GPG.',
	'securepoll-jump' => 'Ir al servidor de votación',
	'securepoll-api-invalid-params' => 'Parámetros inválidos.',
	'securepoll-api-no-user' => 'Ningún usuario fue encontrado con el ID dado.',
	'securepoll-not-logged-in' => 'Debes iniciar sesión para votar en esta elección',
	'securepoll-too-few-edits' => 'Perdón, no puedes votar. Necesitas haber hecho al menos $1 ediciones para votar en esta elección, has hecho $2.',
	'securepoll-not-in-group' => 'Solamente mimbros del grupo $1 pueden votar en esta elección.',
	'securepoll-not-in-list' => 'Perdón, no estás en el lista predetermindad de usuarios autorizados a votar en esta elección.',
	'securepoll-list-title' => 'Lista votos: $1',
	'securepoll-header-timestamp' => 'Tiempo',
	'securepoll-header-voter-name' => 'Nombre',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente de usuario',
	'securepoll-header-strike' => 'Tachar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Trachar',
	'securepoll-strike-reason' => 'Razón:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-need-admin' => 'Necesitas ser un administrador para realizar esta acción.',
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => 'Detalles de voto: #$1',
	'securepoll-header-voter-type' => 'Tipo de votante',
	'securepoll-voter-properties' => 'Propiedades de votante',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Razón',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-dump-no-crypt' => 'No se dispone de un registro encriptado para esta votación dado que esta votación no ha sido configurada para usar encriptación.',
	'securepoll-dump-not-finished' => 'Los registros encriptados de la votación están únicamente disponibles después de la fecha de finalización en $1 de $2',
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Código de lenguaje inválido "$1"',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Seleccionar lenguaje:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-header-title' => 'Nombre',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Lista',
);

/** Estonian (Eesti)
 * @author WikedKentaur
 */
$messages['et'] = array(
	'securepoll-invalid-election' => '"$1" pole õige hääletuse-ID.',
	'securepoll-welcome' => '<strong>Tere tulemast $1!</strong>',
	'securepoll-not-started' => 'Hääletus pole veel alanud.
See algab $1.',
	'securepoll-change-disallowed' => 'Sa oled oma hääle juba andnud.
Teistkorda hääletada ei saa.',
	'securepoll-change-allowed' => '<strong>Teade: Sa oled oma hääle juba andnud.</strong>
Sa võid allpool oma antud häält muuta.
Kui sa seda teed, siis sinu eelmine hääl tühistub.',
	'securepoll-gpg-receipt' => 'Täname hääletamast.

Soovi korral võid talletada järgneva kinnituse antud hääle kohta:

<pre>$1</pre>',
	'securepoll-thanks' => 'Täname, sinu hääl on talletatud.',
	'securepoll-return' => 'Pöördu tagasi $1',
	'securepoll-encrypt-error' => 'Sinu antud hääle andmeid ei õnnestunud krüpteerida.
Sinu häält pole talletatud!

$1',
	'securepoll-header-timestamp' => 'Aeg',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Domeen',
	'securepoll-header-details' => 'Üksikasjad',
	'securepoll-strike-reason' => 'Põhjus:',
	'securepoll-strike-cancel' => 'Katkesta',
	'securepoll-need-admin' => 'Selle tegevuse sooritamiseks pead sa olema administraator.',
	'securepoll-details-title' => 'Hääletuse andmed: #$1',
	'securepoll-invalid-vote' => '"$1" pole õige hääle-ID.',
	'securepoll-header-reason' => 'Põhjus',
	'securepoll-translate-title' => 'Tõlgi: $1',
	'securepoll-invalid-language' => 'Vigane keelekood  "$1"',
	'securepoll-submit-translate' => 'Uuenda',
	'securepoll-language-label' => 'Vali keel:',
	'securepoll-submit-select-lang' => 'Tõlgi',
);

/** Persian (فارسی)
 * @author Meisam
 */
$messages['fa'] = array(
	'securepoll' => 'رای‌گیری امن',
	'securepoll-desc' => 'افزونه برای رای‌گیری‌ها و جمع‌آوری اطلاعات',
	'securepoll-invalid-page' => 'زیرسفحه نامعتبر "<nowiki>$1</nowiki>"',
	'securepoll-not-qualified' => 'شما واجد شرایط شرکت در این رای‌گیری نیستید: $1',
	'securepoll-submit' => 'ارسال رای',
	'securepoll-return' => 'بازگشت به $1',
	'securepoll-header-timestamp' => 'زمان',
	'securepoll-header-voter-name' => 'نام',
	'securepoll-header-voter-domain' => 'دامین',
	'securepoll-header-details' => 'جزئیات',
	'securepoll-strike-reason' => 'دلیل:',
	'securepoll-details-link' => 'جزئیات',
	'securepoll-details-title' => 'جزییات رای: #$1',
	'securepoll-header-voter-type' => 'نوع کاربر',
	'securepoll-header-reason' => 'دلیل',
	'securepoll-header-admin' => 'مدیر',
	'securepoll-submit-translate' => 'به‌روزآوری',
	'securepoll-language-label' => 'انتخاب زبان:',
	'securepoll-submit-select-lang' => 'ترجمه',
);

/** Finnish (Suomi)
 * @author Str4nd
 */
$messages['fi'] = array(
	'securepoll-desc' => 'Liitännäinen vaaleille ja kyselyille.',
	'securepoll-invalid-page' => 'Virheellinen alasivu ”<nowiki>$1</nowiki>”',
	'securepoll-welcome' => '<strong>Tervetuloa $1!</strong>',
	'securepoll-thanks' => 'Kiitos, äänesi on rekisteröity.',
	'securepoll-no-gpg-home' => 'GPG:n kotihakemistoa ei voitu luoda.',
	'securepoll-gpg-config-error' => 'GPG-avaimet ovat asetettu virheellisesti.',
	'securepoll-no-decryption-key' => 'Salauksen purkuavainta ei ole asetettu.
Salausta ei voitu purkaa.',
	'securepoll-header-timestamp' => 'Aika',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Verkkotunnus',
	'securepoll-strike-reason' => 'Syy',
	'securepoll-strike-cancel' => 'Peruuta',
	'securepoll-header-voter-type' => 'Käyttäjätyyppi',
	'securepoll-voter-properties' => 'Äänestäjän asetukset',
	'securepoll-header-reason' => 'Syy',
	'securepoll-invalid-language' => 'Virheellinen kielikoodi ”$1”',
	'securepoll-submit-translate' => 'Päivitä',
	'securepoll-language-label' => 'Valitse kieli',
	'securepoll-submit-select-lang' => 'Käännä',
);

/** French (Français)
 * @author Crochet.david
 * @author IAlex
 * @author PieRRoMaN
 */
$messages['fr'] = array(
	'securepoll' => 'Sondage sécurisé',
	'securepoll-desc' => 'Extension pour des élections et sondages',
	'securepoll-invalid-page' => 'Sous-page « <nowiki>$1</nowiki> » invalide',
	'securepoll-too-few-params' => 'Pas assez de paramètres de sous-page (lien invalide).',
	'securepoll-invalid-election' => "« $1 » n'est pas un identifiant d'élection valide.",
	'securepoll-welcome' => '<strong>Bienvenu $1 !</strong>',
	'securepoll-not-started' => "L'élection n'a pas encore commencé.
Elle débutera le $2 à $3.",
	'securepoll-not-qualified' => "Vous n'êtes pas qualifié pour voter dans cette élection : $1",
	'securepoll-change-disallowed' => 'Vous avez déjà voté pour cette élection.
Désolé, vous ne pouvez pas voter à nouveau.',
	'securepoll-change-allowed' => '<strong>Note : Vous avez déjà voté pour cette élection.</strong>
Vous pouvez changer votre vote en soumettant le formulaire ci-dessous.
Si vous faites ceci, votre ancien vote sera annulé.',
	'securepoll-submit' => 'Soumettre le vote',
	'securepoll-gpg-receipt' => 'Merci de votre vote.

Si vous le désirez, vous pouvez garder ceci comme preuve de votre vote :

<pre>$1</pre>',
	'securepoll-thanks' => 'Merci, votre vote a été enregistré.',
	'securepoll-return' => 'Revenir à $1',
	'securepoll-encrypt-error' => "Le cryptage de votre vote a échoué.
Votre vote n'a pas été enregistré !

$1",
	'securepoll-no-gpg-home' => 'Impossible de créer le dossier de base de GPG.',
	'securepoll-secret-gpg-error' => 'Erreur lors de l\'exécution de GPG.
Ajoutez $wgSecurePollShowErrorDetail=true; à LocalSettings.php pour afficher plus de détails.',
	'securepoll-full-gpg-error' => "Erreur lors de l'exécution de GPG :

Commande : $1

Erreur :
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'Les clés de GPG ne sont pas correctement configurées.',
	'securepoll-gpg-parse-error' => "Erreur lors de l'interprétation de la sortie de GPG.",
	'securepoll-no-decryption-key' => "Aucune clé de décryptage n'a été configurée.
Impossible de décrypter.",
	'securepoll-jump' => 'Aller au serveur de vote',
	'securepoll-remote-auth-error' => 'Erreur lors de la lecture des informations de votre compte depuis le serveur.',
	'securepoll-remote-parse-error' => "Erreur lors de l'interprétation de la réponse d'autorisation du serveur.",
	'securepoll-api-invalid-params' => 'Parmamètres invalides.',
	'securepoll-api-no-user' => "Aucun utilisateur avec l'identifiant donné n'a été trouvé.",
	'securepoll-api-token-mismatch' => 'Jeton de sécurité différent, connexion impossible.',
	'securepoll-not-logged-in' => 'Vous devez vous connecter pour voter dans cette élection.',
	'securepoll-too-few-edits' => 'Désolé, vous ne pouvez pas voter. Vous devez avoir au moins $1 modification pour voter dans cette élection, vous en avez $2.',
	'securepoll-blocked' => 'Désolé, vous ne pouvez pas voter dans cette élection car vous êtes bloqué en écriture.',
	'securepoll-not-in-group' => 'Seuls les membre du groupe $1 peuvent voter dans cette élection.',
	'securepoll-not-in-list' => "Désolé, vous n'êtes pas sur la liste prédéterminée des utilisateurs autorisés à voter dans cette élection.",
	'securepoll-list-title' => 'Liste des votes : $1',
	'securepoll-header-timestamp' => 'Heure',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domaine',
	'securepoll-header-ua' => 'User agent',
	'securepoll-header-strike' => 'Biffer',
	'securepoll-header-details' => 'Détails',
	'securepoll-strike-button' => 'Biffer',
	'securepoll-unstrike-button' => 'Débiffer',
	'securepoll-strike-reason' => 'Raison :',
	'securepoll-strike-cancel' => 'Annuler',
	'securepoll-strike-error' => 'Erreur lors du (dé)biffage : $1',
	'securepoll-need-admin' => 'Vous devez être un administrateur pour exécuter cette action.',
	'securepoll-details-link' => 'Détails',
	'securepoll-details-title' => 'Détails du vote : #$1',
	'securepoll-invalid-vote' => '« $1 » n’est pas un ID de vote valide',
	'securepoll-header-voter-type' => 'Type du votant',
	'securepoll-voter-properties' => 'Propriétés du votant',
	'securepoll-strike-log' => 'Journal des biffages',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Raison',
	'securepoll-header-admin' => 'Administrateur',
	'securepoll-dump-title' => 'Dump : $1',
	'securepoll-dump-no-crypt' => "Les données chiffrées ne sont pas disponibles pour cette élection, car l’élection n'est pas configurée pour utiliser un chiffrement.",
	'securepoll-dump-not-finished' => "Les données cryptées ne sont disponibles qu'après la clôture de l'élection le $1 à $2",
	'securepoll-dump-no-urandom' => "Impossible d'ouvrir /dev/urandom.
Pour maintenir la confidentialité des votants, les données cryptées ne sont disponibles que si elles peuvent être brouillées avec un nombre de caractères aléatoires.",
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Code de langue « $1 » invalide.',
	'securepoll-submit-translate' => 'Mettre à jour',
	'securepoll-language-label' => 'Sélectionner la langue :',
	'securepoll-submit-select-lang' => 'Traduire',
	'securepoll-header-title' => 'Nom',
	'securepoll-header-start-date' => 'Date de début',
	'securepoll-header-end-date' => 'Date de fin',
	'securepoll-subpage-vote' => 'Vote',
	'securepoll-subpage-translate' => 'Traduire',
	'securepoll-subpage-list' => 'Liste',
);

/** Irish (Gaeilge)
 * @author Stifle
 */
$messages['ga'] = array(
	'securepoll-not-started' => 'Níl an toghchán seo tosaithe fós.
De réir an sceidil, tosnóidh sé ag $1.',
	'securepoll-not-qualified' => 'Níl tú cáilithe vótáil sa thoghchán seo: $1',
	'securepoll-change-disallowed' => 'Vótail tú sa thoghchán seo roimhe seo.
Níl cead agat vótáil arís.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'securepoll' => 'Sondaxe de seguridade',
	'securepoll-desc' => 'Extensión para as eleccións e sondaxes',
	'securepoll-invalid-page' => 'Subpáxina "<nowiki>$1</nowiki>" inválida',
	'securepoll-too-few-params' => 'Non hai parámetros de subpáxina suficientes (ligazón inválida).',
	'securepoll-invalid-election' => '"$1" non é un número de identificación das eleccións válido.',
	'securepoll-welcome' => '<strong>Dámoslle a benvida, $1!</strong>',
	'securepoll-not-started' => 'Estas eleccións aínda non comezaron.
Están programadas para empezar o $2 ás $3.',
	'securepoll-not-qualified' => 'Non está cualificado para votar nestas eleccións: $1',
	'securepoll-change-disallowed' => 'Xa votou nestas eleccións.
Sentímolo, non pode votar de novo.',
	'securepoll-change-allowed' => '<strong>Nota: xa votou nestas eleccións.</strong>
Pode cambiar o seu voto enviando o formulario de embaixo.
Déase conta de que se fai isto o seu voto orixinal será descartado.',
	'securepoll-submit' => 'Enviar o voto',
	'securepoll-gpg-receipt' => 'Grazas por votar.

Se o desexa, pode gardar o seguinte recibo como proba do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grazas, o seu voto foi rexistrado.',
	'securepoll-return' => 'Voltar a $1',
	'securepoll-encrypt-error' => 'Non se puido encriptar o rexistro do seu voto.
O seu voto non foi gardado!

$1',
	'securepoll-no-gpg-home' => 'Non se pode crear directorio principal GPG.',
	'securepoll-secret-gpg-error' => 'Erro ao executar o directorio GPG.
Use $wgSecurePollShowErrorDetail=true; en LocalSettings.php para obter máis detalles.',
	'securepoll-full-gpg-error' => 'Erro ao executar o directorio GPG:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GPG están configuradas incorrectamente.',
	'securepoll-gpg-parse-error' => 'Erro de interpretación do GPG de saída.',
	'securepoll-no-decryption-key' => 'Non hai unha chave de desencriptar configurada.
Non se pode desencriptar.',
	'securepoll-jump' => 'Ir ao servidor de votos',
	'securepoll-remote-auth-error' => 'Erro ao enviar a información da túa conta desde o servidor.',
	'securepoll-remote-parse-error' => 'Erro ao interpretar a autorización de resposta desde o servidor.',
	'securepoll-api-invalid-params' => 'Parámetros inválidos.',
	'securepoll-api-no-user' => 'Non se atopou ningún usuario co ID introducido.',
	'securepoll-api-token-mismatch' => 'Desaxuste dun token de seguridade, non pode acceder ao sistema.',
	'securepoll-not-logged-in' => 'Debe acceder ao sistema para votar nestas eleccións',
	'securepoll-too-few-edits' => 'Sentímolo, non pode votar nestas eleccións. Debe ter feito polo menos $1 edicións, e só ten feito $2.',
	'securepoll-blocked' => 'Sentímolo, non pode votar nestas eleccións se está actualmente bloqueado fronte á edición.',
	'securepoll-not-in-group' => 'Só os membros pertencentes ao grupo dos $1 poden votar nestas eleccións.',
	'securepoll-not-in-list' => 'Sentímolo, non está na lista predeterminada de usuarios autorizados a votar nestas eleccións.',
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Axente usuario',
	'securepoll-header-strike' => 'Riscar',
	'securepoll-header-details' => 'Detalles',
	'securepoll-strike-button' => 'Riscar',
	'securepoll-unstrike-button' => 'Retirar o risco',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Erro ao levar a cabo o risco/a retirada do risco: $1',
	'securepoll-need-admin' => 'Ten que ser un administrador para levar a cabo esta acción.',
	'securepoll-details-link' => 'Detalles',
	'securepoll-details-title' => 'Detalles do voto: #$1',
	'securepoll-invalid-vote' => '"$1" non é un ID de voto válido',
	'securepoll-header-voter-type' => 'Tipo de votante',
	'securepoll-voter-properties' => 'Propiedades do elector',
	'securepoll-strike-log' => 'Rexistro de riscos',
	'securepoll-header-action' => 'Acción',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-dump-title' => 'Desbotar: $1',
	'securepoll-dump-no-crypt' => 'Non hai dispoñible ningún rexistro das eleccións encriptado, porque as eleccións non están configuradas para usar encriptación.',
	'securepoll-dump-not-finished' => 'Os rexistros das eleccións encriptados só están dispoñibles despois da data de fin o $1 ás $2',
	'securepoll-dump-no-urandom' => 'Non se pode abrir /dev/urandom.  
Para manter a protección dos datos, os rexistros das eleccións encriptados só están dispoñibles publicamente cando poden ser baraxados cunha secuencia de números aleatorios.',
	'securepoll-translate-title' => 'Traducir: $1',
	'securepoll-invalid-language' => 'Código de lingua inválido "$1"',
	'securepoll-submit-translate' => 'Actualizar',
	'securepoll-language-label' => 'Seleccione a lingua:',
	'securepoll-submit-select-lang' => 'Traducir',
	'securepoll-header-title' => 'Nome',
	'securepoll-header-start-date' => 'Data de inicio',
	'securepoll-header-end-date' => 'Data de fin',
	'securepoll-subpage-vote' => 'Votar',
	'securepoll-subpage-translate' => 'Traducir',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Desbotar',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'securepoll' => 'Sicheri Abstimmig',
	'securepoll-desc' => 'Erwyterig fir Wahlen un Umfroge',
	'securepoll-invalid-page' => 'Nit giltigi Untersyte „<nowiki>$1</nowiki>“',
	'securepoll-too-few-params' => 'Nit gnue Untersyteparameter (nit giltig Gleich).',
	'securepoll-invalid-election' => '„$1“ isch kei giltigi Abstimmigs-ID.',
	'securepoll-welcome' => '<strong>Willchuu $1!</strong>',
	'securepoll-not-started' => 'Die Wahl het nonig aagfange.
Si fangt wahrschyns aa am $2 am $3.',
	'securepoll-not-qualified' => 'Du bisch nit qualifiziert zum in däre Wahl abzstimme: $1',
	'securepoll-change-disallowed' => 'Du hesch in däre Wahl scho abgstimmt.
Du derfsch nit nomol abstimme.',
	'securepoll-change-allowed' => '<strong>Hiiwys: Du hesch in däre Wahl scho abgstimmt.</strong>
Du chasch Dyyn Stimm ändere, indäm s unter Formular abschicksch.
Wänn Du des machsch, wird Dyy urspringligi Stimm iberschribe.',
	'securepoll-submit' => 'Stimm abgee',
	'securepoll-gpg-receipt' => 'Dankschen.

S chunnt e Bstetigung as Bewyys fir Dyy Stimmabgab:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dankschen, Dyy Stimm isch gspycheret wore.',
	'securepoll-return' => 'Zruck zue $1',
	'securepoll-encrypt-error' => 'Bim Verschlissle vu Dyynere Stimm het s e Fähler gee.
Dyy Stimm isch nit gspycheret wore!

$1',
	'securepoll-no-gpg-home' => 'GPG-Heimverzeichnis cha nit aagleit wäre.',
	'securepoll-secret-gpg-error' => 'Fähler bim Uusfiere vu GPG.
$wgSecurePollShowErrorDetail=true; in LocalSettings.php yyfiege go meh Detail aazeige.',
	'securepoll-full-gpg-error' => 'Fähler bim Uusfiere vu GPG:

Befähl: $1

Fähler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-Schlissel sin nit korrekt konfiguriert.',
	'securepoll-gpg-parse-error' => 'Fähler bim Interpretiere vu dr Uusgab vu GPG.',
	'securepoll-no-decryption-key' => 'S isch kei Entschlisseligsschlissel konfiguriert.
Entschlisselig nit megli.',
	'securepoll-jump' => 'Gang zum Stimm-Server',
	'securepoll-remote-auth-error' => 'Fähler bim Abruefe vu Dyyne Benutzerkontoinformatione vum Server.',
	'securepoll-remote-parse-error' => 'Fähler bim Dyte vu dr Autorisierigsantwort vum Server',
	'securepoll-api-invalid-params' => 'Nit giltigi Parameter.',
	'securepoll-api-no-user' => 'S isch kei Benutzer gfunde wore mit däre ID.',
	'securepoll-api-token-mismatch' => 'Fähler bi dr Sicherheitsabfrog, cha Di nit aamälde.',
	'securepoll-not-logged-in' => 'Du muesch aagmäldet syy zum abstimme bi däre Wahl',
	'securepoll-too-few-edits' => 'Excusez, Du chasch nit abstimme. Du muesch zmindescht $1 Beabreitige haa zum Abstimme bi däre Wahl, Du hesch $2.',
	'securepoll-blocked' => 'Excusez, Du derfsch nit abstimme bi däre Wahl, wänn Du grad fir Bearbeitige gsperrt bisch.',
	'securepoll-not-in-group' => 'Numme Benutzer, wu Mitglid in dr $1 Gruppesin, chenne bi däre Wahl abstimme.',
	'securepoll-not-in-list' => 'Excusez, Du bisch nit in dr feschtgleite Lischt vu autorisierte Benutzer, wu bi däre Wahl derfe abstimme.',
	'securepoll-list-title' => 'Stimmen uflischte: $1',
	'securepoll-header-timestamp' => 'Zyt',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domäne',
	'securepoll-header-ua' => 'Benutzeragent',
	'securepoll-header-strike' => 'Stryche',
	'securepoll-header-details' => 'Detail',
	'securepoll-strike-button' => 'Stryche',
	'securepoll-unstrike-button' => 'Strychig zruckneh',
	'securepoll-strike-reason' => 'Grund:',
	'securepoll-strike-cancel' => 'Abbräche',
	'securepoll-strike-error' => 'Fähler bi dr Strychig/Strychigsrucknahm: $1',
	'securepoll-need-admin' => 'Du muesch e Ammann syy go die Aktion durzfiere.',
	'securepoll-details-link' => 'Detail',
	'securepoll-details-title' => 'Abstimmigsdetail: #$1',
	'securepoll-invalid-vote' => '„$1“ isch kei giltigi Abstimmigs-ID',
	'securepoll-header-voter-type' => 'Wehlertyp',
	'securepoll-voter-properties' => 'Wehlereigeschafte',
	'securepoll-strike-log' => 'Strychigs-Logbuech',
	'securepoll-header-action' => 'Aktion',
	'securepoll-header-reason' => 'Grund',
	'securepoll-header-admin' => 'Ammann',
	'securepoll-dump-title' => 'Uuszug: $1',
	'securepoll-dump-no-crypt' => 'Fir die Wahl sin kei verschlissleti Abstimmigsufzeichnige verfiegbar, wel d Wahl nit fir e Verschlisslig konfiguriert woren isch.',
	'securepoll-dump-not-finished' => 'Verschlissleti Abstimmigsufzeichnige sin nume noch em Ändtermin am $1 am $2 verfiegbar',
	'securepoll-dump-no-urandom' => '/dev/urandom cha nit ufgmacht wäre.
Go dr Wehlerdateschutz wohre, sin verschlissleti Abstimmigsufzeichnige nume effentli verfiebar, wänn si mit eme sichere  Zuefallszahlestrom chenne gmischt wäre.',
	'securepoll-translate-title' => 'Ibersetze: $1',
	'securepoll-invalid-language' => 'Nit giltige Sprochcode „$1“',
	'securepoll-submit-translate' => 'Aktualisiere',
	'securepoll-language-label' => 'Sproch uuswehle:',
	'securepoll-submit-select-lang' => 'Ibersetze',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Aafangsdatum',
	'securepoll-header-end-date' => 'Änddatum',
	'securepoll-subpage-vote' => 'Abstimme',
	'securepoll-subpage-translate' => 'Iberseze',
	'securepoll-subpage-list' => 'Lischt',
	'securepoll-subpage-dump' => 'Uusgab',
);

/** Hebrew (עברית)
 * @author Rotem Liss
 * @author דניאל ב.
 */
$messages['he'] = array(
	'securepoll' => 'הצבעה מאובטחת',
	'securepoll-desc' => 'הרחבה המאפשרת הצבעות וסקרים',
	'securepoll-invalid-page' => 'דף משנה בלתי תקין: "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'אין מספיק פרמטרים של דפי משנה (קישור בלתי תקין).',
	'securepoll-invalid-election' => '"$1" אינו מספר הצבעה תקין.',
	'securepoll-welcome' => '<strong>ברוכים הבאים, $1!</strong>',
	'securepoll-not-started' => 'הצבעה זו טרם התחילה.
היא מיועדת להתחיל ב־$3, $2.',
	'securepoll-not-qualified' => 'אינכם רשאים להצביע בהצבעה זו: $1',
	'securepoll-change-disallowed' => 'הצבעתם כבר בהצבעה זו.
מצטערים, אינכם רשאים להצביע שוב.',
	'securepoll-change-allowed' => '<strong>הערה: כבר הצבעתם בהצבעה זו בעבר.</strong>
באפשרותכם לשנות את הצבעתכם באמצעות שליחת הטופס להלן.
אם תעשו זאת, הצבעתכם המקורית תימחק.',
	'securepoll-submit' => 'שליחת ההצבעה',
	'securepoll-gpg-receipt' => 'תודה על ההצבעה.

אם תרצו, תוכלו לשמור את הקבלה הבאה כהוכחה להצבעתכם:

<pre>$1</pre>',
	'securepoll-thanks' => 'תודה לכם, הצבעתכם נרשמה.',
	'securepoll-return' => 'בחזרה ל$1',
	'securepoll-encrypt-error' => 'הצפנת רשומת ההצבעה שלכם לא הצליחה.
הצבעתכם לא נרשמה!

$1',
	'securepoll-no-gpg-home' => 'לא ניתן ליצור את תיקיית הבית של GPG.',
	'securepoll-secret-gpg-error' => 'שגיאה בהרצת GPG.
הגדירו את $wgSecurePollShowErrorDetail=true; בקובץ LocalSettings.php להצגת פרטים נוספים.',
	'securepoll-full-gpg-error' => 'שגיאה בהרצת GPG:

פקודה: $1

שגיאה:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'מפתחות GPG אינם מוגדרים כהלכה.',
	'securepoll-gpg-parse-error' => 'שגיאה בפענוח הפלט של GPG.',
	'securepoll-no-decryption-key' => 'לא הוגדר מפתח פיענוח.
לא ניתן לפענח.',
	'securepoll-jump' => 'מעבר לשרת ההצבעה',
	'securepoll-remote-auth-error' => 'שגיאה בקבלת פרטי החשבון שלכם מהשרת.',
	'securepoll-remote-parse-error' => 'שגיאה בפענוח התגובה על מידע הכניסה מהשרת.',
	'securepoll-api-invalid-params' => 'פרמטרים בלתי תקינים.',
	'securepoll-api-no-user' => 'לא נמצא משתמש עם מספר זה.',
	'securepoll-api-token-mismatch' => 'אסימון האבטחה לא מתאים, לא ניתן להיכנס לחשבון.',
	'securepoll-not-logged-in' => 'עליכם להיכנס לחשבון כדי להצביע בהצבעה זו',
	'securepoll-too-few-edits' => 'מצטערים, אינכם יכולים להצביע. היה עליכם לערוך לפחות $1 עריכות כדי להצביע בהצבעה זו, וערכתם רק $2.',
	'securepoll-blocked' => 'מצטערים, אינכם יכולים להצביע בהצבעה זו אם אתם חסומים כרגע מעריכה.',
	'securepoll-not-in-group' => 'רק חברים בקבוצה $1 יכולים להצביע בהצבעה זו.',
	'securepoll-not-in-list' => 'מצטערים, אינכם ברשימת המשתמשים שהוגדרו מראש כרשאים להצביע בהצבעה זו.',
	'securepoll-list-title' => 'רשימת הצבעות: $1',
	'securepoll-header-timestamp' => 'זמן',
	'securepoll-header-voter-name' => 'שם',
	'securepoll-header-voter-domain' => 'דומיין',
	'securepoll-header-ua' => 'זיהוי דפדפן',
	'securepoll-header-strike' => 'מחיקה',
	'securepoll-header-details' => 'פרטים',
	'securepoll-strike-button' => 'מחיקה',
	'securepoll-unstrike-button' => 'ביטול מחיקה',
	'securepoll-strike-reason' => 'סיבה:',
	'securepoll-strike-cancel' => 'ביטול',
	'securepoll-strike-error' => 'שגיאה בביצוע הסתרה או בביטול הסתרה: $1',
	'securepoll-need-admin' => 'עליכם להיות מנהלי ההצבעה כדי לבצע פעולה זו.',
	'securepoll-details-link' => 'פרטים',
	'securepoll-details-title' => 'פרטי ההצבעה: #$1',
	'securepoll-invalid-vote' => '"$1" אינו מספר הצבעה תקין',
	'securepoll-header-id' => 'מספר',
	'securepoll-header-voter-type' => 'סוג המצביע',
	'securepoll-voter-properties' => 'מאפייני המצביע',
	'securepoll-strike-log' => 'יומן הסתרת הצבעות',
	'securepoll-header-action' => 'פעולה',
	'securepoll-header-reason' => 'סיבה',
	'securepoll-header-admin' => 'מנהל',
	'securepoll-dump-title' => 'העתק מוצפן: $1',
	'securepoll-dump-no-crypt' => 'לא נמצאה רשומת הצבעה מוצפנת עבור הצבעה זו, כיוון שההצבעה אינה מוגדרת לשימוש בהצפנה.',
	'securepoll-dump-not-finished' => 'רשומות ההצבעה המוצפנות זמינות רק לאחר תאריך הסיום ב־$2, $1',
	'securepoll-dump-no-urandom' => 'לא ניתן לפתוח את /dev/urandom. 
כדי לשמור על פרטיות המצביעים, רשומות ההצבעה המוצפנות זמינותת באופן ציבורי רק כאשר ניתן לערבב אותן באמצעות זרם המשתמש במספר אקראי מאובטח.',
	'securepoll-translate-title' => 'תרגום: $1',
	'securepoll-invalid-language' => 'קוד שפה בלתי תקין "$1"',
	'securepoll-header-trans-id' => 'מספר',
	'securepoll-submit-translate' => 'עדכון',
	'securepoll-language-label' => 'בחירת שפה:',
	'securepoll-submit-select-lang' => 'תרגום',
	'securepoll-header-title' => 'שם',
	'securepoll-header-start-date' => 'תאריך התחלה',
	'securepoll-header-end-date' => 'תאריך סיום',
	'securepoll-subpage-vote' => 'הצבעה',
	'securepoll-subpage-translate' => 'תרגום',
	'securepoll-subpage-list' => 'רשימה',
	'securepoll-subpage-dump' => 'העתק מוצפן',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'securepoll' => 'Wěste hłosowanje',
	'securepoll-desc' => 'Rozšěrjenje za wólby a naprašniki',
	'securepoll-invalid-page' => 'Njepłaćiwa podstrona "<nowiki>$1</nowiki>',
	'securepoll-too-few-params' => 'Nic dosć parametrow podstrony (njepłaćiwy wotkaz).',
	'securepoll-invalid-election' => '"$1" płaćiwy wólbny ID njeje.',
	'securepoll-welcome' => '<strong>Witaj $1!</strong>',
	'securepoll-not-started' => 'Wólba hišće njeje započała.
Započnje najskerje $2 $3.',
	'securepoll-not-qualified' => 'Njejsy woprawnjeny w tutej wólbje hłosować: $1',
	'securepoll-change-disallowed' => 'Sy hižo w tutej wólbje wothłosował.
Njesměš znowa wothłosować.',
	'securepoll-change-allowed' => '<strong>Pokazka: Sy hižo w tutej wólbje wothłosował.</strong>
Móžeš swój hłós změnić, hdyž slědowacy formular wotpósćeleš.
Kedźbu: jeli to činiš, budźe so twój prěnjotny hłós přepisować.',
	'securepoll-submit' => 'Hłós wotedać',
	'securepoll-gpg-receipt' => 'Dźakuju za wothłosowanje.

Jeli chceš, móžeš slědowace wobkrućenje jako dokład za swój hłós wobchować:

<pre>$1$</pre>',
	'securepoll-thanks' => 'Dźakujemy so, twój hłós bu zregistrowany.',
	'securepoll-return' => 'Wróćo k $1',
	'securepoll-encrypt-error' => 'Zaklučowanje twojeho wotedaća hłosa je so njeporadźiło.
Twój hłós njeje so zregistrował!

$1',
	'securepoll-no-gpg-home' => 'Njemóžno domjacy zapis GPG wutworić.',
	'securepoll-secret-gpg-error' => 'Zmylk při wuwjedźenju GPG.
Wužij $wgSecurePollShowErrorDetail=true; w LocalSettings.php, zo by dalše podrobnosće pokazał.',
	'securepoll-full-gpg-error' => 'Zmylk při wuwjedźenju GPG:

Přikaz: $1

Zmylk:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-kluče su wopak konfigurowane.',
	'securepoll-gpg-parse-error' => 'Zmylk při interpretowanju wudaća GPG.',
	'securepoll-no-decryption-key' => 'Žadyn dešifrowanski kluč konfigurowany.
Dešifrowanje njemóžno.',
	'securepoll-api-invalid-params' => 'Njepłaćiwe parametry.',
	'securepoll-api-no-user' => 'Wužiwar z podatym ID njeje.',
	'securepoll-not-logged-in' => 'Dyrbiš so přizjewić, zo by w tutej wólbje wothłosował.',
	'securepoll-not-in-group' => 'Jenož čłony skupiny $1 móžeja w tutej wólbje wothłosować.',
	'securepoll-list-title' => 'Hłosy nalistować: $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Mjeno',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Identifikator wobhladowaka',
	'securepoll-header-strike' => 'Šmórnyć',
	'securepoll-header-details' => 'Podrobnosće',
	'securepoll-strike-button' => 'Šmórnyć',
	'securepoll-unstrike-button' => 'Šmórnjenje cofnyć',
	'securepoll-strike-reason' => 'Přičina:',
	'securepoll-strike-cancel' => 'Přetorhnyć',
	'securepoll-strike-error' => 'Zmylk při přewjedźenju šmórnjenja/cofnjenja šmórnjenja: $1',
	'securepoll-need-admin' => 'Dyrbiš administrator być, zo by tutu akciju přewjedł.',
	'securepoll-details-link' => 'Podrobnosće',
	'securepoll-details-title' => 'Podrobnosće hłosowanja: #$1',
	'securepoll-invalid-vote' => '"$1" płaćiwy hłosowanski ID njeje.',
	'securepoll-header-voter-type' => 'Wolerski typ',
	'securepoll-voter-properties' => 'Kajkosće wolerja',
	'securepoll-strike-log' => 'Protokol šmórnjenjow',
	'securepoll-header-action' => 'Akcija',
	'securepoll-header-reason' => 'Přičina',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-dump-title' => 'Wućah: $1',
	'securepoll-dump-no-crypt' => 'Za tutu wólbu žana zaklučowana lisćina wólby k dispoziciji njesteji, dokelž wólba njeje konfigurowana, zo by zaklučowanje wužiwała.',
	'securepoll-dump-not-finished' => 'Zaklučowane zapiski wólby jenož po kónčnym datumje $1 $2 k dispoziciji steja',
	'securepoll-translate-title' => 'Přełožić: $1',
	'securepoll-invalid-language' => 'Njepłaćiwy rěčny kod "$1"',
	'securepoll-submit-translate' => 'Aktualizować',
	'securepoll-language-label' => 'Rěč wubrać:',
	'securepoll-submit-select-lang' => 'Přełožić',
	'securepoll-header-title' => 'Mjeno',
	'securepoll-header-start-date' => 'Spočatny datum',
	'securepoll-header-end-date' => 'Kónčny datum',
	'securepoll-subpage-vote' => 'Wothłosować',
	'securepoll-subpage-translate' => 'Přełožić',
	'securepoll-subpage-list' => 'Lisćina',
	'securepoll-subpage-dump' => 'Wućah',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 */
$messages['hu'] = array(
	'securepoll' => 'BiztonságosSzavazás',
	'securepoll-desc' => 'Kiegészítő választások és közvéleménykutatások lebonyolítására',
	'securepoll-invalid-page' => 'Érvénytelen allap: „"<nowiki>$1</nowiki>"”',
	'securepoll-too-few-params' => 'Nincs elég paraméter az allaphoz (érvénytelen hivatkozás).',
	'securepoll-invalid-election' => '„$1” nem érvényes választási azonosító.',
	'securepoll-welcome' => '<strong>Üdvözlünk $1!</strong>',
	'securepoll-not-started' => 'Ez a választás még nem kezdődött el.
Tervezett indulása: $1.',
	'securepoll-not-qualified' => 'Nincs jogod szavazni ezen a választáson: $1',
	'securepoll-change-disallowed' => 'Már szavaztál ezen a választáson.
Sajnáljuk, nem szavazhatsz újra.',
	'securepoll-change-allowed' => '<strong>Megjegyzés: korábban már szavaztál ezen a választáson.</strong>
Az alábbi űrlap elküldésével módosíthatod a szavazatodat.
Amennyiben ezt teszed, a korábbi szavazatod semmisnek minősül.',
	'securepoll-submit' => 'Szavazat elküldése',
	'securepoll-gpg-receipt' => 'Köszönjük, hogy szavaztál.

Ha szeretnéd, megtarthatod ezt az elismervényt, mint bizonyítékot, hogy szavaztál:

<pre>$1</pre>',
	'securepoll-thanks' => 'Köszönjük, a szavazatodat rögzítettük.',
	'securepoll-encrypt-error' => 'Nem sikerült titkosítani a szavazatodat.
A szavazat nem lett rögzítve!

$1',
	'securepoll-no-gpg-home' => 'A GPG könyvtárát nem sikerült elkészíteni.',
	'securepoll-secret-gpg-error' => 'Hiba történt a GPG futtatásakor.
Használd a $wgSecurePollShowErrorDetail=true; parancsot a LocalSettings.php-ben a hiba részleteinek megjelenítéséhez.',
	'securepoll-full-gpg-error' => 'Hiba történt a GPG futtatásakor:

Parancs: $1

Hiba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'A GPG-kulcsok hibásan vannak beállítva.',
	'securepoll-gpg-parse-error' => 'Hiba történt a GPG kimenetének értelmezése közben.',
	'securepoll-no-decryption-key' => 'Nincs visszafejtő kulcs beállítva.
Nem lehet visszafejteni.',
	'securepoll-list-title' => 'Szavazatok listázása: $1',
	'securepoll-header-timestamp' => 'Idő',
	'securepoll-header-voter-name' => 'Név',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-strike' => 'Törlés',
	'securepoll-header-details' => 'Részletek',
	'securepoll-strike-button' => 'Törlés',
	'securepoll-unstrike-button' => 'Törlés visszavonása',
	'securepoll-strike-reason' => 'Ok:',
	'securepoll-strike-cancel' => 'Mégse',
	'securepoll-strike-error' => 'Hiba történt a törléskor vagy a törlés visszavonásakor: $1',
	'securepoll-need-admin' => 'Csak adminisztrátorok hajthatják végre ezt a műveletet.',
	'securepoll-details-link' => 'Részletek',
	'securepoll-details-title' => 'A szavazás részletei: #$1',
	'securepoll-invalid-vote' => 'A(z) „$1” nem érvényes szavazatazonosító',
	'securepoll-header-voter-type' => 'Szerkesztő típusa',
	'securepoll-voter-properties' => 'Szavazó tulajdonságai',
	'securepoll-strike-log' => 'Törlési napló',
	'securepoll-header-action' => 'Művelet',
	'securepoll-header-reason' => 'Ok',
	'securepoll-header-admin' => 'Adminisztrátor',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'A szavazáshoz nem érhető el titkosított szavazatjegyzőkönyv, mert nem lett hozzá titkosítás beállítva.',
	'securepoll-dump-not-finished' => 'A titkosított szavazatjegyzőkönyvek csak a befejezési dátum ($1) után érhetőek el.',
	'securepoll-dump-no-urandom' => 'Nem nyitható meg a /dev/urandom.
A szavazók névtelenségének megőrzése érdekében a titkosított szavazójegyzőkönyv csak akkor érhető el nyilvánosan, ha egy biztonságos véletlenszám-sorozattal lehet keverni.',
	'securepoll-translate-title' => 'Fordítás: $1',
	'securepoll-invalid-language' => 'Érvénytelen nyelvkód: „$1”',
	'securepoll-submit-translate' => 'Frissítés',
	'securepoll-language-label' => 'Nyelv kiválasztása:',
	'securepoll-submit-select-lang' => 'Fordítás',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'securepoll' => 'Voto secur',
	'securepoll-desc' => 'Extension pro electiones e inquestas',
	'securepoll-invalid-page' => 'Subpagina  "<nowiki>$1</nowiki>" invalide',
	'securepoll-too-few-params' => 'Non satis de parametros del subpagina (ligamine invalide).',
	'securepoll-invalid-election' => '"$1" non es un identificator valide de un election.',
	'securepoll-welcome' => '<strong>Benvenite, $1!</strong>',
	'securepoll-not-started' => 'Iste election non ha ancora comenciate.
Le initio es programmate pro le $2 a $3.',
	'securepoll-not-qualified' => 'Tu non es qualificate pro votar in iste election: $1',
	'securepoll-change-disallowed' => 'Tu ha ja votate in iste election.
Non es possibile votar de novo.',
	'securepoll-change-allowed' => '<strong>Nota: Tu ha ja votate in iste election.</strong>
Tu pote cambiar tu voto per submitter le formulario in basso.
Nota que si tu face isto, le voto original essera cancellate.',
	'securepoll-submit' => 'Submitter voto',
	'securepoll-gpg-receipt' => 'Gratias pro votar.

Si tu vole, tu pote retener le sequente recepta como prova de tu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Gratias, tu voto ha essite registrate.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Impossibile cryptar le registro de tu voto.
Tu voto non ha essite registrate!

$1',
	'securepoll-no-gpg-home' => 'Impossibile crear le directorio de base pro GPG.',
	'securepoll-secret-gpg-error' => 'Error durante le execution de GPG.
Usa $wgSecurePollShowErrorDetail=true; in LocalSettings.php pro revelar plus detalios.',
	'securepoll-full-gpg-error' => 'Error durante le execution de GPG:

Commando: $1

Error:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Le claves GPG non es configurate correctemente.',
	'securepoll-gpg-parse-error' => 'Error durante le interpretation del output de GPG.',
	'securepoll-no-decryption-key' => 'Nulle clave de decryptation es configurate.
Impossibile decryptar.',
	'securepoll-jump' => 'Ir al servitor de votation',
	'securepoll-remote-auth-error' => 'Error durante le lectura del informationes de tu conto ab le servitor.',
	'securepoll-remote-parse-error' => 'Error durante le interpretation del responsa de autorisation ab le servitor.',
	'securepoll-api-invalid-params' => 'Parametros invalide.',
	'securepoll-api-no-user' => 'Nulle usator ha essite trovate con le ID specificate.',
	'securepoll-api-token-mismatch' => 'Le indicio de securitate non corresponde; non pote aperir session.',
	'securepoll-not-logged-in' => 'Tu debe aperir un session pro votar in iste election.',
	'securepoll-too-few-edits' => 'Pardono, tu non pote votar. Tu debe haber facite al minus $1 modificationes pro votar in iste election, e tu ha facite $2.',
	'securepoll-blocked' => 'Pardono, tu non pote votar in iste election durante que tu es blocate de facer modificationes.',
	'securepoll-not-in-group' => 'Solmente le membros del gruppo $1 pote votar in iste election.',
	'securepoll-not-in-list' => 'Pardono, tu non es in le lista predeterminate del usatores autorisate a votar in iste election.',
	'securepoll-list-title' => 'Lista del votos: $1',
	'securepoll-header-timestamp' => 'Tempore',
	'securepoll-header-voter-name' => 'Nomine',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente usator',
	'securepoll-header-strike' => 'Cancellation',
	'securepoll-header-details' => 'Detalios',
	'securepoll-strike-button' => 'Cancellar voto',
	'securepoll-unstrike-button' => 'Restaurar voto',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Annullar',
	'securepoll-strike-error' => 'Error durante le cancellation/restauration: $1',
	'securepoll-need-admin' => 'Tu debe esser un administrator pro poter executar iste action.',
	'securepoll-details-link' => 'Detalios',
	'securepoll-details-title' => 'Detalios del voto: #$1',
	'securepoll-invalid-vote' => '"$1" non es un identificator valide de un voto',
	'securepoll-header-voter-type' => 'Typo de usator',
	'securepoll-voter-properties' => 'Proprietates del votator',
	'securepoll-strike-log' => 'Registro de cancellationes',
	'securepoll-header-action' => 'Action',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Admin',
	'securepoll-dump-title' => 'Extracto: $1',
	'securepoll-dump-no-crypt' => 'Nulle registro cryptate es disponibile pro iste election, proque le election non es configurate pro usar cryptation.',
	'securepoll-dump-not-finished' => 'Le registro cryptate del election non essera disponibile usque le data final: le $1 a $2',
	'securepoll-dump-no-urandom' => 'Impossibile aperir /dev/urandom.
Pro mantener le confidentialitate del votatores, le registro cryptate del election non essera disponibile al publico usque illo pote esser miscite con un fluxo secur de numeros aleatori.',
	'securepoll-translate-title' => 'Traducer: $1',
	'securepoll-invalid-language' => 'Le codice de lingua "$1" es invalide',
	'securepoll-submit-translate' => 'Actualisar',
	'securepoll-language-label' => 'Selige lingua:',
	'securepoll-submit-select-lang' => 'Traducer',
	'securepoll-header-title' => 'Nomine',
	'securepoll-header-start-date' => 'Data de initio',
	'securepoll-header-end-date' => 'Data de fin',
	'securepoll-subpage-vote' => 'Voto',
	'securepoll-subpage-translate' => 'Traduction',
	'securepoll-subpage-list' => 'Lista',
	'securepoll-subpage-dump' => 'Discarga',
);

/** Indonesian (Bahasa Indonesia)
 * @author Rex
 */
$messages['id'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Ekstensi untuk pemungutan suara dan survei',
	'securepoll-invalid-page' => 'Subhalaman tidak sah "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Parameter subhalaman tidak lengkap (pranala tidak sah).',
	'securepoll-invalid-election' => 'ID pemilihan tidak sah: "$1"',
	'securepoll-welcome' => '<strong>Selamat datang $1!</strong>',
	'securepoll-not-started' => 'Pemungutan suara ini belum dimulai
dan baru akan berlangsung pada $1.',
	'securepoll-not-qualified' => 'Anda belum memenuhi syarat untuk memberikan suara dalam pemungutan suara ini: $1',
	'securepoll-change-disallowed' => 'Anda telah memberikan suara dalam pemilihan ini sebelumnya.
Maaf, Anda tidak dapat memberikan suara lagi.',
	'securepoll-change-allowed' => '<strong>Catatan: Anda sudah pernah memberikan suara dalam pemilihan kali ini.</strong>
Anda dapat mengganti suara Anda dengan menggunakan formulir di bawah ini. Suara Anda sebelumnya akan dibatalkan jika Anda mengirimkan suara baru.',
	'securepoll-submit' => 'Kirim suara',
	'securepoll-gpg-receipt' => 'Terima kasih atas suara Anda.

Jika diperlukan, Anda dapat menyimpan bukti penerimaan suara Anda di bawah ini:

<pre>$1</pre>',
	'securepoll-thanks' => 'Terima kasih, suara Anda telah dicatat.',
	'securepoll-return' => 'Kembali ke $1',
	'securepoll-encrypt-error' => 'Gagal mengenkripsi catatan suara Anda.
Suara Anda belum direkam!

$1',
	'securepoll-no-gpg-home' => 'Gagal membuat direktori utama GPG.',
	'securepoll-secret-gpg-error' => 'Gagal menjalankan GPG.
Gunakan $wgSecurePollShowErrorDetail=true; di LocalSettings.php untuk menampilkan rincian lebih lanjut.',
	'securepoll-full-gpg-error' => 'Gagal menjalankan GPG:

Perintah: $1

Kesalahan:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Kesalahan konfigurasi kunci GPG.',
	'securepoll-gpg-parse-error' => 'Gagal menginterpretasikan hasil keluaran GPG.',
	'securepoll-no-decryption-key' => 'Kunci dekripsi belum dikonfigurasikan.
Tidak dapat melakukan dekripsi.',
	'securepoll-list-title' => 'Daftar suara: $1',
	'securepoll-header-timestamp' => 'Waktu',
	'securepoll-header-voter-name' => 'Nama',
	'securepoll-header-voter-domain' => 'Domain',
	'securepoll-header-ua' => 'Aplikasi pengguna',
	'securepoll-header-strike' => 'Coret',
	'securepoll-header-details' => 'Rincian',
	'securepoll-strike-button' => 'Coret',
	'securepoll-unstrike-button' => 'Batal coret',
	'securepoll-strike-reason' => 'Alasan:',
	'securepoll-strike-cancel' => 'Batal',
	'securepoll-strike-error' => 'Gagal mencoret/membatalkan pencoretan: $1',
	'securepoll-need-admin' => 'Tindakan ini hanya dapat dilakukan oleh administrator.',
	'securepoll-details-link' => 'Rincian',
	'securepoll-details-title' => 'Rincian suara: #$1',
	'securepoll-invalid-vote' => 'ID suara tidak sah: "$1"',
	'securepoll-header-voter-type' => 'Jenis pengguna',
	'securepoll-voter-properties' => 'Properti pengguna',
	'securepoll-strike-log' => 'Log pencoretan',
	'securepoll-header-action' => 'Tindakan',
	'securepoll-header-reason' => 'Alasan',
	'securepoll-header-admin' => 'Admin',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Tidak ada catatan pemilihan yang terenkripsi untuk pemilihan ini, karena pemilihan ini tidak dikonfigurasikan untuk menggunakan enkripsi.',
	'securepoll-dump-not-finished' => 'Catatan pemilihan terenkripsi hanya tersedia setelah tanggal selesai pemungutan suara: $1',
	'securepoll-dump-no-urandom' => 'Tidak dapat membuka /dev/urandom.
Untuk memastikan privasi pemberi suara, catatan pemilihan terenkripsi hanya akan tersedia secara publik jika menggunakan sebuah rangkaian nomor keamanan acak.',
	'securepoll-translate-title' => 'Terjemahkan: $1',
	'securepoll-invalid-language' => 'Kode bahasa tidak sah "$1"',
	'securepoll-submit-translate' => 'Perbarui',
	'securepoll-language-label' => 'Pilih bahasa:',
	'securepoll-submit-select-lang' => 'Terjemahkan',
);

/** Italian (Italiano)
 * @author BrokenArrow
 * @author Darth Kule
 * @author Melos
 * @author Nemo bis
 */
$messages['it'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estensione per le elezioni e le indagini',
	'securepoll-invalid-page' => 'Sottopagina non valida "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Parametri della sottopagina non sufficienti (collegamento non valido).',
	'securepoll-invalid-election' => '"$1" non è un ID valido per l\'elezione.',
	'securepoll-welcome' => '<strong>Benvenuto $1!</strong>',
	'securepoll-not-started' => "L'elezione non è ancora iniziata.
L'inizio è programmato per il giorno $2 alle $3.",
	'securepoll-not-qualified' => 'Non sei qualificato per votare in questa elezione: $1',
	'securepoll-change-disallowed' => 'Hai già votato in questa elezione.
Non è possibile votare nuovamente.',
	'securepoll-change-allowed' => '<strong>Nota: hai già votato in questa elezione.</strong>
È possibile modificare il voto compilando il modulo seguente.
Si noti che così facendo il voto originale verrà scartato.',
	'securepoll-submit' => 'Invia il voto',
	'securepoll-gpg-receipt' => 'Grazie per aver votato.

È possibile mantenere la seguente ricevuta come prova della votazione:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grazie, il tuo voto è stato registrato.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => 'Impossibile cifrare le informazioni di voto.
Il voto non è stato registrato.

$1',
	'securepoll-no-gpg-home' => 'Impossibile creare la directory principale di GPG.',
	'securepoll-secret-gpg-error' => 'Errore durante l\'esecuzione di GPG.
Usare $wgSecurePollShowErrorDetail=true; in LocalSettings.php per mostrare maggiori dettagli.',
	'securepoll-full-gpg-error' => "Errore durante l'esecuzione di GPG:

Comando: $1

Errore:
<pre> $2 </pre>",
	'securepoll-gpg-config-error' => 'Le chiavi GPG non sono configurate correttamente.',
	'securepoll-gpg-parse-error' => "Errore nell'interpretazione dell'output di GPG.",
	'securepoll-no-decryption-key' => 'Nessuna chiave di decrittazione è configurata.
Impossibile decifrare.',
	'securepoll-list-title' => 'Elenco voti: $1',
	'securepoll-header-timestamp' => 'Data e ora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente utente',
	'securepoll-header-strike' => 'Annulla',
	'securepoll-header-details' => 'Dettagli',
	'securepoll-strike-button' => 'Annulla questo voto',
	'securepoll-unstrike-button' => 'Elimina annullamento',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Annulla',
	'securepoll-strike-error' => "Errore durante l'annullamento o ripristino del voto: $1",
	'securepoll-need-admin' => 'Devi essere un amministratore per compiere questa azione.',
	'securepoll-details-link' => 'Dettagli',
	'securepoll-details-title' => 'Dettagli del voto: #$1',
	'securepoll-invalid-vote' => '"$1" non è l\'ID di un voto valido',
	'securepoll-header-voter-type' => 'Tipo di utente',
	'securepoll-voter-properties' => 'Proprietà del votante',
	'securepoll-strike-log' => 'Registro degli annullamenti',
	'securepoll-header-action' => 'Azione',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Amministratore',
	'securepoll-dump-no-crypt' => "Per questa elezione non è disponibile nessuna registrazione criptata, perché l'elezione non è impostata per usare la crittazione.",
	'securepoll-dump-not-finished' => "Le registrazioni criptate dell'elezione sono disponibili solo dopo la data di conclusione: $1 alle $2",
	'securepoll-dump-no-urandom' => "Impossibile aprire /dev/urandom. 
Per proteggere la riservatezza dei votanti, le registrazioni criptate dell'elezione sono disponibili pubblicamente solo quando potranno essere mescolate con un flusso sicuro di numeri casuali.",
	'securepoll-translate-title' => 'Traduci: $1',
	'securepoll-invalid-language' => 'Codice lingua non valido: "$1"',
	'securepoll-submit-translate' => 'Aggiorna',
	'securepoll-language-label' => 'Scegli lingua:',
	'securepoll-submit-select-lang' => 'Traduci',
);

/** Japanese (日本語)
 * @author Aotake
 * @author Fryed-peach
 * @author 青子守歌
 */
$messages['ja'] = array(
	'securepoll' => '暗号投票',
	'securepoll-desc' => '選挙と意識調査のための拡張機能',
	'securepoll-invalid-page' => '「<nowiki>$1</nowiki>」は無効なサブページです',
	'securepoll-too-few-params' => 'サブページ引数が足りません（リンクが無効です）。',
	'securepoll-invalid-election' => '「$1」は有効な選挙IDではありません。',
	'securepoll-welcome' => '<strong>$1さん、ようこそ！</strong>',
	'securepoll-not-started' => 'この選挙はまだ始まっていません。$2 $3 に開始する予定です。',
	'securepoll-not-qualified' => 'あなたはこの選挙に投票する資格がありません: $1',
	'securepoll-change-disallowed' => 'あなたはこの選挙で既に投票しています。申し訳ありませんが、二度の投票はできません。',
	'securepoll-change-allowed' => '<strong>注: あなたはこの選挙で既に投票しています。</strong>下のフォームから投稿することで票を変更できます。これを行う場合、以前の票は破棄されることに留意してください。',
	'securepoll-submit' => '投票',
	'securepoll-gpg-receipt' => '投票ありがとうございます。

必要ならば、以下の受理証をあなたの投票の証しとしてとっておくことができます。

<pre>$1</pre>',
	'securepoll-thanks' => 'ありがとうございます。あなたの投票は記録されました。',
	'securepoll-return' => '$1 に戻る',
	'securepoll-encrypt-error' => 'あなたの投票記録の暗号化に失敗しました。あなたの投票は記録されませんでした。

$1',
	'securepoll-no-gpg-home' => 'GPG ホームディレクトリが作成できません。',
	'securepoll-secret-gpg-error' => 'GPG の実行に失敗しました。より詳しい情報を表示するには、LocalSettings.php で $wgSecurePollShowErrorDetail=true; としてください。',
	'securepoll-full-gpg-error' => 'GPG の実行に失敗しました:

コマンド: $1

エラー:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG 鍵の設定が誤っています。',
	'securepoll-gpg-parse-error' => 'GPG 出力の解釈に失敗しました。',
	'securepoll-no-decryption-key' => '復号鍵が設定されておらず、復号できません。',
	'securepoll-jump' => '投票サーバへ移動',
	'securepoll-remote-auth-error' => 'エラー：サーバからあなたのアカウント情報を取得できませんでした',
	'securepoll-remote-parse-error' => 'サーバーからの認証応答の解釈に失敗しました。',
	'securepoll-api-invalid-params' => '不正なパラメータ。',
	'securepoll-api-no-user' => '指定されたIDをもつ利用者が見つかりません。',
	'securepoll-api-token-mismatch' => 'セキュリティ・トークンが一致しないのでログインできません。',
	'securepoll-not-logged-in' => 'この投票に参加するためにはログインしていなければいけません',
	'securepoll-too-few-edits' => '申し訳ありませんが、あなたは投票できません。この投票に参加するためには少なくとも$1回の編集を行なっていなければなりません。現在の編集回数は$2です。',
	'securepoll-blocked' => '申し訳ありませんが、あなたは投稿ブロックを受けているためこの投票に参加できません。',
	'securepoll-not-in-group' => '$1グループに属する利用者のみがこの投票に参加できます。',
	'securepoll-not-in-list' => '申し訳ありませんが、あなたはあらかじめ決められた投票メンバーではないのでこの投票に参加できません。',
	'securepoll-list-title' => '票を一覧する: $1',
	'securepoll-header-timestamp' => '時刻',
	'securepoll-header-voter-name' => '名前',
	'securepoll-header-voter-domain' => 'ドメイン',
	'securepoll-header-ua' => 'ユーザーエージェント',
	'securepoll-header-strike' => '抹消',
	'securepoll-header-details' => '詳細',
	'securepoll-strike-button' => '抹消',
	'securepoll-unstrike-button' => '抹消撤回',
	'securepoll-strike-reason' => '理由:',
	'securepoll-strike-cancel' => 'キャンセル',
	'securepoll-strike-error' => '抹消あるいは抹消撤回の実行に失敗: $1',
	'securepoll-need-admin' => 'この操作を行うには管理者権限が必要です。',
	'securepoll-details-link' => '詳細',
	'securepoll-details-title' => '票の詳細: #$1',
	'securepoll-invalid-vote' => '"$1"は有効な票IDではありません',
	'securepoll-header-voter-type' => '投票者の種類',
	'securepoll-voter-properties' => '投票者情報',
	'securepoll-strike-log' => '抹消記録',
	'securepoll-header-action' => '操作',
	'securepoll-header-reason' => '理由',
	'securepoll-header-admin' => '管理者',
	'securepoll-dump-title' => 'ダンプ: $1',
	'securepoll-dump-no-crypt' => 'この選挙は暗号化を利用するように設定されていないため、暗号化された選挙記録は入手できません。',
	'securepoll-dump-not-finished' => '暗号化された選挙記録は終了日の$1 $2以降にのみ入手できます',
	'securepoll-dump-no-urandom' => '/dev/urandom を開けません。投票者のプライバシーを守るため、暗号化された選挙記録は暗号用乱数ストリームでシャッフルできる場合のみ公に入手できます。',
	'securepoll-translate-title' => '翻訳: $1',
	'securepoll-invalid-language' => '「$1」は無効な言語コードです',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '言語を選択:',
	'securepoll-submit-select-lang' => '翻訳',
	'securepoll-header-title' => '名前',
	'securepoll-header-start-date' => '開始日時',
	'securepoll-header-end-date' => '終了日時',
	'securepoll-subpage-vote' => '投票',
	'securepoll-subpage-translate' => '翻訳する',
	'securepoll-subpage-list' => '一覧',
	'securepoll-subpage-dump' => 'ダンプ',
);

/** Korean (한국어)
 * @author Kwj2772
 * @author Mhha
 * @author Yknok29
 */
$messages['ko'] = array(
	'securepoll' => '비밀 투표',
	'securepoll-desc' => '선거와 여론 조사를 위한 확장 기능',
	'securepoll-invalid-page' => '"<nowiki>$1</nowiki>" 하위 문서가 잘못되었습니다.',
	'securepoll-too-few-params' => '하위 문서 변수가 충분하지 않습니다 (잘못된 링크).',
	'securepoll-invalid-election' => '"$1"은 유효한 선거 ID가 아닙니다.',
	'securepoll-welcome' => '<strong>$1님, 환영합니다!</strong>',
	'securepoll-not-started' => '투표가 아직 시작되지 않았습니다.
투표는 $2 $3부터 시작될 예정입니다.',
	'securepoll-not-qualified' => '당신에게는 이번 선거에서 투표권이 부여되지 않았습니다: $1',
	'securepoll-change-disallowed' => '당신은 이미 투표하였습니다.
죄송하지만 다시 투표할 수 없습니다.',
	'securepoll-change-allowed' => '<strong>참고: 당신은 이전에 투표한 적이 있습니다.</strong>
당신은 아래 양식을 이용해 투표를 변경할 수 있습니다.
그렇게 할 경우 이전의 투표는 무효 처리될 것입니다.',
	'securepoll-submit' => '투표하기',
	'securepoll-gpg-receipt' => '투표해 주셔서 감사합니다.

당신이 원하신다면 당신의 투표에 대한 증거로 다음 투표증을 보관할 수 있습니다:

<pre>$1</pre>',
	'securepoll-thanks' => '감사합니다. 당신의 투표가 기록되었습니다.',
	'securepoll-return' => '$1로 돌아가기',
	'securepoll-encrypt-error' => '당신의 투표를 암호화하는 데 실패했습니다.
당신의 투표가 기록되지 않았습니다.

$1',
	'securepoll-no-gpg-home' => 'GPG 홈 디렉토리를 생성할 수 없습니다.',
	'securepoll-secret-gpg-error' => 'GPG를 실행하는 데 오류가 발생하였습니다.
자세한 정보를 보려면 LocalSettings.php에 $wgSecurePollShowErrorDetail=true; 를 사용하십시오.',
	'securepoll-full-gpg-error' => 'GPG를 실행하는 데 오류가 발생하였습니다.

명령: $1

오류:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG 키가 잘못 설정되었습니다.',
	'securepoll-gpg-parse-error' => 'GPG 출력을 해석하는 데 오류가 발생했습니다.',
	'securepoll-no-decryption-key' => '암호 해독 키가 설정되지 않았습니다.
암호를 해독할 수 없습니다.',
	'securepoll-jump' => '선거서버로 이동하기',
	'securepoll-remote-auth-error' => '귀하의 계정정보 오류를 서버와 동기화하기',
	'securepoll-remote-parse-error' => '서버로부터 권한응답에 따른 번역오류가 발생',
	'securepoll-api-invalid-params' => '잘못된 명령파라미터들입니다.',
	'securepoll-api-no-user' => '등록되어 있지 않은 ID 입니다.',
	'securepoll-api-token-mismatch' => '암호화 통신상의 오류가 발생하여 로그인 하지 못했습니다.',
	'securepoll-not-logged-in' => '이 선거에 투표를 하시려면 먼저 로그인 하셔야 합니다.',
	'securepoll-too-few-edits' => '죄송하지만, 투표에 참여하실 수 없습니다. 투표에 참여하시려면 최소 $1 회의 편집기여를 하셔야 하지만 귀하의 편집기여는 $2 회 입니다.',
	'securepoll-blocked' => '죄송하지만, 귀하의 계정은 차단당한 상태이므로 이 선거에 투표하실 수 없습니다.',
	'securepoll-not-in-group' => '이 선거에는 $1 모임에 속하는 회원만 투표하실 수 있습니다.',
	'securepoll-not-in-list' => '죄송하지만, 귀하는 이 선거에 투표하실 수 있는 선건인단명부에 등록되어 있지 않습니다.',
	'securepoll-list-title' => '투표 목록: $1',
	'securepoll-header-timestamp' => '기간',
	'securepoll-header-voter-name' => '이름',
	'securepoll-header-voter-domain' => '도메인',
	'securepoll-header-ua' => '사용자 선거 사무장',
	'securepoll-header-strike' => '결산',
	'securepoll-header-details' => '상세한 설명',
	'securepoll-strike-button' => '무효화',
	'securepoll-unstrike-button' => '무효화 해제',
	'securepoll-strike-reason' => '이유:',
	'securepoll-strike-cancel' => '취소',
	'securepoll-strike-error' => '무효화/해제 과정에서 오류가 발생하였습니다: $1',
	'securepoll-need-admin' => '이 행동을 하시려면 관리자 권한이 필요합니다.',
	'securepoll-details-link' => '상세한 설명',
	'securepoll-details-title' => '투표 설명: #$1',
	'securepoll-invalid-vote' => '"$1"은 투표할 수 있는 ID가 아닙니다.',
	'securepoll-header-voter-type' => '투표자 유형',
	'securepoll-voter-properties' => '투표자 특성',
	'securepoll-strike-log' => '무효화 기록',
	'securepoll-header-action' => '참여',
	'securepoll-header-reason' => '이유',
	'securepoll-header-admin' => '관리',
	'securepoll-dump-title' => '출력: $1',
	'securepoll-dump-no-crypt' => '이 선거에 대한 기록을 암호화할 수 없습니다. 왜냐하면 이 선거는 암호를 사용하도록 설정되어 있지 않기 때문입니다.',
	'securepoll-dump-not-finished' => '암호화된 선거 기록은 오직 마지막 기한인 $1 $2가 지난 뒤에야 이용하실 수 있습니다.',
	'securepoll-dump-no-urandom' => '/dev/urandom을 열 수 없습니다.
투표자의 사생활을 보호하기 위해서, 암호화된 선거 기록은 안전한 무작위 숫자 흐름으로 뒤섞일 수 있을 때 오직 공적으로 이용 가능합니다.',
	'securepoll-translate-title' => '번역: $1',
	'securepoll-invalid-language' => '"$1"은 인식되지 않는 언어 코드입니다.',
	'securepoll-submit-translate' => '갱신',
	'securepoll-language-label' => '선택한 언어:',
	'securepoll-submit-select-lang' => '번역',
	'securepoll-header-title' => '성명',
	'securepoll-header-start-date' => '시작일',
	'securepoll-header-end-date' => '종료일',
	'securepoll-subpage-vote' => '투표',
	'securepoll-subpage-translate' => '번역',
	'securepoll-subpage-list' => '리스트',
	'securepoll-subpage-dump' => '폐기',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'securepoll' => 'Sescher Afshtemme',
	'securepoll-desc' => 'E Zohsatz-Projramm för Wahle, Meinunge, un Afstemmunge.',
	'securepoll-invalid-page' => '„<nowiki>$1</nowiki>“ es en onjöltijje Ongersigg',
	'securepoll-too-few-params' => 'Dä Lengk es verkeht, et sin nit jenooch Parrameetere för Ongersigge do dren.',
	'securepoll-invalid-election' => '„$1“ es kein jöltije Kennung för en Afshtemmung',
	'securepoll-welcome' => '<strong>Hallo $1,</strong>',
	'securepoll-not-started' => 'Hee di Afshtemmung hät noch jaa nit aanjefange.
Et sull aam $2 aff $3 Uhr loß jonn.',
	'securepoll-not-qualified' => 'Do brengks nit alles met, wat nüdesch es, öm bei hee dä Afshtemmung met_ze_maache: $1',
	'securepoll-change-disallowed' => 'Do häs ald afjeshtemmpt.
Noch ens Afshtemme es nit müjjelesch.',
	'securepoll-change-allowed' => '<strong>Opjepaß: Do häs zo däm Teema ald afjeshtemmp.</strong>
Ding Shtemm kanns De ändere. Donn doför tat Fommullaa hee drunge namme. Wann De dat määs, weet Ding vörher afjejovve Shtemm fott jeschmeße.',
	'securepoll-submit' => 'De Shtemm afjävve',
	'securepoll-gpg-receipt' => 'Häs Dangk för et Afshtemme.

Wann De wells donn Der dat hee als en Quittung för Ding Shtemm faßhaale:

<pre>$1</pre>',
	'securepoll-thanks' => 'Mer donn uns bedangke. Ding Shtemm es faßjehallde.',
	'securepoll-return' => 'Jangk retuur noh $1',
	'securepoll-encrypt-error' => 'Kunnt Ding Shtemm nit verschlößele.
Ding Shtemm es nit jezallt, un weed nit faßjehallde!

$1',
	'securepoll-no-gpg-home' => 'Kann dat Verzeichnis för GPG nit aanlääje.',
	'securepoll-secret-gpg-error' => 'Ene Fähler es opjetrodde bem Ußföhre vun GPG.
Donn <code>$wgSecurePollShowErrorDetail=true;</code>
en <code>LocalSettings.php</code>
endraare, öm mieh Einzelheite ze sinn ze krijje.',
	'securepoll-full-gpg-error' => 'Ene Fähler es opjetrodde bem Ußföhre vun GPG:

Kommando: $1

Fähler:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'De Schlössel för GPG sen verkeeht enjeshtallt.',
	'securepoll-gpg-parse-error' => 'Ene Fähler es opjetrodde bemm Beärbeide vun dämm, wat GPG ußjejovve hät.',
	'securepoll-no-decryption-key' => 'Mer han keine Schlößel för et Äntschlößele, un et es och keine enjeshtallt. Alsu künne mer nix Äntschlößele.',
	'securepoll-jump' => 'Jangk op dä Server för de Afshtemmung',
	'securepoll-remote-auth-error' => 'Ene Fähler es opjetrodde, wi mer däm Server öm Ding Daate jefrooch hann.',
	'securepoll-remote-parse-error' => 'Ene Fähler es opjetrodde. Mer kunnte met däm Server singem Zoshtemmungs_Kood nix aanfange.',
	'securepoll-api-invalid-params' => 'Verkeehte Parrameeterre.',
	'securepoll-api-no-user' => 'Mer han keine Metmaacher jefonge jehatt met dä aanjejovve Kännong.',
	'securepoll-api-token-mismatch' => 'Dä Sesherheitß_Kood deiht nit paße, do kanns De Desch nit ennlogge.',
	'securepoll-not-logged-in' => 'Do moß Desch ald enlogge, för bei dää Afshtemmung metzemaache!',
	'securepoll-too-few-edits' => 'Schadt: Do kanns diß Mol nit affshtemme. En dämm Fall mööts De ald {{PLURAL:$1|einmol|$1 Mol|övverhou noch nie}} en Sigg em Wiki jeändert han, Do häß ävver {{PLURAL:$2|blooß eimol|blooß $2 Mol|övverhoup noch nie}} en Sigg em Wiki jeändert.',
	'securepoll-blocked' => 'Schahdt: Do kanns diß Mol nit affshtemme, weil jraadt för et Ändere aam Wiki jeshperrt beß.',
	'securepoll-not-in-group' => 'Schadt: Do kanns diß Mol nit affshtemme. Bloß de Metmaacher en dä {{NS:Category}} $1 künne hee en Shtemm afjevve!',
	'securepoll-not-in-list' => 'Schadt: Do kanns diß Mol nit affshtemme. De beß nit en de su jenannte Wähler_Leß met de Metmaacher, die hee afshtemme dörve.',
	'securepoll-list-title' => 'Shtemme Opleßte: $1',
	'securepoll-header-timestamp' => 'Zick',
	'securepoll-header-voter-name' => 'Name',
	'securepoll-header-voter-domain' => 'Domähn',
	'securepoll-header-ip' => '<code lang="en">IP</code>-Addreß',
	'securepoll-header-ua' => 'Däm Metmaacher singe Brauser',
	'securepoll-header-strike' => 'Ußshtrieshe?',
	'securepoll-header-details' => 'Einzelheite',
	'securepoll-strike-button' => 'Ußshtriische',
	'securepoll-unstrike-button' => 'nit mieh jeschtresche',
	'securepoll-strike-reason' => 'Aaanlaß o Jrund:',
	'securepoll-strike-cancel' => 'Ophüre!',
	'securepoll-strike-error' => 'Ene Fähler is opjetrodde beim Ußshtriishe odder widder zerök holle: $1',
	'securepoll-need-admin' => 'Do moß ene {{int:group-sysadmin-member}} sin, öm dat maache ze dörve.',
	'securepoll-details-link' => 'Einzelheite',
	'securepoll-details-title' => 'Einzelheite vun dä Shtemm met dä Kennong: „$1“',
	'securepoll-invalid-vote' => '„$1“ kein reschtijje Kännong för en Afshtemmung',
	'securepoll-header-id' => 'Kennong',
	'securepoll-header-voter-type' => 'Zoot Affshtemmer',
	'securepoll-voter-properties' => 'Dem Metmaacher sing Eijeschaffte för et Afshtemme',
	'securepoll-strike-log' => 'Logboch övver de ußjeshtersche un widder jehollte Shtemme en Afshtemmunge',
	'securepoll-header-action' => 'Akßjuhn',
	'securepoll-header-reason' => 'Woröm?',
	'securepoll-header-admin' => '{{int:group-sysop-member}}',
	'securepoll-dump-title' => 'Erus jeschmeße: $1',
	'securepoll-dump-no-crypt' => 'Mer han kei verschlößelte Daate för di Afshtemmung, di löüf nämmlesch der oohne, weil dat esu enjeshtallt es.',
	'securepoll-dump-not-finished' => 'Verschlößelte Opzeishnunge vun dä Afshtemmung sin eetz noh_m Engk aam $1 noh $2 Uhr ze han.',
	'securepoll-dump-no-urandom' => 'Mer künne <code>/dev/random</code> nit opmaache.
Öm dä Afshtemmer ze schötze, don mer verschlößelte Datesäz bloß dann ußjävve,
wann mer se met enem seschere, zohfällije Dateshtrom verwörfelle künne.',
	'securepoll-translate-title' => 'Övveräze: $1',
	'securepoll-invalid-language' => '„<code>$1</code>“ es enne onjöltijje Shprooche_Kood',
	'securepoll-header-trans-id' => 'Kennong',
	'securepoll-submit-translate' => 'Neu maache!',
	'securepoll-language-label' => 'Shprooch ußwähle:',
	'securepoll-submit-select-lang' => 'Övversätze!',
	'securepoll-header-title' => 'Name',
	'securepoll-header-start-date' => 'Aanfangsdattum',
	'securepoll-header-end-date' => 'Et Dattum vum Engk',
	'securepoll-subpage-vote' => 'Afshtemme',
	'securepoll-subpage-translate' => 'Övversezze',
	'securepoll-subpage-list' => 'Leß',
	'securepoll-subpage-dump' => 'Erus jeschmeße',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'securepoll' => 'Securiséiert Ëmfro',
	'securepoll-desc' => 'Erweiderung fir Walen an Ëmfroen',
	'securepoll-invalid-page' => 'Net-valabel Ënnersäit "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Net genuch Ënnersäite-Parameter (net valbele Link).',
	'securepoll-invalid-election' => '"$1" ass keng ID déi fir d\'Wale gëlteg ass.',
	'securepoll-welcome' => '<strong>Wëllkomm $1!</strong>',
	'securepoll-not-started' => 'Dës Walen hunn nach net ugefaang.
Si fänke viraussiichtlech den $2 ëm $3 un.',
	'securepoll-not-qualified' => 'Dir sidd net qualifizéiert fir bäi dëse Walen ofzestëmmen: $1',
	'securepoll-change-disallowed' => 'Dir hutt bäi dëse Walen virdru schonn ofgestëmmt.
Pardon, mee dir däerft net nach eng Kéier ofstëmmen.',
	'securepoll-submit' => 'Stëmm ofginn',
	'securepoll-gpg-receipt' => 'Merci datt Dir Iech un de Wale bedeelegt huet.

Wann Dir wëllt, kënnt Dir dës Confirmatioun vun Ärem Vote behalen:

<pre>$1</pre>',
	'securepoll-thanks' => 'Merci, Är Stëmm gouf gespäichert.',
	'securepoll-return' => 'Zréck op $1',
	'securepoll-encrypt-error' => 'Bei der Verschlëselung vun Ärer Stëmm ass a Feeler geschitt.
Är Stëmm gouf net gespäichert!

$1',
	'securepoll-gpg-parse-error' => 'Feeler beim Interpretéieren vum GPG-Ouput',
	'securepoll-no-decryption-key' => 'Et ass keen Ëntschlësungsschlëssel agestallt.
Ëntschlësselung onméiglech.',
	'securepoll-jump' => 'Op den Ofstëmmungs-Server goen',
	'securepoll-api-invalid-params' => 'Parameter déi net valabel sinn.',
	'securepoll-api-no-user' => 'Et gouf kee Benotzer mat der ID fonnt déi ugi war.',
	'securepoll-not-logged-in' => 'Dir musst Iech aloggen fir bäi dëse Walen ofstëmmen ze kënnen',
	'securepoll-too-few-edits' => 'Pardon, Dir däerft net ofstëmmen. Dir musst mindestens $1 Ännerunge gemaach hun, fir bäi dëse Walen ofstëmmen ze kënnen, Dir hutt der $2 gemaach.',
	'securepoll-blocked' => 'Pardon, Dir kënnt net bäi dëse Walen ofstëmmen wann dir elo fir Ännerunge gespaart sidd.',
	'securepoll-not-in-group' => 'Nëmme Membere vum Grupp $1 kënne bäi dëse Walen ofstëmmen.',
	'securepoll-not-in-list' => 'Pardon, awer Dir stitt op der Lëscht vun de Benotzer déi autoriséiert si fir bäi dëse Walen ofzestëmmen.',
	'securepoll-list-title' => 'Lëscht vun de Stëmmen: $1',
	'securepoll-header-timestamp' => 'Zäit',
	'securepoll-header-voter-name' => 'Numm',
	'securepoll-header-voter-domain' => 'Domaine',
	'securepoll-header-strike' => 'Duerchsträichen',
	'securepoll-header-details' => 'Detailer',
	'securepoll-strike-button' => 'Duerchsträichen',
	'securepoll-unstrike-button' => 'Duerchsträichen ewechhuelen',
	'securepoll-strike-reason' => 'Grond:',
	'securepoll-strike-cancel' => 'Ofbriechen',
	'securepoll-need-admin' => 'Dir musst Admnistrateur si fir dëst kënnen ze maachen.',
	'securepoll-details-link' => 'Detailer',
	'securepoll-details-title' => 'Detailer vun der Ofstëmmung: #$1',
	'securepoll-header-voter-type' => 'Typ vu Wieler',
	'securepoll-voter-properties' => 'Eegeschafte vum Wieler',
	'securepoll-header-action' => 'Aktioun',
	'securepoll-header-reason' => 'Grond',
	'securepoll-header-admin' => 'Administrateur',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-translate-title' => 'Iwwersetzen: $1',
	'securepoll-invalid-language' => 'Net valabele Sproochecode "$1"',
	'securepoll-submit-translate' => 'Aktualiséieren',
	'securepoll-language-label' => 'Sprooch eraussichen:',
	'securepoll-submit-select-lang' => 'Iwwersetzen',
	'securepoll-header-title' => 'Numm',
	'securepoll-header-start-date' => 'Ufanksdatum',
	'securepoll-header-end-date' => 'Schlussdatum',
	'securepoll-subpage-vote' => 'Stëmm',
	'securepoll-subpage-translate' => 'Iwwersetzen',
	'securepoll-subpage-list' => 'Lëscht',
);

/** Limburgish (Limburgs)
 * @author Ooswesthoesbes
 */
$messages['li'] = array(
	'securepoll' => 'VeiligSjtömme',
	'securepoll-desc' => 'Oetbreiding veur verkeziginge en vraogelieste',
	'securepoll-invalid-page' => 'Óngeljige subpaasj "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Óngenóg subpaasjparamaeters (óngeljige verwiezing).',
	'securepoll-invalid-election' => '"$1" is gein geljig verkezigingsnómmer.',
	'securepoll-welcome' => '<strong>Wèlkóm $1!</strong>',
	'securepoll-not-started' => 'Dees sjtömming is nag neet gesjtart.
De sjtömming vank op $1 aan.',
	'securepoll-not-qualified' => 'Doe bös neet bevoog óm te sjtömme in dees sjtömming: $1',
	'securepoll-change-disallowed' => 'Doe höbs al gesjtömp in dees sjtömming.
Doe moogs neet opnuuj sjtömme.',
	'securepoll-change-allowed' => "<strong>Opmèrking: Doe höbs al gesjtömp in dees sjtömming.</strong>
Doe kins dien sjtöm wiezige door 't óngersjtäönde formeleer op te sjlaon.
As se daoveur keus, wörd diene edere sjtöm verwiederd.",
	'securepoll-submit' => 'Sjlaon sjtöm op',
	'securepoll-gpg-receipt' => 'Danke veur diene sjtöm.

Doe kins de óngersjtäönde gegaeves beware as bewies van dien deilnaam aan dees sjtömming;

<pre>$1</pre>',
	'securepoll-thanks' => 'Danke, dien sjtöm is óntvange en opgesjlage.',
	'securepoll-return' => 'trök nao $1',
	'securepoll-encrypt-error' => "'t Codere van dien sjtöm is misluk.
Dien sjtöm is neet opgesjlage!

$1",
	'securepoll-no-gpg-home' => "'t Waas neet meugelik óm de thoesmap veur GPG aan te make.",
	'securepoll-secret-gpg-error' => "d'r Is 'n fout opgetraoje bie 't oetveure van GPG.
Gebroek \$wgSecurePollShowErrorDetail=true; in LocalSettings.php óm meer details waer te gaeve.",
	'securepoll-full-gpg-error' => "d'r Is 'n fout opgetraoje bie 't oetveure van GPG:

Beveel: $1

Fotmeljing:
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'De GPG-sjleutels zeen ónjuus ingesjteld.',
	'securepoll-gpg-parse-error' => "d'r Is 'n fout opgetraoje bie 't interpretere van GPG-oetveur.",
	'securepoll-no-decryption-key' => "d'r Is geine decryptiesjleutel ingesjteld.
Decodere is neet meugelik.",
	'securepoll-list-title' => 'Sóm sjtömme op: $1',
	'securepoll-header-timestamp' => 'Tied',
	'securepoll-header-voter-name' => 'Naom',
	'securepoll-header-voter-domain' => 'Domien',
	'securepoll-header-ua' => 'Gebroekeragent',
	'securepoll-header-strike' => 'Haol door',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Haol door',
	'securepoll-unstrike-button' => 'Haol neet door',
	'securepoll-strike-reason' => 'Raej:',
	'securepoll-strike-cancel' => 'Braek aaf',
	'securepoll-strike-error' => "Fout bie 't (neet) doorhaole: $1",
	'securepoll-need-admin' => "Doe mós 'ne beheerder zeen óm dees hanjeling te moge oetveure.",
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Sjtömdetails: #$1',
	'securepoll-invalid-vote' => '"$1" is gein geljig sjtömnómmer',
	'securepoll-header-voter-type' => 'Gebroekerstype',
	'securepoll-voter-properties' => 'Sjtömbeneudighede',
	'securepoll-strike-log' => 'Doorhaolingslogbook',
	'securepoll-header-action' => 'Hanjeling',
	'securepoll-header-reason' => 'Raej',
	'securepoll-header-admin' => 'Beheer',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-translate-title' => 'Vertaol: $1',
	'securepoll-invalid-language' => 'Óngeljige taolcode "$1"',
	'securepoll-submit-translate' => 'Wèrk bie',
	'securepoll-language-label' => 'Selecteer taol:',
	'securepoll-submit-select-lang' => 'Vertaol',
);

/** Macedonian (Македонски)
 * @author Brest
 */
$messages['mk'] = array(
	'securepoll-header-timestamp' => 'Време',
	'securepoll-header-voter-name' => 'Име',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-language-label' => 'Избери јазик:',
);

/** Malay (Bahasa Melayu)
 * @author Aurora
 */
$messages['ms'] = array(
	'securepoll-desc' => 'Sambungan untuk pemilihan dan tinjauan',
	'securepoll-invalid-page' => 'Sublaman tidak sah "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Parameter sublaman tidak cukup (pautan tidak sah).',
	'securepoll-invalid-election' => '"$1" bukan merupakan ID pemilihan yang sah.',
	'securepoll-welcome' => '<strong>Selamat datang $1!</strong>',
	'securepoll-not-started' => 'Pemilihan ini belum lagi bermula.
Ia dijadualkan bermula pada $1.',
	'securepoll-not-qualified' => 'Anda tidak layak mengundi di dalam pemilihan ini: $1',
	'securepoll-change-disallowed' => 'Anda telah mengundi di dalam pemilihan ini sebelum ini.
Maaf, anda tidak boleh mengundi sekali lagi.',
	'securepoll-change-allowed' => '<strong>Nota: Anda telah mengundi di dalam pemilihan ini sebelum ini.</strong>
Anda boleh menukar undi anda dengan menyerahkan borang di bawah.
Perhatikan bahawa jika anda berbuat demikian, undi asal anda akan dimansuhkan.',
	'securepoll-submit' => 'Serah undian',
	'securepoll-gpg-receipt' => 'Terima kasih kerana mengundi.

Jika anda mahu, anda boleh menyimpan resit yang berikut sebagai bukti undian anda:

<pre>$1</pre>',
	'securepoll-thanks' => 'Terima kasih, undi anda telah direkodkan.',
	'securepoll-return' => 'Kembali ke $1',
	'securepoll-encrypt-error' => 'Gagal menyulitkan rekod undian anda.
Undi anda tidak direkodkan!

$1',
	'securepoll-no-gpg-home' => 'Tidak dapat mencipta direktori rumah GPG.',
	'securepoll-secret-gpg-error' => 'Ralat melakukan GPG.
Gunakan $wgSecurePollShowErrorDetail=true; dalam LocalSettings.php untuk menunjukkan butiran lebih.',
	'securepoll-full-gpg-error' => 'Ralat melakukan GPG:

Arahan: $1

Ralat:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Kunci GPG tidak dibentuk dengan betul.',
	'securepoll-gpg-parse-error' => 'Ralat mentafsirkan output GPG.',
	'securepoll-no-decryption-key' => 'Tiada kunci penyahsulitan dibentuk.
Tidak dapat menyahsulit.',
	'securepoll-jump' => 'Pergi ke pelayan undian',
	'securepoll-remote-auth-error' => 'Ralat dalam mengambil maklumat akaun anda dari pelayan.',
	'securepoll-remote-parse-error' => 'Ralat menafsirkan jawapan kebenaran dari pelayan.',
	'securepoll-api-invalid-params' => 'Parameter tidak sah.',
	'securepoll-api-no-user' => 'Tiada pengguna dengan ID yang diberi dijumpai.',
	'securepoll-api-token-mismatch' => 'Token keselamatan tidak serasi, tidak dapat log masuk.',
	'securepoll-not-logged-in' => 'Anda mesti log masuk untuk mengundi dalam pemilihan ini',
);

/** Low German (Plattdüütsch)
 * @author Slomox
 */
$messages['nds'] = array(
	'securepoll' => 'SekerAfstimmen',
	'securepoll-desc' => 'Extension för Wahlen un Ümfragen',
	'securepoll-invalid-page' => 'Ungüllige Ünnersied „<nowiki>$1</nowiki>“',
	'securepoll-invalid-election' => '„$1“ is keen güllige Wahl-ID.',
	'securepoll-not-authorised' => 'Du dröffst bi disse Wahl nich mit afstimmen.',
	'securepoll-welcome' => '<strong>Willkamen $1!</strong>',
	'securepoll-not-qualified' => 'Du dröffst bi disse Wahl nich mit afstimmen: $1',
	'securepoll-submit' => 'Stimm afgeven',
	'securepoll-thanks' => 'Wees bedankt, dien Stimm is optekent.',
	'securepoll-return' => 'Trüch na $1',
);

/** Dutch (Nederlands)
 * @author Mwpnl
 * @author Siebrand
 */
$messages['nl'] = array(
	'securepoll' => 'VeiligStemmen',
	'securepoll-desc' => 'Uitbreiding voor stemmingen en enquêtes',
	'securepoll-invalid-page' => 'Ongeldige subpagina "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Onvoldoende subpaginaparameters (ongeldige verwijzing).',
	'securepoll-invalid-election' => '"$1" is geen geldig stemmingsnummer.',
	'securepoll-welcome' => '<strong>Welkom $1!</strong>',
	'securepoll-not-started' => 'Deze stemming is nog niet gestart.
De stemming begint op $2 om $3.',
	'securepoll-not-qualified' => 'U bent niet bevoegd om te stemmen in deze stemming: $1',
	'securepoll-change-disallowed' => 'U hebt al gestemd in deze stemming.
U mag niet opnieuw stemmen.',
	'securepoll-change-allowed' => '<strong>Opmerking: U hebt al gestemd in deze stemming.</strong>
U kunt uw stem wijzigigen door het onderstaande formulier op te slaan.
Als u daarvoor kiest, wordt uw eerdere stem verwijderd.',
	'securepoll-submit' => 'Stem opslaan',
	'securepoll-gpg-receipt' => 'Dank u voor uw stem.

U kunt de onderstaande gegevens bewaren als bewijs van uw deelname aan deze stemming:

<pre>$1</pre>',
	'securepoll-thanks' => 'Dank u wel. Uw stem is ontvangen en opgeslagen.',
	'securepoll-return' => 'terug naar $1',
	'securepoll-encrypt-error' => 'Het coderen van uw stem is mislukt.
Uw stem is niet opgeslagen!

$1',
	'securepoll-no-gpg-home' => 'Het was niet mogelijk om de thuismap voor GPG aan te maken.',
	'securepoll-secret-gpg-error' => 'Er is een fout opgetreden bij het uitvoeren van GPG.
Gebruik $wgSecurePollShowErrorDetail=true; in LocalSettings.php om meer details weer te geven.',
	'securepoll-full-gpg-error' => 'Er is een fout opgetreden bij het uitvoeren van GPG:

Commando: $1

Foutmelding:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'De GPG-sleutels zijn onjuist ingesteld.',
	'securepoll-gpg-parse-error' => 'Er is een fout opgetreden bij het interpreteren van GPG-uitvoer.',
	'securepoll-no-decryption-key' => 'Er is geen decryptiesleutel ingesteld.
Decoderen is niet mogelijk.',
	'securepoll-list-title' => 'Stemmen weergeven: $1',
	'securepoll-header-timestamp' => 'Tijd',
	'securepoll-header-voter-name' => 'Naam',
	'securepoll-header-voter-domain' => 'Domein',
	'securepoll-header-ua' => 'User-agent',
	'securepoll-header-strike' => 'Doorhalen',
	'securepoll-header-details' => 'Details',
	'securepoll-strike-button' => 'Doorhalen',
	'securepoll-unstrike-button' => 'Doorhalen ongedaan maken',
	'securepoll-strike-reason' => 'Reden:',
	'securepoll-strike-cancel' => 'Annuleren',
	'securepoll-strike-error' => 'Er is een fout opgetreden bij het uitvoeren doorhalen/doorhalen ongedaan maken: $1',
	'securepoll-need-admin' => 'U moet een beheerder zijn om deze handeling te mogen uitvoeren.',
	'securepoll-details-link' => 'Details',
	'securepoll-details-title' => 'Stemdetails: #$1',
	'securepoll-invalid-vote' => '"$1" is geen geldig stemnummer',
	'securepoll-header-voter-type' => 'Gebruikerstype',
	'securepoll-voter-properties' => 'Kiezerseigenschappen',
	'securepoll-strike-log' => 'Logboek stemmen doorhalen',
	'securepoll-header-action' => 'Handeling',
	'securepoll-header-reason' => 'Reden',
	'securepoll-header-admin' => 'Beheer',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Er is geen versleutelde stemmingsinformatie beschikbaar voor deze stemming, want de stemming is niet ingesteld voor het gebruik van versleuteling.',
	'securepoll-dump-not-finished' => 'De versleutelde stemgegevens zijn pas beschikbaar na het eindigen van de stemming op $1 om $2',
	'securepoll-dump-no-urandom' => 'Het was niet mogelijk om /dev/urandom te openen.
Om de privacy van de stemmers te beschermen, zijn de stemmingsgegevens pas beschikbaar als ze willekeurig gesorteerd kunnen worden met behulp van een willekeurige nummerreeks.',
	'securepoll-translate-title' => 'Vertalen: $1',
	'securepoll-invalid-language' => 'Ongeldige taalcode "$1"',
	'securepoll-submit-translate' => 'Bijwerken',
	'securepoll-language-label' => 'Taal selecteren:',
	'securepoll-submit-select-lang' => 'Vertalen',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Eirik
 * @author Gunnernett
 * @author Harald Khan
 */
$messages['nn'] = array(
	'securepoll-desc' => 'Ei utviding for val og undersøkingar',
	'securepoll-invalid-page' => 'Ugyldig underside «<nowiki>$1</nowiki>»',
	'securepoll-too-few-params' => 'Ikkje nok undersideparametrar (ugyldig lenkje)',
	'securepoll-invalid-election' => '«$1» er ikkje ein gyldig val-ID.',
	'securepoll-welcome' => '<strong>Velkomen, $1!</strong>',
	'securepoll-not-started' => 'Dette valet har ikkje starta enno.
Det gjer det etter planen på $2 ved $3.',
	'securepoll-not-qualified' => 'Du er ikkje kvalifisert til å røysta i dette valet: $1',
	'securepoll-change-disallowed' => 'Du har alt røysta i dette valet og kan ikkje røysta på nytt.',
	'securepoll-change-allowed' => '<strong>Merk: Du har alt røysta i dette valet.</strong>
Du kan endra røysta di gjennom å senda inn skjemaet under.
Merk at om du gjer dette, vil den opphavlege røysta di verta sletta.',
	'securepoll-submit' => 'Røyst',
	'securepoll-gpg-receipt' => 'Takk for at du gav røysta di.

Om du ynskjer det, kan du ta vare på den fylgjande kvitteringa som eit prov på røysta di:

<pre>$1</pre>',
	'securepoll-thanks' => 'Takk, røysta di er vorten registrert.',
	'securepoll-return' => 'Attende til $1',
	'securepoll-encrypt-error' => 'Klarte ikkje kryptera røysta di.
Ho har ikkje vorte registrert!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikkje oppretta heimekatalog for GPG',
	'securepoll-secret-gpg-error' => 'Feil ved køyring av GPG.
Bruk $wgSecurePollShowErrorDetail=true; i LocalSettings.php for å sjå fleire detaljar.',
	'securepoll-full-gpg-error' => 'Feil ved køyring av GPG:

Kommando: $1

Feil:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøklane er ikkje sette opp rett.',
	'securepoll-gpg-parse-error' => 'Feil ved tolking av utdata frå GPG.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnøkkel er sett opp.
Kan ikkje dekryptera.',
	'securepoll-not-in-group' => 'Berre brukarar som er med i gruppa $1 kan røysta i denne avrøystinga.',
	'securepoll-not-in-list' => 'Du er diverre ikkje på lista over brukarar som har løyve til å røysta i denne avrøystinga.',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-domain' => 'Domene',
	'securepoll-header-details' => 'Opplysingar',
	'securepoll-strike-reason' => 'Grunngjeving:',
	'securepoll-need-admin' => 'Du må vera ein administrator, for å utføra denne handlinga.',
	'securepoll-header-action' => 'Handling',
	'securepoll-header-reason' => 'Grunn',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-translate-title' => 'Set om: $1',
	'securepoll-invalid-language' => 'Ugyldig språkode "$1"',
	'securepoll-submit-translate' => 'Oppdatér',
	'securepoll-language-label' => 'Vél språk',
	'securepoll-submit-select-lang' => 'Set om',
	'securepoll-header-title' => 'Namn',
	'securepoll-header-start-date' => 'Start dato',
	'securepoll-header-end-date' => 'Sluttdato',
	'securepoll-subpage-list' => 'Utslisting',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Finnrind
 * @author Stigmj
 */
$messages['no'] = array(
	'securepoll' => 'SikkertValg',
	'securepoll-desc' => 'En utvidelse for valg og undersøkelser',
	'securepoll-invalid-page' => 'Ugyldig underside «<nowiki>$1</nowiki>»',
	'securepoll-too-few-params' => 'Ikke mange nok undersideparametre (ugyldig lenke).',
	'securepoll-invalid-election' => '"$1" er ikke en gyldig valg-id.',
	'securepoll-welcome' => '<strong>Velkommen $1!</strong>',
	'securepoll-not-started' => 'Dette valget har enda ikke startet.
Det starter etter planen $1.',
	'securepoll-not-qualified' => 'Du er ikke kvalifisert til å stemme i dette valget: $1',
	'securepoll-change-disallowed' => 'Du har allerede stemt i dette valget.
Du kan desverre ikke stemme på nytt.',
	'securepoll-change-allowed' => '<strong>Bemerk: Du har allerede stemt i dette valget.</strong>
Du kan endre stemmen din ved å sende inn skjemaet nedenfor.
Bemerk at dersom du gjør dette vil den opprinnelige stemmen din bli forkastet.',
	'securepoll-submit' => 'Avgi stemme',
	'securepoll-gpg-receipt' => 'Takk for at du avga stemme.

Dersom du ønsker det kan du ta vare på følgende kvittering som bevis på din stemme:

<pre>$1</pre>',
	'securepoll-thanks' => 'Takk, stemmen din har blitt registrert.',
	'securepoll-return' => 'Tilbake til $1',
	'securepoll-encrypt-error' => 'Klarte ikke å kryptere din stemme.
Stemmen har ikke blitt registrert!

$1',
	'securepoll-no-gpg-home' => 'Kunne ikke opprette hjemmekatalog for GPG',
	'securepoll-secret-gpg-error' => 'Feil ved kjøring av GPG.
bruk $wgSecurePollShowErrorDetail=true; i LocalSettings.php for å se flere detaljer.',
	'securepoll-full-gpg-error' => 'Feil under kjøring av GPG:

Kommando: $1

Feil:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nøklene er ikke satt opp riktig.',
	'securepoll-gpg-parse-error' => 'Feil under tolking av utdata fra GPG.',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'securepoll' => 'Sondatge securizat',
	'securepoll-desc' => "Extension per d'eleccions e de sondatges",
	'securepoll-invalid-page' => 'Sospagina « <nowiki>$1</nowiki> » invalida',
	'securepoll-too-few-params' => 'Pas pro de paramètres de sospagina (ligam invalid).',
	'securepoll-invalid-election' => "« $1 » es pas un identificant d'eleccion valid.",
	'securepoll-welcome' => '<strong>Benvenguda $1 !</strong>',
	'securepoll-not-started' => "L'eleccion a pas encara començat.
Lo començament es programat pel $1 a $3.",
	'securepoll-not-qualified' => 'Sètz pas qualificat(ada) per votar dins aquesta eleccion : $1',
	'securepoll-change-disallowed' => 'Ja avètz votat per aquesta eleccion.
O planhèm, podètz pas votar tornamai.',
	'securepoll-change-allowed' => '<strong>Nòta : Ja avètz votat per aquesta eleccion.</strong>
Podètz cambiar vòstre vòte en sometent lo formulari çaijós.
Se fasètz aquò, vòstre vòte ancian serà anullat.',
	'securepoll-submit' => 'Sometre lo vòte',
	'securepoll-gpg-receipt' => "Mercés per vòstre vòte.

S'o desiratz, podètz gardar aquò coma pròva de vòstre vòte :

<pre>$1</pre>",
	'securepoll-thanks' => 'Mercés, vòstre vòte es estat enregistrat.',
	'securepoll-return' => 'Tornar a $1',
	'securepoll-encrypt-error' => 'Lo criptatge de vòstre vòte a fracassat.
Vòstre vòte es pas estat enregistrat !

$1',
	'securepoll-no-gpg-home' => 'Impossible de crear lo dorsièr de basa de GPG.',
	'securepoll-secret-gpg-error' => 'Error al moment de l\'execucion de GPG.
Apondètz $wgSecurePollShowErrorDetail=true; a LocalSettings.php per afichar mai de detalhs.',
	'securepoll-full-gpg-error' => "Error al moment de l'execucion de GPG :

Comanda : $1

Error :
<pre>$2</pre>",
	'securepoll-gpg-config-error' => 'Las claus de GPG son pas configuradas corrèctament.',
	'securepoll-gpg-parse-error' => "Error al moment de l'interpretacion de la sortida de GPG.",
	'securepoll-no-decryption-key' => 'Cap de clau de descriptatge es pas estada configurada.
Impossible de descriptar.',
	'securepoll-list-title' => 'Lista dels vòtes : $1',
	'securepoll-header-timestamp' => 'Ora',
	'securepoll-header-voter-name' => 'Nom',
	'securepoll-header-voter-domain' => 'Domeni',
	'securepoll-header-ua' => "Agent d'utilizaire",
	'securepoll-header-strike' => 'Raiar',
	'securepoll-header-details' => 'Detalhs',
	'securepoll-strike-button' => 'Raiar',
	'securepoll-unstrike-button' => 'Desraiar',
	'securepoll-strike-reason' => 'Rason :',
	'securepoll-strike-cancel' => 'Anullar',
	'securepoll-strike-error' => 'Error al moment del (des)raiatge : $1',
	'securepoll-need-admin' => 'Vos cal èsser un administrator per executar aquesta accion.',
	'securepoll-details-link' => 'Detalhs',
	'securepoll-details-title' => 'Detalhs del vòte : #$1',
	'securepoll-invalid-vote' => '« $1 » es pas un ID de vòte valid',
	'securepoll-header-voter-type' => "Tipe de l'utilizaire",
	'securepoll-voter-properties' => 'Proprietats del votant',
	'securepoll-strike-log' => 'Jornal dels raiatges',
	'securepoll-header-action' => 'Accion',
	'securepoll-header-reason' => 'Rason',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-dump-title' => 'Extrach : $1',
	'securepoll-dump-no-crypt' => 'Las donadas chifradas son pas disponiblas per aquesta eleccion, perque l’eleccion es pas configurada per utilizar un chiframent.',
	'securepoll-dump-not-finished' => "Las donadas criptadas son disponiblas soalment aprèp la clausura de l'eleccion : $1",
	'securepoll-dump-no-urandom' => 'Impossible de dobrir /dev/urandom.
Per manténer la confidencialitat dels votants, las donadas criptadas son disponiblas sonque se pòdon èsser reboladas amb un nombre de caractèrs aleatòris.',
	'securepoll-translate-title' => 'Traduire : $1',
	'securepoll-invalid-language' => 'Còde de lenga « $1 » invalid.',
	'securepoll-submit-translate' => 'Metre a jorn',
	'securepoll-language-label' => 'Seleccionar la lenga :',
	'securepoll-submit-select-lang' => 'Traduire',
);

/** Polish (Polski)
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'securepoll' => 'Głosowanie',
	'securepoll-desc' => 'Rozszerzenie do realizacji wyborów oraz sondaży',
	'securepoll-invalid-page' => 'Nieprawidłowa podstrona „<nowiki>$1</nowiki>”',
	'securepoll-too-few-params' => 'Niewystarczające parametry podstrony (nieprawidłowy link).',
	'securepoll-invalid-election' => '„$1” nie jest prawidłowym identyfikatorem głosowania.',
	'securepoll-welcome' => '<strong>Witamy Cię $1!</strong>',
	'securepoll-not-started' => 'Wybory jeszcze się nie rozpoczęły.
Planowane rozpoczęcie $2 o $1.',
	'securepoll-not-qualified' => 'Nie jesteś upoważniony do głosowania w wyborach $1',
	'securepoll-change-disallowed' => 'W tych wyborach już głosowałeś.
Nie możesz ponownie zagłosować.',
	'securepoll-change-allowed' => '<strong>Uwaga – głosowałeś już w tych wyborach.</strong>
Możesz zmienić swój głos poprzez zapisanie poniższego formularza.
Jeśli to zrobisz, Twój oryginalny głos zostanie anulowany.',
	'securepoll-submit' => 'Zapisz głos',
	'securepoll-gpg-receipt' => 'Dziękujemy za oddanie głosu.

Jeśli chcesz, możesz zachować poniższe pokwitowanie jako dowód.

<pre>$1</pre>',
	'securepoll-thanks' => 'Twój głos został zarejestrowany.',
	'securepoll-return' => 'Wróć do $1',
	'securepoll-encrypt-error' => 'Nie można zaszyfrować rekordu głosowania.
Twój głos nie został zarejestrowany! 

$1',
	'securepoll-no-gpg-home' => 'Nie można utworzyć katalogu domowego GPG.',
	'securepoll-secret-gpg-error' => 'Błąd podczas uruchamiania GPG.
Ustaw $wgSecurePollShowErrorDetail=true; w LocalSettings.php aby zobaczyć szczegóły.',
	'securepoll-full-gpg-error' => 'Błąd podczas uruchamiania GPG:

Polecenie – $1

Błąd:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Klucze GPG zostały nieprawidłowo skonfigurowane.',
	'securepoll-gpg-parse-error' => 'Błąd interpretacji wyników GPG.',
	'securepoll-no-decryption-key' => 'Klucz odszyfrowujący nie został skonfigurowany.
Odszyfrowanie nie jest możliwe.',
	'securepoll-jump' => 'Przejdź do serwera obsługującego głosowanie',
	'securepoll-remote-auth-error' => 'Wystąpił błąd podczas pobierania informacji z serwera o Twoim koncie.',
	'securepoll-remote-parse-error' => 'Wystąpił błąd interpretacji odpowiedzi autoryzującej z serwera.',
	'securepoll-api-invalid-params' => 'Nieprawidłowe parametry.',
	'securepoll-api-no-user' => 'Nie znaleziono użytkownika o podanym ID.',
	'securepoll-api-token-mismatch' => 'Niepwawidłowy żeton bezpieczeństwa, nie można się zalogować.',
	'securepoll-not-logged-in' => 'Musisz się zalogować, aby głosować w tych wyborach',
	'securepoll-too-few-edits' => 'Niestety, nie możesz głosować. Musisz mieć przynajmniej $1 {{PLURAL:$1|edycję|edycje|edycji}} aby głosować w tych wyborach, wykonane $2.',
	'securepoll-blocked' => 'Niestety, nie możesz głosować w tych wyborach, ponieważ masz zablokowaną możliwość edytowania.',
	'securepoll-not-in-group' => 'Tylko członkowie grupy $1 mogą głosować w tych wyborach.',
	'securepoll-not-in-list' => 'Niestety nie ma Cię na wstępnie przygotowanej liście użytkowników uprawnionych do głosowania w tych wyborach.',
	'securepoll-list-title' => 'Lista głosów – $1',
	'securepoll-header-timestamp' => 'Czas',
	'securepoll-header-voter-name' => 'Nazwa',
	'securepoll-header-voter-domain' => 'Domena',
	'securepoll-header-ua' => 'Aplikacja klienta',
	'securepoll-header-strike' => 'Skreślony',
	'securepoll-header-details' => 'Szczegóły',
	'securepoll-strike-button' => 'Skreśl',
	'securepoll-unstrike-button' => 'Usuń skreślenie',
	'securepoll-strike-reason' => 'Powód',
	'securepoll-strike-cancel' => 'Zrezygnuj',
	'securepoll-strike-error' => 'Błąd podczas skreślania lub usuwania skreślenia – $1',
	'securepoll-need-admin' => 'Musisz być administratorem, aby wykonać tę operację.',
	'securepoll-details-link' => 'Szczegóły',
	'securepoll-details-title' => 'Szczegóły głosu nr $1',
	'securepoll-invalid-vote' => '„$1” nie jest poprawnym identyfikatorem głosu',
	'securepoll-header-voter-type' => 'Typ wyborcy',
	'securepoll-voter-properties' => 'Dane wyborcy',
	'securepoll-strike-log' => 'Rejestr skreślania',
	'securepoll-header-action' => 'Czynność',
	'securepoll-header-reason' => 'Powód',
	'securepoll-header-admin' => 'Administrator',
	'securepoll-dump-title' => 'Zrzut $1',
	'securepoll-dump-no-crypt' => 'Brak zaszyfrowanego rekordu głosu w tych wyborach ponieważ wybory nie zostały skonfigurowane do wykorzystywania szyfrowania.',
	'securepoll-dump-not-finished' => 'Zaszyfrowane rekordy głosów dostępne będą dopiero po zakończeniu wyborów $1 o $2',
	'securepoll-dump-no-urandom' => 'Nie można otworzyć /dev/urandom. 
Dla zapewnienia wyborcom poufności, zaszyfrowane rekordy głosów są publicznie dostępne wyłącznie wymieszane z danymi losowymi.',
	'securepoll-translate-title' => 'Tłumaczenie $1',
	'securepoll-invalid-language' => 'Nieprawidłowy kod języka „$1”',
	'securepoll-submit-translate' => 'Uaktualnij',
	'securepoll-language-label' => 'Wybierz język',
	'securepoll-submit-select-lang' => 'Przetłumacz',
	'securepoll-header-title' => 'Nazwa',
	'securepoll-header-start-date' => 'Data rozpoczęcia',
	'securepoll-header-end-date' => 'Data zakończenia',
	'securepoll-subpage-vote' => 'Głos',
	'securepoll-subpage-translate' => 'Tłumacz',
	'securepoll-subpage-list' => 'Wykaz',
	'securepoll-subpage-dump' => 'Zrzut',
);

/** Portuguese (Português)
 * @author Malafaya
 * @author Waldir
 */
$messages['pt'] = array(
	'securepoll' => 'Sondagem Segura',
	'securepoll-desc' => 'Extensão para eleições e sondagens',
	'securepoll-invalid-page' => 'Subpágina inválida: "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Parâmetros de subpágina insuficientes (ligação inválida).',
	'securepoll-invalid-election' => '"$1" não é um identificador de eleição válido.',
	'securepoll-welcome' => '<strong>Bem-vindo $1!</strong>',
	'securepoll-not-started' => 'Esta eleição ainda não se iniciou.
Está programada para começar em $1.',
	'securepoll-not-qualified' => 'Você não está qualificado a votar nesta eleição: $1',
	'securepoll-change-disallowed' => 'Você já votou nesta eleição antes.
Desculpe, você não pode votar novamente.',
	'securepoll-change-allowed' => '<strong>Nota: Você já votou nesta eleição antes.</strong>
Você pode mudar o seu voto, enviando o formulário abaixo.
Note que se você fizer isso, o seu voto original será removido.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Obrigado pelo seu voto.

Se desejar, você pode guardar o seguinte recibo como prova do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Obrigado, o seu voto foi registado.',
	'securepoll-return' => 'Voltar para $1',
	'securepoll-encrypt-error' => 'Falha ao codificar o registo do seu voto.
O seu voto não foi registado!

$1',
	'securepoll-no-gpg-home' => 'Não foi possível criar diretório GPG de base.',
	'securepoll-secret-gpg-error' => 'Erro ao executar GPG.
Use $wgSecurePollShowErrorDetail=true; em LocalSettings.php para mostrar mais detalhes.',
	'securepoll-full-gpg-error' => 'Erro ao executar GPG:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GPG estão mal configuradas.',
	'securepoll-gpg-parse-error' => 'Erro ao interpretar a saída GPG.',
	'securepoll-no-decryption-key' => 'Nenhuma chave de descodificação está configurada.
Não é possível descodificar.',
	'securepoll-list-title' => 'Listar votos: $1',
	'securepoll-header-timestamp' => 'Hora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Domínio',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-header-voter-type' => 'Tipo de utilizador',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-submit-select-lang' => 'Traduzir',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Eduardo.mps
 */
$messages['pt-br'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Extensão para eleições e pesquisas',
	'securepoll-invalid-page' => 'Subpágina inválida "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Sem parâmetros de subpágina suficientes (ligação inválida).',
	'securepoll-invalid-election' => '"$1" não é um ID de eleição válido.',
	'securepoll-welcome' => '<strong>Bem vindo(a) $1!</strong>',
	'securepoll-not-started' => 'Esta eleição ainda não começou.
Ela está programada para se iniciar às $1.',
	'securepoll-not-qualified' => 'Você não está qualificado(a) para votar nesta eleição: $1',
	'securepoll-change-disallowed' => 'Você já votou nesta eleição previamente.
Desculpe, mas você não pode votar novamente.',
	'securepoll-change-allowed' => '<strong>Nota: Você já votou nesta eleição anteriormente.</strong>
Você pode mudar seu voto enviando o formulário abaixo.
Note que se fizer isso, seu voto original será descartado.',
	'securepoll-submit' => 'Enviar voto',
	'securepoll-gpg-receipt' => 'Obrigado por votar.

Se desejar, você pode ter o seguinte recibo como evidência do seu voto:

<pre>$1</pre>',
	'securepoll-thanks' => 'Obrigado, seu voto foi registrado.',
	'securepoll-return' => 'Retornar a $1',
	'securepoll-encrypt-error' => 'Falha ao criptografar seu registro de voto.
Seu voto não foi registrado!

$1',
	'securepoll-no-gpg-home' => 'Não foi possível criar o diretório raiz do GPG',
	'securepoll-secret-gpg-error' => 'Erro ao executar o GPG.
Utilize $wgSecurePollShowErrorDetail=true; no LocalSettings.php para exibir mais detalhes.',
	'securepoll-full-gpg-error' => 'Erro ao executar GPG:

Comando: $1

Erro:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'As chaves GPG estão configuradas incorretamente.',
	'securepoll-gpg-parse-error' => 'Erro ao interpretar os dados de saída do GPG.',
	'securepoll-no-decryption-key' => 'Nenhuma chave de descriptografia está configurada.
Não foi possível descriptografar.',
	'securepoll-list-title' => 'Lista de votos: $1',
	'securepoll-header-timestamp' => 'Data',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Domínio',
	'securepoll-header-ua' => 'Agente utilizador',
	'securepoll-header-strike' => 'Riscados',
	'securepoll-header-details' => 'Detalhes',
	'securepoll-strike-button' => 'Riscar',
	'securepoll-unstrike-button' => 'Remover risco',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Cancelar',
	'securepoll-strike-error' => 'Erro ao riscar/remover risco: $1',
	'securepoll-need-admin' => 'Você precisa ser um administrador para realizar esta ação',
	'securepoll-details-link' => 'Detalhes',
	'securepoll-details-title' => 'Detalhes do voto: #$1',
	'securepoll-invalid-vote' => '"$1" não é um ID de voto válido',
	'securepoll-header-voter-type' => 'Tipo de utilizador',
	'securepoll-voter-properties' => 'Propriedades do votante',
	'securepoll-strike-log' => 'Registro de riscados',
	'securepoll-header-action' => 'Ação',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Administrador',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => 'Nenhum registro criptografado de eleição está disponível para esta eleição, porque a eleição não está configurada para usar criptografia.',
	'securepoll-dump-not-finished' => 'Registros criptografados da eleição estarão disponíveis apenas após a data de encerramento: $1',
	'securepoll-dump-no-urandom' => 'Não foi possível abrir /dev/urandom.
Para mantes a privacidade do eleitor, os registros criptografados da eleição são disponibilizados publicamente quando eles podem ser embaralhados com uma sequência segura de números aleatórios.',
	'securepoll-translate-title' => 'Traduzir: $1',
	'securepoll-invalid-language' => 'Código de língua "$1" inválido',
	'securepoll-submit-translate' => 'Atualizar',
	'securepoll-language-label' => 'Selecionar língua:',
	'securepoll-submit-select-lang' => 'Traduzir',
);

/** Russian (Русский)
 * @author HalanTul
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'securepoll' => 'БезопасноеГолосование',
	'securepoll-desc' => 'Расширение для проведения выборов и опросов',
	'securepoll-invalid-page' => 'Ошибочная подстраница «<nowiki>$1</nowiki>»',
	'securepoll-too-few-params' => 'Не хватает параметров подстраницы (ошибочная ссылка).',
	'securepoll-invalid-election' => '«$1» не является допустимым идентификатором выборов.',
	'securepoll-welcome' => '<strong>Добро пожаловать, $1!</strong>',
	'securepoll-not-started' => 'Эти выборы ещё не начались.
Начало запланировано на $2 $3.',
	'securepoll-not-qualified' => 'Вы не правомочны голосовать на этих выборах: $1',
	'securepoll-change-disallowed' => 'Вы уже голосовали на этих выборах ранее.
Извините, вы не можете проголосовать ещё раз.',
	'securepoll-change-allowed' => '<strong>Примечание. Вы уже голосовали на этих выборах ранее.</strong>
Вы можете изменить свой голос, отправив приведённую ниже форму.
Если вы сделаете это, то ваш предыдущий голос не будет учтён.',
	'securepoll-submit' => 'Отправить голос',
	'securepoll-gpg-receipt' => 'Благодарим за участие в голосовании.

При желании вы можете сохранить следующие строки как подтверждение вашего голоса:

<pre>$1</pre>',
	'securepoll-thanks' => 'Спасибо, ваш голос записан.',
	'securepoll-return' => 'Вернуться к $1',
	'securepoll-encrypt-error' => 'Не удалось зашифровать запись о вашем голосе.
Ваш голос не был записан!

$1',
	'securepoll-no-gpg-home' => 'Невозможно создать домашний каталог GPG.',
	'securepoll-secret-gpg-error' => 'Ошибка при выполнении GPG.
Задайте настройку $wgSecurePollShowErrorDetail=true; в файле LocalSettings.php чтобы получить более подробное сообщение.',
	'securepoll-full-gpg-error' => 'Ошибка при выполнении GPG:

Команда: $1

Ошибка:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-ключи настроены неправильно.',
	'securepoll-gpg-parse-error' => 'Ошибка при интерпретации вывода GPG.',
	'securepoll-no-decryption-key' => 'Не настроен ключ расшифровки.
Невозможно  расшифровать.',
	'securepoll-jump' => 'Перейти на сервер голосований',
	'securepoll-remote-auth-error' => 'Ошибка получения информации об учётной записи с сервера.',
	'securepoll-remote-parse-error' => 'Ошибка интерпретации ответа авторизации с сервера.',
	'securepoll-api-invalid-params' => 'Ошибочные параметры.',
	'securepoll-api-no-user' => 'Не найдено участника с заданным идентификатором.',
	'securepoll-api-token-mismatch' => 'Несоответствие признака безопасности, невозможно войти в систему.',
	'securepoll-not-logged-in' => 'Вы должны представиться системе, чтобы принять участие в голосовании',
	'securepoll-too-few-edits' => 'Извините, вы не можете проголосовать. Вам необходимо иметь не менее $1 правок для участия в этом голосовании, за вами числится $2.',
	'securepoll-blocked' => 'Извините, вы не можете голосовать на выборах, если учётная запись была заблокирована.',
	'securepoll-not-in-group' => 'Только члены группы $1 могут голосовать на этих выборах.',
	'securepoll-not-in-list' => 'Извините, вы не входите в список участников, допущенных для голосования на этих выборах.',
	'securepoll-list-title' => 'Список голосов: $1',
	'securepoll-header-timestamp' => 'Время',
	'securepoll-header-voter-name' => 'Имя',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Агент пользователя',
	'securepoll-header-strike' => 'Вычёркивание',
	'securepoll-header-details' => 'Подробности',
	'securepoll-strike-button' => 'Вычеркнуть',
	'securepoll-unstrike-button' => 'Снять вычёркивание',
	'securepoll-strike-reason' => 'Причина:',
	'securepoll-strike-cancel' => 'Отмена',
	'securepoll-strike-error' => 'Ошибка при вычёркивании или снятии вычёркивания: $1',
	'securepoll-need-admin' => 'Вы должны быть администратором, чтобы выполнить это действие.',
	'securepoll-details-link' => 'Подробности',
	'securepoll-details-title' => 'Подробности голосования: #$1',
	'securepoll-invalid-vote' => '«$1» не является допустимым идентификатором голосования',
	'securepoll-header-voter-type' => 'Тип голосующего',
	'securepoll-voter-properties' => 'Свойства избирателя',
	'securepoll-strike-log' => 'Журнал вычёркиваний',
	'securepoll-header-action' => 'Действие',
	'securepoll-header-reason' => 'Причина',
	'securepoll-header-admin' => 'Админ',
	'securepoll-dump-title' => 'Дамп: $ 1',
	'securepoll-dump-no-crypt' => 'Незашифрованные записи подачи голоса доступны на этих выборах, так как выборы не настроены на использование шифрования.',
	'securepoll-dump-not-finished' => 'Зашифрованные записи подачи голосов доступны только после окончания голосования $1 $2',
	'securepoll-dump-no-urandom' => 'Не удаётся открыть /dev/urandom.
Для обеспечения конфиденциальности избирателей, зашифрованные записи подачи голосов можно делать общедоступными, когда порядок их следования изменён с использованием безопасного источника случайных чисел.',
	'securepoll-translate-title' => 'Перевод: $1',
	'securepoll-invalid-language' => 'Ошибочный код языка «$1»',
	'securepoll-submit-translate' => 'Обновить',
	'securepoll-language-label' => 'Выбор языка:',
	'securepoll-submit-select-lang' => 'Перевести',
	'securepoll-header-title' => 'Имя',
	'securepoll-header-start-date' => 'Дата начала',
	'securepoll-header-end-date' => 'Дата окончания',
	'securepoll-subpage-vote' => 'Голосование',
	'securepoll-subpage-translate' => 'Перевод',
	'securepoll-subpage-list' => 'Список',
	'securepoll-subpage-dump' => 'Дамп',
);

/** Yakut (Саха тыла)
 * @author HalanTul
 */
$messages['sah'] = array(
	'securepoll' => 'КөмүскэммитКуоластааһын',
	'securepoll-desc' => 'Быыбар уонна ыйытыы ыытарга аналлаах тупсарыы',
	'securepoll-invalid-page' => 'Алҕастаах алын сирэй "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Алын сирэй туруоруулара (параметрадара) тиийбэттэр (сыыһа сигэ).',
	'securepoll-invalid-election' => '"$1" быыбар дьиҥнээх нүөмэрэ буолбатах.',
	'securepoll-welcome' => '<strong>Нөрүөн нөргүй, $1!</strong>',
	'securepoll-not-started' => 'Бу быыбар өссө саҕалана илик.
Баччаҕа саҕаланар: $1, $3.',
	'securepoll-not-qualified' => 'Бу быыбарга куоластыыр кыаҕыҥ суох: $1',
	'securepoll-change-disallowed' => 'Бу быыбарга куолатсаабыт эбиккин.
Баалаама, иккистээн куоластыыр кыаҕыҥ суох.',
	'securepoll-change-allowed' => '<strong>Быһаарыы. Эн урут бу быыбарга куоластаабыт эбиккин.</strong>
Аллара баар фуорманы толорон урут эппиккин уларытыаххын сөп.
Инньэ гыннаххына урукку куоластаабытыҥ аахсыллыа суоҕа.',
	'securepoll-submit' => 'Куолаһы биэрии',
	'securepoll-gpg-receipt' => 'Куолстааһыҥҥа кыттыбытыҥ иһин махтал.

Куолстаабыккын бигэргэтиэххин баҕарар буоллаххына бу устуруокалары бэйэҕэр хаалларыаххын сөп:

<pre>$1</pre>',
	'securepoll-thanks' => 'Махтал, эн куолаһыҥ сурулунна.',
	'securepoll-return' => 'Манна $1 төнүн',
	'securepoll-encrypt-error' => 'Эн куоластаабытын туһунан сурук кыайан оҥоһуллубата.
Эн куолаһыҥ суруллубата!

$1',
	'securepoll-no-gpg-home' => 'GPG дьиэтээҕи каталога оҥоһуллар кыаҕа суох.',
	'securepoll-secret-gpg-error' => 'GPG-ны толорго алҕас таҕыста.
$wgSecurePollShowErrorDetail=true; туруоруутун LocalSettings.php билэҕэ уган бу туһунан сиһилии көр.',
	'securepoll-full-gpg-error' => 'GPG-ны оҥорорго алҕас таҕыста:

Хамаанда:  $1

Алҕас:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG күлүүстэрэ сыыһа туруоруллубуттар.',
	'securepoll-gpg-parse-error' => 'GPG тахсыытыгар ааҕыыга алҕас таҕыста.',
	'securepoll-no-decryption-key' => 'Расшифровка күлүүһэ настройкаламматах.
Расшифровкалыыр табыллыбат.',
	'securepoll-list-title' => 'Куоластааһын тиһигэ: $1',
	'securepoll-header-timestamp' => 'Кэм',
	'securepoll-header-voter-name' => 'Аат',
	'securepoll-header-voter-domain' => 'Домен',
	'securepoll-header-ua' => 'Кыттааччы агена',
	'securepoll-header-strike' => 'Сотуу',
	'securepoll-header-details' => 'Сиһилии',
	'securepoll-strike-button' => 'Сот',
	'securepoll-unstrike-button' => 'Сотууну устуу',
	'securepoll-strike-reason' => 'Төрүөтэ:',
	'securepoll-strike-cancel' => 'Төннөрүү',
	'securepoll-strike-error' => 'Сотууга / сотуутун устууга алҕас таҕыста: $1',
	'securepoll-need-admin' => 'Маны оҥорорго дьаһабыл буолуоххун наада.',
	'securepoll-details-link' => 'Сиһилии',
	'securepoll-details-title' => 'Куоластааһын туһунан сиһилии: #$1',
	'securepoll-invalid-vote' => '"$1" куоластааһын көнүллэммит нүөмэрэ буолбатах',
	'securepoll-header-voter-type' => 'Кыттааччы көрүҥэ',
	'securepoll-voter-properties' => 'Быыбардааччы туруоруута',
	'securepoll-strike-log' => 'Сотуу сурунаала',
	'securepoll-header-action' => 'Дьайыы',
	'securepoll-header-reason' => 'Төрүөтэ',
	'securepoll-header-admin' => 'Дьаһабыл',
	'securepoll-dump-title' => 'Дамп: $1',
	'securepoll-dump-no-crypt' => 'Быыбар шифрованиены туһанарга туруоруллубатах, онон бу быыбарга кистэммэтэх куоластааһын көҥүллэнэр.',
	'securepoll-dump-not-finished' => 'Куоластааһын хаамыытын быыбар бүппүтүн кэннэ баччаҕа көрүөххүн сөп: $1, $2',
	'securepoll-dump-no-urandom' => '/dev/urandom кыайан аһыллыбат.
Быыбар хаамыытын аһаҕас гыныахха сөп, ол гынан баран ким хайдах куоластаабытын көрдөрбөт туһуттан куоластааччылар бэрээдэктэрин түбэспиччэ чыыһылалары туруоран уларытыллар.',
	'securepoll-translate-title' => 'Тылбаас: $1',
	'securepoll-invalid-language' => 'Тыл куода алҕастаах: "$1"',
	'securepoll-submit-translate' => 'Саҥардан биэр',
	'securepoll-language-label' => 'Тылы талыы:',
	'securepoll-submit-select-lang' => 'Тылбаас',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'securepoll' => 'Zabezpečené hlasovanie',
	'securepoll-desc' => 'Rozšírenie pre voľby a dotazníky',
	'securepoll-invalid-page' => 'Neplatná podstránka „<nowiki>$1</nowiki>“',
	'securepoll-too-few-params' => 'Nedostatok parametrov podstránky (neplatný odkaz).',
	'securepoll-invalid-election' => '„$1“ nie je platný ID hlasovania.',
	'securepoll-welcome' => '<strong>Vitajte $1!</strong>',
	'securepoll-not-started' => 'Tieto voľby zatiaľ nezačali.
Začiatok je naplánovaný na $2 $3.',
	'securepoll-not-qualified' => 'Nekvalifikujete sa do tohto hlasovania: $1',
	'securepoll-change-disallowed' => 'V tomto hlasovaní ste už hlasovali.
Je mi ľúto, nemôžete znova voliť.',
	'securepoll-change-allowed' => '<strong>Pozn.: V tomto hlasovaní ste už hlasovali.</strong>
Svoj hlas môžete zmeniť zaslaním dolu uvedeného formulára.
Ak tak spravíte, váš pôvodný hlas sa zahodí.',
	'securepoll-submit' => 'Poslať hlas',
	'securepoll-gpg-receipt' => 'Ďakujeme za hlasovanie.

Ak chcete, môžete si ponechať nasledovné potvrdenie ako dôkaz o tom, že ste hlasovali:

<pre>$1</pre>',
	'securepoll-thanks' => 'Ďakujeme, váš hlas bol zaznamenaný.',
	'securepoll-return' => 'Späť na $1',
	'securepoll-encrypt-error' => 'Nepodarilo sa zašifrovať záznam o vašom hlasovaní.
Váš hlas nebol zaznamenaný!

$1',
	'securepoll-no-gpg-home' => 'Chyba pri vytváraní domovského adresára GPG.',
	'securepoll-secret-gpg-error' => 'Chyba pri spúšťaní GPG.
Ďalšie podrobnosti zobrazíte nastavením $wgSecurePollShowErrorDetail=true; v súbore LocalSettings.php.',
	'securepoll-full-gpg-error' => 'Chyba pri súpšťaní GPG:

Príkaz: $1

Chyba:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG kľúče sú nesprávne nakonfigurované.',
	'securepoll-gpg-parse-error' => 'Chyba pri interpretácii výstupu GPG.',
	'securepoll-no-decryption-key' => 'Nie je nakonfigurovaný žiadny dešifrovací kľúč.
Nie je možné dešifrovať.',
	'securepoll-jump' => 'Prejsť na hlasovací server',
	'securepoll-remote-auth-error' => 'Pri zisťovaní vašich prihlasovacích informácií zo servera nastala chyba.',
	'securepoll-remote-parse-error' => 'Pri interpretácii odpovede o autorizácii od servera nastala chyba.',
	'securepoll-api-invalid-params' => 'Neplatné parametre.',
	'securepoll-api-no-user' => 'Nebol nájdený žiadny používateľ so zadaným ID.',
	'securepoll-api-token-mismatch' => 'Bezpečnostné identifikátory sa nezhodujú, nie je možné prihlásiť.',
	'securepoll-not-logged-in' => 'Aby ste mohli hlasovať, musíte sa prihlásiť',
	'securepoll-too-few-edits' => 'Prepáčte, nemôžete hlasovať. Aby ste sa mohli zúčastniť tohto hlasovania, museli by ste mať aspoň $1 úprav. Máte $2 úprav.',
	'securepoll-blocked' => 'Prepáčte, tohto hlasovania sa nemôžete zúčastniť, pretože ste momentálne zablokovaný.',
	'securepoll-not-in-group' => 'Tohto hlasovania sa môžu zúčastniť iba členovia skuupiny $1.',
	'securepoll-not-in-list' => 'Prepáčte, nenáchádzate sa na vopred určenom zozname používateľov oprávnených zúčastniť sa tohto hlasovania.',
	'securepoll-list-title' => 'Zoznam hlasov: $1',
	'securepoll-header-timestamp' => 'Čas',
	'securepoll-header-voter-name' => 'Meno',
	'securepoll-header-voter-domain' => 'Doména',
	'securepoll-header-ua' => 'Prehliadač',
	'securepoll-header-strike' => 'Škrtnúť',
	'securepoll-header-details' => 'Podrobnosti',
	'securepoll-strike-button' => 'Škrtnúť',
	'securepoll-unstrike-button' => 'Zrušiť škrtnutie',
	'securepoll-strike-reason' => 'Dôvod:',
	'securepoll-strike-cancel' => 'Zrušiť',
	'securepoll-strike-error' => 'Chyba operácie škrtnutie/zrušenie škrtnutia: $1',
	'securepoll-need-admin' => 'Aby ste mohli vykonať túto operáciu, musíte byť správca.',
	'securepoll-details-link' => 'Podrobnosti',
	'securepoll-details-title' => 'Podrobnosti hlasovania: #$1',
	'securepoll-invalid-vote' => '„$1“ nie je platný ID hlasovania',
	'securepoll-header-voter-type' => 'Typ hlasujúceho',
	'securepoll-voter-properties' => 'Vlastnosti hlasujúceho',
	'securepoll-strike-log' => 'Záznam škrtnutí',
	'securepoll-header-action' => 'Operácia',
	'securepoll-header-reason' => 'Dôvod',
	'securepoll-header-admin' => 'Správca',
	'securepoll-dump-title' => 'Výpis: $1',
	'securepoll-dump-no-crypt' => 'Pre tieto voľby nie je dostupný žiadny šifrovaný záznam o voľbách, pretože nebolo nastavené aby tieto voľby používali šifrovanie.',
	'securepoll-dump-not-finished' => 'Šifrované záznamy o voľbách sú dostupné len po dátume ich skončenia: $1 $2',
	'securepoll-dump-no-urandom' => 'Nie je možné otvoriť /dev/urandom.
Aby bola zabezpečená anonymita hlasujúceho, šifrované záznamy o voľbách sú dostupné verejne len keď bôžu byť zamiešané náhodným tokom čísel.',
	'securepoll-translate-title' => 'Preložiť: $1',
	'securepoll-invalid-language' => 'Neplatný kód jazyka „$1“',
	'securepoll-submit-translate' => 'Aktualizovať',
	'securepoll-language-label' => 'Vyberte jazyk:',
	'securepoll-submit-select-lang' => 'Preložiť',
	'securepoll-header-title' => 'Meno',
	'securepoll-header-start-date' => 'Dátum začiatku',
	'securepoll-header-end-date' => 'Dátum ukončenia',
	'securepoll-subpage-vote' => 'Hlasovať',
	'securepoll-subpage-translate' => 'Preložiť',
	'securepoll-subpage-list' => 'Zoznam',
	'securepoll-subpage-dump' => 'Výpis',
);

/** Swedish (Svenska)
 * @author Najami
 */
$messages['sv'] = array(
	'securepoll' => 'SäkerOmröstning',
	'securepoll-desc' => 'Ett programtillägg för omröstningar och enkäter',
	'securepoll-invalid-page' => 'Ogiltig undersida "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Ej tillräckligt många undersideparametrar (ogiltig länk).',
	'securepoll-invalid-election' => '"$1" är inte ett giltigt omröstnings-ID.',
	'securepoll-welcome' => '<strong>Välkommen $1!</strong>',
	'securepoll-not-started' => 'Den här omröstningen är inte startat ännu.
Den planeras starta den $1 kl $3.',
	'securepoll-not-qualified' => 'Du är inte kvalificerad att rösta i den här omröstningen: $1',
	'securepoll-change-disallowed' => 'Du har redan röstat i den här omröstningen.
Du kan tyvärr inte rösta igen.',
	'securepoll-change-allowed' => '<strong>Observera att du redan har röstat i den här omröstningen.</strong>
Du kan ändra din röst genom att skicka in formuläret nedan.
Observera att om du gör det här, kommer din ursprungliga röst att slängas.',
	'securepoll-submit' => 'Spara röst',
	'securepoll-gpg-receipt' => 'Tack för din röst.

Om du vill kan du behålla följande kvitto som ett bevis på din röst:

<pre>$1</pre>',
	'securepoll-thanks' => 'Tack, din röst har registrerats.',
	'securepoll-return' => 'Tillbaka till $1',
	'securepoll-encrypt-error' => 'Misslyckades att kryptera din röst.
Din röst har inte registrerats!

$1',
	'securepoll-no-gpg-home' => 'Kunde inte skapa en GPG-hemkatalog.',
	'securepoll-secret-gpg-error' => 'Ett fel uppstod när GPG exekverades.
Använd $wgSecurePollShowErrorDetail=true; i LocalSettings.php för mer information.',
	'securepoll-full-gpg-error' => 'Ett fel uppstod när GPG exekverades:

Kommando: $1

Fel:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG-nycklar har kofigurerats fel.',
	'securepoll-gpg-parse-error' => 'Ett fel uppstod när GPG-utdatan interpreterades.',
	'securepoll-no-decryption-key' => 'Ingen dekrypteringsnyckel är konfigurerad.
Kan inte dekryptera.',
	'securepoll-list-title' => 'Visa röster: $1',
	'securepoll-header-timestamp' => 'Tid',
	'securepoll-header-voter-name' => 'Namn',
	'securepoll-header-voter-domain' => 'Domän',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'securepoll-header-voter-name' => 'పేరు',
	'securepoll-header-details' => 'వివరాలు',
	'securepoll-strike-reason' => 'కారణం:',
	'securepoll-details-link' => 'వివరాలు',
	'securepoll-header-action' => 'చర్య',
	'securepoll-header-reason' => 'కారణం',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'securepoll' => 'GüvenliAnket',
	'securepoll-desc' => 'Seçimler ve anketler için eklenti',
	'securepoll-invalid-page' => 'Geçersiz altsayfa "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Yeterli altsayfa parametresi yok (geçersiz bağlantı).',
	'securepoll-invalid-election' => '"$1" geçerli bir seçim IDsi değil.',
	'securepoll-welcome' => '<strong>Hoş Geldin $1!</strong>',
	'securepoll-not-started' => 'Bu seçim henüz başlamadı.
$2 tarihinde $3 saatinde başlaması planlanıyor.',
	'securepoll-not-qualified' => 'Bu seçimlerde oy kullanmak için yetkili değilsiniz: $1',
	'securepoll-change-disallowed' => 'Bu seçimde daha önce oy kullandınız.
Üzgünüz, tekrar oy kullanamayabilirsiniz.',
	'securepoll-change-allowed' => '<strong>Not: Bu seçimde daha önce oy kullandınız.</strong>
Aşağıdaki formu göndererek oyunuzu değiştirebilirsiniz.
Eğer bunu yaparsanız, orjinal oyunuzun iptal edileceğini unutmayın.',
	'securepoll-submit' => 'Oyu gönder',
	'securepoll-gpg-receipt' => 'Oy verdiğiniz için teşekkürler.

Eğer dilerseniz, aşağıdaki makbuzu oyunuzun delili olarak muhafaza edebilirsiniz:

<pre>$1</pre>',
	'securepoll-thanks' => 'Teşekkürler, oyunuz kaydedildi.',
	'securepoll-return' => "$1'e geri dön",
	'securepoll-encrypt-error' => 'Oy kaydınızın şifrelenmesi başarısız oldu.
Oyunuz kaydedilmedi!

$1',
	'securepoll-no-gpg-home' => 'GPG ev dizini oluşturulamıyor.',
	'securepoll-secret-gpg-error' => 'GPG çalıştırırken hata.
Daha fazla ayrıntı göstermek için LocalSettings.php\'de $wgSecurePollShowErrorDetail=true kullanın.',
	'securepoll-full-gpg-error' => 'GPG çalıştırırken hata:

Komut: $1

Hata:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG anahtarları yanlış yapılandırılmış.',
	'securepoll-gpg-parse-error' => 'GPG çıktısı yorumlanırken hata.',
	'securepoll-no-decryption-key' => 'Hiç deşifre anahtarı ayarlanmamış.
Deşifrelenemiyor.',
	'securepoll-jump' => 'Oylama sunucusuna git',
	'securepoll-remote-auth-error' => 'Sunucudan hesap bilgileriniz alınırken hata.',
	'securepoll-remote-parse-error' => 'Sunucunun yetkilendirme cevabı değerlendirilirken hata.',
	'securepoll-api-invalid-params' => 'Geçersiz değişkenler.',
	'securepoll-api-no-user' => 'Verilen ID ile hiçbir kullanıcı bulunamadı.',
	'securepoll-api-token-mismatch' => 'Güvenlik simgesi uyuşmuyor, giriş yapılamıyor.',
	'securepoll-not-logged-in' => 'Bu seçimde oy kullanmak için giriş yapmanız gerekiyor',
	'securepoll-too-few-edits' => 'Üzgünüz, oy veremezsiniz. Bu seçimlerde oy kullanmak için en az $1 değişiklik yapmanız gerekir, sizin $2 değişikliğiniz var.',
	'securepoll-blocked' => 'Üzgünüz, eğer şu anda değişiklik yapmaya engellenmiş iseniz bu seçimlerde oy kullanamazsınız.',
	'securepoll-not-in-group' => 'Bu seçimlerde sadece $1 grubu üyeleri oy verebilir.',
	'securepoll-not-in-list' => 'Üzgünüz, bu seçimde oy kullanmaya yetkili öntanımlı kullanıcılar listesinde değilsiniz.',
	'securepoll-list-title' => 'Oyları listele: $1',
	'securepoll-header-timestamp' => 'Zaman',
	'securepoll-header-voter-name' => 'Ad',
	'securepoll-header-voter-domain' => 'Etki alanı',
	'securepoll-header-ua' => 'Kullanıcı temsilcisi',
	'securepoll-header-strike' => 'Üstünü çiz',
	'securepoll-header-details' => 'Ayrıntılar',
	'securepoll-strike-button' => 'Üstünü çiz',
	'securepoll-unstrike-button' => 'Üstünü çizme',
	'securepoll-strike-reason' => 'Sebep:',
	'securepoll-strike-cancel' => 'İptal',
	'securepoll-strike-error' => 'Üsütünü çiz/çizme yerine getirilirken hata: $1',
	'securepoll-need-admin' => 'Bu eylemi gerçekleştirebilmek için bir yönetici olmanız gerekir.',
	'securepoll-details-link' => 'Ayrıntılar',
	'securepoll-details-title' => 'Oy ayrıntıları: #$1',
	'securepoll-invalid-vote' => '"$1" geçerli bir oy IDsi değil',
	'securepoll-header-voter-type' => 'Seçmen tipi',
	'securepoll-voter-properties' => 'Seçmen özellikleri',
	'securepoll-strike-log' => 'Üstünü çizme günlüğü',
	'securepoll-header-action' => 'Eylem',
	'securepoll-header-reason' => 'Sebep',
	'securepoll-header-admin' => 'Yönetici',
	'securepoll-dump-title' => 'Çöp: $1',
	'securepoll-dump-no-crypt' => 'Bu seçim için şifrelenmiş seçim kaydı yok, çünkü seçim şifreleme kullanacak şekilde ayarlanmamış.',
	'securepoll-dump-not-finished' => "Şifreli seçim kayıtları sadece bitiş tarihi $1 saat $2'den sonra mevcut olur",
	'securepoll-dump-no-urandom' => '/dev/urandom açılamıyor.
Seçmen gizliliğini idame etmek için, şifreli seçim kayıtları sadece güvenli bir rasgele sayı akıntısıyla karıştırılabilirse umumen mevcut olur.',
	'securepoll-translate-title' => 'Çevir: $1',
	'securepoll-invalid-language' => 'Geçersiz dil kodu "$1"',
	'securepoll-submit-translate' => 'Güncelle',
	'securepoll-language-label' => 'Dili seç:',
	'securepoll-submit-select-lang' => 'Çevir',
	'securepoll-header-title' => 'Ad',
	'securepoll-header-start-date' => 'Başlangıç tarihi',
	'securepoll-header-end-date' => 'Bitiş tarihi',
	'securepoll-subpage-vote' => 'Oy ver',
	'securepoll-subpage-translate' => 'Çevir',
	'securepoll-subpage-list' => 'Listele',
	'securepoll-subpage-dump' => 'Döküm',
);

/** Urdu (اردو)
 * @author محبوب عالم
 */
$messages['ur'] = array(
	'securepoll-desc' => 'توسیعہ برائے انتخابات و مساحات',
	'securepoll-invalid-page' => 'غیرصحیح ذیلی‌صفحہ "<nowiki>$1</nowiki>"',
	'securepoll-invalid-election' => '"$1" کوئی معتبر انتخابی شناخت نہیں ہے.',
	'securepoll-welcome' => '<strong>خوش آمدید $1!</strong>',
	'securepoll-not-started' => 'چناؤ ابھی شروع نہیں ہوا.

اِس کا آغاز $1 کو ہوگا.',
	'securepoll-not-qualified' => 'آپ اِس چناؤ میں رائےدہندگی کے اہل نہیں: $1',
	'securepoll-change-disallowed' => 'آپ اِس چناؤ میں پہلے رائے دے چکے ہیں.

معذرت، آپ دوبارہ رائے نہیں دے سکتے.',
	'securepoll-change-allowed' => '<strong>یاددہانی: آپ اِس چناؤ میں پہلے رائے دے چکے ہیں.</strong>

آپ درج ذیل تشکیلہ بھیج کر اپنی رائے تبدیل کرسکتے ہیں.

یاد رہے کہ ایسا کرنے سے آپ کی اصل رائے ختم ہوجائے گی.',
	'securepoll-submit' => 'رائے بھیجئے',
	'securepoll-gpg-receipt' => 'رائےدہندگی کا شکریہ.

اگر آپ چاہیں تو درج ذیل رسید کو اپنی رائےدہندگی کے ثبوت کے طور پر رکھ سکتے ہیں:

<pre>$1</pre>',
	'securepoll-thanks' => 'شکریہ، آپ کی رائے محفوظ کرلی گئی.',
	'securepoll-return' => 'واپس بطرف $1',
);

/** Vèneto (Vèneto)
 * @author Candalua
 */
$messages['vec'] = array(
	'securepoll' => 'SecurePoll',
	'securepoll-desc' => 'Estension par le elession e i sondagi',
	'securepoll-invalid-page' => 'Sotopàxena mia vàlida: "<nowiki>$1</nowiki>"',
	'securepoll-too-few-params' => 'Paràmetri de la sotopàxena mia suficenti (colegamento mia vàlido).',
	'securepoll-invalid-election' => '"$1" no xe un ID vàlido par l\'elession.',
	'securepoll-welcome' => '<strong>Benvegnù $1!</strong>',
	'securepoll-not-started' => "L'elession no la xe gnancora tacà.
L'inissio el xe programà par el $1.",
	'securepoll-not-qualified' => 'No te sì mia qualificà par votar in sta elession: $1',
	'securepoll-change-disallowed' => 'Ti gà xà votà in sta elession.
No ti podi votar da novo.',
	'securepoll-change-allowed' => '<strong>Ocio: ti gà xà votà in sta elession.</strong>
Ti podi canbiar el voto conpilando el mòdulo qua soto.
Ocio che fasendo cussì el voto orijinale el vegnarà scartà.',
	'securepoll-submit' => 'Manda el voto',
	'securepoll-gpg-receipt' => 'Grassie de aver votà.

Sta chì xe la riçevuta de la votassion:

<pre>$1</pre>',
	'securepoll-thanks' => 'Grassie, el to voto el xe stà rejistrà.',
	'securepoll-return' => 'Torna a $1',
	'securepoll-encrypt-error' => "No se riesse a cifrar le informassion de voto.
El voto no'l xe mia stà rejistrà.

$1",
	'securepoll-no-gpg-home' => 'NO se riesse a crear la cartèla prinsipale de GPG.',
	'securepoll-secret-gpg-error' => 'Eròr durante l\'esecussion de GPG.
Dòpara $wgSecurePollShowErrorDetail=true; in LocalSettings.php par védar majori detagli.',
	'securepoll-full-gpg-error' => "Eròr durante l'esecussion de GPG:

Comando: $1

Eròr:
<pre> $2 </pre>",
	'securepoll-gpg-config-error' => 'Le ciave GPG no le xe mia configurà juste.',
	'securepoll-gpg-parse-error' => "Eròr in tel'interpretassion de l'output de GPG.",
	'securepoll-no-decryption-key' => 'No xe stà configurà nissuna ciave de decritassion.
No se pole decritar.',
	'securepoll-list-title' => 'Elenco voti: $1',
	'securepoll-header-timestamp' => 'Data e ora',
	'securepoll-header-voter-name' => 'Nome',
	'securepoll-header-voter-domain' => 'Dominio',
	'securepoll-header-ua' => 'Agente utente',
	'securepoll-header-strike' => 'Anùla',
	'securepoll-header-details' => 'Detagli',
	'securepoll-strike-button' => 'Anùla sta voto',
	'securepoll-unstrike-button' => 'Recupera sto voto',
	'securepoll-strike-reason' => 'Motivo:',
	'securepoll-strike-cancel' => 'Anùla',
	'securepoll-strike-error' => "Eròr durante l'anulamento o el ripristino del voto: $1",
	'securepoll-need-admin' => 'Ti gà da èssar un aministrador par poder far sta assion.',
	'securepoll-details-link' => 'Detagli',
	'securepoll-details-title' => 'Detagli del voto: #$1',
	'securepoll-invalid-vote' => '"$1" no xe l\'ID de un voto vàlido',
	'securepoll-header-voter-type' => 'Tipo de utente',
	'securepoll-voter-properties' => 'Proprietà del votante',
	'securepoll-strike-log' => 'Registro dei anulamenti',
	'securepoll-header-action' => 'Assion',
	'securepoll-header-reason' => 'Motivo',
	'securepoll-header-admin' => 'Aministrador',
	'securepoll-dump-title' => 'Dump: $1',
	'securepoll-dump-no-crypt' => "Par sta elession no xe disponibile nissuna registrassion criptada, parché l'elession no la xe inpostà par doparar la critassion.",
	'securepoll-dump-not-finished' => "Le registrassion criptade de l'elession le xe disponibili solo dopo la data de conclusion: $1",
	'securepoll-dump-no-urandom' => "No se riesse a vèrzar /dev/urandom.  
Par protègiare la riservatessa dei votanti, le registrassion criptade de l'elession le xe disponibili publicamente solo quando le podarà vegner smissià con un flusso sicuro de nùmari casuali.",
	'securepoll-translate-title' => 'Tradusi: $1',
	'securepoll-invalid-language' => 'Còdese lengua mia vàlido: "$1"',
	'securepoll-submit-translate' => 'Ajorna',
	'securepoll-language-label' => 'Siegli lengua:',
	'securepoll-submit-select-lang' => 'Tradusi',
);

/** Veps (Vepsan kel')
 * @author Игорь Бродский
 */
$messages['vep'] = array(
	'securepoll-header-timestamp' => 'Aig',
	'securepoll-header-voter-name' => 'Nimi',
	'securepoll-header-voter-domain' => 'Domen',
	'securepoll-header-ua' => 'Kävutajan agent',
	'securepoll-strike-reason' => 'Sü:',
	'securepoll-strike-cancel' => 'Heitta pätand',
	'securepoll-header-action' => 'Tego',
	'securepoll-header-reason' => 'Sü',
	'securepoll-header-admin' => 'Admin',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 * @author Vinhtantran
 */
$messages['vi'] = array(
	'securepoll' => 'Bỏ phiếu An toàn',
	'securepoll-desc' => 'Bộ mở rộng dành cho bầu cử và thăm dò ý kiến',
	'securepoll-invalid-page' => 'Trang con không hợp lệ “<nowiki>$1</nowiki>”',
	'securepoll-too-few-params' => 'Không đủ thông số trang con (liên kết không hợp lệ).',
	'securepoll-invalid-election' => '“$1” không phải là mã số bầu cử hợp lệ.',
	'securepoll-welcome' => '<strong>Xin chào $1!</strong>',
	'securepoll-not-started' => 'Cuộc bầu cử này chưa bắt đầu.
Dự kiến nó sẽ bắt đầu vào $1.',
	'securepoll-not-qualified' => 'Bạn không đủ tiêu chuẩn để bỏ phiếu trong cuộc bầu cử này: $1',
	'securepoll-change-disallowed' => 'Bạn đã bỏ phiếu cho cuộc bầu cử này rồi.
Rất tiếc, bạn không thể bỏ phiếu được nữa.',
	'securepoll-change-allowed' => '<strong>Chú ý: Bạn đã bỏ phiếu trong cuộc bầu cử này rồi.</strong>
Bạn có thể thay đổi phiếu bầu bằng cách điền vào mẫu đơn phía dưới.
Ghi nhớ rằng nếu bạn làm điều này, phiếu bầu trước đây của bạn sẽ bị hủy.',
	'securepoll-submit' => 'Gửi phiếu bầu',
	'securepoll-gpg-receipt' => 'Cảm ơn bạn đã tham gia bỏ phiếu.

Nếu muốn, bạn có thể nhận biên lai sau để làm bằng chứng cho phiếu bầu của bạn:

<pre>$1</pre>',
	'securepoll-thanks' => 'Cảm ơn, phiếu bầu của bạn đã được ghi nhận.',
	'securepoll-return' => 'Trở về $1',
	'securepoll-encrypt-error' => 'Không thể mã hóa phiếu bầu của bạn.
Việc bỏ phiếu của bạn chưa được ghi lại!

$1',
	'securepoll-no-gpg-home' => 'Không thể khởi tạo thư mục nhà GPG',
	'securepoll-secret-gpg-error' => 'Có lỗi khi xử lý GPG.
Hãy dùng $wgSecurePollShowErrorDetail=true; trong LocalSettings.php để hiển thị thêm chi tiết.',
	'securepoll-full-gpg-error' => 'Có lỗi khi xử lý GPG:

Lệnh: $1

Lỗi:
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'Khóa GPG không được cấu hình đúng.',
	'securepoll-gpg-parse-error' => 'Có lỗi khi thông dịch dữ liệu xuất GPG.',
	'securepoll-no-decryption-key' => 'Chưa cấu hình khóa giải mã.
Không thể giải mã.',
	'securepoll-list-title' => 'Liệt kê các lá phiếu: $1',
	'securepoll-header-timestamp' => 'Thời điểm',
	'securepoll-header-voter-name' => 'Tên',
	'securepoll-header-voter-domain' => 'Tên miền',
	'securepoll-header-ua' => 'Trình duyệt',
	'securepoll-header-strike' => 'Gạch bỏ',
	'securepoll-header-details' => 'Chi tiết',
	'securepoll-strike-button' => 'Gạch bỏ',
	'securepoll-unstrike-button' => 'Phục hồi',
	'securepoll-strike-reason' => 'Lý do:',
	'securepoll-strike-cancel' => 'Hủy bỏ',
	'securepoll-strike-error' => 'Lỗi khi gạch bỏ hay phục hồi: $1',
	'securepoll-need-admin' => 'Chỉ các quản lý viên có quyền thực hiện tác vụ này.',
	'securepoll-details-link' => 'Chi tiết',
	'securepoll-details-title' => 'Chi tiết lá phiếu: #$1',
	'securepoll-invalid-vote' => '“$1” không phải là ID lá phiếu hợp lệ',
	'securepoll-header-voter-type' => 'Loại người dùng',
	'securepoll-voter-properties' => 'Thuộc tính cử tri',
	'securepoll-strike-log' => 'Nhật trình gạch bỏ',
	'securepoll-header-action' => 'Tác vụ',
	'securepoll-header-reason' => 'Lý do',
	'securepoll-header-admin' => 'Quản lý viên',
	'securepoll-dump-title' => 'Kết xuất: $1',
	'securepoll-dump-no-crypt' => 'Không có sẵn hồ sơ mật mã hóa cho cuộc bầu cử này, vì tính năng mật mã hóa không được thiết lập cho cuộc bầu cử.',
	'securepoll-dump-not-finished' => 'Các hồ sơ bầu cử mật mã hóa chỉ có sẵn sau ngày kết thúc: $1',
	'securepoll-dump-no-urandom' => 'Không thể mở /dev/urandom.
Để giữ gìn tính riêng tư của các cử tri, các hồ sơ bầu cử mật mã hóa cần được ngẫu nhiên hóa dùng dòng số ngẫu nhiên mã hóa trước khi công khai.',
	'securepoll-translate-title' => 'Biên dịch: $1',
	'securepoll-invalid-language' => 'Mã ngôn ngữ “$1” không hợp lệ',
	'securepoll-submit-translate' => 'Cập nhật',
	'securepoll-language-label' => 'Chọn ngôn ngữ:',
	'securepoll-submit-select-lang' => 'Biên dịch',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Bencmq
 * @author Skjackey tse
 */
$messages['zh-hans'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '选举和投票扩展',
	'securepoll-invalid-page' => '无效的子页面「<nowiki>$1</nowiki>」',
	'securepoll-too-few-params' => '缺少子页面参数（无效链接）。',
	'securepoll-invalid-election' => '「$1」不是有效的选举投票编号。',
	'securepoll-welcome' => '<strong>欢迎$1！</strong>',
	'securepoll-not-started' => '这个投票尚未开始。
按计划将于$1开始。',
	'securepoll-not-qualified' => '您不具有参与投票的资格：$1',
	'securepoll-change-disallowed' => '您已经参与过本次投票。对不起，您不能再次投票。',
	'securepoll-change-allowed' => '<strong>注意：您曾经在本次投票中投下一票。</strong>您可以提交下面的表格并更改您的选票。请注意若您更改选票，原先的选票将作废。',
	'securepoll-submit' => '提交投票',
	'securepoll-gpg-receipt' => '感谢您的投票。

您可以保留下面的回执作为您参与投票的证据：

<pre>$1</pre>',
	'securepoll-thanks' => '谢谢您，您的投票已被记录。',
	'securepoll-return' => '回到$1',
	'securepoll-encrypt-error' => '投票记录加密失败。
您的投票未被记录。

$1',
	'securepoll-no-gpg-home' => '无法创建GPG主目录。',
	'securepoll-secret-gpg-error' => '执行GPG出错。
在LocalSettings.php中使用$wgSecurePollShowErrorDetail=true;以查看更多细节。',
	'securepoll-full-gpg-error' => '执行GPG错误：

命令：$1

错误：
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG密匙配置错误。',
	'securepoll-gpg-parse-error' => '解释GPG输出时出错。',
	'securepoll-no-decryption-key' => '解密密匙未配置。
无法解密。',
	'securepoll-list-title' => '投票列表：$1',
	'securepoll-header-timestamp' => '时间',
	'securepoll-header-voter-name' => '名称',
	'securepoll-header-voter-domain' => '域名',
	'securepoll-header-ua' => '用户代理',
	'securepoll-header-strike' => '删除选票',
	'securepoll-header-details' => '细节',
	'securepoll-strike-button' => '删除选票',
	'securepoll-unstrike-button' => '恢复选票',
	'securepoll-strike-reason' => '理由：',
	'securepoll-strike-cancel' => '取消',
	'securepoll-strike-error' => '进行删除选票/恢复被删除选票时出错：$1',
	'securepoll-need-admin' => '您必须是管理员才能进行此操作。',
	'securepoll-details-link' => '细节',
	'securepoll-details-title' => '投票细节：#$1',
	'securepoll-invalid-vote' => '“$1”不是有效的投票ID',
	'securepoll-header-voter-type' => '用户类型',
	'securepoll-voter-properties' => '投票人属性',
	'securepoll-strike-log' => '删除选票日志',
	'securepoll-header-action' => '动作',
	'securepoll-header-reason' => '原因',
	'securepoll-header-admin' => '管理员',
	'securepoll-dump-title' => 'Dump：$1',
	'securepoll-dump-no-crypt' => '本次投票没有被加密的投票记录，因为它被配置为不须加密。',
	'securepoll-dump-not-finished' => '加密的投票记录只有在截止日期$1后方可获得',
	'securepoll-dump-no-urandom' => '无法打开/dev/urandom。为了保证投票者的隐私，经过加密的投票记录只有在经随机数据串干涉后方可公开。',
	'securepoll-translate-title' => '翻译：$1',
	'securepoll-invalid-language' => '无效的语言代码“$1”',
	'securepoll-submit-translate' => '更新',
	'securepoll-language-label' => '选择语言：',
	'securepoll-submit-select-lang' => '翻译',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Skjackey tse
 * @author Wong128hk
 */
$messages['zh-hant'] = array(
	'securepoll' => '安全投票',
	'securepoll-desc' => '投票及選舉擴展',
	'securepoll-invalid-page' => '無效的子頁面「<nowiki>$1</nowiki>」',
	'securepoll-too-few-params' => '缺少子頁面參數（無效鏈接）。',
	'securepoll-invalid-election' => '「$1」不是有效的選舉編號。',
	'securepoll-welcome' => '<strong>歡迎$1！</strong>',
	'securepoll-not-started' => '這個選舉尚未開始。
按計劃將於$1開始。',
	'securepoll-not-qualified' => '您不具有於是次選舉中參與表決的資格︰$1',
	'securepoll-change-disallowed' => '您已於是次選舉中投票。
閣下恕未可再次投票。',
	'securepoll-change-allowed' => '<strong>請注意您已於較早前於是次選舉中投票。</strong>
您可以透過遞交以下的表格改動您的投票。
惟請注意，若然閣下作出此番舉動，閣下原先所投之票將變為廢票。',
	'securepoll-submit' => '遞交投票',
	'securepoll-gpg-receipt' => '多謝您參與投票。

閣下可以保留以下收條以作為參與過是次投票的憑證︰

<pre>$1</pre>',
	'securepoll-thanks' => '感謝，閣下的投票已被紀錄。',
	'securepoll-return' => '回到$1',
	'securepoll-encrypt-error' => '投票紀錄加密失敗。
您的投票未被紀錄。

$1',
	'securepoll-no-gpg-home' => '無法建立GPG主目錄。',
	'securepoll-secret-gpg-error' => '執行GPG出錯。
於LocalSettings.php中使用$wgSecurePollShowErrorDetail=true;以展示更多細節。',
	'securepoll-full-gpg-error' => '執行GPG錯誤：

命令：$1

錯誤：
<pre>$2</pre>',
	'securepoll-gpg-config-error' => 'GPG密匙配置錯誤。',
	'securepoll-gpg-parse-error' => '解釋GPG輸出時出錯。',
	'securepoll-no-decryption-key' => '解密密匙未配置。
無法解密。',
);

