let lp = 1;

function dodajFilm(){
    const tytul = document.getElementById('tytulFilm').value;
    const rezyser = document.getElementById('rezyserFilm').value;
    const rok = document.getElementById('rokFilm').value;

    if(tytul && rezyser && rok){                         //sprawdzam czy dane nie są puste
        const row = document.createElement('tr');       //tworze wiersz

        const lpF = document.createElement('td');    //ustawiam liczbę 
        lpF.innerText = lp;
        lp++;

        const tytulF = document.createElement('td');    //dodaje tytul do wiersza
        tytulF.innerText = tytul;

        const rezyserF = document.createElement('td');  //dodaje rezysera do wiersza
        rezyserF.innerText = rezyser;

        const rokF = document.createElement('td');      //dodaj rok do wiersza
        rokF.innerText = rok;

        row.appendChild(lpF);                       //dodaj komórki
        row.appendChild(tytulF);
        row.appendChild(rezyserF);
        row.appendChild(rokF);

        const tabela = document.getElementById('tabFilm');  //szykam tabeli i jej wlasnośći tbody i wpisuje dane
        tabela.appendChild(row);

        document.getElementById('tytulFilm').value = '';    //czyścimy pola w egzemplarzu
        document.getElementById('rezyserFilm').value = '';
        document.getElementById('rokFilm').value = '';
    } else {
        alert("Wszystkie pola muszą być wypełnione!");
    }

}

document.getElementById('dodFilm').addEventListener('click',dodajFilm);