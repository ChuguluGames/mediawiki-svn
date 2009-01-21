<?php
/**
 * Internationalisation for Drafts extension
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Trevor Parscal
 */
$messages['en'] = array(
	'drafts' => 'Drafts',
	'drafts-desc' => 'Adds the ability to save [[Special:Drafts|draft]] versions of a page on the server',
	'drafts-view' => 'ViewDraft',
	'drafts-view-article' => 'Page',
	'drafts-view-existing' => 'Existing drafts',
	'drafts-view-saved' => 'Saved',
	'drafts-view-discard' => 'Discard',
	'drafts-view-nonesaved' => 'You do not have any drafts saved at this time.',
	'drafts-view-notice' => 'You have $1 for this page.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|draft|drafts}}',
	'drafts-view-warn' => 'By navigating away from this page you will lose all unsaved changes to this page.
Do you want to continue?',
	'drafts-save' => 'Save this as a draft',
	'drafts-save-save' => 'Save draft',
	'drafts-save-saved' => 'Saved',
	'drafts-save-error' => 'Error saving draft',
	'tooltip-drafts-save' => 'Save as a draft',
	'accesskey-drafts-save' => 'g', # do not translate or duplicate this message to other languages
);

/** Message documentation (Message documentation)
 * @author Darth Kule
 */
$messages['qqq'] = array(
	'drafts' => 'Title of Special:Drafts',
	'drafts-desc' => 'Short description of the Drafts extension, shown in [[Special:Version]]. Do not translate or change links.',
	'drafts-view-article' => 'Name of column in Special:Drafts, when there are draft versions saved.

{{Identical|Page}}',
	'drafts-view-existing' => 'Shown at the top while editing a page with draft versions saved',
	'drafts-view-saved' => 'Name of column in Special:Drafts, when there are draft versions saved',
	'drafts-view-discard' => 'Name of button to delete draft version of a page',
	'drafts-view-nonesaved' => 'Displayed in Special:Drafts when there are no draft versions saved',
	'drafts-view-notice' => "Shown at the top while previewing a page with draft versions saved. ''$1'' is {{msg-mw|Drafts-view-notice-link}} message",
	'drafts-view-notice-link' => "Used in {{msg-mw|Drafts-view-notice}}. ''$1'' is the number of draft versions saved for the page",
	'drafts-save' => 'Tooltip of {{msg-mw|Drafts-save-save}} button',
	'drafts-save-save' => 'Button shown near "Show changes" under editing form of a page',
);

/** Magyar (magázó) (Magyar (magázó))
 * @author Dani
 */
$messages['hu-formal'] = array(
	'drafts-view-nonesaved' => 'Jelenleg nincs egyetlen elmentett piszkozata sem.',
	'drafts-view-notice-link' => '{{PLURAL:$1|egy|$1}} piszkozata',
	'drafts-view-warn' => 'Ha elmegy az oldalról, az összes mentetlen változtatás elvész.
Biztosan folytatja?',
);

/** Arabic (العربية)
 * @author Meno25
 */
$messages['ar'] = array(
	'drafts' => 'مسودات',
	'drafts-desc' => 'يضيف القدرة على حفظ نسخ [[Special:Drafts|مسودة]] لصفحة على الخادم',
	'drafts-view' => 'عرض المسودة',
	'drafts-view-article' => 'الصفحة',
	'drafts-view-existing' => 'المسودات الموجودة',
	'drafts-view-saved' => 'محفوظة',
	'drafts-view-discard' => 'تجاهل',
	'drafts-view-nonesaved' => 'أنت ليس لديك أي مسودات محفوظة في هذا الوقت.',
	'drafts-view-notice' => 'أنت لديك $1 لهذه الصفحة.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|مسودة|مسودة}}',
	'drafts-view-warn' => 'بواسطة الإبحار عن هذه الصفحة ستفقد كل التغييرات غير المحفوظة لهذه الصفحة.
هل تريد الاستمرار؟',
	'drafts-save' => 'حفظ هذه كمسودة',
	'drafts-save-save' => 'حفظ المسودة',
	'drafts-save-saved' => 'محفوظة',
	'drafts-save-error' => 'خطأ أثناء حفظ المسودة',
	'tooltip-drafts-save' => 'حفظ كمسودة',
);

/** Egyptian Spoken Arabic (مصرى)
 * @author Meno25
 */
$messages['arz'] = array(
	'drafts' => 'مسودات',
	'drafts-desc' => 'يضيف القدرة على حفظ نسخ [[Special:Drafts|مسودة]] لصفحة على الخادم',
	'drafts-view' => 'عرض المسودة',
	'drafts-view-article' => 'الصفحة',
	'drafts-view-existing' => 'المسودات الموجودة',
	'drafts-view-saved' => 'محفوظة',
	'drafts-view-discard' => 'تجاهل',
	'drafts-view-nonesaved' => 'أنت ليس لديك أى مسودات محفوظة فى هذا الوقت.',
	'drafts-view-notice' => 'أنت لديك $1 لهذه الصفحة.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|مسودة|مسودة}}',
	'drafts-view-warn' => 'بواسطة الإبحار عن هذه الصفحة ستفقد كل التغييرات غير المحفوظة لهذه الصفحة.
هل تريد الاستمرار؟',
	'drafts-save' => 'حفظ هذه كمسودة',
	'drafts-save-save' => 'حفظ المسودة',
	'drafts-save-saved' => 'محفوظة',
	'drafts-save-error' => 'خطأ أثناء حفظ المسودة',
	'tooltip-drafts-save' => 'حفظ كمسودة',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'drafts' => 'Чарнавікі',
	'drafts-desc' => 'Дадае магчымасьць запісу [[Special:Drafts|чарнавіка]] старонкі на сэрвэры',
	'drafts-view' => 'Прагляд чарнавіка',
	'drafts-view-article' => 'Старонка',
	'drafts-view-existing' => 'Існуючыя чарнавікі',
	'drafts-view-saved' => 'Захаваны',
	'drafts-view-discard' => 'Выдаліць',
	'drafts-view-nonesaved' => 'Зараз у Вас няма захаваных чарнавікоў.',
	'drafts-view-notice' => 'Вы маеце $1 для гэтай старонкі.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|чарнавік|чарнавікі|чарнавікоў}}',
	'drafts-view-warn' => 'Закрыцьцё гэтай старонкі прывядзе да страты ўсіх незахаваных зьменаў.
Вы жадаеце працягваць?',
	'drafts-save' => 'Захаваць гэта як чарнавік',
	'drafts-save-save' => 'Захаваць чарнавік',
	'drafts-save-saved' => 'Захаваны',
	'drafts-save-error' => 'Памылка захаваньня чарнавіка',
	'tooltip-drafts-save' => 'Захаваць як чарнавік',
);

