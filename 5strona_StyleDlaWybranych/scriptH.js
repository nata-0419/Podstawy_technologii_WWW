let lp = 1;

function dodajKontakt(){

    const imieK = document.getElementById('imie').value;
    const nazwiskoK = document.getElementById('nazwisko').value;
    const emailK = document.getElementById('email').value;
    const wiekK = document.getElementById('wiek').value;
    const dataK = document.getElementById('data').value;
    const plecK = document.getElementById('plec').value;
    const grupaK = document.getElementById('grupa').value;


    if(imieK && nazwiskoK && emailK && wiekK && dataK) {
        const row = document.createElement('tr');
        row.className = grupaK;

        const lpK = document.createElement('td');
        lpK.innerText = lp;
        lp++;

        const imie = document.createElement('td');
        imie.innerText = imieK;

        const nazwisko = document.createElement('td');
        nazwisko.innerText = nazwiskoK;

        const email = document.createElement('td');
        email.innerText = emailK;

        const wiek = document.createElement('td');
        wiek.innerText = wiekK;

        const data = document.createElement('td');
        data.innerText = dataK;

        const plec = document.createElement('td');
        plec.innerText = plecK

        const grupa = document.createElement('td');
        grupa.innerText = grupaK;

        row.appendChild(lpK);
        row.appendChild(imie);
        row.appendChild(nazwisko);
        row.appendChild(email);        
        row.appendChild(wiek);
        row.appendChild(data);      
        row.appendChild(plec);
        row.appendChild(grupa);

        const tabela = document.getElementById('tabela');  //szykam tabeli i jej wlasnośći tbody i wpisuje dane
        tabela.appendChild(row);

        document.getElementById('imie').value = '';    //czyścimy pola w egzemplarzu

    } else {
        alert("Wszystkie pola muszą być wypełnione!");
    }

    }

document.getElementById('dodKontakt').addEventListener('click',dodajKontakt);