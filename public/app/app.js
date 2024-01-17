
/* set the current theme to the localstorage */ 
function applyStoragedTheme($theme) {

   switch ($theme) {

    case "dark-mode":
        body.setAttribute.remove("light-mode");
        body.classList.add("dark-mode");
        break;

    case "light-mode":
        body.classList.remove("dark-mode");
        body.classList.add("light-mode");
        break;
   
    default:
        body.classList.remove("light-mode");
        body.classList.add("dark-mode");
        break;
   }
}

/**
 * function called when clicking on a deleteBtn (all of them are trashcan icon or red elements)
 * @param {MouseEvent} event 
 * @param {Element} openDelete 
 */
function deleteConfirm(event, openDelete) {

    // stops the action of the clicked btn / link from taking place
    event.preventDefault();
    
    // function called when clicking on 'confirm'
    // it closes the modal and remove the event for both btns
    const confirmEvent = function(){
        customConfirm.close(); 
        btnConfirmYes.removeEventListener('click', confirmEvent, false);
        console.log('confirm'); 

        btnConfirmNo.removeEventListener('click', cancelEvent, false);
        // redirect to the action that was stopped by the preventDefault
        window.location.href = openDelete.href;
    }
    // function called when clicking on 'cancel'
    // it closes the modal and remove the event for both btns
    const cancelEvent = function(){
        customConfirm.close(); 
        btnConfirmNo.removeEventListener('click', cancelEvent, false);
        console.log('cancel'); 
        
        btnConfirmYes.removeEventListener('click', confirmEvent, false);
    }
    
    // make the <dialog> element created earlier via DOM to appear as a Modal with confirm and cancel btns
    customConfirm.showModal();

    // event for each btns 
    btnConfirmYes.addEventListener('click', confirmEvent, false)
    btnConfirmNo.addEventListener('click', cancelEvent, false)
}

/**
 * toggle the arrow's icon and their className so they change visually
 * @param {HTMLCollectionOf} arrowElement 
 */
function toggleArrow(arrowElement) {

    arrowElement.classList.toggle('arrow');

    arrowElement.classList.toggle('fa-chevron-down');
    arrowElement.classList.toggle('fa-chevron-up');
}

/* body wrapper */
const body = document.getElementById('body-wrapper');

/* main wrapper */
const wrapper = document.getElementById('wrapper');

/* btn to toggle dark/light mode */
const switchMode = document.getElementById('switch-mode');

/* my delete btn */
const deleteIcon = document.getElementsByClassName('deleteIcon');

/***** BurgerMenu *****/
const nav = document.querySelector('NAV');

/* icon  burger menu */
const burgerBtn = document.getElementById('burger-btn');

/* items inside the burger menu */
const burgerItems = document.querySelectorAll('.burger-items'); // querySelectorAll instead of getByClassName bcs it doesnt work for some reason

/* div menu */
const burgerContent = document.createElement("div");
burgerContent.setAttribute('id', 'burger-content');
nav.appendChild(burgerContent);

/***** CustomConfirm *****/
/* dialog box */
const customConfirm = document.createElement('dialog');
customConfirm.setAttribute('id', 'custom-confirm');

/* text */
const textConfirm = document.createElement('p');
textConfirm.classList.add('custom-confirm-text');
textConfirm.textContent = 'Do you really want to delete this ?';

/* div containing btns */
const buttonsConfirm = document.createElement('div');
buttonsConfirm.setAttribute('id', 'custom-confirm-buttons');

/* btn confirm */
const btnConfirmYes = document.createElement('button');
btnConfirmYes.textContent = "Confirm";
btnConfirmYes.classList.add('custom-confirm-btn');
btnConfirmYes.setAttribute('id', 'custom-confirm-yes');

/* btn cancel */
const btnConfirmNo = document.createElement('button');
btnConfirmNo.textContent = "Cancel";
btnConfirmNo.classList.add('custom-confirm-btn');
btnConfirmNo.setAttribute('id', 'custom-confirm-no');

/* dark background / useless */
const unclickableBack = document.createElement('div');
unclickableBack.classList.add('unclickable-background');

/* array of my btns / potentially useless */
const buttons = document.getElementsByClassName('custom-confirm-btn');

/***** customConfirm box *****/ 
wrapper.prepend(customConfirm); // the dialog is 
customConfirm.appendChild(textConfirm);

customConfirm.appendChild(buttonsConfirm);
buttonsConfirm.appendChild(btnConfirmYes);
buttonsConfirm.appendChild(btnConfirmNo);

/* burger content style used to keep burgerItems outside of the div while in desktop mode */
let compStyle = window.getComputedStyle(burgerContent);

window.addEventListener('resize', function() {
    compStyle = window.getComputedStyle(burgerContent);
})

/* put all all of my burger items in the burger content div */
if(compStyle.getPropertyValue("display") == "flex" ) {
    for (let i = 0; i < burgerItems.length; i++) {
        const openBurger = burgerItems[i];
        burgerContent.appendChild(openBurger);
    }
}

/* ask the user to confirm his choice when clicking on the delete btn */
for (let i = 0; i < deleteIcon.length; i++) {
    // openDelete is the <a href="" class="deleteIcon"> element i clicked
    const openDelete = deleteIcon[i]; 
    
    openDelete.addEventListener("click", function(event) {
        console.log('echo event on delete btn');
        deleteConfirm(event, openDelete);
    })
}

/*
* check if there is a theme in the locale storage
*/
if(!localStorage.getItem("themeIs")) {
    localStorage.setItem("themeIs", 'dark-mode');
}

window.addEventListener("load", () => {
    applyStoragedTheme(localStorage.getItem("themeIs"))
});

switchMode.addEventListener("click", function() {
    switch (localStorage.getItem("themeIs")) {
        case "light-mode":
                // toggleTheme();
                localStorage.removeItem("themeIs");
                localStorage.setItem("themeIs", "dark-mode");
            break;

        case "dark-mode":
                // toggleTheme();
                localStorage.removeItem("themeIs");
                localStorage.setItem("themeIs", "light-mode");
            break;

        default:
            
            break;
    }
    applyStoragedTheme(localStorage.getItem("themeIs"));
})


const sessionHead = document.getElementById('passed-sessions-head');
const sessionContent = document.getElementsByClassName('passed-sessions-content');
const arrow = document.getElementsByClassName('arrow');

/* open and closes the dropdown menu depending on its current state (open with the arrow up or closed with the arrow down ) */
for (let i = 0; i < arrow.length; i++) {
    const openArrow = arrow[i];
    
    openArrow.addEventListener('click', function() {

        if (openArrow.classList.contains('fa-chevron-down')) {
            // every items in the table disappear
            for (let i = 0; i < sessionContent.length; i++) {
                const openSession = sessionContent[i];
                openSession.style.display = 'none';
            } 

        } else {
            // every items in the table appear
            for (let i = 0; i < sessionContent.length; i++) {
                const openSession = sessionContent[i];
                openSession.style.display = 'flex';
            } 

        } toggleArrow(openArrow);
    })
}

/* toggle the show and showItems class on click in order to open and close the burger menu */
burgerBtn.addEventListener('click', function() {
    burgerContent.classList.toggle('show');

    for (let i = 0; i < burgerItems.length; i++) {
        const openBurger = burgerItems[i];
        openBurger.classList.toggle('showItems');
    }
})