let win_offers_get = document.querySelector("#win_offers_get");
let win_offers = document.querySelector("#win_offers");
let win_vaka = document.querySelector("#win_vaka");
let win_kont = document.querySelector("#win_kont");
let win_menu = document.querySelector("#win_menu");
let win_news = document.querySelector("#win_news");

win_offers_get.classList.add("delete");
win_offers.classList.add("delete");
win_vaka.classList.add("delete");
win_kont.classList.add("delete");
win_menu.classList.add("delete");
win_news.classList.add("delete");


function KeyShowNews_click(){
    win_offers_get.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.remove("delete");
};
function KeyShowMeny_click(){
    win_offers_get.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.remove("delete");
    win_news.classList.add("delete");
};
function KeyShowKont_click(){    
    win_offers_get.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.remove("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};

function KeyShowVack_click(){    
    win_offers_get.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.remove("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};
function KeyShowOffers_click(){
    win_offers_get.classList.add("delete");
    win_offers.classList.remove("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};
function KeyShowOffersGet_click(){
    win_offers_get.classList.remove("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};