/** Bulgarian (Български)
 * @author DCLXVI
 */
$messages['bg'] = array(
	'drafts' => 'Чернови',
	'drafts-desc' => 'Добавя възможност за съхраняване на [[Special:Drafts|чернови]] на страниците',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Налични чернови',
	'drafts-view-nonesaved' => 'Все още нямате съхранени чернови.',
	'drafts-view-notice' => 'Имате $1 за тази страница.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|чернова|чернови}}',
	'drafts-save' => 'Съхраняване на съдържанието като чернова',
	'drafts-save-save' => 'Съхраняване като чернова',
	'drafts-save-error' => 'Възникна грешка при съхраняване на черновата',
	'tooltip-drafts-save' => 'Съхраняване като чернова',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'drafts' => 'Skice',
	'drafts-desc' => 'Dodaje mogućnost spremanja [[Special:Drafts|draft]] verzija stranice na server',
	'drafts-view' => 'Pogledaj skicu',
	'drafts-view-article' => 'Stranica',
	'drafts-view-existing' => 'Postojeće skice',
	'drafts-view-saved' => 'Spremljeno',
	'drafts-view-discard' => 'Odustani',
	'drafts-view-nonesaved' => 'Trenutno nemate spremljen nijedan draft.',
	'drafts-view-notice' => 'Imate $1 za ovu stranicu.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|skicu|skice|skica}}',
	'drafts-view-warn' => 'Ako napustite ovu stranicu izgubit ćete sve nespremljene izmjene na stranici.
Da li želite da nastavite?',
	'drafts-save' => 'Spremi ovo kao skicu',
	'drafts-save-save' => 'Sačuvaj skicu',
	'drafts-save-saved' => 'Spremljeno',
	'drafts-save-error' => 'Greška pri spremanju skice',
	'tooltip-drafts-save' => 'Spremi kao skicu',
);

/** Czech (Česky)
 * @author Matěj Grabovský
 */
$messages['cs'] = array(
	'drafts' => 'Návrhy',
	'drafts-desc' => 'Přidává možnost uložit na server verzi stránky jako [[Special:Drafts|návrh]]',
	'drafts-view' => 'Zobrazit návrh',
	'drafts-view-article' => 'Stránka',
	'drafts-view-existing' => 'Existující návrhy',
	'drafts-view-saved' => 'Uložené',
	'drafts-view-discard' => 'Smazat',
	'drafts-view-nonesaved' => 'Momentálně nemáte uloženy žádné návrhy.',
	'drafts-view-notice' => 'Máte $1 této stránky',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|návrh|návrhy|návrhů}}',
	'drafts-view-warn' => 'Pokud odejdete z této stránky, ztratíte všechny neuložené změny této stránky. Chcete pokračovat?',
	'drafts-save' => 'Uložit tuto verzi jako návrh',
	'drafts-save-save' => 'Uložit návrh',
	'drafts-save-saved' => 'Uložené',
	'drafts-save-error' => 'Chyba při ukládání návrhu',
	'tooltip-drafts-save' => 'Uložit jako návrh',
);

/** German (Deutsch)
 * @author ChrisiPK
 * @author Pill
 * @author W (aka Wuzur)
 */
$messages['de'] = array(
	'drafts' => 'Zwischengespeicherte Versionen',
	'drafts-desc' => 'Ermöglicht, [[Special:Drafts|zwischengespeicherte Versionen]] auf dem Server zu erstellen',
	'drafts-view' => 'Zwischengespeicherte Version anzeigen',
	'drafts-view-article' => 'Seite',
	'drafts-view-existing' => 'Bestehende zwischengespeicherte Versionen',
	'drafts-view-saved' => 'Gespeichert',
	'drafts-view-discard' => 'Verwerfen',
	'drafts-view-nonesaved' => 'Du hast bisher noch keine zwischengespeicherten Versionen erstellt.',
	'drafts-view-notice' => 'Du hast $1 für diese Seite.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|zwischengespeicherte Version|zwischengespeicherte Versionen}}',
	'drafts-view-warn' => 'Wenn du diese Seite verlässt, gehen alle nichtgespeicherten Änderungen verloren.
Möchtest du dennoch fortfahren?',
	'drafts-save' => 'Diese Version zwischenspeichern',
	'drafts-save-save' => 'Zwischenspeichern',
	'drafts-save-saved' => 'Gespeichert',
	'drafts-save-error' => 'Fehler beim Erstellen der zwischengespeicherten Version',
	'tooltip-drafts-save' => 'Eine zwischengespeicherte Version erstellen',
);

/** German (formal address) (Deutsch (Sie-Form))
 * @author ChrisiPK
 */
$messages['de-formal'] = array(
	'drafts-view-notice' => 'Sie haben $1 für diese Seite.',
);

/** Lower Sorbian (Dolnoserbski)
 * @author Michawiki
 */
