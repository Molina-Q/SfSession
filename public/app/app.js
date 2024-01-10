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

/* set the current theme in the storage */ 
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

/**
 * toggle the arrow's icon and their class name so they change visually
 * @param {HTMLCollectionOf} $class 
 */
function toggleArrow($class) {
    $class.classList.toggle('arrow');

    $class.classList.toggle('fa-chevron-down');
    $class.classList.toggle('fa-chevron-up');
}

/* my body wrapper */
const body = document.getElementById('body-wrapper');

/* btn */
const switchMode = document.getElementById('switch-mode');

/* my delete btn */
const deleteIcon = document.getElementsByClassName('deleteIcon');

/***** BurgerMenu *****/
const nav = document.querySelector('NAV');
/* icon  burger menu */
const burgerBtn = document.getElementById('burger-btn');
/* items inside the burger menu */
const burgerItems = document.getElementsByClassName('burger-items');
/* div menu */
const burgerContent = document.createElement("div");
burgerContent.classList.add('burger-content');
nav.appendChild(burgerContent);
console.log(burgerItems);

// burgerContent.prepend(burgerItems[2]);
// burgerContent.prepend(burgerItems[1]);
// burgerContent.prepend(burgerItems[3]);
// burgerContent.prepend(burgerItems[0]);

// for (let i in burgerItems) {
//     const openBurger = burgerItems[i];
//     burgerContent.prepend(openBurger);
// }
window.addEventListener('load', function() {
    for (let i = 0; i < burgerItems.length; i++) {
        const openBurger = burgerItems[i];
        burgerContent.prepend(openBurger);
    }
})


// for (let i = 0; i < burgerItems.length; i++) {
//     const openBurger = burgerItems[i];
//     burgerContent.prepend(openBurger);
// }

// for (let i = 0; i < burgerItems.length; i++) {
//     const openBurger = burgerItems[i];
//     burgerContent.prepend(openBurger);
// }

/* ask the user to confirm his when clicking on the delete btn */
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

        checkConfirm = confirm("Are you sure you want to delete this ?");
        // if check is false the href is changed and the delete() method isn't called, if true the delete() method will be called 
        if(!checkConfirm) {
            openDelete.href = "#";
            setTimeout(updateHref, 2000); // write the initial href back after 2 seconds
        }
    })
}

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

for (let i = 0; i < arrow.length; i++) {
    const openArrow = arrow[i];
    
    openArrow.addEventListener('click', function() {

        if (openArrow.classList.contains('fa-chevron-down')) {

            for (let i = 0; i < sessionContent.length; i++) {
                const openSession = sessionContent[i];
                openSession.style.display = 'none';
            } 

        } else {

            for (let i = 0; i < sessionContent.length; i++) {
                const openSession = sessionContent[i];
                openSession.style.display = 'flex';
            } 

        } toggleArrow(openArrow);
    })
}





