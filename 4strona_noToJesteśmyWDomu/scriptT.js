const dodBut = document.getElementById('dodTech');
const usunOstBut = document.getElementById('usunOst');
const usunWszBut = document.getElementById('usunWsz');
const listaTech = document.getElementById('listaTech');

function dodajNowaTech(){

    const nazwaTech = document.getElementById('nazwaTech');
    const li = document.createElement('li');
    li.innerText = nazwaTech.value;
    listaTech.appendChild(li);
    document.getElementById('nazwaTech').value = '';

}

function usunOstTech(){

    const policz = listaTech.children.length;
    if (policz > 0){
        listaTech.removeChild(listaTech.children[policz -1]);
    } else {
        alert("Nie ma wystarczającej ilości danych na liście");
    }

}

function usunWszTech(){
    Array.from(listaTech.children).forEach(li => listaTech.removeChild(li));
}


dodBut.addEventListener('click',dodajNowaTech);
usunOstBut.addEventListener('click',usunOstTech);
usunWszBut.addEventListener('click',usunWszTech);