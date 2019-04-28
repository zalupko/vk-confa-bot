<?php
use Bot\ORM\DB;
use Bot\ORM\Tables\Options;
use Bot\ORM\Tables\Ratings;
use Bot\ORM\Tables\Responses;
use Bot\Orm\Tables\Smiles;
use Bot\ORM\Tables\User;
require_once('bot/tools/autoloader.php');
// TODO: add Ratings info
//region Installing Options
$options = DB::table(Options::class);
$options->create();
$optionsData = array(
    Options::OPTION_NAME => 'BOT_VERSION',
    Options::OPTION_VALUE => '0'
);
$options->add($optionsData);
//endregion
//region Installing Users
$users = DB::table(User::class);
$users->create();
//endregion
//region Installing Smiles
$smiles = DB::table(Smiles::class);
$smiles->create();
$smilesData = array(
    //region Smiles
    array(
        Smiles::SMILE_NAME => ':пох:',
        Smiles::SMILE_PATH => 'photo-180945331_456239031',
    ),
    array(
        Smiles::SMILE_NAME => ':вкурсе:',
        Smiles::SMILE_PATH => 'photo-180945331_456239032',
    ),
    array(
        Smiles::SMILE_NAME => ':скибидливо:',
        Smiles::SMILE_PATH => 'photo-180945331_456239033',
    ),
    array(
        Smiles::SMILE_NAME => ':нокомент:',
        Smiles::SMILE_PATH => 'photo-180945331_456239034',
    ),
    array(
        Smiles::SMILE_NAME => ':скибиди:',
        Smiles::SMILE_PATH => 'photo-180945331_456239035',
    ),
    array(
        Smiles::SMILE_NAME => ':матюша:',
        Smiles::SMILE_PATH => 'photo-180945331_456239036',
    ),
    array(
        Smiles::SMILE_NAME => ':тохик:',
        Smiles::SMILE_PATH => 'photo-180945331_456239037',
    ),
    array(
        Smiles::SMILE_NAME => ':едем:',
        Smiles::SMILE_PATH => 'photo-180945331_456239038',
    ),
    array(
        Smiles::SMILE_NAME => ':свидомит:',
        Smiles::SMILE_PATH => 'photo-180945331_456239039',
    ),
    array(
        Smiles::SMILE_NAME => ':э:',
        Smiles::SMILE_PATH => 'photo-180945331_456239040',
    ),
    array(
        Smiles::SMILE_NAME => ':серя:',
        Smiles::SMILE_PATH => 'photo-180945331_456239041',
    ),
    array(
        Smiles::SMILE_NAME => ':подробнее:',
        Smiles::SMILE_PATH => 'photo-180945331_456239042',
    ),
    array(
        Smiles::SMILE_NAME => ':нытик:',
        Smiles::SMILE_PATH => 'photo-180945331_456239043',
    ),
    array(
        Smiles::SMILE_NAME => ':серун:',
        Smiles::SMILE_PATH => 'photo-180945331_456239044',
    ),
    array(
        Smiles::SMILE_NAME => ':никто:',
        Smiles::SMILE_PATH => 'photo-180945331_456239045',
    ),
    array(
        Smiles::SMILE_NAME => ':приколюха:',
        Smiles::SMILE_PATH => 'photo-180945331_456239046',
    ),
    array(
        Smiles::SMILE_NAME => ':оа:',
        Smiles::SMILE_PATH => 'photo-180945331_456239047',
    ),
    array(
        Smiles::SMILE_NAME => ':постирония:',
        Smiles::SMILE_PATH => 'photo-180945331_456239048',
    ),
    array(
        Smiles::SMILE_NAME => ':о:',
        Smiles::SMILE_PATH => 'photo-180945331_456239049',
    ),
    array(
        Smiles::SMILE_NAME => ':ркн:',
        Smiles::SMILE_PATH => 'photo-180945331_456239050',
    ),
    array(
        Smiles::SMILE_NAME => ':постирай:',
        Smiles::SMILE_PATH => 'photo-180945331_456239051',
    ),
    array(
        Smiles::SMILE_NAME => ':смайл:',
        Smiles::SMILE_PATH => 'photo-180945331_456239052',
    ),
    array(
        Smiles::SMILE_NAME => ':бан:',
        Smiles::SMILE_PATH => 'photo-180945331_456239053',
    ),
    array(
        Smiles::SMILE_NAME => ':увожение:',
        Smiles::SMILE_PATH => 'photo-180945331_456239054',
    ),
    array(
        Smiles::SMILE_NAME => ':говно:',
        Smiles::SMILE_PATH => 'photo-180945331_456239055',
    ),
    array(
        Smiles::SMILE_NAME => ':рип:',
        Smiles::SMILE_PATH => 'photo-180945331_456239056',
    ),
    array(
        Smiles::SMILE_NAME => ':пиздануть:',
        Smiles::SMILE_PATH => 'photo-180945331_456239057',
    ),
    array(
        Smiles::SMILE_NAME => ':шут:',
        Smiles::SMILE_PATH => 'photo-180945331_456239058',
    ),
    array(
        Smiles::SMILE_NAME => ':шут2:',
        Smiles::SMILE_PATH => 'photo-180945331_456239059',
    ),
    array(
        Smiles::SMILE_NAME => ':jukwow:',
        Smiles::SMILE_PATH => 'photo-180945331_456239060',
    ),
    array(
        Smiles::SMILE_NAME => ':mafacemasol:',
        Smiles::SMILE_PATH => 'photo-180945331_456239061',
    ),
    array(
        Smiles::SMILE_NAME => ':goblinnoice:',
        Smiles::SMILE_PATH => 'photo-180945331_456239062',
    ),
    array(
        Smiles::SMILE_NAME => ':communisticsreaming:',
        Smiles::SMILE_PATH => 'photo-180945331_456239063',
    ),
    array(
        Smiles::SMILE_NAME => ':horrorgadza:',
        Smiles::SMILE_PATH => 'photo-180945331_456239064',
    ),
    array(
        Smiles::SMILE_NAME => ':ohmy:',
        Smiles::SMILE_PATH => 'photo-180945331_456239065',
    ),
    array(
        Smiles::SMILE_NAME => ':gooslya:',
        Smiles::SMILE_PATH => 'photo-180945331_456239066',
    ),
    array(
        Smiles::SMILE_NAME => ':hereicome:',
        Smiles::SMILE_PATH => 'photo-180945331_456239067',
    ),
    array(
        Smiles::SMILE_NAME => ':soundofyoura:',
        Smiles::SMILE_PATH => 'photo-180945331_456239068',
    ),
    array(
        Smiles::SMILE_NAME => ':goblinha:',
        Smiles::SMILE_PATH => 'photo-180945331_456239070',
    ),
    array(
        Smiles::SMILE_NAME => ':goblintea:',
        Smiles::SMILE_PATH => 'photo-180945331_456239071',
    ),
    array(
        Smiles::SMILE_NAME => ':necrorofl:',
        Smiles::SMILE_PATH => 'photo-180945331_456239072',
    ),
    array(
        Smiles::SMILE_NAME => ':vashezdorovie:',
        Smiles::SMILE_PATH => 'photo-180945331_456239073',
    ),
    array(
        Smiles::SMILE_NAME => ':pgg:',
        Smiles::SMILE_PATH => 'photo-180945331_456239074',
    ),
    array(
        Smiles::SMILE_NAME => ':old:',
        Smiles::SMILE_PATH => 'photo-180945331_456239075',
    ),
    array(
        Smiles::SMILE_NAME => ':чай:',
        Smiles::SMILE_PATH => 'photo-180945331_456239078',
    ),
    array(
        Smiles::SMILE_NAME => ':дотасбор:',
        Smiles::SMILE_PATH => 'photo-180945331_456239079',
    ),
    //endregion
);
foreach ($smilesData as $item) {
    $smiles->add($item);
}
//endregion
//region Installing Responses
$responses = DB::table(Responses::class);
$responses->create();
$responseData = array(
    //region Scythe responses
    array(
        Responses::RESPONSE_TYPE => 'SCYTHE_LOST',
        Responses::RESPONSE_CONTEXT => 'Коса #attacker# отправляет в могилу #defender#.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'SCYTHE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# покупает шиву против #defender#. Штаны в говне.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'SCYTHE_SELF',
        Responses::RESPONSE_CONTEXT => 'Не туда воюешь, долбоеб на #attacker#'
    ),
    //endregion
    //region AFK responses
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Ой, ребята, вот что хотел спросить'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Гага Тленин чмоха, согласны?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Так, стоп, у антимага аганим?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'А это что, БАЛАНАР ЛЕТАЕТ???'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Не ну это, можно я защитпостю?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Каво'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Если вас назвали Саша - хуй сосать работа ваша! Гагагага'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Пажилое присутсвие в здании ? А хуя высаси пажилая шушера!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'ГАГАГАГАГАГАГ, ой, простите, шиза напала.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'ДА НЕ ШИЗИК Я!!!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'А вы знали, что хохлы не люди?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Узнали? Нет, ну узнали? А вот еще что, узнали?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Гагага опять свои битриксы делаете.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Да у меня комп 100+ фпс в доте на ультрах. Да ёп, 75 градусов'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Пидарасы, вы суки'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Ой, а у хахла то жопа порвалась'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Ех, щас бы на линхуйсе битрикс попограмировать...'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'ДА НЕ НИЩУК Я! Н Е  Б О М Б И Т !'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Не, ну а че, гачи-бота может быть добавить???!!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Да сука, кнопачка не нажалсь!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Хех, ну Стас и чмо!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => ''
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Матюша в рот пердюша, гагагага'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Сначала классика, потом 69.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Нет, ну вы в курсе? СТАДИОН СМЫЛО!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Мурижечку жалко...'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Краснобай тупа сдал гагагага'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Чего уставился? никогда хуйла не видел?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'розы гибнут на газонах пирожки на красных зонах фарту масти матери по пасти смерть матерям свободу мусорам'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Юрий "Зверев" (Зверев Юрий "Не называйте меня Юрий Зеверев") Зверев оказался шизиком, держу в курсе'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Давно тебя не было в уличных гонках! Заходи!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Антон Мурыгин установил игру Тюряга. Москва открыта!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Если ты вдруг подумаешь, что ты лох, вспомни, что у мурыги 6 швов на сраке'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Эй, Ержан, э, вставай, заебал бля, яе спишь? на работу пора!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'AFK',
        Responses::RESPONSE_CONTEXT => 'Да не бомбит у меня?'
    ),
    //endregion
    //region Battle responses
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_LOST',
        Responses::RESPONSE_CONTEXT => '#attacker# вызвал на катачку #defender#, но раскачавшись по методу Юрца жидко обсерися как денди на любом инте. '
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_LOST',
        Responses::RESPONSE_CONTEXT => '#attacker# захотел cразиться на паджиках в высере 2 с #defender#, однако забыл где находится кнопачкy и опозорился перед всей конфой. Браво, даун!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_LOST',
        Responses::RESPONSE_CONTEXT => '#attacker# почувствовал себя топ емемер и решил опустить #defender#, но #defender# подрубил кнопочку разъебав опущенного по миду.'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_LOST',
        Responses::RESPONSE_CONTEXT => '#attacker# посмотрев гайд метагейма на снайпера решил бросить вызов #defender#, но столкнувшись с жестокой реальностью дабнул ебалом в асфальт. Победитель по жизни!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_LOST',
        Responses::RESPONSE_CONTEXT => '#attacker# вызвал #defender# на бой, но бой произошел с его губой гагага. Висаси!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# посмотрев гайд метагейма на паджика вызвал #defender# 1 на 1 и обоссал лалку, грац, даун!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# собрал всю свою мощь украинской продоты и обоссал в неравном бою #defender#. СЛАВА УКРАИНЕ!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# вызвал #defender# пакатать в гавно 2 и унизил опущенка. Ну что, #attacker#, мать проверял после этого?'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# решил катануть против #defender# и не прогадал, ведь 15 фепеес придало уверенности победе #attacker#. Ну и что ? Зато линукс не логает'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_WON',
        Responses::RESPONSE_CONTEXT => '#attacker# выиграв емемеры решил вызвать #defender# на бой. Сосать #defender#, Украина домой!'
    ),
    array(
        Responses::RESPONSE_TYPE => 'BATTLE_SELF',
        Responses::RESPONSE_CONTEXT => '#attacker# завел кастомку и отлично провел время.'
    )
    //endregion
);
foreach ($responseData as $item) {
    $responses->add($item);
}
//endregion
//region Installing Ratings
$ratings = DB::table(Ratings::class);
$ratings->create();
//endregion


