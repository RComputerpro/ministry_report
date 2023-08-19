//recup des éléments du DOM

const content = document.getElementById('content');
const table = document.getElementById('ministryReportTable');

const rmMonth = document.getElementById('rmMonth');
const addMonth = document.getElementById('addMonth');

//recup des donnees

let yearDataContainer;
let yearData;
let yearDataTable = new Array();
let monthDataTable = new Array();

let today = new Date();

//initialisation des donnees du mois

let pub;
let vid;
let min;
let minTotales;
let hours;
let formatedHour;
let nv;
let stud;

//fonctions

function recupDataMonth() {

    monthDataTable.splice(0, monthDataTable.length);
    yearDataTable.forEach((ligne) => {
        let dt = new Date(ligne[0]);
        if(dt.getFullYear() == today.getFullYear() && dt.getMonth() == today.getMonth()) {
            monthDataTable.push(ligne);
        }
    })
}

function createTable(table) {
    let a = table.split("|");
    a.forEach(element => {
        let b = element.split(';');
        yearDataTable.push(b);
    });
}

function addOneMonth() {
    today.setMonth(today.getMonth() + 1);
}

function rmOneMonth() {
    today.setMonth(today.getMonth() - 1);
}

//afficher les données

function affData() {
    document.getElementById('monthCell').textContent = today.toLocaleDateString('en-US', {month: 'long'});
    document.getElementById('PubCell').textContent = pub;
    document.getElementById('VidCell').textContent = vid;
    document.getElementById('HoursCell').textContent = formatedHour;
    document.getElementById('NvCell').textContent = nv;
    document.getElementById('StudCell').textContent = stud;
}

//caluler les donnees

function calcData() {
    
    pub = 0;
    vid = 0;
    minTotales = 0;
    min = 0;
    hours = 0;
    formatedHour = "";
    nv = 0;
    stud = 0;

    monthDataTable.forEach((ligne) => {
        minTotales += new Number(ligne[1]);
        pub += new Number(ligne[2])
        vid += new Number(ligne[3]);
        nv += new Number(ligne[4]);
        stud += new Number(ligne[5]);
    })

    min = minTotales % 60;
    hours = (minTotales - min) / 60;
    formatedHour = hours + ":" + min;
}   


//event listeners pour les boutons

rmMonth.addEventListener('click', () => {
    content.classList.add('masque');
    rmOneMonth();
    recupDataMonth();
    calcData();
    setTimeout(() => {
        content.classList.remove('masque');
        content.classList.add('aff');
        calcData();
        affData();
    }, 800);
    setTimeout(() => {
        content.classList.remove('aff');
    }, 2000);
});

addMonth.addEventListener('click', () => {
    content.classList.add('masque');
    addOneMonth();
    recupDataMonth();
    calcData();
    setTimeout(() => {
        content.classList.remove('masque');
        content.classList.add('aff');
        calcData();
        affData();
    }, 800);
    setTimeout(() => {
        content.classList.remove('aff');
    }, 2000);
});

//main

document.addEventListener('DOMContentLoaded', () => {
    yearDataContainer = document.getElementById('yearDataContainer');
    yearData = yearDataContainer.getAttribute('data-YearData');
    createTable(yearData);
    recupDataMonth();
    calcData();
    affData();
})