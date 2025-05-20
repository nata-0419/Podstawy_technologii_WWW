<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>szczególy bajki</title>
</head>
<body>
    
    <?php
    $id = $_GET['id'];
    switch ($id) {
        
        case 1:
            $tytul = "Shrek 1";
            $informacje = "W bagnie żył olbrzym Shrek, którego cenna samotność została nagle zakłócona inwazją dokuczliwych postaci z bajek. Ślepe myszki buszują w zapasach olbrzyma, zły wilk sypia w jego łóżku, a trzy świnki buszują po jego samotni. Wszystkie te postaci zostały wypędzone ze swego królestwa przez złego Lorda Farquaada.
                        Zdecydowany ocalić ich dom - nie mówiąc już o swoim - Shrek porozumiewa się z Farquaadem i wyrusza na ratunek pięknej księżniczce Fionie, która ma zostać żoną Lorda. W misji towarzyszy mu przemądrzały Osioł, który zrobi dla Shreka wszystko z wyjątkiem... przestania mielenia ozorem. Ocalenie księżniczki przed ziejącym ogniem smokiem okazuje się być najmniejszym problemem przyjaciół, kiedy to zostaje odkryty głęboko skrywany, mroczny sekret Fiony.";
            $zdjecie = "1.webp";
            break;

        case 2:
            $tytul = "Shrek 2";
            $informacje = "Po powrocie z miesiąca miodowego Shrek i Fiona postanawiają odwiedzić rodziców księżniczki, do których dotarła jedynie wiadomość o ślubie ich córki z prawdziwą miłością jej życia. Młoda para rusza więc do królestwa Zasiedmiogórogrodu. Problem jednak w tym, że rodzice Fiony w ogóle nie zdają sobie sprawy z ciążącej na niej klątwy. W związku z tym są pewni, iż poślubiła ona kogoś z wyższych sfer, kawalera pokroju Lorda Farquaada - władcy rządzącego zasobnym państwem. Jakież więc jest zdziwienie, kiedy ich zięć okazuje się ważącym ponad 300 kilogramów zielonym ogrem nie przywiązującym wagi do higieny, któremu w dodatku towarzyszy gadający osioł. ";
            $zdjecie = " 2.webp";
            break;

        case 3:
            $tytul = "Shrek 3";
            $informacje = "Historii zielonego ogra ciąg dalszy. Ojciec Fiony zaakceptował ostatecznie swojego zięcia, zdecydował nawet, że Shrek i Fiona mają pełnić obowiązki panującej pary królewskiej. Oboje nie czują jednak się w tej roli najlepiej, a Shrek z miłą chęcią wróciłby na swoje bagno. Król postanawia więc, że jeśli odnajdą następcę tronu, który obejmie rządy i godnie ich zastąpi, będą mogli opuścić królestwo i żyć własnym życiem. Odpowiednim kandydatem na króla jest siostrzeniec królowej Lilian, książę Artie. Shrek wyrusza, razem ze swoimi wiernymi druhami: Osiołkiem i Kotem w butach, w daleką podróż, aby odnaleźć i przekonać zbuntowanego Artiego, że powinien zasiąść na tronie. Tymczasem, podczas nieobecności Shreka w królestwie, Książę z bajki przeprowadza zamach stanu. Fiona organizuje ruch oporu, który ma przeciwstawić się uzurpatorowi do czasu, aż Shrek, Osiołek, Kot w butach i przyszły król Artur powrócą z podróży.";
            $zdjecie = "3.webp ";
            break;
        
        case 4:
            $tytul = "Shrek forever";
            $informacje = "Czym zajmują się ogry, kiedy już rozprawią się ze straszliwym smokiem, poślubią piękną królewnę i ocalą królestwo teścia? Shrek został pantoflarzem. Małorolni nie uciekają już przed nim z krzykiem. Dziś proszą, żeby podpisał im się na widłach. Tęskniąc za czasami, kiedy 'żył jak na ogra przystało', Shrek nieopatrznie zawiera pakt z podstępnym Rumplesnickim i ląduje w rządzonej przez niego, spaczonej, alternatywnej wersji Zasiedmiogórogrodu. Tu na ogry się poluje, a Shrek i Fiona nigdy się nie spotkali. Czy Shrekowi uda się odwrócić zaklęcie, uratować przyjaciół i odzyskać ukochaną?";
            $zdjecie = " 4.webp";
            break;
        }   

    ?>
        <h2><?php echo $tytul; ?></h2>
        <h4>Informacje o filmie</h4>
        <p><?php echo $informacje; ?></p>
        <img src="<?php echo $zdjecie; ?>" alt="<?php echo $tytul; ?>" width="200">
        <br><br>
        <a href="index.html">Powrót do listy</a>
    </body>    

</body>
</html>