document.addEventListener("DOMContentLoaded", function () {
    const links = document.querySelectorAll(".nav-link");
    const currentPage = window.location.pathname.split("/").pop(); 
    links.forEach(link => {
        if (link.getAttribute("href") === currentPage) {
            link.classList.add("active"); 
        } else {
            link.classList.remove("active"); 
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".tab-link");
    const reservations = document.querySelectorAll(".reserv1");

    function updateReservations() {
        const currentCategory = window.location.hash ? window.location.hash.substring(1) : "hotel";
        
        reservations.forEach(reservation => {
            if (reservation.id === currentCategory){
                reservation.style.display = "flex";
            } 
            else{
                reservation.style.display = "none";
            }
        });

        tabs.forEach(tab => {
            if (tab.getAttribute("href") === "#" + currentCategory) {
                tab.classList.add("active");
            } else {
                tab.classList.remove("active");
            }
        });
    }

    updateReservations();
    window.addEventListener("hashchange", updateReservations);
});


function tosignup(){
    window.location.href="signup.php";
}
document.addEventListener("DOMContentLoaded", function() {
    const Button = document.getElementById("getstarted");
    
    if (Button) {
        Button.addEventListener("click", tosignup);
    }
});

function toreserv(){
    window.location.href="Accueil.php#recommendations";
}
document.addEventListener("DOMContentLoaded", function() {
    const Button = document.getElementById("reserver");
    
    if (Button) {
        Button.addEventListener("click", toreserv);
    }
});

function tocontact(){
    window.location.href="contact.php#Contact";
}
document.addEventListener("DOMContentLoaded", function() {
    const Button = document.getElementById("Contacter");
    
    if (Button) {
        Button.addEventListener("click", tocontact);
    }
});

function toarticles(){
    window.location.href="results.php";
}

document.addEventListener("DOMContentLoaded", function() {
    const Button = document.getElementById("search");
    if (Button) {
        Button.addEventListener("click", toarticles);
    }
});

document.addEventListener("DOMContentLoaded", function(){
    const logout_btn = document.getElementById("logout-btn");
    const annuler_lo = document.querySelector(".annuler");
    const confirmer_lo = document.querySelector(".confirmer");
    const logout_card = document.querySelector(".logout-card");
    const logout_cont = document.querySelector(".logout-content");

    logout_btn.addEventListener("click", function(e){
        e.preventDefault();
        logout_card.style.display = "flex";
    });

    annuler_lo.addEventListener("click", function(){
        logout_card.style.display = "none";
    });

    confirmer_lo.addEventListener("click", function(){
        window.location.href = "logout.php";
    });

    logout_card.addEventListener("click", function(e){
        if(!logout_cont.contains(e.target)){
            logout_card.style.display = "none";
        }
    })
})

document.addEventListener("DOMContentLoaded", function(){
    const annuler_up = document.querySelector(".close-update");
    const update_btn = document.querySelector(".edit-btn");
    const update_card = document.querySelector(".update-card");
    const update_cont = document.querySelector(".update-content");

    update_btn.addEventListener("click", function(){
        update_card.style.display = "flex";
    });

    annuler_up.addEventListener("click", function(){
        update_card.style.display = "none";
    });

    update_card.addEventListener("click", function(e){
        if(!update_cont.contains(e.target)){
            update_card.style.display = "none";
        }
    })
})

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("searchBar");

    searchInput.addEventListener("input", function () {
      const filter = this.value.toLowerCase();
      const articles = document.querySelectorAll(".article1");

      articles.forEach(article => {
        const nameElement = article.querySelector(".name h5");
        const placeElement = article.querySelector(".name p");
        const name = nameElement.textContent.toLowerCase();
        const place = placeElement.textContent.toLowerCase();
        if(name.includes(filter) || place.includes(filter)){
          article.style.display = "";
        } 
        else{
          article.style.display = "none";
        }
      });
    });
  });

window.addEventListener("load", function () {
  const wrapper = document.getElementById("loader-wrapper");
  setTimeout(() => {
    wrapper.style.opacity = "0";
    wrapper.style.transition = "0.4s ease";
    document.body.classList.remove("loading");
    setTimeout(() => {
      wrapper.remove();
    }, 400);
  }, 1000);
});

window.addEventListener("load", function () {
const search_loader = document.getElementById("search-loader");
setTimeout(() => {
    search_loader.style.display = "none";
}, 500);
});