$messages['dsb'] = array(
	'drafts' => 'Nacerjenja',
	'drafts-desc' => 'Zmóžna składowanje [[Special:Drafts|nacerjeńskich wersijow]] boka na serwerje',
	'drafts-view' => 'Nacerjenje se woglědaś',
	'drafts-view-article' => 'Bok',
	'drafts-view-existing' => 'Eksistěrujuce nacerjenja',
	'drafts-view-saved' => 'Skłaźony',
	'drafts-view-discard' => 'Zachyśiś',
	'drafts-view-nonesaved' => 'Dotychměst njejsy składł nacerjenja.',
	'drafts-view-notice' => 'Maš $1 za toś ten bok.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|nacerjenje|nacerjeni|nacerjenja|nacerjenjow}}',
	'drafts-view-warn' => 'Gaž spušćaš toś ten bok, zgubijoš wše njeskłaźone změny na toś tom boku.
Coš weto pókšacowaś?',
	'drafts-save' => 'To ako nacerjenje składowaś',
	'drafts-save-save' => 'Nacerjenje składowaś',
	'drafts-save-saved' => 'Skłaźony',
	'drafts-save-error' => 'Zmólka pśi składowanju nacerjenja',
	'tooltip-drafts-save' => 'Ako nacerjenje składowaś',
);

/** Esperanto (Esperanto)
 * @author Melancholie
 * @author Yekrats
 */
$messages['eo'] = array(
	'drafts' => 'Malnetoj',
	'drafts-desc' => 'Permesas la kapablon konservi [[Special:Drafts|malnetajn]] versiojn de paĝo de la servilo',
	'drafts-view' => 'VidiMalneton',
	'drafts-view-article' => 'Paĝo',
	'drafts-view-existing' => 'Ekzistante malnetojn',
	'drafts-view-saved' => 'Konservita',
	'drafts-view-discard' => 'Forĵeti',
	'drafts-view-nonesaved' => 'Vi ne havas iujn malnetojn konservitajn ĉi-momente.',
	'drafts-view-notice' => 'Vi havas $1n por ĉi tiun paĝon.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|malneto|malnetoj}}',
	'drafts-view-warn' => 'Se vi navigus for de ĉi tiu paĝo, vi perdus ĉiun nekonservitajn ŝanĝojn al ĉi tiu paĝo.
Ĉu vi volas fari tiel?',
	'drafts-save' => 'Konservi ĉi tiun kiel malneton',
	'drafts-save-save' => 'Konservi malneton',
	'drafts-save-saved' => 'Konservita',
	'drafts-save-error' => 'Eraro konservante malneton',
	'tooltip-drafts-save' => 'Konservi kiel malneton',
);

/** Spanish (Español)
 * @author Imre
 */
$messages['es'] = array(
	'drafts-view-article' => 'Página',
);

/** Basque (Euskara)
 * @author Kobazulo
 */
$messages['eu'] = array(
	'drafts' => 'Zirriborroak',
	'drafts-view-article' => 'Orrialdea',
	'drafts-view-existing' => 'Dauden zirriborroak',
	'drafts-view-saved' => 'Gordeta',
	'drafts-view-discard' => 'Baztertu',
	'drafts-view-notice' => 'Orrialde honetarako $1 duzu.',
	'drafts-view-notice-link' => '{{PLURAL:$1|Zirriborro $1|$1 zirriborro}}',
	'drafts-save-save' => 'Zirriborroa gorde',
	'drafts-save-saved' => 'Gordeta',
);

/** Finnish (Suomi)
 * @author Crt
 * @author Nike
 * @author Vililikku
 */
$messages['fi'] = array(
	'drafts' => 'Luonnokset',
	'drafts-desc' => 'Lisää mahdollisuuden tallentaa [[Special:Drafts|luonnosversioita]] sivusta palvelimelle.',
	'drafts-view' => 'Katso luonnosta',
	'drafts-view-article' => 'Sivu',
	'drafts-view-existing' => 'Olemassa olevat luonnokset',
	'drafts-view-saved' => 'Tallennettu',
	'drafts-view-discard' => 'Hylkää',
	'drafts-view-nonesaved' => 'Sinulla ei ole yhtään tallennettua luonnosta tällä hetkellä.',
	'drafts-view-notice' => 'Sinulla on $1 tälle sivulle.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|luonnos|luonnosta}}',
	'drafts-view-warn' => 'Jos siirryt pois tältä sivulta, kadotat kaikki tallentamattomat muutokset.
Haluatko jatkaa?',
	'drafts-save' => 'Tallenna nykyinen teksti luonnoksena',
	'drafts-save-save' => 'Tallenna luonnos',
	'drafts-save-saved' => 'Tallennettu',
	'drafts-save-error' => 'Luonnoksen tallentaminen epäonnistui',
	'tooltip-drafts-save' => 'Tallenna luonnoksena',
);

/** French (Français)
 * @author Grondin
 */
$messages['fr'] = array(
	'drafts' => 'Brouillons',
	'drafts-desc' => 'Ajoute la possibilité de sauvegarder les versions « [[Special:Drafts|brouillon]] » d’une page sur le serveur',
	'drafts-view' => 'Voir le brouillon',
	'drafts-view-article' => 'Page',
	'drafts-view-existing' => 'Brouillons existants',
	'drafts-view-saved' => 'Sauvegarder',
	'drafts-view-discard' => 'Abandonner',
	'drafts-view-nonesaved' => 'Vous n’avez pas de brouillon sauvegardé actuellement.',
	'drafts-view-notice' => 'Vous avez $1 pour cette page.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|brouillon|brouillons}}',
	'drafts-view-warn' => 'En navigant en dehors de cette page vous y perdrez toutes les modifications non sauvegardées.',
	'drafts-save' => 'Sauvez ceci comme brouillon',
	'drafts-save-save' => 'Sauvegarder le brouillon',
	'drafts-save-saved' => 'Sauvegardé',
	'drafts-save-error' => 'Erreur de sauvegarde du brouillon',
	'tooltip-drafts-save' => 'Sauvegarder comme brouillon',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'drafts' => 'Borrador',
	'drafts-desc' => 'Engade a habilidade de gardar, no servidor, versións [[Special:Drafts|borrador]] dunha páxina',
	'drafts-view' => 'Ver o borrador',
	'drafts-view-article' => 'Páxina',
	'drafts-view-existing' => 'Borradores existentes',
	'drafts-view-saved' => 'Gardado',
	'drafts-view-discard' => 'Desbotar',
	'drafts-view-nonesaved' => 'Nestes intres non ten gardado ningún borrador.',
	'drafts-view-notice' => 'Ten $1 para esta páxina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|borrador|borradores}}',
	'drafts-view-warn' => 'Se deixa esta páxina perderá todos os cambios que non foron gardados.
Quere continuar?',
	'drafts-save' => 'Gardar isto como un borrador',
	'drafts-save-save' => 'Gardar o borrador',
	'drafts-save-saved' => 'Gardado',
	'drafts-save-error' => 'Produciuse un erro ao gardar o borrador',
	'tooltip-drafts-save' => 'Gardar como un borrador',
);

