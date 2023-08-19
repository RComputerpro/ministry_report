//compte et deconnexion

const options_menu = document.getElementById('options_menu');

const close_options = document.getElementById('close_options');

close_options.hidden = true;

const mon_compte = document.getElementById('mon_compte');

mon_compte.hidden = true;

const deconnexion = document.getElementById('deconnexion');

deconnexion.hidden = true;

options_menu.classList.add('masque');

const compte_btn = document.getElementById('compte_btn');

compte_btn.addEventListener('click', () => {
    mon_compte.hidden = false;
    deconnexion.hidden = false;
    close_options.hidden = false;
    options_menu.classList.remove('hide');
    options_menu.classList.add('aff');
})

close_options.addEventListener('click', () => {
    options_menu.classList.remove('aff');
    options_menu.classList.add('masque');
    setTimeout(() => {
        mon_compte.hidden = true;
        deconnexion.hidden = true;
        close_options.hidden = true;
    }, 1000);
})