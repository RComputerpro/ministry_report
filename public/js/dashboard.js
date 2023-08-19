//cercles de progression

const MonthCircle = document.getElementById('progressMonth');
const YearCircle = document.getElementById('progressYear');

const completeCircle = new Number(565.2);

//heures du mois

const hoursMonthTab = document.getElementById('hoursMonth').innerHTML.split(':');

const hoursInMinutes = (new Number(hoursMonthTab[0] * 60)) + (new Number(hoursMonthTab[1]));

const objHours = document.getElementById('objHours').innerHTML;

const objInMinutes = objHours * 60;

let progressHoursMonth;

if (hoursInMinutes <= objInMinutes) {
    progressHoursMonth = new Number(completeCircle - ((completeCircle * hoursInMinutes) / (objInMinutes)));
}
else {
    progressHoursMonth = new Number(0);
}

//heures de l'année

const hoursYearTab = document.getElementById('hoursYear').innerHTML.split(':');

const yearHoursInMinutes = (new Number(hoursYearTab[0] * 60)) + (new Number(hoursYearTab[1]));

const yearObjHours = document.getElementById('yearObjHours').innerHTML;

const yearObjInMinutes = yearObjHours * 60;

let progressHoursYear;

if (yearHoursInMinutes <= yearObjInMinutes) {
    progressHoursYear = new Number(completeCircle - ((completeCircle * yearHoursInMinutes) / (yearObjInMinutes)));
} else {
    progressHoursYear = new Number(0);
}

//ajout des animations

const styleSheet = new CSSStyleSheet();

styleSheet.replaceSync(`
@keyframes progressMonth {
    to {
        stroke-dashoffset: ${progressHoursMonth};
    }
}

@keyframes progressYear {
    to {
        stroke-dashoffset: ${progressHoursYear};
    }
}`)


document.adoptedStyleSheets = [styleSheet];

MonthCircle.style.animation = 'progressMonth 1s forwards';
YearCircle.style.animation = 'progressYear 1s forwards'