/** Swiss German (Alemannisch)
 * @author Als-Holder
 */
$messages['gsw'] = array(
	'drafts' => 'Versione im Zwischespycher',
	'drafts-desc' => 'Macht s megli, [[Special:Drafts|zwischegspychereti Versione]] uf em Server aazlege',
	'drafts-view' => 'Version im Zwischespycher aazeige',
	'drafts-view-article' => 'Syte',
	'drafts-view-existing' => 'Versione, wu s im Zwischespycher git',
	'drafts-view-saved' => 'Gspycheret',
	'drafts-view-discard' => 'Furt gheije',
	'drafts-view-nonesaved' => 'Du hesch no kei Versione im Zwischespychere aagleit.',
	'drafts-view-notice' => 'Du hesch $1 fir die Syte.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|Version im Zwischespycher|Versione im Zwischespycher}}',
	'drafts-view-warn' => 'Wänn Du die Syte verlosch, no gehn alli Änderige verlore, wu nit gspycheret sin.
Mechtsch einewäg wytergoh?',
	'drafts-save' => 'Die Version zwischespychere',
	'drafts-save-save' => 'Zwischespychere',
	'drafts-save-saved' => 'Gspycheret',
	'drafts-save-error' => 'Fähler bim Aalege vu dr zwischegspycherete Version',
	'tooltip-drafts-save' => 'E zwischegspychereti Version aalege',
);

/** Hebrew (עברית)
 * @author Rotemliss
 * @author YaronSh
 */
$messages['he'] = array(
	'drafts' => 'טיוטות',
	'drafts-desc' => 'הוספת האפשרות לשמירת גרסאות [[Special:Drafts|טיוטה]] של הדף בשרת',
	'drafts-view' => 'הצגת טיוטה',
	'drafts-view-article' => 'דף',
	'drafts-view-existing' => 'טיוטות קיימות',
	'drafts-view-saved' => 'שמורה',
	'drafts-view-discard' => 'מחיקה',
	'drafts-view-nonesaved' => 'אין לכם טיוטות שמורות לעת עתה.',
	'drafts-view-notice' => 'יש לכם $1 לדף זה.',
	'drafts-view-notice-link' => '{{PLURAL:$1|טיוטה אחת|$1 טיוטות}}',
	'drafts-view-warn' => 'אם תנווטו אל מחוץ לדף, תאבדו את כל השינויים שלא נשמרו לדף זה.
האם ברצונכם להמשיך?',
	'drafts-save' => 'שמירת דף זה כטיוטה',
	'drafts-save-save' => 'שמירת טיוטה',
	'drafts-save-saved' => 'נשמרה',
	'drafts-save-error' => 'שגיאה בשמירת הטיוטה',
	'tooltip-drafts-save' => 'שמירה כטיוטה',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'drafts' => 'Naćiski',
	'drafts-desc' => 'Zmóžnja składowanje [[Special:Drafts|naćiskich wersijow]] strony na serwerje',
	'drafts-view' => 'ViewDraft',
	'drafts-view-article' => 'Strona',
	'drafts-view-existing' => 'Eksistowace naćiski',
	'drafts-view-saved' => 'Składowany',
	'drafts-view-discard' => 'Zaćisnyć',
	'drafts-view-nonesaved' => 'Njejsy dotal žane naćiski składował.',
	'drafts-view-notice' => 'Maš $1 za tutu stronu.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|naćisk|naćiskaj|naćiski|naćiskow}}',
	'drafts-view-warn' => 'Hdyž stronu wopušćiš, zhubiš wšě njeskładowane změny tuteje strony. Chceš najebać toho pokročować?',
	'drafts-save' => 'To jako naćisk składować',
	'drafts-save-save' => 'Naćisk składować',
	'drafts-save-saved' => 'Składowany',
	'drafts-save-error' => 'Zmylk při składowanju naćiska',
	'tooltip-drafts-save' => 'Jako naćisk składować',
);

/** Hungarian (Magyar)
 * @author Bdamokos
 * @author Dani
 */
$messages['hu'] = array(
	'drafts' => 'Piszkozatok',
	'drafts-desc' => 'Lehetővé teszi lapok [[Special:Drafts|piszkozatainak]] elmentését a szerverre',
	'drafts-view' => 'Piszkozatok megtekintése',
	'drafts-view-article' => 'Lap',
	'drafts-view-existing' => 'Elmentett piszkozatok',
	'drafts-view-saved' => 'Elmentve',
	'drafts-view-discard' => 'Elvetés',
	'drafts-view-nonesaved' => 'Jelenleg nincs egyetlen elmentett piszkozatod sem.',
	'drafts-view-notice' => 'Jelenleg $1 van ehhez a laphoz.',
	'drafts-view-notice-link' => '{{PLURAL:$1|egy|$1}} piszkozatod',
	'drafts-view-warn' => 'Ha elmész az oldalról, az összes nem mentett változtatás elvész.
Biztosan folytatod?',
	'drafts-save' => 'Mentés piszkozatként',
	'drafts-save-save' => 'Mentés piszkozatként',
	'drafts-save-saved' => 'Elmentve',
	'drafts-save-error' => 'Hiba történt a piszkozat elmentése közben',
	'tooltip-drafts-save' => 'Mentés piszkozatként',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'drafts' => 'Versiones provisori',
	'drafts-desc' => 'Adde le possibilitate de immagazinar versiones [[Special:Drafts|provisori]] de un pagina in le servitor',
	'drafts-view' => 'ViderVersionProvisori',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Versiones provisori existente',
	'drafts-view-saved' => 'Immagazinate',
	'drafts-view-discard' => 'Abandonar',
	'drafts-view-nonesaved' => 'Tu non ha alcun version provisori immagazinate al momento.',
	'drafts-view-notice' => 'Tu ha $1 pro iste pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|version|versiones}} provisori',
	'drafts-view-warn' => 'Si tu quita iste pagina, tu perdera tote le modificationes non immagazinate de iste pagina.
Continuar?',
	'drafts-save' => 'Immagazinar isto como version provisori',
	'drafts-save-save' => 'Immagazinar version provisori',
	'drafts-save-saved' => 'Immagazinate',
	'drafts-save-error' => 'Error immagazinante le version provisori',
	'tooltip-drafts-save' => 'Immagazinar como version provisori',
);

