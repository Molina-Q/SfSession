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

function checkTheme() {
    if(body.classList.contains("dark-mode")) {
        return "dark-mode"
    } else {
        return "light-mode"
    }
}

/* my body wrapper */
const body = document.getElementById('body-wrapper');

/* btn */
const switchMode = document.getElementById('switch-mode');

/* my delete btn */
const deleteIcon = document.getElementsByClassName('deleteIcon');

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
    localStorage.setItem("themeIs", "dark-mode");
}

function applyStoragedTheme() {
    storagedTheme = localStorage.getItem("themeIs");

    switch (storagedTheme) {
        case 'light-mode':
            
            break;

        case 'dark-mode':
            
            break;
    
        default:
            break;
    }
}

window.addEventListener("load", () => checkTheme());

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
})

// switchMode.addEventListener('click', () => toggleTheme());