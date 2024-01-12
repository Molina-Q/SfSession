/* toggle the theme of the app to dark or light depending on the current active theme */
function toggleTheme() {
    if(body.classList.contains("dark-mode")) {
        body.classList.remove("dark-mode");
        body.classList.add("light-mode");
    } else {
        body.classList.remove("light-mode");
        body.classList.add("dark-mode");
    }
}

/* return the current theme */
function checkTheme() {
    if(body.classList.contains("dark-mode")) {
        return "dark-mode";
    } else {
        return "light-mode";
    }
}

/* set the current theme to the localstorage */ 
function applyStoragedTheme($theme) {
   switch ($theme) {
    case "dark-mode":
        body.classList.remove("light-mode");
        body.classList.add("dark-mode");
        break;
    case "light-mode":
        body.classList.remove("dark-mode");
        body.classList.add("light-mode");
        break;
   
    default:
        break;
   }
}

function showCustomConfirm() {
    wrapper.prepend(customConfirm);
    customConfirm.appendChild(textConfirm);

    customConfirm.appendChild(buttonsConfirm);
    buttonsConfirm.appendChild(btnConfirmYes);
    buttonsConfirm.appendChild(btnConfirmNo);

    body.appendChild(unclickableBack);

    const buttons = document.getElementsByClassName('custom-confirm-btn');

    buttons.addEventListener('click', function(event) {
        for (let i = 0; i < buttons.length; i++) {
            const clickedBtn = buttons[i];
            console.log(clickedBtn == btnConfirmYes ? true : false);
            // return clickedBtn == btnConfirmYes ? true : false;
        }
    });
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
const customConfirm = document.createElement('div');
customConfirm.setAttribute('id', 'custom-confirm');

const textConfirm = document.createElement('p');
textConfirm.classList.add('custom-confirm-text');
textConfirm.textContent = 'Do you really want to delete this ?';

const buttonsConfirm = document.createElement('div');
buttonsConfirm.setAttribute('id', 'custom-confirm-buttons');

const btnConfirmYes = document.createElement('button');
btnConfirmYes.textContent = "Confirm";
btnConfirmYes.classList.add('custom-confirm-btn');
btnConfirmYes.setAttribute('id', 'custom-confirm-yes');

const btnConfirmNo = document.createElement('button');
btnConfirmNo.textContent = "Cancel";
btnConfirmNo.classList.add('custom-confirm-btn');
btnConfirmNo.setAttribute('id', 'custom-confirm-no');

const unclickableBack = document.createElement('div');
unclickableBack.classList.add('unclickable-background');

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
    
    openDelete.addEventListener("click", function() {
        // i store the string in his href
        let initialHref = openDelete.href; 

        // function that give the <a> element his initial href
        function updateHref() { 
            openDelete.href = initialHref;
        }
        checkConfirm = showCustomConfirm();
    })
}

/* ask the user to confirm his choice when clicking on the delete btn */
// for (let i = 0; i < deleteIcon.length; i++) {
//     // openDelete is the <a href="" class="deleteIcon"> element i clicked
//     const openDelete = deleteIcon[i]; 
    
//     openDelete.addEventListener("click", function() {
//         // i store the string in his href
//         let initialHref = openDelete.href; 

//         // function that give the <a> element his initial href
//         function updateHref() { 
//             openDelete.href = initialHref;
//         }
//         checkConfirm = confirm("Are you sure you want to delete this ?");

//         // if check is false the href is changed and the delete() method isn't called, if true the delete() method will be called 
//         if(!checkConfirm) {
//             openDelete.href = "#";
//             setTimeout(updateHref, 2000); // write the initial href back after 2 seconds
//         }
//     })
// }

/*
* check if there is a theme in the locale storage
*/
if(!localStorage.getItem("themeIs")) {
    localStorage.setItem("themeIs", 'light-mode');
}

window.addEventListener("load", function() {
    applyStoragedTheme(localStorage.getItem("themeIs"))
});

switchMode.addEventListener("click", function() {
    switch (localStorage.getItem("themeIs")) {
        case "light-mode":
                toggleTheme();
                localStorage.removeItem("themeIs");
                localStorage.setItem("themeIs", "dark-mode");
            break;

        case "dark-mode":
                toggleTheme();
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