/** Italian (Italiano)
 * @author Darth Kule
 */
$messages['it'] = array(
	'drafts' => 'Bozze',
	'drafts-desc' => 'Aggiunge la possibilità di salvare versioni di [[Special:Drafts|bozza]] di una pagina sul server',
	'drafts-view' => 'VisualizzaBozza',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Bozze esistenti',
	'drafts-view-saved' => 'Salvata',
	'drafts-view-discard' => 'Cancella',
	'drafts-view-nonesaved' => 'Non hai alcuna bozza salvata al momento.',
	'drafts-view-notice' => 'Hai $1 per questa pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|bozza|bozze}}',
	'drafts-view-warn' => 'Uscendo da questa pagina tutte le modifiche apportate non salvate saranno perse. Si desidera continuare?',
	'drafts-save' => 'Salva come bozza',
	'drafts-save-save' => 'Salva bozza',
	'drafts-save-saved' => 'Salvata',
	'drafts-save-error' => 'Errore nel salvataggio della bozza',
	'tooltip-drafts-save' => 'Salva come bozza',
);

/** Japanese (日本語)
 * @author Fryed-peach
 * @author Hosiryuhosi
 */
$messages['ja'] = array(
	'drafts' => '下書き',
	'drafts-desc' => 'ページの[[Special:Drafts|下書き]]をサーバーに保存できるようにする',
	'drafts-view' => '下書きの閲覧',
	'drafts-view-article' => 'ページ',
	'drafts-view-existing' => '既存の下書き',
	'drafts-view-saved' => '保存済',
	'drafts-view-discard' => '破棄',
	'drafts-view-nonesaved' => 'あなたが現時点で保存している下書きはありません。',
	'drafts-view-notice' => 'あなたはこのページの$1をもっています。',
	'drafts-view-notice-link' => '$1件の下書き',
	'drafts-view-warn' => 'このページから抜けると、あなたがこのページに加えた未保存の変更がすべて失われてしまいます。続けますか？',
	'drafts-save' => 'これを下書きとして保存する',
	'drafts-save-save' => '下書きを保存',
	'drafts-save-saved' => '保存完了',
	'drafts-save-error' => '下書きの保存に失敗',
	'tooltip-drafts-save' => '下書きとして保存する',
);

/** Georgian (ქართული)
 * @author Sopho
 */
$messages['ka'] = array(
	'drafts-view-article' => 'გვერდი',
);

/** Khmer (ភាសាខ្មែរ)
 * @author Thearith
 */
$messages['km'] = array(
	'drafts' => 'ពង្រាង',
	'drafts-desc' => 'បន្ថែម​លទ្ធភាព ដើម្បី​រក្សាទុក​កំណែ [[Special:ពង្រាង|ពង្រាង]] នៃ​ទំព័រ​មួយ​លើ​ម៉ាស៊ីនបម្រើ',
	'drafts-view' => 'មើល​ពង្រាង',
	'drafts-view-article' => 'ទំព័រ',
	'drafts-view-existing' => 'ពង្រាង​ដែល​មាន​ស្រេច',
	'drafts-view-saved' => 'បាន​រក្សាទុក',
	'drafts-view-discard' => 'បោះចោល',
	'drafts-view-nonesaved' => 'អ្នក​មិន​មាន​ពង្រាង​ណាមួយ​ត្រូវ​បាន​រក្សាទុក​នាពេលនេះ​ទេ​។',
	'drafts-view-notice' => 'អ្នក​មាន $1 សម្រាប់​ទំព័រ​នេះ​។',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|ពង្រាង|ពង្រាង}}',
	'drafts-save' => 'រក្សាទុក​ជា​ពង្រាង',
	'drafts-save-save' => 'រក្សាទុក​ពង្រាង',
	'drafts-save-saved' => 'បាន​រក្សាទុក',
	'drafts-save-error' => 'កំហុស​រក្សាទុក​ពង្រាង',
	'tooltip-drafts-save' => 'រក្សាទុក​ជា​ពង្រាង',
);

/** Korean (한국어)
 * @author Klutzy
 * @author Kwj2772
 */
$messages['ko'] = array(
	'drafts' => '임시 저장된 문서 목록',
	'drafts-desc' => '작업중인 문서를 [[Special:Drafts|임시적으로 저장]]하는 기능입니다.',
	'drafts-view' => '초고 보기',
	'drafts-view-article' => '문서',
	'drafts-view-existing' => '임시 저장된 문서 목록',
	'drafts-view-saved' => '저장된 시간',
	'drafts-view-discard' => '삭제',
	'drafts-view-nonesaved' => '임시 저장한 문서가 없습니다.',
	'drafts-view-notice' => '당신은 이 문서에 $1를 갖고 있습니다.',
	'drafts-view-notice-link' => '$1개의 초고',
	'drafts-view-warn' => '다른 문서를 둘러보면, 당신은 저장하지 않은 모든 편집이 사라질 것입니다.
계속하시곘습니까?',
	'drafts-save' => '이 편집을 초안으로 저장',
	'drafts-save-save' => '임시 저장',
	'drafts-save-saved' => '저장됨',
	'drafts-save-error' => '임시 저장 중 오류 발생',
	'tooltip-drafts-save' => '초안으로 저장하기',
);

