let win_mess_gost = document.querySelector("#win_mess_gost");
let win_offers = document.querySelector("#win_offers");
let win_vaka = document.querySelector("#win_vaka");
let win_kont = document.querySelector("#win_kont");
let win_menu = document.querySelector("#win_menu");
let win_news = document.querySelector("#win_news");

win_mess_gost.classList.add("delete");
win_offers.classList.add("delete");
win_vaka.classList.add("delete");
win_kont.classList.add("delete");
win_menu.classList.add("delete");
win_news.classList.add("delete");


function KeyShowNews_click(){
    win_mess_gost.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.remove("delete");
};
function KeyShowMeny_click(){
    win_mess_gost.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.remove("delete");
    win_news.classList.add("delete");
};
function KeyShowKont_click(){    
    win_mess_gost.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.remove("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};

function KeyShowVack_click(){    
    win_mess_gost.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.remove("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};
function KeyShowOffers_click(){
    win_mess_gost.classList.add("delete");
    win_offers.classList.remove("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};
function KeyShowOffersGet_click(){
    win_mess_gost.classList.remove("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
};

function KeyMessGost_click(){
    let LFormDate = new FormData;
	LFormDate.append('VID', 0);
	LFormDate.append('VLogin', 0);
   	LFormDate.append('VSession', 0);
	LFormDate.append('VFunction', "MessGostSet");
	LFormDate.append('VMethod', "INSERT");

//    win_mess_gost.classList.remove("delete");

    let MGUserName = win_mess_gost.querySelector('input[IDField="name"]');
    let MGTele = win_mess_gost.querySelector('input[IDField="tele"]');
    let MGEMail = win_mess_gost.querySelector('input[IDField="email"]');
    let MGPrivat = win_mess_gost.querySelector('select[IDField="private"]');
    let MGMessage = win_mess_gost.querySelector('textarea');

    LFormDate.append('MGUserName', MGUserName.value);
    LFormDate.append('MGTele', MGTele.value);
    LFormDate.append('MGEMail',MGEMail.value);
    LFormDate.append('MGPrivat', MGPrivat.value);
    LFormDate.append('MGMessage', MGMessage.value);
    SendData('../fphp/phpsql.php', LFormDate, FOK_SetMessage, '', FERR_Error);
};
function FOK_SetMessage(str, param){
	const arr = JSON.parse(str);
   	if (arr[0][0][0] != "OK"){
   		alert ('Oшибка');     
   		return;
   	};
    alert ('Ваше сообщение передано');     
    hintall();
}

function FERR_Error(str, param){
    alert ('Ошибка на сервере');     
}

function hintall(){
    win_mess_gost.classList.add("delete");
    win_offers.classList.add("delete");
    win_vaka.classList.add("delete");
    win_kont.classList.add("delete");
    win_menu.classList.add("delete");
    win_news.classList.add("delete");
}