/** Ripoarisch (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'drafts' => 'Äntwörf',
	'drafts-desc' => 'Deit de Müjjeleschkeit dobei, en [[Special:Drafts|Entworf]] fun en Sigg om Server affzelääje.',
	'drafts-view' => 'Äntworf zeije',
	'drafts-view-article' => 'Sigg',
	'drafts-view-existing' => 'Jespeicherte Äntwörf',
	'drafts-view-saved' => 'Jespeichert',
	'drafts-view-discard' => 'Schmiiß fott!',
	'drafts-view-nonesaved' => 'Do häß jrad kein Äntwörf jespeichert.',
	'drafts-view-notice' => 'Do häß $1 för heh di Sigg.',
	'drafts-view-notice-link' => '{{PLURAL:$1|eine Entworf|$1 Äntwörf|keine Entworf}}',
	'drafts-view-warn' => 'Wann De heh vun dä Sigg fott jeihß, dann sen all Ding Ennjabe fott, di De noch nit avjespeicht häß.
Wellß De wigger maaache?',
	'drafts-save' => 'Wat mer heh süht als_ennen Entworf avspeichere',
	'drafts-save-save' => 'Entworf avspeichere',
	'drafts-save-saved' => 'Avjespeichert',
	'drafts-save-error' => 'Bemm Entworf Speichere es jet donevve jejange, dat hät nit jeflupp.',
	'tooltip-drafts-save' => 'Als ene Entworf avspeichere',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'drafts' => 'Brouillonen',
	'drafts-desc' => 'Erlaabt et Versioune vun enger Säit als [[Special:Drafts|Brouillon]] op dem Server ze späicheren',
	'drafts-view' => 'Brouillon weisen',
	'drafts-view-article' => 'Säit',
	'drafts-view-existing' => 'Brouillonen déi et gëtt',
	'drafts-view-saved' => 'Gespäichert',
	'drafts-view-discard' => 'Verwerfen',
	'drafts-view-nonesaved' => 'Dir hutt elo keng Brouillone gespäichert.',
	'drafts-view-notice' => 'Dir hutt $1 fir dës Säit.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|Brouillon|Brouillone}}',
	'drafts-view-warn' => 'Wann Dir vun dëser Säit weidersurft da verléiert Dir all netgespäichert ännerungen vun dëser Säit.',
	'drafts-save' => 'Dës als Brouillon späicheren',
	'drafts-save-save' => 'Brouillon späicheren',
	'drafts-save-saved' => 'Gespäichert',
	'drafts-save-error' => 'Feller beim späicher vum Brouillon',
	'tooltip-drafts-save' => 'Als Brouillon späicheren',
);

/** Limburgish (Limburgs)
 * @author Remember the dot
 */
$messages['li'] = array(
	'drafts-view-article' => 'Pazjena',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'drafts' => 'Werkversies',
	'drafts-desc' => 'Voegt functionaliteit toe om [[Special:Drafts|werkversies]] van een pagina op de server op te slaan',
	'drafts-view' => 'WerkversieBekijken',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Bestaande werkversies',
	'drafts-view-saved' => 'Opgeslagen',
	'drafts-view-discard' => 'Verwijderen',
	'drafts-view-nonesaved' => 'U hebt geen opgeslagen werkversies.',
	'drafts-view-notice' => 'U moet $1 voor deze pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|werkversie|werkversies}}',
	'drafts-view-warn' => 'Door van deze pagina weg te navigeren verliest u alle wijzigingen die u nog niet hebt opgeslagen.
Wilt u doorgaan?',
	'drafts-save' => 'Opslaan als werkversie',
	'drafts-save-save' => 'Werkversie opslaan',
	'drafts-save-saved' => 'Opgeslagen',
	'drafts-save-error' => 'Fout bij het opslaan van de werkversie',
	'tooltip-drafts-save' => 'Als werkversie opslaan',
);

/** Norwegian Nynorsk (‪Norsk (nynorsk)‬)
 * @author Harald Khan
 */
$messages['nn'] = array(
	'drafts' => 'Utkast',
	'drafts-desc' => 'Gjer det mogleg å lagra [[Special:Drafts|utkastsversjonar]] av ei sida på tenaren',
	'drafts-view' => 'Syna utkast',
	'drafts-view-article' => 'Sida',
	'drafts-view-existing' => 'Eksisterande utkast',
	'drafts-view-saved' => 'Lagra',
	'drafts-view-discard' => 'Vrak',
	'drafts-view-nonesaved' => 'Du har ingen lagra  utkast på noverande tidspunkt.',
	'drafts-view-notice' => 'Du har $1 for denne sida.',
	'drafts-view-notice-link' => '{{PLURAL:$1|eitt utkast|$1 utkast}}',
	'drafts-view-warn' => 'Ved å navigera vekk frå denne sida vil du missa alle endringar på sida som ikkje er lagra.
Vil du halda fram?',
	'drafts-save' => 'Lagra dette som eit utkast',
	'drafts-save-save' => 'Lagra utkast',
	'drafts-save-saved' => 'Lagra',
	'drafts-save-error' => 'Det oppstod ein feil under lagring av utkast',
	'tooltip-drafts-save' => 'Lagra som utkast',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Laaknor
 */
$messages['no'] = array(
	'drafts' => 'Kladder',
	'drafts-desc' => 'Legger til muligheten til å lagre [[Special:Drafts|utkast]]versjoner av en side på serveren',
	'drafts-view' => 'Vis utkast',
	'drafts-view-article' => 'Side',
	'drafts-view-existing' => 'Eksisterende utkast',
	'drafts-view-saved' => 'Lagret',
	'drafts-view-discard' => 'Forkast',
	'drafts-view-nonesaved' => 'Du har ingen utkast lagret på nåværende tidspunkt',
	'drafts-view-notice' => 'Du har $1 for denne siden.',
	'drafts-view-notice-link' => '{{PLURAL:$1|ett utkast|$1 utkast}}',
	'drafts-view-warn' => 'Ved å navigere vekk fra denne siden vil du miste alle ulagrede endringer til denne siden.
Vil du fortsette?',
	'drafts-save' => 'Lagre dette som et utkast',
	'drafts-save-save' => 'Lagre utkast',
	'drafts-save-saved' => 'Lagret',
	'drafts-save-error' => 'Feil ved lagring av utkast',
	'tooltip-drafts-save' => 'Lagre som et utkast',
);

/** Occitan (Occitan)
 * @author Cedric31
 */
$messages['oc'] = array(
	'drafts' => 'Borrolhons',
	'drafts-desc' => 'Apond la possibilitat de salvar las versions « [[Special:Drafts|borrolhon]] » d’una pagina sul servidor',
	'drafts-view' => 'Veire lo borrolhon',
	'drafts-view-article' => 'Pagina',
	'drafts-view-existing' => 'Borrolhons existents',
	'drafts-view-saved' => 'Salvar',
	'drafts-view-discard' => 'Abandonar',
	'drafts-view-nonesaved' => 'Avètz pas de borrolhon salvat actualament.',
	'drafts-view-notice' => 'Avètz $1 per aquesta pagina.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|borrolhon|borrolhons}}',
	'drafts-view-warn' => "En navigant en defòra d'aquesta pagina i perdretz totes los cambiaments pas salvats.",
	'drafts-save' => 'Salvatz aquò coma borrolhon',
	'drafts-save-save' => 'Salvar lo borrolhon',
	'drafts-save-saved' => 'Salvat',
	'drafts-save-error' => 'Error de salvament del borrolhon',
	'tooltip-drafts-save' => 'Salvar coma borrolhon',
);

/** Polish (Polski)
 * @author Derbeth
 * @author Leinad
 * @author Sp5uhe
 */
$messages['pl'] = array(
	'drafts' => 'Szkice',
	'drafts-desc' => 'Dodaje możliwość zapisywania [[Special:Drafts|szkicu]] strony na serwerze',
	'drafts-view' => 'Zobacz szkic',
	'drafts-view-article' => 'Strona',
	'drafts-view-existing' => 'Istniejące szkice',
	'drafts-view-saved' => 'Zapisane',
	'drafts-view-discard' => 'Usuń',
	'drafts-view-nonesaved' => 'Nie masz obecnie zapisanych żadnych szkiców.',
	'drafts-view-notice' => 'Posiadasz $1 dla tej strony.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|szkic|szkice|szkiców}}',
	'drafts-view-warn' => 'Opuszczenie tej strony spowoduje utratę wszystkich niezapisanych zmian na tej stronie. 
Czy chcesz kontynuować?',
	'drafts-save' => 'Zapisz to jako szkic',
	'drafts-save-save' => 'Zapisz szkic',
	'drafts-save-saved' => 'Zapisany',
	'drafts-save-error' => 'Błąd zapisywania szkicu',
	'tooltip-drafts-save' => 'Zapisz jako szkic',
);

/** Portuguese (Português)
 * @author Malafaya
 */
$messages['pt'] = array(
	'drafts' => 'Rascunhos',
	'drafts-desc' => 'Adiciona a possibilidade de gravar versões [[Special:Drafts|rascunho]] de uma página no servidor',
	'drafts-view' => 'Ver Rascunho',
	'drafts-view-article' => 'Página',
	'drafts-view-existing' => 'Rascunhos existentes',
	'drafts-view-saved' => 'Gravado',
	'drafts-view-discard' => 'Descartar',
	'drafts-view-nonesaved' => 'Não tem neste momento quaisquer rascunhos gravados.',
	'drafts-view-notice' => 'Você tem $1 para esta página.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|rascunho|rascunhos}}',
	'drafts-view-warn' => 'Se navegar para fora desta página, perderá todas as alterações por gravar desta página.
Pretende continuar?',
	'drafts-save' => 'Gravar isto como rascunho',
	'drafts-save-save' => 'Gravar rascunho',
	'drafts-save-saved' => 'Gravado',
	'drafts-save-error' => 'Erro a gravar rascunho',
	'tooltip-drafts-save' => 'Gravar como rascunho',
);

/** Romanian (Română)
 * @author KlaudiuMihaila
 */
$messages['ro'] = array(
	'drafts-view-article' => 'Pagină',
);

/** Russian (Русский)
 * @author Ferrer
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'drafts' => 'Черновики',
	'drafts-desc' => 'Добавляет возможность сохранять [[Special:Drafts|черновики]] страниц на сервере',
	'drafts-view' => 'ПросмотрЧерновика',
	'drafts-view-article' => 'Страница',
	'drafts-view-existing' => 'Действующие черновики',
	'drafts-view-saved' => 'Сохранено',
	'drafts-view-discard' => 'Отменено',
	'drafts-view-nonesaved' => 'В настоящее время у вас нет сохранённых черновиков.',
	'drafts-view-notice' => 'У вас $1 этой страницы.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|черновик|черновика|черновиков}}',
	'drafts-view-warn' => 'Уходя с этой страницы вы потеряете все несохранённые изменения.
Вы желаете продолжить?',
	'drafts-save' => 'Сохранить это как черновик',
	'drafts-save-save' => 'Сохранить черновик',
	'drafts-save-saved' => 'Сохранено',
	'drafts-save-error' => 'Ошибка сохранения черновика',
	'tooltip-drafts-save' => 'Сохранить как черновик',
);

/** Slovak (Slovenčina)
 * @author Helix84
 */
$messages['sk'] = array(
	'drafts' => 'Návrhy',
	'drafts-desc' => 'Pridáva možnosť uložiť na server verzie stránky ako [[Special:Drafts|návrhy]]',
	'drafts-view' => 'ZobraziťNávrh',
	'drafts-view-article' => 'Stránka',
	'drafts-view-existing' => 'Existujúce návrhy',
	'drafts-view-saved' => 'Uložené',
	'drafts-view-discard' => 'Zmazať',
	'drafts-view-nonesaved' => 'Momentálne nemáte uložené žiadne návrhy.',
	'drafts-view-notice' => 'Máte $1 tejto stránky.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|návrh|návrhy|návrhov}}',
	'drafts-view-warn' => 'Ak odídete z tejto stránky, stratíte všetky neuložené zmeny tejto stránky. Chcete pokračovať?',
	'drafts-save' => 'Uložiť túto verziu ako návrh',
	'drafts-save-save' => 'Uložiť návrh',
	'drafts-save-saved' => 'Uložené',
	'drafts-save-error' => 'Chyba pri ukladaní návrhu',
	'tooltip-drafts-save' => 'Uložiť ako návrh',
);

/** Swedish (Svenska)
 * @author Boivie
 * @author Najami
 */
$messages['sv'] = array(
	'drafts' => 'Utkast',
	'drafts-desc' => 'Möjliggör att kunna spara [[Special:Drafts|utkastsversioner]] av en sida på servern',
	'drafts-view' => 'Visa utkast',
	'drafts-view-article' => 'Sida',
	'drafts-view-existing' => 'Existerande utkast',
	'drafts-view-saved' => 'Sparad',
	'drafts-view-discard' => 'Förkasta',
	'drafts-view-nonesaved' => 'Du har inga utkast sparade just nu.',
	'drafts-view-notice' => 'Du har $1 för denna sida.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|utkast|utkast}}',
	'drafts-view-warn' => 'Genom att navigera bort från denna sida kommer du förlora alla osparade ändringar för denna sida.
Vill du fortsätta?',
	'drafts-save' => 'Spara detta som ett utkast',
	'drafts-save-save' => 'Spara utkast',
	'drafts-save-saved' => 'Sparad',
	'drafts-save-error' => 'Fel vid sparande av utkast',
	'tooltip-drafts-save' => 'Spara som ett utkast',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'drafts-view-article' => 'పేజీ',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'drafts' => 'Mga balangkas',
	'drafts-desc' => 'Nagdaragdag ng kakayahang makapagsagip ng mga bersyon [[Special:Drafts|ng balangkas]] ng isang pahina sa loob ng serbidor',
	'drafts-view' => 'TingnanBalangkas',
	'drafts-view-article' => 'Pahina',
	'drafts-view-existing' => 'Umiiral na mga balangkas',
	'drafts-view-saved' => 'Nasagip na',
	'drafts-view-discard' => 'Itapon (ibasura)',
	'drafts-view-nonesaved' => 'Wala kang nakasagip na kahit na anong mga balangkas sa ngayon.',
	'drafts-view-notice' => 'Mayroon kang $1 para sa pahinang ito.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|balangkas|mga balangkas}}',
	'drafts-view-warn' => 'Sa pamamagitan ng paglalayag papalayo mula sa pahinang ito, mawawala ang lahat ng hindi nakasagip na mga pagbabago mo para sa pahinang ito.
Nais mo bang magpatuloy?',
	'drafts-save' => 'Sagipin ito bilang isang balangkas',
	'drafts-save-save' => 'Sagipin ang balangkas',
	'drafts-save-saved' => 'Nasagip na',
	'drafts-save-error' => 'May kamalian sa pagsasagip ng balangkas',
	'tooltip-drafts-save' => 'Sinagip bilang isang balangkas',
);

/** Turkish (Türkçe)
 * @author Joseph
 */
$messages['tr'] = array(
	'drafts' => 'Taslaklar',
	'drafts-desc' => 'Bir sayfanın [[Special:Drafts|taslak]] sürümünü sunucuya kaydetme özelliğini ekler',
	'drafts-view' => 'TaslağıGör',
	'drafts-view-article' => 'Sayfa',
	'drafts-view-existing' => 'Mevcut taslaklar',
	'drafts-view-saved' => 'Kaydedildi',
	'drafts-view-discard' => 'Sil',
	'drafts-view-nonesaved' => 'Şu anda kayıtlı hiçbir taslağınız yok.',
	'drafts-view-notice' => 'Bu sayfa için $1 var.',
	'drafts-view-notice-link' => '$1 {{PLURAL:$1|taslağınız|taslağınız}}',
	'drafts-view-warn' => 'Bu sayfadan ayrılarak, sayfadaki tüm kaydedilmemiş değişiklikleri kaybedeceksiniz.
Devam etmek istiyor musunuz?',
	'drafts-save' => 'Bunu taslak olarak kaydet',
	'drafts-save-save' => 'Taslağı kaydet',
	'drafts-save-saved' => 'Kaydedildi',
	'drafts-save-error' => 'Taslağı kaydederken hata',
	'tooltip-drafts-save' => 'Taslak olarak kaydet',
);

/** Simplified Chinese (‪中文(简体)‬)
 * @author Gzdavidwong
 * @author Wmr89502270
 */
$messages['zh-hans'] = array(
	'drafts' => '草稿',
	'drafts-view' => '查看草稿',
	'drafts-view-article' => '页面',
	'drafts-view-existing' => '现有草稿',
	'drafts-view-saved' => '已保存',
	'drafts-view-discard' => '舍弃',
	'drafts-view-nonesaved' => '您还没有任何已保存的草稿。',
	'drafts-save' => '把此页面以草稿形式保存',
	'drafts-save-save' => '保存草稿',
	'drafts-save-saved' => '已保存',
	'drafts-save-error' => '保存草稿时发生错误',
	'tooltip-drafts-save' => '以草稿形式保存',
);

/** Traditional Chinese (‪中文(繁體)‬)
 * @author Gzdavidwong
 * @author Wrightbus
 */
$messages['zh-hant'] = array(
	'drafts' => '草稿',
	'drafts-view-article' => '頁面',
	'drafts-view-existing' => '現有草稿',
	'drafts-view-saved' => '已儲存',
	'drafts-view-discard' => '捨棄',
	'drafts-save' => '把此頁面以草稿形式儲存',
	'drafts-save-save' => '儲存草稿',
	'drafts-save-saved' => '已儲存',
	'drafts-save-error' => '儲存草稿時發生錯誤',
	'tooltip-drafts-save' => '以草稿形式儲存',
);

